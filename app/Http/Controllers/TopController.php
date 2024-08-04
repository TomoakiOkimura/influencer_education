<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Article;

class TopController extends Controller
{
    public function index()
    {
        $banners = Banner::all();
        $articles = Article::all();
        return view('layouts.top', compact('banners', 'articles'));
    }
}
