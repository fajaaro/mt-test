<?php

namespace App\Helpers;

class AbsenceHelper
{
    public static function getAbsenceReport($absence)
    {
        $absenceDate = $absence->created_at;

        $startClockInStr = $absenceDate->format('Y-m-d') . ' 08:00:00';
        $startClockIn = \Carbon\Carbon::parse($startClockInStr);
        $startClockOutStr = $absenceDate->format('Y-m-d') . ' 17:00:00';
        $startClockOut = \Carbon\Carbon::parse($startClockOutStr);

        $lateInMinutes = null;
        if ($absence && $absence->clock_in && $absence->clock_in > $startClockIn) {
            $clockIn = \Carbon\Carbon::parse($absence->clock_in);
            $lateInMinutes = $startClockIn->diffInMinutes($clockIn);
        }

        $overtimeInMinutes = null;
        if ($absence && $absence->clock_out && $absence->clock_out > $startClockOut) {
            $clockOut = \Carbon\Carbon::parse($absence->clock_out);
            $overtimeInMinutes = $startClockOut->diffInMinutes($clockOut);
        }

        $earlyClockOutInMinutes = null;
        if ($absence && $absence->clock_out && $absence->clock_out < $startClockOut) {
            $clockOut = \Carbon\Carbon::parse($absence->clock_out);
            $earlyClockOutInMinutes = $clockOut->diffInMinutes($startClockOut);
        }

        return [
            'late_in_minutes' => $lateInMinutes,
            'overtime_in_minutes' => $overtimeInMinutes,
            'early_clock_out_in_minutes' => $earlyClockOutInMinutes
        ];
    }
}