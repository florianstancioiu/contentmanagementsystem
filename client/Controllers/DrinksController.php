<?php

namespace Client\Controllers;

use Common\Controller;
use Common\Models\Drink;

class DrinksController extends Controller
{
    public function index()
    {
        $drinks = Drink
            ::select('title', 'slug')
            ::where('id', '>', 1)
            ::where('title', 'LIKE', '%t%')
            ::paginate();
        $search_keyword = request('search_keyword');

        return view('client/drinks/index', compact('drinks'));
    }

    public function show(string $slug)
    {
        $drink = Drink::find($slug);

        return view('client/drinks/show', compact('drink'));
    }
}
