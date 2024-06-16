<?php

namespace App\Http\Controllers;
class ValidationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:view,App\Models\User');
    }
    public function index()
    {
        return view('validations.index');
    }
}