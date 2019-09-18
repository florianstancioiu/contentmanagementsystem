<?php

namespace Controllers\Admin;

use Common\Controller;
use Common\Models\Page;
use \Exception;

class PagesController extends Controller
{
    protected static $auth_methods = [
        'index',
        'create',
        'edit',
        'store',
        'update',
        'destroy'
    ];

    protected function index()
    {
        $pages = Page::paginate();

        return view('admin/pages/index', compact('pages'));
    }

    protected function create()
    {
        return view('admin/pages/create');
    }

    protected function edit(int $id)
    {
        $page = Page::find($id);

        return view('admin/pages/edit', compact('page'));
    }

    // TODO: Validate request either
    // by creating a validate method in the base Controller class (quicker)
    // or by doing the whole dependency container thingy (takes a lot of time)
    protected function store()
    {
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

    protected function update()
    {
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

    protected function destroy(int $id)
    {
        try {
            Page::destroy($id);
        } catch (Exception $exception) {
            dd('Exception message:' . $exception->getMessage());
        }

        redirect('/admin/pages');
    }
}
