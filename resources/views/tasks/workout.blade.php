@extends('layouts.app')

@section('content')
    <br>
        <div class="container p-0">

            <a href="/discardworkout/{{$trackerid}}" class="btn btn-warning">Discard Workout</a>

            <div class="container mt-1 p-2 rounded" style="background-color: #e9e6e6;">

              <div class="w-100 d-flex flex-row justify-content-between">
                @if (count($addedworkout) == 0)
                  <button class="btn btn-dark" disabled>Start</button>
                @else
                  <button onclick="startTimer()" class="btn btn-success">Start</button>  
                @endif
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                  <i class="fa fa-hourglass-end"></i>
                </button>
                {{-- data submits --}}
                {{-- total sets and total duration --}}
                <form action="/storetracker/{{$trackerid}}" method="GET" class="m-0">
                  {{--<input type="hidden" name="tracker_id" id="tracker_id" value={{$trackerid}} />--}}
                  <input type="hidden" name="duration" id="duration" />
                  <input type="hidden" name="sets" id="sets" value={{$sets}} />
                  @if (count($addedworkout) == 0)
                    <button type="submit" class="btn btn-dark" disabled>Finish</button>
                  @else
                    <button type="submit" class="btn btn-success" onclick="stopTimer()">Finish</button>  
                  @endif
                </form>
              </div>

              <br>

              <div class="container p-0 d-flex flex-row justify-content-around" style="color: #176f9b;">
                <div id="timer" class="h3">
                  <i id="div1" class="fa fa-stopwatch"></i>
                  <span id="minutes">00</span>:<span id="seconds">00</span>
                </div>
                <div id="timer" class="h3">
                  <i id="div1" class="fa fa-running"></i>
                  <span id="sets_display">{{$sets}}</span>
                </div>
              </div>

              <br>
              <div class="w-100 d-flex flex-column justify-content-center align-items-center">
                <h5 class="text-secondary">Add an exercise to start your workout..</h5>
                <button id="add_button" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addworkouts">
                  Add Workouts
                </button>
              </div>

              <br>
              
              <ul class="list-group">
                @if (count($addedworkout) > 0)
                <table class="table text-center table-borderless">
                  <thead>
                    <tr>
                      <th scope="col"><i class="fa fa-arrow-down"></i></th>
                      <th scope="col">Workout</th>
                      <th scope="col">Set</th>
                      <th scope="col"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($addedworkout as $workout)
                    <tr>
                      <th scope="row">{{ $loop->index+1 }}</th>
                      <td>{{ $workout->workout_name }}</td>
                      <td class="text-muted" id="set">1</td>
                      <td id="trash">
                        <a href="/removeworkout/{{$workout->id}}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                      </td>
                      {{--<td>
                        <button class="btn btn-info" id="check-btn" onclick="finished(); this.disabled=true;
                        document.getElementById('trash').hidden=true;
                        "><i class="fa fa-check"></i></button>
                      </td>--}}
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                @else
                  <li class="list-group-item text-secondary">No workout yet..</li>
                @endif
              </ul>

            </div>
        </div>
    <!-- timer -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title h1" id="exampleModalLabel">Timer</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body d-flex flex-row justify-content-center align-items-center">
            
            <button onclick="inc()" class="btn btn-success">10 <i class="fa fa-plus"></i></button>
            <div class="h1 m-2">
              <span id="countMN">00</span>:<span id="countSEC">00</span>
            </div>
            <button onclick="dec()" class="btn btn-danger"><i class="fa fa-minus"></i> 10</button>

          </div>
          <button onclick="startcountdown()" type="button" class="text-white btn btn-info p-1 m-1 ml-1 mr-1 mb-0">START <i class="fa fa-play"></i></button>
          <button onclick="reset()" type="button" class="btn btn-danger p-1 m-1">RESET <i class="fa fa-redo"></i></button>
        </div>
      </div>
    </div>

    <!-- add workout -->
    <div class="modal fade" id="addworkouts" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title h3">All Workouts</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">

            <form action="/startworkout" method="GET" class="m-0">
              <div class="input-group m-0">
                <input type="search" id="exerciseSearch" name="exerciseSearch" class="form-control rounded" placeholder="Find exercise.." />
                <button type="submit" class="btn btn-outline-success">search</button>
                <button type="submit" class="btn btn-outline-success"><i class="fa fa-eraser"></i></button>
              </div>
            </form>
            <ul class="list-group">
              @if (count($customworkouts) > 0)
                <br>
                <h4 style="color:#02e093;">Custom Workouts</h4>
                @foreach ($customworkouts as $customworkout)
                  <li class="list-group-item d-flex flex-row justify-content-between align-items-center">
                    <img width="28px" height="28px" src="{{asset('images/empty.png')}}" class="rounded float-end border border-info" alt="...">
                    <span>{{ $customworkout->workout }}</span>
                    <a href="/storeworkout/{{$customworkout->id}}/{{$trackerid}}/{{1}}" class="btn text-white" style="background: #02e093;"><i class="fa fa-plus"></i></a>
                  </li> 
                @endforeach 
              @endif
            </ul>
            <ul class="list-group">
              @if (count($exercises) > 0)
                <br>
                @foreach ($exercises as $exercise)
                  <li class="list-group-item d-flex flex-row justify-content-between align-items-center">
                    <img width="28px" height="28px" src="{{asset($exercise->imgpath)}}" class="rounded float-end border border-info" alt="...">
                    <span>{{ $exercise->exercise }}</span>
                    <a href="/storeworkout/{{$exercise->id}}/{{$trackerid}}/{{2}}" class="btn text-white" style="background: #02e093;"><i class="fa fa-plus"></i></a>
                  </li> 
                @endforeach 
              @endif
            </ul>

            @if (count($exercises) == 0 && count($customworkouts) == 0)
              <br>
              <div class="alert alert-info m-0" role="alert">
                <h4 class="alert-heading">No Exercise...</h4>
              </div>
            @endif

            <br>
          </div>
        </div>
      </div>
    </div>

    <br><br><br>
  
    {{-- script --}}
    <script>

        var totalsets = 0;
        function finished() {
          totalsets += 1;
          document.getElementById('sets_display').innerHTML = totalsets;
          document.getElementById('sets').value = totalsets;
        }

        var second = 0;
        function pad ( value ) { return value > 9 ? value : "0" + value; }
        function startTimer() {
          var timer = setInterval( function(){
            document.getElementById("seconds").innerHTML=pad(++second%60);
            document.getElementById("minutes").innerHTML=pad(parseInt(second/60,10));
          }, 1000);

          document.getElementById('add_button').disabled = true;
          document.getElementById('add_button').style.backgroundColor = "grey";
        }
        function stopTimer() {
          //clearInterval(timer);
          document.getElementById("duration").value = second;
        }

        var countdownSecond = 6;
        var initcountdown = countdownSecond;

        function inc() {
          countdownSecond += 11;
          initcountdown = countdownSecond;
          document.getElementById("countSEC").innerHTML=pad(--countdownSecond%60);
          document.getElementById("countMN").innerHTML=pad(parseInt(countdownSecond/60,10));
        }
        function dec() {
          if (countdownSecond >= 0 && countdownSecond >= 9) {
            countdownSecond -= 9;
            initcountdown = countdownSecond;
            document.getElementById("countSEC").innerHTML=pad(--countdownSecond%60);
            document.getElementById("countMN").innerHTML=pad(parseInt(countdownSecond/60,10));
          } else {
            countdownSecond = 1;
            initcountdown = countdownSecond;
            document.getElementById("countSEC").innerHTML=pad(--countdownSecond%60);
            document.getElementById("countMN").innerHTML=pad(parseInt(countdownSecond/60,10));
          }
        }

        document.getElementById("countSEC").innerHTML=pad(--countdownSecond%60);
        document.getElementById("countMN").innerHTML=pad(parseInt(countdownSecond/60,10));

        var countdown = setInterval();
        function startcountdown() {
            countdown = setInterval(function() {
              document.getElementById("countSEC").innerHTML=pad(--countdownSecond%60);
              document.getElementById("countMN").innerHTML=pad(parseInt(countdownSecond/60,10));
              if (countdownSecond <= 0) {
                clearInterval(countdown);
                countdownSecond = initcountdown;
                alert("Time's up!");
              }
            }, 1000);
        }
        function reset() {
          clearInterval(countdown);
          countdownSecond = initcountdown;
          document.getElementById("countSEC").innerHTML=pad(--countdownSecond%60);
          document.getElementById("countMN").innerHTML=pad(parseInt(countdownSecond/60,10));
        }

    </script>

@endsection