@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-300">
                    {{ __("You're logged in as admin!") }}
                </div>
            </div>
        </div>
    </div>
@endsection
