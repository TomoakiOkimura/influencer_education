<?php

namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;


class ArticleController extends Controller
{
    public function article(article $article){

        $articles = [$article];

        return view('user.article',['articles'=>$articles]);
    }

}
