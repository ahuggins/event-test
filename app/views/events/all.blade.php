@extends('layouts/default')

@section('Content')
	<div class="main">
		<div class="container">
			<h3>Today</h3>
			<div class="events">
				@foreach($events as $event)
					<div class="event">
						<img src="//lorempixel.com/300/150/nightlife/{{ rand(1,10) }}" alt="">
						<div class="details">
							<h3>{{ $event['title'] }}</h3>
							<div class="time">
							Time: {{ date( 'h:i A', strtotime( $event['start_time'] ) ) }} - {{ date( 'h:i A', strtotime( $event['end_time'] ) ) }} 
							</div>	
							<div class="description">
								{{ $event['description'] }}
							</div>
						</div> 
					</div>
				@endforeach
			</div>
		</div>
	</div>
@stop