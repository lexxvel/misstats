<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\sprintscauseslink;
use App\Models\sprints;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SprintscauseslinkController extends Controller
{
    public function getTopFiveCausesBySprint(Request $request) {
        $sprint_Name = $request->input('Sprint_Name');
        
        if ($sprint_Name !== null) {
            $sprint_id = sprints::where('Sprint_Name', 'like', $sprint_Name)->first()->Sprint_id;

            $result =  sprintscauseslink::join('causes', 'causes.Cause_id', '=', 'sprintscauseslink.Cause_id')
            ->select('sprintscauseslink.Cause_id', 'causes.Cause_Name', 'sprintscauseslink.Cause_Failcount')
            ->where('sprintscauseslink.Sprint_id', $sprint_id)
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
