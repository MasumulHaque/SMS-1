<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;

class YourController extends Controller
{
    public function yourMethod()
    {
        // Fetch data from the database
        $students = DB::table('students')->get();
        
        // Pass data to the view
        return view('index', ['students' => $students]);
    }
}
