<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    
    public function index(){
        $articles = Article::latest()->paginate(10);
        return view('articulos.index',compact('articles'));
    }
}
