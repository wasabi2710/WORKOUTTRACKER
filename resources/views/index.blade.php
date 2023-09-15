@extends('layouts.app')

@section('content')

    <!-- index page -->
    <!-- welcome carousel -->
    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="{{ asset('images/work1.jpg') }}" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h3>Welcome To Simple Workout Tracker</h3>
            </div>
          </div>
          <div class="carousel-item">
            <img src="{{ asset('images/work2.jpg') }}" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h4>Track your workout routines</h4>
                <p>Set your Workout. Start your Workout. Finish your Workout. Save your Records.</p>
            </div>
          </div>
          <div class="carousel-item">
            <img src="{{ asset('images/work3.jpg') }}" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h4>Exercises & Routines</h4>
                <p>Customize your Routines with the exercises.</p>
            </div>
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
    </div>
    <!-- app description -->
    <br><br>
      <div class="row">
        <div class="col">
          <h3><i class="fa fa-biking"></i>&nbspWorkout Tracker</h3>
          <p>WorkoutTracker is designed to replace your paper workout journal. It combines the best features found in other apps with a minimalistic approach and a clean, easy-to-use interface. Give it a try. We know you'll love it!</p>
        </div>
        <div class="col">
          <h3><i class="fa fa-heart"></i>&nbspKeep It Simple</h3>
          <p>We keep WorkoutTracker simple by avoiding all the unnecessary extras. A workout log should be quick and easy to use in the gym or home without getting in your way, or slowing you down.</p>
        </div>
        <div class="w-100"></div>
        <div class="col">
          <h3><i class="fas fa-chart-bar"></i>&nbspSee your Progress</h3>
          <p>Provide different graphs that help you track your progress. There are graphs for gym workouts, cardio workouts and bodyweight. The graphs are highly customizable: you can select the date range, exercise and group the results by month, week or single workout.</p>
        </div>
        <div class="col">
          <h3><i class="fas fa-running"></i>&nbspExercises & Routines</h3>
          <p>Provide exercises and the ability to create your own routines and add exercises.</p>
        </div>
      </div>
    <br><br><br><br>

@endsection

