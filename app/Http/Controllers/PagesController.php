<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index() {
        $title = "Welcome to My Test Site";
        return view('pages/index')->with('title', $title);
    }

    public function about() {
        $title = "About Me";
        return view('pages/about')->with('title', $title);
    }

    public function services() {
        $data = array(
            'title' => 'Services',
            'services' => ['Web Design', 'Consulting', 'Project Management', 'SEO']
        );
        return view('pages/services')->with($data);
    }
}
