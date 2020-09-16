<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PreventionPage extends Controller
{
    //
    public function __invoke()
    {
        return "you don't have permission for this page!";
    }
}
