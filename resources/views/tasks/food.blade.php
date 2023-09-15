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
                <a href="/exercise" class="nav-link text-white">
                  <i class="fa fa-walking"></i>
                  Exercise
                </a>
              </li>
              <li>
                <a href="/food" class="nav-link active">
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

        <div class="container p-0 m-0">
            <h3>NUTRITION FACTS FOR <span class="text-uppercase">{{ auth()->user()->name }}</span></h3>
            <form action="/food" method="GET">
              <div class="input-group mt-1">
                <input type="search" id="foodsearch" name="foodsearch" class="form-control rounded" placeholder="Search Food's Name.." />
                <button type="submit" class="btn btn-outline-primary">search</button>
                <button type="submit" class="btn btn-outline-primary"><i class="fa fa-eraser"></i></button>
              </div>
            </form>
            <hr>
            @if (count($foods) > 0)
            <ul class="list-group" id="myList">
                @foreach ($foods as $food)
                <li class="list-group-item border border-dark mt-1 p-0">
                <h3 class="m-1 p-2 text-white" style="background-color: #4472c4">{{ $food->food }}</h3>
                <table class="table table-striped m-0" style="background-color: #d9e1f2">
                  <thead>
                    <tr>
                      <th scope="col">Nutrients</th>
                      <th scope="col">Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Calories</td>
                      <td class="text-danger">{{ $food->calories }}</td>
                    </tr>
                    <tr>
                      <td>Total Fat</td>
                      <td class="text-danger">{{ $food->fat }} g</td>
                    </tr>
                    <tr>
                      <td>Cholesterol</td>
                      <td class="text-danger">{{ $food->cholesterol }} mg</td>
                    </tr>
                    <tr>
                      <td>Sodium</td>
                      <td class="text-danger">{{ $food->sodium }} mg</td>
                    </tr>
                    <tr>
                      <td>Protein</td>
                      <td class="text-danger">{{ $food->protein }} g</td>
                    </tr>
                    <tr>
                      <td>Calcium</td>
                      <td class="text-danger">{{ $food->calcium }} %</td>
                    </tr>
                  </tbody>
                </table>
                </li>
                @endforeach
            </ul>
            @else

            <div class="alert alert-info" role="alert">
              <h4 class="alert-heading">Aww, No Matching Food!</h4>
              <hr>
              @for ($i = 0; $i < 7; $i++)
                <i class="fa fa-carrot"></i>
                <i class="fa fa-bone"></i>
              @endfor
            </div>

            @endif
            <br>
            {{$foods->links()}}

          </div>

    </div>

</div>
<br><br><br><br><br>

@endsection