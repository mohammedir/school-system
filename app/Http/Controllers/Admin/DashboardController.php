<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Lands;
use App\Models\Projects;
use App\Models\EngineeringPartner;
use App\Models\Investors;
use App\Models\Contractors;

class DashboardController extends Controller
{
    public function index()
    {
        $student_cnt = Student::count();
        $contractors_cnt = Contractors::count();

        return view('admin.dashboard', compact(  'student_cnt', 'contractors_cnt'));
    }
}
