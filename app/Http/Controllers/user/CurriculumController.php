<?php

namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Curriculum;
use App\Models\Grade;

class CurriculumController extends Controller
{
    public function curriculum_list($id = null) {
        $grades = Grade::all();

        if (!$id){
            $curriculums =Curriculum::all();
        } else{
            $curriculums = Curriculum::where('grade_id' , $id)->get();
        }
    
        return view('user.curriculum_list', ['grades'=> $grades, 'curriculums' => $curriculums]);
    }
    
}
