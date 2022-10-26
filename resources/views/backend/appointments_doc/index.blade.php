@extends('layouts.app')

@section('content')

    <div class="roles-permissions">

        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-gray-700 uppercase font-bold">Appointments</h2>
            </div>
        </div>

        <div class="mt-8 bg-white rounded border-b-4 border-gray-300">

            <div class="flex flex-wrap items-center uppercase text-sm font-semibold bg-gray-300 text-gray-600 rounded-tl rounded-tr">
                <div class="w-2/12 px-4 py-3">Number</div>
                <div class="w-2/12 px-4 py-3">Patient</div>
                <div class="w-3/12 px-4 py-3">Time</div>
                <div class="w-3/12 px-4 py-3">Status</div>
                <div class="w-2/12 px-4 py-3">Action</div>
            </div>

            @foreach ($appointments as $appointment)
            
                <div class="flex flex-wrap items-center text-gray-700 border-t-2 border-l-4 border-r-4 border-gray-300">

                    <div class="w-2/12 px-4 py-3 text-sm font-semibold text-gray-600 tracking-tight">{{ $loop->iteration }}</div>
                    <div class="w-2/12 px-4 py-3 text-sm font-semibold text-gray-600 tracking-tight">{{ $appointment->name }}</div>
                    <div class="w-3/12 px-4 py-3 text-sm font-semibold text-gray-600 tracking-tight">{{ $appointment->appointment_date }}</div>
                    <div class="w-2/12 px-4 py-3 text-sm font-semibold text-gray-600 tracking-tight">
                        @if (!$appointment->appointment_status)
                            <span class="text-xs text-white bg-green-500 px-2 py-1 rounded">Valid</span>
                        @else
                            <span class="text-xs text-white bg-red-500 px-2 py-1 rounded">Check out</span>
                        @endif
                    </div>
                    @if ($appointment->appointment_status)
                        <div class="w-2/12 flex items-center justify-end px-3">
                            <a class="px-2" href="{{ route('doctor.appointments.show', $appointment->id) }}">
                                <svg class="h-6 w-6 fill-current text-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) --><path d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z"/></svg>
                            </a>
                        </div>
                    @else
                        <div class="w-2/12 flex items-center justify-end px-3">
                            <a class="px-2" href="{{ route('doctor.appointments.create', $appointment->id) }}">
                                <svg class="h-6 w-6 fill-current text-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M438.6 105.4C451.1 117.9 451.1 138.1 438.6 150.6L182.6 406.6C170.1 419.1 149.9 419.1 137.4 406.6L9.372 278.6C-3.124 266.1-3.124 245.9 9.372 233.4C21.87 220.9 42.13 220.9 54.63 233.4L159.1 338.7L393.4 105.4C405.9 92.88 426.1 92.88 438.6 105.4H438.6z"/></svg>
                            </a>
                        </div>
                    @endif
                </div>

            @endforeach

        </div>

        <div class="mt-8">
            {{ $appointments->links() }}
        </div>

    </div>

@endsection