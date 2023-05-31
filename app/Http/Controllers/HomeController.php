<?php

namespace App\Http\Controllers;

use App\Helpers\AbsenceHelper;
use Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();

        $todayAbsence = $user->getTodayAbsence();

        $startClockInStr = '08:00';
        $startClockOutStr = '17:00';

        $data = AbsenceHelper::getAbsenceReport($todayAbsence);
        $lateInMinutes = $data['late_in_minutes'];
        $overtimeInMinutes = $data['overtime_in_minutes'];
        $earlyClockOutInMinutes = $data['early_clock_out_in_minutes'];

        return view('home', compact('todayAbsence', 'startClockInStr', 'startClockOutStr', 'lateInMinutes', 'overtimeInMinutes', 'earlyClockOutInMinutes'));
    }
}
