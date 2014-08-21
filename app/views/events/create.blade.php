@extends('layouts/default')

@section('scripts')
<!-- Add Scripts here, will be below jQuery -->
 {{ HTML::script('js/moment.js') }}
 {{ HTML::script('js/bootstrap-datetimepicker.min.js') }}
 {{ HTML::script('js/bootstrap-tokenfield.min.js') }}
 {{ HTML::script('js/typeahead.bundle.min.js') }}
<!-- Add Styles here, will be below Twitter Bootstrap -->
 {{ HTML::style('css/bootstrap-datetimepicker.min.css') }}
 {{ HTML::style('css/bootstrap-tokenfield.min.css') }}
 {{ HTML::style('css/tokenfield-typeahead.min.css') }}

@stop

@section('ready')
	 <script type="text/javascript">
        $(function () {
            $('.datepicker').datetimepicker();
            $('#tokenfield-typeahead').tokenfield({});
        });
    </script>
@stop


@section('Content')
	<div>
		<div class="container">
		<h2>Create A New Event</h2>
			{{ Form::open( ['route' => 'eventAdmin.store', 'class' => 'form-signin', 'files' => true] ) }}
				{{ Form::text('title', null, array('placeholder' => 'Title', 'class' => 'form-control', 'autofocus')) }}
				{{ Form::text('start_time', null, array('placeholder' => 'Start Time', 'class' => 'form-control datepicker', 'data-datepicker' => 'datepicker')) }}
				{{ Form::text('end_time', null, array('placeholder' => 'End Time', 'class' => 'form-control datepicker', 'data-datepicker' => 'datepicker')) }}
				{{ Form::text('location', null, array('placeholder' => 'Address', 'class' => 'form-control')) }}
				{{ Form::text('hosted_by', null, array('placeholder' => 'What/who is hosting? Business, Group, or Person?', 'class' => 'form-control')) }}
				{{ Form::textarea('description', null, array('placeholder' => 'MAX 140 characters', 'class' => 'form-control')) }}
				{{ Form::textarea('full_details', null, array('placeholder' => 'Go nuts', 'class' => 'form-control')) }}
				<div class="form-group">
				    {{ Form::label('event_image', 'Add Image') }}
					{{ Form::file('event_image') }}
				    <p class="help-block">Upload an Image to represent the event.</p>
				</div>
				
				<div class="checkbox">
					<label>
				    	{{ Form::checkbox('is_private', 1, null) }} Is the event private?
				    </label>
				</div>
				{{ Form::text('event_type', null, array('placeholder' => 'Add Event Types, Type and hit enter', 'class' => 'form-control tokenfield', 'id' => 'tokenfield-typeahead')) }}
				{{ Form::submit('Create Event', array('class' => 'btn btn-lg btn-primary btn-block')) }}
			{{ Form::close() }}
		</div>
	</div>
@stop