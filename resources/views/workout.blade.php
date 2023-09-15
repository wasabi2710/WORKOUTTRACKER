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
                    <a href="#" class="nav-link text-white">
                      <i class="fa fa-walking"></i>
                      Exercise
                    </a>
                  </li>
                  <li>
                    <a href="#" class="nav-link text-white">
                      <i class="fa fa-egg"></i>
                      Food
                    </a>
                  </li>
                  <li>
                    <a href="#" class="nav-link text-white">
                      <i class="fa fa-history"></i>
                      Tracker
                    </a>
                  </li>
                </ul>
                <hr>
              </div>

        </div>
        <div class="col-9 border">
            
            @yield('task')

        </div>

    </div>

@endsection