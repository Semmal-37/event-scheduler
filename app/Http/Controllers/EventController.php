<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Models\User;
use App\Models\Event;
use App\Models\Schedule;
use Carbon\Carbon;
use DateTime;
use DB;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $id = Auth::user()->id;

        try{

            $events = Event::with('shedules')->where('user_id', '=', $id)->get();

            return view('calendar/schedules', compact('events'));

        } catch(Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function create(Request $request)
    {
        //Getting the currewnt Authenticated user id
        $id = Auth::user()->id;

        try{

            //Validating event form values
            $validator = Validator::make($request->all() , ['event' => 'required|max:255', 'description' => 'required', 'day_of_week' => 'required', 'start_time' => 'date_format:H:i', 'end_time' => 'date_format:H:i|after:start_time', ], ['end_time.after' => 'You must enter end time higher than start time.', ]);

            if ($validator->fails())
            {
                return redirect()
                    ->route('create-event')
                    ->withErrors($validator)->withInput();
            }

            //Setting up the start date,end date and time to create event and schedules
            $event_startDate = Carbon::now();
            $event_endDate = Carbon::now()->addDays(90);
            $event_startTime = Carbon::parse($request->start_time)
                ->format('H:i:s');
            $event_endTime = Carbon::parse($request->end_time)
                ->format('H:i:s');

            //Storing user event days in array
            $schedule_days = $request->day_of_week;

            //Creating new Event
            $event = new Event;

            $event->user_id = $id;
            $event->name = $request->event;
            $event->description = $request->description;
            $event->day_of_week = implode(',', $request->day_of_week);
            $event->start_date = $event_startDate;
            $event->end_date = $event_endDate;

            $event->save();

            //Getting current event id from created event object
            $event_id = $event->id;

            //Calling schedule method to store schedules for created event
            $this->createSchedules($schedule_days, $event_id, $event_startTime, $event_endTime, $event_startDate, $event_endDate);

            return redirect()->route('schedules')
                ->with('message', 'The new event added successfully!');

        } catch(Exception $e) {
            return back()->withErrors($e->getMessage());
        }

    }

    public function createSchedules($schedule_days, $event_id, $event_startTime, $event_endTime, $event_startDate, $event_endDate)
    {

        //Assigning values to each day of the week
        $days = array(
            '1' => 'Monday',
            '2' => 'Tuesday',
            '3' => 'Wednesday',
            '4' => 'Thursday',
            '5' => 'Friday',
            '6' => 'Saturday',
            '7' => 'Sunday'
        );

        //Schedule date between event's start date and end date
        foreach ($schedule_days as $schedule_day => $value)
        {
            for ($i = strtotime($days[$value], strtotime($event_startDate));$i <= strtotime($event_endDate);$i = strtotime('+1 week', $i))

            $scheduleDays[] = date('Y-m-d', $i);
        }

        //Assigning the schedule's start time and end time for scheduled events
        foreach ($scheduleDays as $scheduleDay => $value)
        {
            //Merging scheduled date with starttime and endtime
            $schedule_startTime = ($value . " " . $event_startTime);
            $schedule_endTime = ($value . " " . $event_endTime);

            //Creating schedules for scheduled days
            $schedule = new Schedule;
            $schedule->event_id = $event_id;
            $schedule->start_time = $schedule_startTime;
            $schedule->end_time = $schedule_endTime;
            $schedule->save();
        }

        return back()->with('success', 'Schedules updated successfully!');

    }

}

