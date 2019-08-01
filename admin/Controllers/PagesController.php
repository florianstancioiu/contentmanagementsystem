<?php

namespace Admin\Controllers;

use Common\Controller;

class PagesController extends Controller
{
    public function index()
    {
        $this->checkAuth();

        $base_url = base_url();

        return view('admin/pages/index.html', compact('base_url'));
    }
}