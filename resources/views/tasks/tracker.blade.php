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
                    <a href="/food" class="nav-link text-white">
                      <i class="fa fa-egg"></i>
                      Food
                    </a>
                  </li>
                  <li>
                    <a href="/tracker" class="nav-link active">
                      <i class="fa fa-history"></i>
                      Tracker
                    </a>
                  </li>
                </ul>
                <hr>
              </div>

        </div>
        <div class="col-9 p-0">
            
            <h2 style="color:rgb(7, 156, 156)"><i class="fa fa-bookmark"></i> {{ $user }}</h2>
            
            <table class="mt-2 mb-0 table table-secondary table-hover table-bordered border-white text-secondary">
              <tbody>
                {{--<tr>
                  <td class="h4 text-success">Duration</td>
                  <td class="h4 text-success">Workouts</td>
                </tr>--}}
                <tr>
                  <td class="h5"><i class="fa fa-dumbbell"></i> Workouts: {{ $sum_sets }}</td>
                  <td class="h5">
                    @if (empty($last_workout->created_at))
                      No workout..
                    @else
                      Last Workout: {{$last_workout->created_at->diffForHumans()}}
                    @endif
                  </td>
                </tr>
              </tbody>
            </table>

            {{-- days of the week, calculate from $now --}}
            <div id="days" class="d-none">
            @foreach($days as $day)
              <h4 id="day{{$loop->index+1}}">{{ $day->format('d/m/Y') }}</h4>
            @endforeach
            </div>
            {{-- sums of the week, calculate from $now --}}
            <div id="sums" class="d-none">
              @foreach($sums as $sum)
                <h4 id="sum{{$loop->index+1}}">@php
                  echo gmdate('i', $sum);
                @endphp</h4>
              @endforeach
            </div>

            <br>
                    
            <h4 id="total_duration" class="text-secondary m-0">This Week: @php
              echo gmdate('H', $sum_duration);
              echo "hr&nbsp"; 
              echo gmdate('i', $sum_duration);
              echo "mn";
            @endphp</h4>

            <canvas id="myChart" width="auto" height="auto"></canvas>

            <br>
            
            <h2 class="text-secondary">Workouts History</h2>

            <div class="list-group">
              @if (count($workouteds) > 0)
                  @foreach ($workouteds as $workouted)
                  <div class="list-group-item list-group-item-action p-3 mb-2 border">
                    <div class="d-flex w-100 justify-content-between">
                      <h5 class="mb-1 text-success"><i class="fa fa-running"></i>
                          @php
                            echo gmdate('i', $workouted->total_duration);
                            echo "mn";
                            echo gmdate('s', $workouted->total_duration);
                            echo "s";
                          @endphp
                      </h5>
                      <small>{{ $workouted->created_at->format('d/m/Y') }}</small>
                    </div>

                      @foreach ($dones as $done)
                          @if ($done->workout_id == $workouted->id)
                          <p class="h6 w-auto">
                            {{ $done->workout_name }} <i class="fa fa-times text-primary"></i>
                            <span class="text-primary">{{ $done->count_row }}
                            @if ($done->count_row <= 1)
                            set
                            @else
                            sets  
                            @endif  
                            </span>
                            <br>
                          </p>
                          @endif
                      @endforeach

                  </div>
                  @endforeach
              @else
                <div class="text-secondary h4">No workouts..</div>
              @endif

              {{ $workouteds->links() }}

            </div>

        </div>

    </div>

    <br><br><br>

    <script>
      const ctx = document.getElementById('myChart').getContext('2d');
      const myChart = new Chart(ctx, {
          type: 'line',
          data: {
              labels: [
                document.getElementById('day1').innerText, 
                document.getElementById('day2').innerText, 
                document.getElementById('day3').innerText,
                document.getElementById('day4').innerText,
                document.getElementById('day5').innerText,
                document.getElementById('day6').innerText,
                document.getElementById('day7').innerText
              ],
              datasets: [{
                  label: 'Duration: ',
                  borderColor: 'blue',
                  data: [
                    document.getElementById('sum1').innerText, 
                    document.getElementById('sum2').innerText, 
                    document.getElementById('sum3').innerText,
                    document.getElementById('sum4').innerText,
                    document.getElementById('sum5').innerText,
                    document.getElementById('sum6').innerText,
                    document.getElementById('sum7').innerText,
                  ],
                  backgroundColor: [
                      'rgba(255, 99, 132, 0.2)',
                      'rgba(54, 162, 235, 0.2)',
                      'rgba(255, 206, 86, 0.2)',
                      'rgba(75, 192, 192, 0.2)',
                      'rgba(153, 102, 255, 0.2)',
                      'rgba(153, 102, 255, 0.2)',
                      'rgba(255, 159, 64, 0.2)'
                  ],/*
                  borderColor: [
                      'rgba(255, 99, 132, 1)',
                      'rgba(54, 162, 235, 1)',
                      'rgba(255, 206, 86, 1)',
                      'rgba(75, 192, 192, 1)',
                      'rgba(153, 102, 255, 1)',
                      'rgba(153, 102, 255, 0.2)',
                      'rgba(255, 159, 64, 1)'
                  ],*/
                  borderWidth: 1,
                  tension: 0.2
              }]
          },
          options: {
              scales: {
                  y: {
                      //beginAtZero: true
                    ticks: {
                    // Include a dollar sign in the ticks
                    callback: function(value, index, ticks) {
                        return value + "mn";
                    }
                }
                  }
              },
              plugins: {
                legend: {
                    display: false
                }
              }
          }
      });
      </script>

@endsection