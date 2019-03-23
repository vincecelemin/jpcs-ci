<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersArticleController extends Controller
{
    public function index() {
        return view('author.articles');
    }

    public function create() {
        return view('author.create');
    }
}
