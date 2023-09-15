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
                    <a href="/routines" class="nav-link active" aria-current="page">
                      <i class="fa fa-tasks"></i>
                      Routines
                    </a>
                  </li>
                  <li>
                    <a href="/exercise" class="nav-link text-white">
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
            
          <h3>{{ $user }}'s Routines</h3>

          <hr>

          <div class="row">
            <div class="col">
              <h3>Quick Start</h3>
              <a href="/createworkout" class="btn btn-dark w-100 p-4">
                <span class="h5"><i class="fa fa-plus"></i>&nbsp;Start a Workout</span>
              </a>
            </div>
            <div class="col">
              <h3>Routines</h3>
              <a type="button" href="#" class="btn btn-dark w-100 p-4 disabled">
                <span class="h5"><i class="fa fa-list"></i>&nbsp;Create a Routine</span>
              </a>
            </div>
          </div>

          <br>

          <h3>All Routines</h3>

          <ul class="list-group">
            <li class="list-group-item">A Routine</li>
          </ul>

        </div>

    </div>

@endsection