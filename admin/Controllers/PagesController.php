<?php

namespace Admin\Controllers;

use Common\Controller;
use Admin\Models\Page;

class PagesController extends Controller
{
    // TODO: Check auth automatically
    public function index()
    {
        $this->checkAuth();
        $base_url = base_url();
        $pages = Page::get();
        $page = $pages[0];

        return view('admin/pages/index', compact('base_url', 'pages', 'page'));
    }
}