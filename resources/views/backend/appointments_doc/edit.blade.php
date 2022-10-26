@extends('layouts.app')

@section('content')
    <div class="roles">

        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-gray-700 uppercase font-bold">Edit Appointment</h2>
            </div>
            <div class="flex flex-wrap items-center">
                <a href="{{ route('doctor.appointments.show', $appointment->id) }}" class="bg-gray-200 text-gray-700 text-sm uppercase py-2 px-4 flex items-center rounded ml-3">
                    <svg class="w-3 h-3 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="long-arrow-alt-left" class="svg-inline--fa fa-long-arrow-alt-left fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M134.059 296H436c6.627 0 12-5.373 12-12v-56c0-6.627-5.373-12-12-12H134.059v-46.059c0-21.382-25.851-32.09-40.971-16.971L7.029 239.029c-9.373 9.373-9.373 24.569 0 33.941l86.059 86.059c15.119 15.119 40.971 4.411 40.971-16.971V296z"></path></svg>
                    <span class="ml-2 text-xs font-semibold">Back</span>
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


            <form action="{{ route('doctor.appointments.update', $appointment->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="w-full sm:w-1/2 mb-6 px-6 float-right">
                    <h3 class="text-gray-700 uppercase font-bold mb-2">diagnosis</h3>
                    <div class="flex flex-wrap items-center">
                        <div class="w-full border border-gray-200 rounded">
                            <div class="text-gray-800 uppercase font-semibold px-4 py-4">
                                <textarea class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" name="diagnosis" id="diagnosis" rows="5">{{ $appointment->diagnosis }}</textarea>
                                @error('diagnosis')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
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
                            <button type="button" class="px-2" id="addBtn">
                                <svg class="h-6 w-6 fill-current text-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M432 256c0 17.69-14.33 32.01-32 32.01H256v144c0 17.69-14.33 31.99-32 31.99s-32-14.3-32-31.99v-144H48c-17.67 0-32-14.32-32-32.01s14.33-31.99 32-31.99H192v-144c0-17.69 14.33-32.01 32-32.01s32 14.32 32 32.01v144h144C417.7 224 432 238.3 432 256z"/></svg>
                            </button>
                        </div>
                    </div>

                    @foreach ($medicines as $medicine)
                    <div class="flex items-center justify-between border border-gray-200">                      
                        <div class="w-1/6 text-left text-gray-600 py-2 px-4 font-medium row-index">
                            {{ $loop->iteration }}
                        </div>
                        <div class="text-left text-gray-600 py-2 px-4 font-medium">
                                <div class="relative">
                                    <select name="medicine_id_{{ $loop->iteration }}" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                                        <option value="{{ $medicine->id }}">{{ $medicine->name }}</option>
                                        @foreach ($allMedicines as $med)
                                            @if ($medicine->id != $med->id)
                                                <option value="{{ $med->id }}">{{ $med->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                    </div>
                                </div>
                        </div>
                        <div class="w-1/4 text-right text-gray-600 py-2 px-3 font-medium">
                            <button type="button" class="px-2">
                                <svg class="h-6 w-6 fill-current text-red-700" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"/></svg>
                            </button>
                        </div>
                    </div>
                    @endforeach

                    <div class="md:flex md:items-center mt-12 mb-12">
                        <div class="md:w-1/3"></div>
                        <div class="md:w-2/3">
                            <button class="shadow bg-blue-500 hover:bg-blue-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" type="submit">
                                Update
                            </button>
                        </div>
                    </div>

                </div>

            </form>
                 
        </div>
        
    </div>

@endsection