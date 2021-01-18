@extends('layouts.app')

@section('content')
 <script>
    $(document).ready(function() {
        // page is now ready, initialize the calendar...
        $('#calendar').fullCalendar({
            themeSystem: 'bootstrap4',
             header: {
                   left: 'prev,next today',
                   center: 'title',
                   right: 'month,agendaWeek,agendaDay,listMonth'
                     },
            weekNumbers: true,
            eventLimit: true, // allow "more" link when too many events
            events : [
                @foreach ($events as $event => $value)
                
                @foreach ($value->shedules as $cal_event)
                {
                    title : '{{  $value->name }}',
                    description : '{{  $value->description }}',
                    start : '{{ $cal_event->start_time }}',
                    @if ($cal_event->end_time)
                            end: '{{ $cal_event->end_time }}',
                    @endif
                },
                 @endforeach
                @endforeach
            ],
        });
    });
</script>

@if(session()->has('message'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
        {{ session()->get('message') }}
    </div>
@endif
<div class="container">
    <div class="card">
        <div class="card-header"><h4 style="text-align: center;margin: 0;display: inline-block;">Your Schedules</h4>
         <a style="float: right;" href="{{route('create-event')}}"class="btn btn-secondary">Make Schedule</a> </div>
         <div class="card-body">
        <div id='calendar'></div>
        </div>
    </div>
</div>
@endsection


