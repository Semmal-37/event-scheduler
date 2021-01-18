@extends('layouts.app')

@section('content')

@if(count($errors) > 0 )
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <ul class="p-0 m-0" style="list-style: none;">
        @foreach($errors->all() as $error)
        <li>{{$error}}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">   
            <div class="card">    

                <div class="card-header">
                    <h4 style="margin: 0;display: inline-block;">Schedule Event</h4>
                    <a style="float: right;" href="{{route('schedules')}}"class="btn btn-secondary">My Schedules</a> 
                </div>
                <div class="card-body">
            <form method="POST" action="{{ route('event') }}">
                 {{ csrf_field() }}
                <div class="form-group">
                  <label for="event">Event</label>
                  <input type="text" class="form-control" name="event" id="event" placeholder="Event name" required="">
               </div>
               <div class="form-group">
                  <label for="description">Describe your event</label>
                  <textarea class="form-control" name="description" id="description" rows="3" placeholder="Event Description" required=""></textarea>
               </div>
               <div class="form-group">
                  <label for="start_time">Choose your start time</label>
                  <input type="time" name="start_time" class="form-control" id="start_time" required="">
               </div>
               <div class="form-group">
                  <label for="end_time">Choose your end time</label>
                  <input type="time" name="end_time"  class="form-control" id="end_time" required="">
               </div>
               <div class="form-group">
                  <label for="day_of_week">Choose your day</label>
                  <select  name="day_of_week[]" id="day_of_week"  class="form-control" required="" multiple>                     
                        <option value="1">Monday</option>
                         <option value="2">Tuesday</option>
                          <option value="3">Wednesday</option>
                           <option value="4">Thursday</option>
                            <option value="5">Friday</option>
                             <option value="6">Saturday</option>
                              <option value="7">Sunday</option>
                  </select>
                   @error('day_of_week')
                  <div class="error">{{ $message }}</div>
                  @enderror
              </div>

              <button style="float: right" id="btnSubmit" type="submit" class="btn btn-secondary">Save</button>
            </form>
            </div>
            </div>
        </div>
    </div>
</div>

@endsection
 