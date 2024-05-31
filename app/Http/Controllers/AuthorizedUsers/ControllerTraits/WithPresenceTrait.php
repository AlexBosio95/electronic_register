<?php

namespace App\Http\Controllers\AuthorizedUsers\ControllerTraits;

use Illuminate\Support\Facades\Log;

trait WithPresenceTrait
{

    function buildPresenceGrid($students, $timetable, $current_day, $current_date)
    {
        $res = [];
        $dayTimetable = json_decode($timetable, true);
        // Filtra gli elementi dell'array in base al giorno corrente
        $dayTimetable = array_filter($dayTimetable, function($item) use ($current_day) {
                return strtolower($item['day_of_week']) === strtolower($current_day);
        });
        $dayTimetable = array_values($dayTimetable);
        if (empty($dayTimetable)){
            return false;
        }
        foreach($students as $student){
            $dayPresence = json_decode($student->presences, true);
            //Filtra gli elementi dell'array in base al giorno corrente
            $dayPresences = array_filter($dayPresence, function($item) use ($current_date) {
                return $item['data'] === $current_date;
            });
            
            $values = array_values($dayPresences);
            foreach($dayTimetable as $t){
                $trovato = false;
                foreach($values as $v){
                    if($t['time_start'] ==  $v['hour']){
                        $res[$student->id][] = [$v['presence'], $v['id']];  
                        
                        $trovato = true;
                    } else {
                        if ($trovato){
                            break;
                        }   
                    }  
                }
                if(!$trovato){
                    $res[$student->id][] = '';
                }
            } 
        }
        return $res;
    }


}