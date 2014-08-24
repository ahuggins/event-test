@extends('layouts/default')

@section('scripts')
@stop

@section('ready')
@stop

@section('Content')
	<div class="main">
		<div class="container">
		<h3>{{ $event->title }}</h3>
			<div class="row">
				<div class="col-md-7">
					@if ($event->event_image)
						<img src="{{ asset('images') }}/{{ $event->event_image }}" alt="" class="img-responsive">
					@endif
					<h3>Description:</h3>
					{{ $event->description }}
					<h3>Full Details:</h3>	
					{{ $event->full_details }}
				</div>
				<div class="col-md-5">
					Start Date:<br />
					{{ date('m-d-Y H:i A', strtotime($event->start_time)) }}<br />
					End Date:<br />
					{{ date('m-d-Y H:i A', strtotime($event->end_time)) }}<br />
					Location:<br />
					{{ $event->location }}<br />
					Hosted By:<br />
					{{ $event->hosted_by }}<br />
					Created By:<br />
					{{ $event->created_by }}<br />
					Event Type: <br />
					{{ $event->event_type }}<br />
					Map:<br />
					MAP GOES HERE<br />
				</div>
			</div>
		</div>
	</div>
@stop