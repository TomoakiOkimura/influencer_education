<?php

namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Curriculum;
use App\Models\Grade;
use App\Models\User;
use App\Models\CurriculumProgress;

class CurriculumController extends Controller
{
    public function curriculum_list($id = null) {
        $user = User::find(1);


        $grades = Grade::all();

        if (!$id){
            $curriculums =Curriculum::all();
        } else{
            $curriculums = Curriculum::where('grade_id' , $id)->get();
        }

        $curriculum_progress = CurriculumProgress::where('user_id', $user->id)->get()->keyBy('curriculum_id');
    
        return view('user.curriculum_list', ['grades'=> $grades, 'curriculums' => $curriculums,'curriculum_progress' => $curriculum_progress,],compact('user'));
    }
    
}
