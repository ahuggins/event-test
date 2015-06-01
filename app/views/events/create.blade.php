@extends('layouts/default')

@section('scripts')
<!-- Add Scripts here, will be below jQuery -->
 {{ HTML::script('js/moment.js') }}
 {{ HTML::script('js/bootstrap-datetimepicker.min.js') }}
 {{ HTML::script('js/summernote.min.js') }}
 {{ HTML::script('js/chosen.jquery.min.js') }}
 {{ HTML::script('js/create-event.js') }}
<!-- Add Styles here, will be below Twitter Bootstrap -->
 {{ HTML::style('css/bootstrap-datetimepicker.min.css') }}
 {{ HTML::style('css/font-awesome.min.css') }}
 {{ HTML::style('css/summernote.css') }}
 {{ HTML::style('css/summernote-bs3.css') }}
 {{ HTML::style('css/chosen.min.css') }}
@stop

@section('Content')
	<div>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					@if ($event)
						<h2>Edit {{ $event->title }}</h2>
					@else
						<h2>Create A New Event</h2>
					@endif
				</div>
				@if ($event)
					{{ Form::model($event, ['method' => 'PATCH', 'route' => ['event.update', $event->id], 'class' => 'form-signin', 'files' => true] ) }}
				@else
					{{ Form::model($event, ['route' => 'event.store', 'class' => 'form-signin', 'files' => true] ) }}
				@endif

						<div class="col-md-9">

							{{ Form::text('title', null, array('placeholder' => 'Title', 'class' => 'form-control', 'autofocus')) }}
							{{ $errors->first('title', '<span class=bg-danger>:message</span>') }}
							{{ Form::text('start_time', null, array('placeholder' => 'Start Time', 'class' => 'form-control datepicker', 'data-datepicker' => 'datepicker')) }}
							{{ $errors->first('start_time', '<span class=bg-danger>:message</span>') }}
							{{ Form::text('end_time', null, array('placeholder' => 'End Time', 'class' => 'form-control datepicker', 'data-datepicker' => 'datepicker')) }}
							{{ $errors->first('end_time', '<span class=bg-danger>:message</span>') }}
							{{ Form::text('location', null, array('placeholder' => 'Address', 'class' => 'form-control')) }}
							{{ Form::text('hosted_by', null, array('placeholder' => 'What/who is hosting? Business, Group, or Person?', 'class' => 'form-control')) }}
							{{ Form::text('description', null, array('placeholder' => 'Description (Maximum 140 characters)', 'class' => 'form-control', 'id' => 'description')) }}
							<div id="chars">140</div>
							<div class="form-group">
								<label for="full_details">Full Event Details: </label>
								{{ Form::textarea('full_details', null, array('class' => 'form-control summernote')) }}
							</div>
						</div>
						<div class="col-md-3">
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
							{{ Form::select('event_type[]', $tags, null, ['multiple' => 'true', 'class' => 'event-type form-control', 'data-placeholder' => 'Select Event Tags']) }}
							{{ $errors->first('event_type', '<span class=bg-danger>:message</span>') }}
							{{ Form::submit((!empty($event)?'Update Event' : 'Create Event'), array('class' => 'btn btn-lg btn-primary btn-block')) }}
						</div>
				{{ Form::close() }}
			</div> <!-- close .row -->
		</div> <!-- close .container -->
	</div>
@stop
