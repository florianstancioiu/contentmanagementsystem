<?php

namespace App\Controllers\Client;

use Common\Controller;
use App\DbLayers\Tree;

class TreesController extends Controller
{
    public function index()
    {
        $trees = Tree::paginate();

        return view('client/trees/index', compact('trees'));
    }

    public function show(string $slug)
    {
        $tree = Tree::find($slug);

        return view('client/trees/show', compact('tree'));
    }
}
