<?php

namespace Admin\Controllers;

use Common\Controller;
use Admin\Models\Page;

class PagesController extends Controller
{
    public function index()
    {
        // TODO: Check auth automatically
        $this->checkAuth();

        $base_url = base_url();
        $pages = Page::get();
        $page = $pages[0];

        return view('admin/pages/index', compact('base_url', 'pages', 'page'));
    }


    public function create()
    {
        // TODO: Check auth automatically
        $this->checkAuth();

        $base_url = base_url();

        return view('admin/pages/create', compact('base_url'));
    }

    public function edit(int $id)
    {
        // TODO: Check auth automatically
        $this->checkAuth();

        $base_url = base_url();
        $page = Page::find($id);

        return view('admin/pages/edit', compact('base_url', 'page'));
    }

    public function store()
    {
        // TODO: Check auth automatically
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
            dd('Exception message:' . $exception->getMessage());
        }

        redirect('/admin/pages');
    }


    public function destroy($id)
    {
        // TODO: Check auth automatically
        $this->checkAuth();

        try {
            Page::destroy([
                ':id' => (int) $id,
            ]);
        } catch (\Exception $exception) {
            dd('Exception message:' . $exception->getMessage());
        }

        redirect('/admin/pages');
    }
}