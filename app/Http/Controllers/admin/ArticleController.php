<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Article;
use App\Http\Requests\ArticleRequest;

class ArticleController extends Controller
{
    public function article_list(){

        $articles = Article::all();

        return view('admin.article_list')->with('articles', $articles);
    }

    public function create()
    {

        return view('admin.article_create');
    }

    public function store(ArticleRequest $request){
        try {
            $request->validated();

            \Log::info('Request data: ', $request->all()); 
            
            $article = new Article();
            $article->saveArticle($request->all());
            
            return redirect('admin/article_list');
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back()->withErrors('保存に失敗しました');
        }
    }

    public function article_edit(Article $article) {
        
        return view('admin.article_edit',compact('article'));
    }

    public function update(ArticleRequest $request, Article $article){
        try {
            $validatedData = $request->validated();
            
            // updateArticleメソッドが存在しない場合は、標準のupdateメソッドを使用
            $article->update($validatedData);
            
            return redirect()->route('admin.article_list')
                ->with('success', 'Article updated successfully');
        } catch (\Exception $e) {
            // エラーメッセージをログに記録
            Log::error($e->getMessage());
            
            return redirect()->back()
                ->with('error', '更新できませんでした');
            }
        }


    public function destroy(Article $article)
    {
        $article->delete();

        return redirect('admin/article_list');
    }
}
