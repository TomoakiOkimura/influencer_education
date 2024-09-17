<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurriculumProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'curriculum_id',
        'user_id',
        'clear_flg',
    ];

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
