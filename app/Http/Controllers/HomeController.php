<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Box;
use App\Models\Arsip;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $boxtotal = Box::all()->count();
        $arsiptotal = Arsip::all()->count();
        return view('home', [
            'totalbox' => $boxtotal,
            'totalarsip' => $arsiptotal,
        ]);
    }
}
