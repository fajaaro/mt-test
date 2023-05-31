<?php

namespace App\Http\Controllers;

use App\Models\UserAbsence;
use Auth;
use Illuminate\Http\Request;

class AbsenceController extends Controller
{
    public function clockIn(Request $request)
    {
        $user = Auth::user();

        $absence = $user->getTodayAbsence();

        if ($absence != null)
            return back()->with('failed', 'Anda sudah melakukan absen masuk pada hari ini.');

        $absence = new UserAbsence();
        $absence->user_id = $user->id;
        $absence->clock_in = now();
        $absence->save();

        return back()->with('success', 'Absen masuk berhasil dilakukan pada waktu ' . $absence->clock_in . '!');
    }

    public function clockOut(Request $request)
    {
        $user = Auth::user();

        $absence = $user->getTodayAbsence();

        if ($absence->clock_out != null)
            return back()->with('failed', 'Anda sudah melakukan absen pulang pada hari ini.');

        $absence->clock_out = now();
        $absence->save();

        return back()->with('success', 'Absen pulang berhasil dilakukan pada waktu ' . $absence->clock_out . '!');
    }

    public function index(Request $request)
    {
        $q = UserAbsence::with('user');

        if ($request->start_date) {
            $startDate = date('Y-m-d 00:00:00', strtotime($request->start_date));
            $q = $q->where('created_at', '>=', $startDate);
        }

        if ($request->end_date) {
            $endDate = date('Y-m-d 23:59:59', strtotime($request->end_date));
            $q = $q->where('created_at', '<=', $endDate);
        }

        $absences = $q->latest()->get();
 
        return view('hr.monitor-absences', compact('absences'));
    }
}