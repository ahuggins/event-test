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
					<img src="//lorempixel.com/750/350/nightlife/{{ rand(1,10) }}" alt="" class="img-responsive">
					<h3>Description:</h3>
					{{ $event->description }}			
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
					{{ $event->created_by }}
					Event Type: <br />
					{{ $event->event_type }}<br />
					Map:<br />
					MAP GOES HERE<br />
				</div>
			</div>
		</div>
	</div>
@stop