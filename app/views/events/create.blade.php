@extends('layouts/default')

@section('scripts')
 {{ HTML::script('js/moment.js') }}
 {{ HTML::script('js/bootstrap-datetimepicker.min.js') }}
 {{ HTML::style('css/bootstrap-datetimepicker.min.css') }}
@stop

@section('ready')
	 <script type="text/javascript">
        $(function () {
            $('.datepicker').datetimepicker();
        });
    </script>
@stop


@section('Content')

	<div>
		<div class="container">
		<h2>Create A New Event</h2>
			{{ Form::open( ['route' => 'eventAdmin.store', 'class' => 'form-signin'] ) }}
				{{ Form::text('title', null, array('placeholder' => 'Title', 'class' => 'form-control', 'autofocus')) }}
				{{ Form::text('start_time', null, array('placeholder' => 'Start Time', 'class' => 'form-control datepicker', 'data-datepicker' => 'datepicker')) }}
				{{ Form::text('end_time', null, array('placeholder' => 'End Time', 'class' => 'form-control datepicker', 'data-datepicker' => 'datepicker')) }}
				{{ Form::text('location', null, array('placeholder' => 'Address', 'class' => 'form-control')) }}
				{{ Form::text('hosted_by', null, array('placeholder' => 'What/who is hosting? Business, Group, or Person?', 'class' => 'form-control')) }}
				{{ Form::textarea('description', null, array('placeholder' => 'A Short description of the event', 'class' => 'form-control')) }}
				<div class="checkbox">
					<label>
				    	{{ Form::checkbox('is_private', 1, null) }} Is the event private?
				    </label>
				</div>

				{{ Form::text('event_type', null, array('placeholder' => 'Event Type', 'class' => 'form-control')) }}
				{{ Form::submit('Create Event', array('class' => 'btn btn-lg btn-primary btn-block')) }}
			{{ Form::close() }}
		</div>
	</div>
@stop