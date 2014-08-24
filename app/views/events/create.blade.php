@extends('layouts/default')

@section('scripts')
<!-- Add Scripts here, will be below jQuery -->
 {{ HTML::script('js/moment.js') }}
 {{ HTML::script('js/bootstrap-datetimepicker.min.js') }}
 {{ HTML::script('js/bootstrap-tokenfield.min.js') }}
 {{ HTML::script('js/typeahead.bundle.min.js') }}
 {{ HTML::script('js/summernote.min.js') }}
<!-- Add Styles here, will be below Twitter Bootstrap -->
 {{ HTML::style('css/bootstrap-datetimepicker.min.css') }}
 {{ HTML::style('css/bootstrap-tokenfield.min.css') }}
 {{ HTML::style('css/tokenfield-typeahead.min.css') }}
 {{ HTML::style('css/summernote.css') }}
 
 <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">


@stop

@section('ready')
	 <script type="text/javascript">
        $(function () {
            $('.datepicker').datetimepicker();
            $('#tokenfield-typeahead').tokenfield({});
            $('.summernote').summernote({
				  toolbar: [
				    //[groupname, [button list]]
				    ['format', ['style']], 
				    ['style', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
				    ['fontsize', ['fontsize']],
				    ['color', ['color']],
				    ['para', ['ul', 'ol', 'paragraph']],
				    ['insert', ['picture', 'link', 'video', 'hr']],
				    ['misc', ['fullscreen', 'codeview', 'undo', 'redo']],

				  ],
				  height: 300
				});
        });
    </script>
@stop


@section('Content')
	<div>
		<div class="container">
			<div class="row">
				<h2>Create A New Event</h2>
					{{ Form::open( ['route' => 'eventAdmin.store', 'class' => 'form-signin', 'files' => true] ) }}
						<div class="col-md-9">
						
							{{ Form::text('title', null, array('placeholder' => 'Title', 'class' => 'form-control', 'autofocus')) }}
							{{ Form::text('start_time', null, array('placeholder' => 'Start Time', 'class' => 'form-control datepicker', 'data-datepicker' => 'datepicker')) }}
							{{ Form::text('end_time', null, array('placeholder' => 'End Time', 'class' => 'form-control datepicker', 'data-datepicker' => 'datepicker')) }}
							{{ Form::text('location', null, array('placeholder' => 'Address', 'class' => 'form-control')) }}
							{{ Form::text('hosted_by', null, array('placeholder' => 'What/who is hosting? Business, Group, or Person?', 'class' => 'form-control')) }}
							{{ Form::textarea('description', null, array('placeholder' => 'MAX 140 characters', 'class' => 'form-control')) }}
							<div class="form-group">
								{{ Form::textarea('full_details', null, array('placeholder' => 'Go nuts', 'class' => 'form-control summernote')) }}
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
							{{ Form::text('event_type', null, array('placeholder' => 'Add Event Types, Type and hit enter', 'class' => 'form-control tokenfield', 'id' => 'tokenfield-typeahead')) }}
							{{ Form::submit('Create Event', array('class' => 'btn btn-lg btn-primary btn-block')) }}
						</div>	
				{{ Form::close() }}
			</div> <!-- close .row -->
		</div> <!-- close .container -->
	</div>
@stop