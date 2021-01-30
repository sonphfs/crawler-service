<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Blog;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::all();
        return view("blog.index", ['blogs' => $blogs]);
    }

    public function getBlogByCategory(Request $request)
    {
        $blogs = Blog::where('category_id', $request->id)->get();
        return view("blog.index", ['blogs' => $blogs]);
    }

}
