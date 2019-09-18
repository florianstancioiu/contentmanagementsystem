<?php

namespace App\Controllers\Client;

use Common\Controller;
use App\Models\Vegetable;

class VegetablesController extends Controller
{
    public function index()
    {
        $vegetables = Vegetable::paginate();

        return view('client/vegetables/index', compact('vegetables'));
    }

    public function show(string $slug)
    {
        $vegetable = Vegetable::find($slug);

        return view('client/vegetables/show', compact('vegetable'));
    }
}
