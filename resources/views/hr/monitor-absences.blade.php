@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Data Absensi Seluruh Karyawan') }}</div>

                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <p>Hi, {{ Auth::user()->name }}!</p>
                            <form method="get" action="{{ route('hr.monitor-absences') }}">
                                <input style="width: 40%;" type="text" placeholder="Start Date" class="form-control d-inline mr-2" name="start_date"
                                    onfocus="(this.type='date')" value="{{ Request::get('start_date') }}">
                                <input style="width: 40%;" type="text" placeholder="End Date" class="form-control d-inline mr-2" name="end_date"
                                    onfocus="(this.type='date')" value="{{ Request::get('end_date') }}">
                                <button style="margin-top: -5px;" class="btn btn-primary">Filter</button>
                            </form>
                        </div>

                        <hr>

                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Nama Karyawan</th>
                                    <th scope="col">Clock In</th>
                                    <th scope="col">Clock Out</th>
                                    <th scope="col">Keterlambatan</th>
                                    <th scope="col">Lembur</th>
                                    <th scope="col">Pulang Cepat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($absences as $absence)
                                    @php
                                        $data = \App\Helpers\AbsenceHelper::getAbsenceReport($absence);
                                        $lateInMinutes = $data['late_in_minutes'];
                                        $overtimeInMinutes = $data['overtime_in_minutes'];
                                        $earlyClockOutInMinutes = $data['early_clock_out_in_minutes'];
                                    @endphp

                                    <tr>
                                        <td>{{ $absence->user->name }}</td>
                                        <td>{{ $absence->clock_in }}</td>
                                        <td>{{ $absence->clock_out ?? '-' }}</td>
                                        <td>{{ $lateInMinutes . ' Menit' ?? '-' }}</td>
                                        <td>{{ $overtimeInMinutes ? $overtimeInMinutes . '  Menit' : '-' }}</td>
                                        <td>{{ $earlyClockOutInMinutes ? $earlyClockOutInMinutes . '  Menit Lebih Awal' : '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
