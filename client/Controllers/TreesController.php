<?php

namespace Client\Controllers;

use Common\Controller;
use Common\Models\Tree;

class TreesController extends Controller
{
    public function index()
    {
        $trees = Tree::paginate(5);
        $search_keyword = request('search_keyword');

        return view('client/trees/index', compact('trees'));
    }

    public function show(string $slug)
    {
        $tree = Tree::find($slug);

        return view('client/trees/show', compact('tree'));
    }
}
