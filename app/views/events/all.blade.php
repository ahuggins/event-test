@extends('layouts/default')

@section('scripts')
	{{ HTML::script('js/isotope.pkgd.min.js'); }}
	{{ HTML::script('js/imagesloaded.pkgd.min.js'); }}
	{{ HTML::script('js/filter.js'); }}
@stop

@section('Content')
	<div id="filters">
		<div class="container">
			<div class="row">
				<div class="ui-group col-md-12">
					<h3>Event Type</h3>
					<div class="btn-group js-radio-button-group" data-filter-group="color">
						<button class="btn btn-default is-checked" data-filter="">any</button>
						@if (isset($tags))
							@foreach($tags as $tag)
								<button class="btn btn-default" data-filter=".{{ $tag['filter_text'] }}">{{ $tag['tag_text'] }}</button>
							@endforeach
						@endif
					</div>
				</div>
				<div class="ui-group col-md-12">
					<h3>Date</h3>
					<div class="btn-group js-radio-button-group" data-filter-group="start-time">
						<button class="btn btn-default is-checked" data-filter="">Next 30 days</button>
						<button class="btn btn-default" data-filter=".today">Today</button>
						<button class="btn btn-default" data-filter=".tomorrow">Tomorrow</button>
						<button class="btn btn-default" data-filter=".this-week">This week (ends Sun)</button>
						<button class="btn btn-default" data-filter=".this-weekend">This weekend</button>
						<button class="btn btn-default" data-filter=".next-week">Next Week (starts Mon)</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="main">
		<div class="container">
			<div class="row">
				<div id="events">
					@if (isset($events))
						@forelse($events as $event)
							 <div class="event col-xs-12 col-sm-6 col-md-4 col-lg-3 clearfix {{ Events::timeClasses($event->start_time) }} @foreach($event->tags as $tag) {{ $tag['filter_text'] }} @endforeach">
								<a href="event/{{ $event['id'] }}">
									{{ HTML::image(URL::to('/') . Events::image($event), $event->locations->name, ['class' => 'img-responsive']) }}
								</a>
								<div class="details">
									<a href="event/{{ $event['id'] }}">
										<h3>{{ $event['title'] }}</h3>
									</a>
									<div class="location">
										<a href="location/{{ $event->locations->id }}">{{ $event->locations->name }}</a>
									</div>
									<div class="time">
										{{ Events::start($event->start_time) }} - {{ $event->end_time }}
									</div>
									<div class="description">
										{{ $event['description'] }}
									</div>
									<div class="controls">
										{{ Form::open( ['route' => 'event.attend','data-remote'] ) }}
											{{ Form::hidden('events_id', $event['id']) }}
												@if (isset($attending))
													@if (in_array($event['id'], $attending))
														{{ Form::hidden('attending', 'true') }}
														{{ Form::submit('Attending', ['class' => 'btn btn-default btn-xs pull-left']) }}
													@else
														{{ Form::hidden('attending', 'false') }}
														{{ Form::submit('Attend', ['class' => 'btn btn-default btn-xs pull-left']) }}
													@endif
												@endif
										{{ Form::close() }}
										@include('partials.edit')
									</div>
								</div>
							</div>
						@empty
							<div class="event col-md-4">There are no events to display.</div>
						@endforelse
					@endif
				</div>
			</div>
		</div>
	</div>
@stop
