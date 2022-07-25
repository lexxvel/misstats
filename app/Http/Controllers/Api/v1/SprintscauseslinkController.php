<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\sprintscauseslink;
use App\Models\sprints;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SprintscauseslinkController extends Controller
{
    public function getTopFiveCausesBySprint(Request $request) {
        $Sprint_id = $request->input('Sprint_id');
        
        if ($Sprint_id !== null) {

            $result =  sprintscauseslink::join('causes', 'causes.Cause_id', '=', 'sprintscauseslink.Cause_id')
            ->select('sprintscauseslink.Cause_id', 'causes.Cause_Name', 'sprintscauseslink.Cause_Failcount')
            ->where('sprintscauseslink.Sprint_id', $Sprint_id)
            ->orderBy('sprintscauseslink.Cause_Failcount', 'DESC')
            ->take(5)->get();
            
            return $result;
        } else {
            return [
                "status" => false,
                "message" => 'Не переданы обязательные параметры!'
            ];
        }
    }
}
