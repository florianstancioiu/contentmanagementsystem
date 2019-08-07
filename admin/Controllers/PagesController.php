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

    // TODO: Check auth automatically
    public function create()
    {
        $this->checkAuth();

        $base_url = base_url();

        return view('admin/pages/create', compact('base_url'));
    }

    // TODO: Check auth automatically
    public function store()
    {
        $this->checkAuth();

        $data = [
            ':title' => request('title'),
            ':slug' => request('slug'),
            ':lang' => request('lang'),
            ':content' => request('content'),
            ':description' => request('description'),
            ':user_id' => $_SESSION['user']['id']
        ];

        try {
            Page::store($data);
        } catch (\Exception $exception) {
            dd('we has problems: ' . $exception->getMessage());
        }

        redirect('/admin/pages');
    }
}