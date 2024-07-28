<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Grade extends Model
{
    use HasFactory;
     public function getGradeFirst(){
        $grades = DB::table('grades')
        ->where('id','=',1)
        ->get();

        return $grades;

     }
     public function searchGrade($grade_id){
      $grades = DB::table('grades')
        ->where('id','=',$grade_id)
        ->get();

        return $grades;
     }
     public function showGrade(){
      $grades = DB::table('grades')
      ->select('grades.*')
      ->get();

      return $grades;

     }
}
