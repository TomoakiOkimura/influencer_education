<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'video_url', 'always_public', 'start_date', 'end_date', 'grade_id'];

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
}
