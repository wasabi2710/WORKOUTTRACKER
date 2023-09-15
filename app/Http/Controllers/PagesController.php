<?php

namespace App\Http\Controllers;

use App\Models\CustomWorkout;
use App\Models\Exercise;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Food;
use App\Models\UserTracker;
use App\Models\WorkoutDone;
use Carbon\Carbon;
use Illuminate\Support\Arr;
//use Illuminate\Contracts\Session\Session;
use Session;

class PagesController extends Controller
{
    
    /**
     * Create a new controller instance
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'about']]);
    }

    /**
     * return default index..
     */
    public function index() {

        return view('index');

    }

    /**
     * return about page..
     */
    public function about() {
        $authors = array('Em Vannin', 'Keo Leangchoue', 'Lang Singchheng', 'Noch PhakSamnang');
        return view('about', [
            'authors' => $authors
        ]);
    }

    // tasks components..

    /**
     * return routines..
     */
    public function routines(Request $request) {
        $user = Auth()->user()->name;

        return view('tasks.routines')->with('user', $user);
    }

    /**
     * return food..
     */
    public function food(Request $request) {
        // query
        $searchFood = $request->input('foodsearch');

        //$foods = Food::where('food', 'LIKE', "%{$searchFood}%")->paginate(2);
        $foods = Food::where('food', 'ilike', '%' . $searchFood . '%')->paginate(2);

        // validate
        /*$this->validate($request, [
            'foodsearch' => 'required'
        ]);*/

        return view('tasks.food', [
            'foods' => $foods
        ]);
    }

    /**
     * return all exercise related pages..
     */
    public function exercise(Request $request) {
        // query current user..
        $user_id = Auth()->user()->id;
        // query
        $searchExercise = $request->input('exerciseSearch');

        //$exercises = Exercise::where('exercise', 'LIKE', '%' . strtolower($searchExercise) . '%')->paginate(5);
        $exercises = Exercise::where('exercise', 'ilike', '%' . $searchExercise . '%')->paginate(5);

        $customworkouts = CustomWorkout::where([
            //['workout', 'LIKE', '%' . strtolower($searchExercise) . '%'],
            ['workout', 'ilike', '%' . $searchExercise . '%'],
            ['user_id', 'LIKE', $user_id]
        ])->paginate(5);

        return view('tasks.exercise', [
            'exercises' => $exercises,
            'customworkouts' => $customworkouts
        ]);
    }
    public function showexercise($id) {
        $exercise = Exercise::find($id);

        return view('tasks.showexercise', [
            'exercise' => $exercise
        ]);
    }
    // custom workout
    public function addExercise(Request $request) {

        // valid empty field
        $this->validate($request, [
            'exerciseName' => 'required'
        ]);

        $exercises = CustomWorkout::all();
        $workouts = Exercise::all();

        foreach($exercises as $exercise) {
            $casestr = strcasecmp($exercise->workout, $request->exerciseName);
            if ($casestr == 0 && $exercise->user_id == auth()->user()->id) {
                return back()->with('error', 'Oops! This exercise is already existed!');
                break;
            } else {continue;}
        }
        foreach($workouts as $workout) {
            $str = strcasecmp($workout->exercise, $request->exerciseName);
            if ($str == 0) {
                return back()->with('error', 'Oops! This exercise is already existed!');
                break;
            } else {continue;}
        }
        // store exercise..
        $exercise = new CustomWorkout();

        $exercise->workout = $request->exerciseName;
        $exercise->user_id = auth()->user()->id;

        // save..
        $exercise->save();

        return back()->with('success', 'An Exercise has been added!');
    }
    public function showworkout($id) {
        $customworkout = CustomWorkout::find($id);

        return view('tasks.showworkout', [
            'customworkout' => $customworkout
        ]);
    }
    public function destroyWorkout($id) {
        $exercise = CustomWorkout::find($id);
        $exercise->delete();

        return redirect('/exercise')->with('success', 'Exercise has been deleted');
    }

    // start workout
    public function startworkout(Request $request) {
        // query 
        // query authenticated user..
        $user_id = Auth()->user()->id;
        // query workouts..
        $searchExercise = $request->input('exerciseSearch');

        //$exercises = Exercise::where('exercise', 'LIKE', '%' . strtolower($searchExercise) . '%')->get();
        $exercises = Exercise::where('exercise', 'ilike', '%' . $searchExercise . '%')->get();

        $customworkouts = CustomWorkout::where([
            //['workout', 'LIKE', '%' . strtolower($searchExercise) . '%'],
            ['workout', 'ilike', '%' . $searchExercise . '%'],
            ['user_id', 'LIKE', $user_id]
        ])->get();

        //$trackerid = session('trackerid');
        $trackerid = session()->get('trackerid');

        $workoutdone = WorkoutDone::where([
            ['workout_id', 'LIKE', $trackerid],
            ['user_id', 'LIKE', $user_id]
        ])->get();

        $sets = WorkoutDone::where([
            ['workout_id', 'LIKE', $trackerid],
            ['user_id', 'LIKE', $user_id]
        ])->count();

        return view('tasks.workout', [
            'exercises' => $exercises, 'customworkouts' => $customworkouts
            , 'addedworkout' => $workoutdone
            , 'trackerid' => $trackerid
            , 'sets' => $sets
        ]);
    }
    // create a workout
    public function createworkout() {
        $user_id = Auth()->user()->id;
        // create a workout
        $tracker = new UserTracker();
        $tracker->user_id = $user_id;
        $tracker->total_duration = 0;
        $tracker->total_sets = 0;

        // save tracker..
        $tracker->save();

        $trackerid = $tracker->id;

        //to set a session variable use
        /*session(['trackerid' => $trackerid]);
        session()->save();*/
        session()->put('trackerid', $trackerid);
        
        return redirect('/startworkout');
        //return back();
    }
    // discard a workout
    public function discardworkout($id) {
        $tracker = UserTracker::find($id);
        $workouts = WorkoutDone::all();

        foreach($workouts as $workout) {
            if ($workout->workout_id == $tracker->id) {
                // delete workouts..
                $workout->delete();
            }
        }
        // delete workout
        $tracker->delete();

        return redirect('/routines')->with('success', 'Workout Discarded!');
    }
    // store sets & duration
    public function storetracker(Request $request, $trackerid) {
        // store total trackers
        $tracker = UserTracker::find($trackerid);

        $tracker->total_duration = $request->duration;
        $tracker->total_sets = $request->sets;

        // save..
        $tracker->save();

        return redirect('/tracker')->with('success', "You've finished a workout!");
    }
    // store workouts & sets
    public function storeworkout(Request $request, $id, $trackerid, $type) {
        // store workouts & sets
        $user_id = Auth()->user()->id;
        $workout = Exercise::find($id);
        $customworkout = CustomWorkout::find($id);
        $workoutdone = new WorkoutDone();

        $workoutdone->user_id = $user_id;
        if ($type == 1) {
            $workoutdone->workout_name = $customworkout->workout;
        } else {
            $workoutdone->workout_name = $workout->exercise;
        }

        $workoutdone->workout_id = $trackerid;
        $workoutdone->workout_sets = 1;

        // save added workout..
        $workoutdone->save();

        //return redirect('/startworkout')->with('trackerid', $trackerid);
        return back();
    }
    // remove workouts..
    public function removeworkout($id) {
        $workout = WorkoutDone::find($id);

        // delete..
        $workout->delete();

        return back()->with('success', 'Workout removed!');
    }
    // store routines
    public function storeroutine(Request $request) {
        $user = Auth()->user()->name;

        $totaltime = $request->duration;

        return redirect('/routines');
    }

    /**
     * tracker page
     */
    public function tracker(Request $request) {
        $now = Carbon::now();

        $user = Auth()->user()->name;
        $user_id = Auth()->user()->id;

        $from = date($now->startOfWeek());
        $to = date($now->endOfWeek());

        // days of the week..
        $monday = Carbon::now()->startOfWeek();
        $tuesday = $monday->copy()->addDay();
        $wednesday = $tuesday->copy()->addDay();
        $thursday = $wednesday->copy()->addDay();
        $friday = $thursday->copy()->addDay();
        $saturday = $friday->copy()->addDay();
        $sunday = $saturday->copy()->addDay();

        $days = array($monday, $tuesday, $wednesday, $thursday, $friday, $saturday, $sunday);

        // sum of duration each days..
        $sum_mon = UserTracker::whereDate('created_at', $monday)->where('user_id', 'LIKE', $user_id)->sum('total_duration');
        $sum_tue = UserTracker::whereDate('created_at', $tuesday)->where('user_id', 'LIKE', $user_id)->sum('total_duration');
        $sum_wed = UserTracker::whereDate('created_at', $wednesday)->where('user_id', 'LIKE', $user_id)->sum('total_duration');
        $sum_thur = UserTracker::whereDate('created_at', $thursday)->where('user_id', 'LIKE', $user_id)->sum('total_duration');
        $sum_fri = UserTracker::whereDate('created_at', $friday)->where('user_id', 'LIKE', $user_id)->sum('total_duration');
        $sum_sat = UserTracker::whereDate('created_at', $saturday)->where('user_id', 'LIKE', $user_id)->sum('total_duration');
        $sum_sun = UserTracker::whereDate('created_at', $sunday)->where('user_id', 'LIKE', $user_id)->sum('total_duration');

        $sums = array($sum_mon, $sum_tue, $sum_wed, $sum_thur, $sum_fri, $sum_sat, $sum_sun);

        //$sum_duration = UserTracker::where('user_id', 'LIKE', $user_id)->sum('total_duration');
        $sum_duration = UserTracker::whereBetween('created_at', [$from, $to])->where('user_id', 'LIKE', $user_id)->sum('total_duration');
        $sum_sets = UserTracker::where('user_id', 'LIKE', $user_id)->count();
        $last_workout = UserTracker::where('user_id', 'LIKE', $user_id)->select('created_at')->get()->last();

        // query all the workout dones..
        $workouteds = UserTracker::where('user_id', 'LIKE', $user_id)
        ->orderBy('created_at', 'desc')
        ->limit(8)->cursorPaginate(5);

        $dones = WorkoutDone::groupBy(['workout_id','workout_name'])
        ->select(array('workout_id', 'workout_name', WorkoutDone::raw("COUNT(*) as count_row")))
        ->get();

        $new_dones = array();

        return view('tasks.tracker',[
            'user' => $user,
            'days' => $days,
            'sums' => $sums,
            'sum_duration' => $sum_duration, 
            'sum_sets' => $sum_sets,
            'last_workout' => $last_workout,
            'workouteds' => $workouteds,
            'dones' => $dones
        ]);
    }

}
