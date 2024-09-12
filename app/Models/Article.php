<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'posted_date',
        'title',
        'article_contents',
    ];

    public function saveArticle($data)
    {
        $this->posted_date = $data['posted_date'];
        $this->title = $data['title'];
        $this->article_contents = $data['article_contents'];
        $this->save();
    }
}
