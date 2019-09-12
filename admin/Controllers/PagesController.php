<?php

namespace Admin\Controllers;

use Common\Controller;
use Common\Models\Page;
use \Exception;

class PagesController extends Controller
{
    public function index()
    {
        // TODO: Check auth automatically
        $this->checkAuth();

        $base_url = base_url();
        // TODO: Implement pagination function
        $pages = Page::get();
        $page = isset($pages[0]) ? $pages[0] : [];

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
        } catch (Exception $exception) {
            dd('Exception message:' . $exception->getMessage());
        }

        redirect('/admin/pages');
    }

    public function update()
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
            Page::update((int) request('page_id'), $data);
        } catch (Exception $exception) {
            dd('Exception message:' . $exception->getMessage());
        }

        redirect('/admin/pages');
    }

    public function destroy(int $id)
    {
        // TODO: Check auth automatically
        $this->checkAuth();

        try {
            Page::destroy((int) $id);
        } catch (Exception $exception) {
            dd('Exception message:' . $exception->getMessage());
        }

        redirect('/admin/pages');
    }
}
