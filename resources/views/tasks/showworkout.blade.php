@extends('layouts.app')

@section('content')
    <br>
    <div class='row'>

        <div class="col-3">
            
            <div class="d-flex rounded flex-column flex-shrink-0 p-3 text-white bg-dark">
                <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                  <i class="fa fa-book"></i>
                  <span class="fs-4">&nbspLog</span>
                </a>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                  <li class="nav-item">
                    <a href="/routines" class="nav-link text-white" aria-current="page">
                      <i class="fa fa-tasks"></i>
                      Routines
                    </a>
                  </li>
                  <li>
                    <a href="/exercise" class="nav-link text-white active">
                      <i class="fa fa-walking"></i>
                      Exercise
                    </a>
                  </li>
                  <li>
                    <a href="/food" class="nav-link text-white">
                      <i class="fa fa-egg"></i>
                      Food
                    </a>
                  </li>
                  <li>
                    <a href="/tracker" class="nav-link text-white">
                      <i class="fa fa-history"></i>
                      Tracker
                    </a>
                  </li>
                </ul>
                <hr>
              </div>

        </div>
        <div class="col-9 p-0">
            
            @if ($customworkout)

            <div class="card m-0">
              <div class="card-body">
                <h3 class="card-title text-info">{{ $customworkout->workout }}</h3>
                <hr>
                <a href="/exercise" class="btn btn-dark">Go Back</a>
                <a href="/destroyWorkout/{{ $customworkout->id }}" class="btn btn-danger float-end">Remove Workout</a>
              </div>
            </div>

            @endif

        </div>

    </div>

    <br><br><br>

@endsection