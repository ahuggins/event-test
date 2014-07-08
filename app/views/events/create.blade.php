@extends('layouts/default')

@section('Content')

	<div>
		<div class="container">
		<h2>Create A New Event</h2>
			{{ Form::open( ['route' => 'eventAdmin.store'] ) }}
				{{ Form::text('title', null, array('placeholder' => 'Title', 'class' => 'form-control', 'autofocus')) }}
				{{ Form::text('start_time', null, array('placeholder' => 'Start Time', 'class' => 'form-control')) }}
				{{ Form::text('end_time', null, array('placeholder' => 'End Time', 'class' => 'form-control')) }}
				{{ Form::text('location', null, array('placeholder' => 'Location', 'class' => 'form-control')) }}
				{{ Form::textarea('description', null, array('placeholder' => 'A Short description of the event', 'class' => 'form-control')) }}
				<div class="checkbox">
					<label>
				    	{{ Form::checkbox('is_private', 0, null) }} Is the event private?
				    </label>
				</div>

				{{ Form::text('event_type', null, array('placeholder' => 'Event Type', 'class' => 'form-control')) }}
				{{ Form::hidden('created_by', $user) }}
				{{ Form::submit() }}
			{{ Form::close() }}
		</div>
	</div>
@stop