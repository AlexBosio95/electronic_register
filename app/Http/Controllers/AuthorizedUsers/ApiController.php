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
use App\Http\Controllers\AuthorizedUsers\ControllerTraits\WithPresenceTrait;


class ApiController extends Controller
{
    use WithPresenceTrait;

    public function getTimetable(string $id, string $dateParam)
    {
        //Log::info($id);
        $dayOfWeek = date("l", strtotime($dateParam));
        //Log::info($dayOfWeek);
        try{
            $selectedClass = Classe::findOrFail($id);
            //Log::info($selectedClass->id);    
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            Log::info($e);
        }
             
        if ($selectedClass) {
            $timetable = $selectedClass->calendar();
            //Log::info($timetable->pluck('time_start')->implode(', '));
            $filteredTimetable = $timetable->where('day_of_week', $dayOfWeek)->get();
            //Log::info(empty($filteredTimetable));
            if($filteredTimetable->isEmpty()){
                return response()->json(['message' => 'La classe non ha un orario associato']);
            }
            //costruzione matrice per la griglia delle presenze
            //$res = $this->buildPresenceGrid($students,$timetable,$current_day,$current_date);
            
            $matrice = $this->getPresences($filteredTimetable ,$selectedClass, $dateParam);
            /* if(empty($matrice)){
                return response()->json(['message' => 'Gli studenti non hanno presenze/assenze da mostrare']);
            } */
            $resp = [
                'timetable' => $filteredTimetable,
                'presences' => $matrice
            ];
            //Log::info($resp);
            return response()->json($resp);
        } else {
            return response()->json(['message' => 'Orario non trovato'], 404);
        }
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
    
        return response()->json($grades);
    }

    /**
     * Recupera le opzioni voti
     */

    public function getGradesOption()
    {
        $gradeOptions = GradeOption::all();
        return response()->json($gradeOptions);
    }

    /**
     * Recupera le opzioni materie
     */

    public function getSubjectsOption()
    {
        $subjectOption = Subject::all();
        return response()->json($subjectOption);
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
                return response()->json($students);
            } else {
                return response()->json(['message' => 'Classe non trovata'], 404);
            }
        } else {
            return response()->json(['message' => 'Parametro "class" mancante'], 400);
        }
    }


}