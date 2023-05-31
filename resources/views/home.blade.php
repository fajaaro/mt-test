@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Data Absensi') }}</div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('failed'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('failed') }}
                            </div>
                        @endif
                        
                        <div class="d-flex justify-content-between">
                            <p>Hi, {{ Auth::user()->name }}!</p>
                            <p>Jam Masuk <b class="text-success">{{ $startClockInStr }}</b>, Jam Pulang <b class="text-danger">{{ $startClockOutStr }}</b></p>
                        </div>

                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Clock In</th>
                                    <th scope="col">Clock Out</th>
                                    <th scope="col">Keterlambatan</th>
                                    <th scope="col">Lembur</th>
                                    <th scope="col">Pulang Cepat</th>
                                </tr>
                            </thead>
                            <tbody>

                                @if ($todayAbsence)
                                    <tr>
                                        <td>{{ $todayAbsence->clock_in }}</td>
                                        <td>{{ $todayAbsence->clock_out ?? '-' }}</td>
                                        <td>{{ $lateInMinutes . ' Menit' ?? '-' }}</td>
                                        <td>{{ $overtimeInMinutes ? $overtimeInMinutes . '  Menit' : '-' }}</td>
                                        <td>{{ $earlyClockOutInMinutes ? $earlyClockOutInMinutes . '  Menit Lebih Awal' : '-' }}</td>
                                    </tr>                                
                                @else
                                    <tr>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>

                        <div class="float-right">
                            <form action="{{ route('absences.clock-in') }}" method="post" class="d-inline">
                                @csrf
                                <button class="btn btn-success mr-2" {{ $todayAbsence == null ? '' : 'disabled' }}>Clock In</button>
                            </form>
                            <form action="{{ route('absences.clock-out') }}" method="post" class="d-inline">
                                @csrf
                                <button class="btn btn-warning" {{ $todayAbsence && $todayAbsence->clock_in && $todayAbsence->clock_out == null ? '' : 'disabled' }}>Clock Out</button>    
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
