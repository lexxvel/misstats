<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\causes;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CausesController extends Controller
{
    public function getAllCauses(){
        return causes::all();
    }

    public function getCauseById($id){
        $cause = causes::
        where("Cause_id", $id)->first();
        return $cause;
    }

    public function getTopFiveFailCauses() {
        $causes = causes::
        select("Cause_id", "Cause_Name", "Cause_Failcount")
        ->orderBy('Cause_Failcount', 'DESC')
        ->take(5)->get();
        return $causes;
    }
}
