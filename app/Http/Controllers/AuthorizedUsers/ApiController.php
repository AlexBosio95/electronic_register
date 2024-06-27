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


}