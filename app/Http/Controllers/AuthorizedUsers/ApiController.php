<?php

namespace App\Http\Controllers\AuthorizedUsers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Classe;
use App\Models\Student;
use App\Models\GradesStudentRegister;
use App\Models\GradeOption;
use App\Models\Subject;
use App\Models\NotesStudentRegister;
use App\Http\Controllers\AuthorizedUsers\ControllerTraits\WithPresenceTrait;
use App\Models\Absence;
use App\Models\SchoolCalendar;

class ApiController extends Controller
{
    use WithPresenceTrait;

    public function getTimetable(string $id, string $dateParam)
    {
        $dayOfWeek = date("l", strtotime($dateParam));
        try{
            $selectedClass = Classe::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            Log::info($e);
        }

        if ($selectedClass) {
            $timetable = $selectedClass->calendar();
            $filteredTimetable = $timetable->where('day_of_week', $dayOfWeek)->get();
            if($filteredTimetable->isEmpty()){
                $resp = [];
                $result = false;
                $message = 'La classe non ha un orario associato';
                $statusCode = 404;
            } else {
                //costruzione matrice per la griglia delle presenze
            
                $matrice = $this->getPresences($filteredTimetable ,$selectedClass, $dateParam);
                $resp = [
                    'timetable' => $filteredTimetable,
                    'presences' => $matrice
                ];
                $result = true;
                $message = '';
                $statusCode = 200;
            }           
        } else {
            $resp = [];
            $result = false;
            $message = 'Orario non trovato';
            $statusCode = 404;
        }
        return $this->ajaxLogAndResponse($resp, $message, $result, $statusCode);
    }



    public function getPresences($timetable, $selectedClass, $current_date){

        $students = $selectedClass->students;
        $current_date = \DateTime::createFromFormat('j F Y', $current_date)->format('Y-m-d');
        $res = [];
        foreach($students as $student){
            $dayPresence = json_decode($student->presences, true);
            //Filtra gli elementi dell'array in base al giorno corrente
            $dayPresences = array_filter($dayPresence, function($item) use ($current_date) {
                return $item['data'] === $current_date;
            });
            
            $values = array_values($dayPresences);
            foreach($timetable as $t){
                $trovato = false;
                foreach($values as $v){
                    if($t['time_start'] ==  $v['hour']){
                        $res[$student->id][] = [$v['presence'], $v['id']];  
                        //$res[$student->id][] = $v['presence'];
                        $trovato = true;
                    } else {
                        if ($trovato){
                            break;
                        }   
                    }  
                }
                if(!$trovato){
                    $res[$student->id][] = ['',''];
                }
            } 
        }
        //Log::info($res);
        return $res;
    }

    public function getGrades(Request $request)
    {
        // Verifica se è stata fornita una query string per la materia
        if ($request->has('subject')) {
            // Recupera i voti in base alla materia selezionata
            $subjectId = $request->input('subject');
            $grades = GradesStudentRegister::where('type', 'mark')
                                            ->where('subject_id', $subjectId)
                                            ->get();
        } else {
            $grades = [];
        }
        $responseData = $grades;
        $result = true;
        $message = 'Voti recuperati con successo';
        $statusCode = 200;
    
        return $this->ajaxLogAndResponse($responseData, $message, $result, $statusCode);
    }

    /**
     * Recupera le opzioni voti
     */

    public function getGradesOption()
    {
        $gradeOptions = GradeOption::all();
        return $this->ajaxLogAndResponse($gradeOptions, "Dati ottenuti con successo", true, 200);
    }

    /**
     * Recupera le opzioni materie
     */

    public function getSubjectsOption()
    {
        $subjectOption = Subject::all();
        return $this->ajaxLogAndResponse($subjectOption, "Dati ottenuti con successo", true, 200);
    }

    /**
     * Recupera gli studenti di quella classe
     */

    public function getStudentsByClass(Request $request)
    {
        //Log::info($request);
        if ($request->has('class')) {
            $classeId = $request->input('class');
            $classe = Classe::find($classeId);

            if ($classe) {
                $students = Student::where('class_id', $classeId)->get();
                $result = true;
                $message = "";
                $statusCode = 200;
            } else {
                $students = [];
                $result = false;
                $message = 'Classe non trovata';
                $statusCode = 404;
            }
        } else {
            $students = [];
            $result = false;
            $message = 'Parametro "class" mancante';
            $statusCode = 404;
        }
        return $this->ajaxLogAndResponse($students, $message, $result, $statusCode);
    }

  
    public function getJustifications($month, $status){
        
        $absences = Absence::whereMonth('date', $month)->where('status', $status)->orderBy('date')->get();
        return $this->ajaxLogAndResponse($absences, "", true, 200);
    }
  
  
    /**
     * Recupera le note di quella classe
     */

    public function getNotes(Request $request)
    {
        if ($request->has('students')) {
            // Recupera la lista degli ID degli studenti
            $students = explode(',', $request->input('students'));
            
            // Valida che tutti gli ID degli studenti siano numerici
            if (array_filter($students, 'is_numeric') === $students) {
                // Includi le relazioni con student e teacher
                $notes = NotesStudentRegister::whereIn('student_id', $students)
                    ->with(['student', 'teacher'])
                    ->get();

                $responseData = $notes;
                $result = true;
                $message = 'Note recuperate con successo';
                $statusCode = 200;
            } else {
                $responseData = [];
                $result = false;
                $message = 'ID studenti non validi';
                $statusCode = 400;
            }
        } else {
            $responseData = [];
            $result = false;
            $message = 'Parametro "students" mancante';
            $statusCode = 400;
        }

        return $this->ajaxLogAndResponse($responseData, $message, $result, $statusCode);
    }


    public function getTimetableByClass(string $classe){

        if(is_numeric($classe)){
            $results = DB::table('school_calendar')
            ->join('subjects', 'school_calendar.subject_id', '=', 'subjects.id')
            ->join('teachers', 'school_calendar.teacher_id', '=', 'teachers.id')
            ->where('school_calendar.class_id', $classe) 
            ->select(
                'school_calendar.id',
                'school_calendar.day_of_week',
                'school_calendar.time_start',
                'school_calendar.time_end',
                'subjects.name as subject_name',
                'teachers.name as teacher_name'
            )
            ->orderBy('school_calendar.day_of_week')  
            ->orderBy('school_calendar.time_start') 
            ->get();

            //prendo tutti i giorni una volta sola
            $uniqueDays = $results->pluck('day_of_week')->unique()->values();

            // Definisco l'ordine dei giorni della settimana
            $daysOfWeekOrder = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            
            // Ordino i giorni unici in base all'ordine corretto
            $sortedDays = $uniqueDays->sort(function ($a, $b) use ($daysOfWeekOrder) {
                return array_search($a, $daysOfWeekOrder) <=> array_search($b, $daysOfWeekOrder);
            })->values();

            

            // Raggruppa i risultati per 'time_start'
            $groupedByTimeStart = [];

            foreach ($results as $entry) {
                // Ottieni il time_start per ogni voce
                $timeStart = $entry->time_start;

                // Inizializza l'array per quel time_start se non esiste ancora
                if (!isset($groupedByTimeStart[$timeStart])) {
                    $groupedByTimeStart[$timeStart] = [];
                }

                // Aggiungi l'elemento all'array del time_start corrispondente
                $groupedByTimeStart[$timeStart][] = (array) $entry;
            }
            Log::info(json_encode($groupedByTimeStart));


            $responseData = [
                'timetable' => $groupedByTimeStart,
                'days' => $sortedDays
            ];
            $result = true;
            $message = 'Orario recuperato con successo';
            $statusCode = 200;
        }
        else {
            $responseData = [];
            $result = false;
            $message = 'ID classe non numerico';
            $statusCode = 400;
        }
        return $this->ajaxLogAndResponse($responseData, $message, $result, $statusCode);
    }


    public function getTeacherPerClass(string $class){

        if(is_numeric($class)){
            $results = DB::table('teacher_classes')
                ->join('teachers', 'teacher_classes.teacher_id', '=', 'teachers.id')
                ->where('teacher_classes.class_id', $class)
                ->select(
                    'teachers.id',
                    'teachers.name',
                    'teachers.surname'
                )
                ->get();

            $responseData = $results;
            $message = "Professori recuperati correttamente";
            $result = true;
            $statusCode = 200;
        } else {
            $responseData = [];
            $result = false;
            $message = 'Impossibile recuperare correttamente i prof della classe';
            $statusCode = 400;
        }
        
        return $this->ajaxLogAndResponse($responseData, $message, $result, $statusCode);        
        
    }

    public function getTeacherSubjects(int $id){
        if(is_numeric($id)){
            $results = DB::table('teacher_subjects')
                ->join('subjects', 'teacher_subjects.subject_id', '=', 'subjects.id')
                ->where('teacher_subjects.teacher_id', $id)
                ->select(
                    'subjects.id',
                    'subjects.name'
                )
                ->get();

            $responseData = $results;
            $message = "Materie recuperati correttamente";
            $result = true;
            $statusCode = 200;
        } else {
            $responseData = [];
            $result = false;
            $message = 'Impossibile recuperare correttamente i prof della classe';
            $statusCode = 400;
        }

        return $this->ajaxLogAndResponse($responseData, $message, $result, $statusCode);  
    }


    public function updateTimetable(int $school_calendar_id, int $subject_id, int $teacher_id){

        $idCalendar = SchoolCalendar::findOrFail($school_calendar_id);
        Log::info($idCalendar);

        $idCalendar->subject_id = $subject_id;
        $idCalendar->teacher_id = $teacher_id;
        $idCalendar->save();
        $responseData = [];
        $message = "Orario aggiornato correttamente";
        $result = true;
        $statusCode = 200;

        return $this->ajaxLogAndResponse($responseData, $message, $result, $statusCode);  

    }




}