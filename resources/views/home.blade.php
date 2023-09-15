@extends('layouts.app')

@section('content')

    <br>
    <div class="container p-3 bg-dark text-white rounded">
        <h1>Dashboard</h1>
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        {{ __('You are logged in!') }}
        <br><br>
        <a href="/routines" class="btn btn-success p-1">Go To Workout Log</a>
    </div>

@endsection
