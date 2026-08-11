<?php

namespace App\Http\Controllers;

use App\Models\SubmissionSchedule;
use Illuminate\Http\Request;

class SubmissionScheduleController extends Controller
{
    public function showSubmissionSchedule ()
    {
        return view('tracer.submission');
    }
}