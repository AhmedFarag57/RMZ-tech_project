@extends('layouts.app')

@section('content')
    <div class="roles">

        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-gray-700 uppercase font-bold">Show Appointment</h2>
            </div>
            <div class="flex flex-wrap items-center">
                <a href="{{ route('doctor.appointments.index') }}" class="bg-gray-200 text-gray-700 text-sm uppercase py-2 px-4 flex items-center rounded ml-3">
                    <svg class="w-3 h-3 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="long-arrow-alt-left" class="svg-inline--fa fa-long-arrow-alt-left fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M134.059 296H436c6.627 0 12-5.373 12-12v-56c0-6.627-5.373-12-12-12H134.059v-46.059c0-21.382-25.851-32.09-40.971-16.971L7.029 239.029c-9.373 9.373-9.373 24.569 0 33.941l86.059 86.059c15.119 15.119 40.971 4.411 40.971-16.971V296z"></path></svg>
                    <span class="ml-2 text-xs font-semibold">Back</span>
                </a>
                <a href="{{ route('doctor.appointments.edit', $appointment->id) }}" class="bg-gray-200 text-gray-700 text-sm uppercase py-2 px-4 flex items-center rounded ml-3">
                    <svg class="w-3 h-3 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M490.3 40.4C512.2 62.27 512.2 97.73 490.3 119.6L460.3 149.7L362.3 51.72L392.4 21.66C414.3-.2135 449.7-.2135 471.6 21.66L490.3 40.4zM172.4 241.7L339.7 74.34L437.7 172.3L270.3 339.6C264.2 345.8 256.7 350.4 248.4 353.2L159.6 382.8C150.1 385.6 141.5 383.4 135 376.1C128.6 370.5 126.4 361 129.2 352.4L158.8 263.6C161.6 255.3 166.2 247.8 172.4 241.7V241.7zM192 63.1C209.7 63.1 224 78.33 224 95.1C224 113.7 209.7 127.1 192 127.1H96C78.33 127.1 64 142.3 64 159.1V416C64 433.7 78.33 448 96 448H352C369.7 448 384 433.7 384 416V319.1C384 302.3 398.3 287.1 416 287.1C433.7 287.1 448 302.3 448 319.1V416C448 469 405 512 352 512H96C42.98 512 0 469 0 416V159.1C0 106.1 42.98 63.1 96 63.1H192z"/></svg>
                    <span class="ml-2 text-xs font-semibold">Edit</span>
                </a>
            </div>
        </div>

        <div class="table w-full mt-8 bg-white rounded">

            <div class="w-full max-w-xl px-6 py-12">

                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Patient Name
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <div class="bg-gray-200 border-2 border-gray-200 rounded w-full py-3 px-4 text-gray-700 leading-tight">
                            {{ $appointment->patient->name }}
                        </div>
                    </div>
                </div>

                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Appointment Status
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <div class="bg-gray-200 border-2 border-gray-200 rounded w-full py-3 px-4 text-gray-700 leading-tight">
                            @if (!$appointment->appointment_status)
                                <span class="text-xs text-white bg-green-500 px-2 py-1 rounded">Valid</span>
                            @else
                                <span class="text-xs text-white bg-red-500 px-2 py-1 rounded">Check out</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Appointment Time
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <div class="bg-gray-200 border-2 border-gray-200 rounded w-full py-3 px-4 text-gray-700 leading-tight">
                            {{ $appointment->appointment_date }}
                        </div>
                    </div>
                </div>
                
            </div>

            <div class="w-full sm:w-1/2 mb-6 px-6 float-right">
                <h3 class="text-gray-700 uppercase font-bold mb-2">diagnosis</h3>
                <div class="flex flex-wrap items-center">
                    <div class="w-full border border-gray-200 rounded">
                        <div class="text-gray-800 font-semibold px-4 py-4 mb-2">
                            <div class="bg-gray-200 border-2 border-gray-200 rounded w-full py-3 px-4 text-gray-700 leading-tight">
                                {{ $appointment->diagnosis }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full sm:w-1/2 ml-2 mb-6 px-6">
                <h3 class="text-gray-700 uppercase font-bold mb-2">Medicines List</h3>
                <div class="flex items-center bg-gray-200 rounded-tl rounded-tr">
                    <div class="w-1/3 text-left text-gray-600 py-2 px-4 font-semibold">Number</div>
                    <div class="w-1/3 text-left text-gray-600 py-2 px-4 font-semibold">Name</div>
                    <div class="w-1/3 flex items-center justify-end px-3">
                        
                    </div>
                </div>
                @foreach ($medicines as $medicine)
                    <div class="flex items-center justify-between border border-gray-200">
                        <div class="w-1/3 text-left text-gray-600 py-2 px-4 font-medium">{{ $loop->iteration }}</div>
                        <div class="w-1/3 text-left text-gray-600 py-2 px-4 font-medium">{{ $medicine->name }}</div>
                        <div class="w-1/3 text-right text-gray-600 py-2 px-4 font-medium">{{-- $subject->teacher->user->name --}}</div>
                    </div>
                @endforeach
            </div>
                 
        </div>
        
    </div>

@endsection