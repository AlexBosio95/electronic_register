<?php

namespace App\Http\Controllers\AuthorizedUsers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Teacher;
use Illuminate\Support\Facades\Log;

class CommonController extends Controller
{
    public function commonIndex(Request $request, string $currentPage)
    {
        $user = Auth::user();
        if (!$user){
            abort(401, 'Unauthorized');
        }
        $userId = $user->id;
        $user_role = $user->role;
        $teacher = Teacher::where('user_id', $userId)->first();
        $classes = [];
        $page = $currentPage;
        $method = $request->method();
        $main_sections = array_keys(config('sections'));
        $sections = [];

        $isVisibleCalendar = true;
        foreach($main_sections as $section){
            if ($user_role == 'admin'){
                $sections[config('sections.'.$section.'.route_name')] =  config('sections.'.$section.'.section_name');  
            } else {
                if (isset(config('sections.'.$section.'.visibility')[$user_role])){
                    if (in_array(strtolower($method), config('sections.'.$section.'.visibility')[$user_role])){
                        $sections[config('sections.'.$section.'.route_name')] = config('sections.'.$section.'.section_name');
                    }
                } 
            }

            $condizioneVisibilita = config('sections.'.$section.'.calendar', 'not set');
            Log::info("fuori ".$condizioneVisibilita);

            //controllo per capire se devo inibire il calendario
            if ($condizioneVisibilita == false && $isVisibleCalendar){
                if(config('sections.'.$section.'.section_name') == $currentPage){
                    $isVisibleCalendar = false;
                    Log::info(
                        "entrato". config('sections.'.$section.'.calendar'). config('sections.'.$section.'.section_name')
                    );
                }
            }
        }
        Log::info("oltre ".$isVisibleCalendar);
        

        if ($teacher) {
            $classes = $teacher->classes;
            return view('teacher.presents', compact('classes', 'user_role', 'page', 'sections', 'userId', 'isVisibleCalendar'));       
        } else {
            return view('teacher.presents', compact('classes', 'user_role', 'page', 'sections', 'userId', 'isVisibleCalendar'))->withErrors(['message' => 'Teacher not found.']);
        }
    }


    public function getApiKey(){
        $user = Auth::user();
        if(!$user){
            abort(401, 'Unauthorized');
        }  
        if(!empty($user->api_key)){
            $responseData = [
                'success' => true,
                'message' => 'Recuperata api key con successo!',
                'api_key' => $user->api_key
            ]; 
        } else {
            $responseData = [
                'success' => false,
                'message' => 'Errore nel recupero dell\'api key!',
            ];
        }
        return response()->json($responseData); 
    }
}
