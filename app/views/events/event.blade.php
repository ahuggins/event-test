@extends('layouts/default')

@section('Content')
	<div class="main">
		<div class="container">
		<h3>{{ $event->title }}</h3>
			<div class="row">
				<div class="col-md-7">
					@include('partials.edit')
					@if ($event->event_image)
						<img src="{{ asset('images') }}/{{ $event->event_image }}" alt="" class="img-responsive">
					@endif
					<h3>Description:</h3>
					{{ $event->description }}
					<h3>Full Details:</h3>
					{{ $event->full_details }}
				</div>
				<div class="col-md-5">
					Time: <br>
					{{ Events::start($event->start_time) }} - {{ $event->end_time }} <br>
					Location:<br>
					{{ $event->locations->address }}<br>
					{{ $event->locations->city }} {{ $event->locations->state }}, {{ $event->locations->zip }} <br>
					Hosted By:<br>
					{{ $event->locations->name }}<br>
					Created By:<br>
					{{ $event->created_by }}<br>
					Event Type: <br>
					{{ $event->event_type }}<br>
					Map:<br>
					MAP GOES HERE<br>
				</div>
			</div>
		</div>
	</div>
@stop
