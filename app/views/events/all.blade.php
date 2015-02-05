@extends('layouts/default')

@section('scripts')
{{ HTML::script('js/isotope.pkgd.min.js'); }}
{{ HTML::script('js/imagesloaded.pkgd.min.js'); }}

@stop

@section('ready')
<script>
	$(document).ready(function() {
		var $container = $('#events').imagesLoaded( function() {
		  $container.isotope({
		    itemSelector: '.event',
		    layoutMode: 'masonry'
		  });
		});
	  	
	  	$('form[data-remote]').on('submit', function(e) {
	  		e.preventDefault();
			var form = $(this);
			var method = form.find('input[name="_method"]').val() || 'POST';
			var url = form.prop('action');
			var value = $(this).find('input[type="submit"]').val();
			$.ajax({
				type: method,
				url: url,
				data: form.serialize(),
				success: function() {
					if (value == 'Attend') {
						form.find('input[name=attending]').val('true');
						form.find('input[type=submit]').val('Attending');	
					} else {
						form.find('input[name=attending]').val('false');
						form.find('input[type=submit]').val('Attend');
					};
					
				}
			});
		});
	  // store filter for each group
	  var filters = {};

	  $('#filters').on( 'click', '.btn', function() {
	    var $this = $(this);
	    // get group key
	    var $buttonGroup = $this.parents('.btn-group');
	    var filterGroup = $buttonGroup.attr('data-filter-group');
	    // set filter for group
	    filters[ filterGroup ] = $this.attr('data-filter');
	    // combine filters
	    var filterValue = '';
	    for ( var prop in filters ) {
	      filterValue += filters[ prop ];
	    }
	    // set filter for Isotope
	    $container.isotope({ filter: filterValue });
	  });

	  // change is-checked class on buttons
	  $('.btn-group').each( function( i, buttonGroup ) {
	    var $buttonGroup = $( buttonGroup );
	    $buttonGroup.on( 'click', 'button', function() {
	      $buttonGroup.find('.is-checked').removeClass('is-checked');
	      $( this ).addClass('is-checked');
	    });
	  });
	});
</script>
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
						
							<?php 
								$class = '';
								if ( date('Ymd') == date('Ymd', strtotime($event->start_time) ) ) {
									$class[] = 'today';
								} elseif ( date('Ymd', strtotime('+1 day') ) == date('Ymd', strtotime($event->start_time) ) ) {
									$class[] = 'tomorrow';
								} elseif(
									date('Ymd', strtotime('next Thursday') ) == date('Ymd', strtotime($event->start_time) ) ||
									date('Ymd', strtotime('next Friday') ) == date('Ymd', strtotime($event->start_time) ) ||
									date('Ymd', strtotime('next Saturday') ) == date('Ymd', strtotime($event->start_time) ) ||
									date('Ymd', strtotime('next Sunday') ) == date('Ymd', strtotime($event->start_time) ) 
									) {
									$class[] = "this-weekend";
								}
								if( ( date('W') == date('W', strtotime($event->start_time) ) ) )
								{
									$class[] = 'this-week';
								}
								elseif( ( date('W', strtotime('+1 week')) == date('W', strtotime($event->start_time) ) ) )
								{
									$class[] = 'next-week';
								}
							 ?>
							 <div class="event col-xs-12 col-sm-6 col-md-4 col-lg-3 clearfix @if( is_array($class) ) {{ implode(' ', $class) }} @endif @foreach($event['Tags'] as $tag) {{ $tag['filter_text'] }} @endforeach">
							 	@if ($event->event_image)
							 		<a href="event/{{ $event['id'] }}">
										<img src="images/{{ $event->event_image }}" alt="" class="img-responsive">
									</a>
							 	@endif
								<div class="details">
									<a href="event/{{ $event['id'] }}">
										<h3>{{ $event['title'] }}</h3>
									</a>
									<div class="location">
										{{ $event['hosted_by'] }}
									</div>
									<div class="time">
										{{ date('M d', strtotime( $event['start_time'] ) ) }} @
										{{ date( 'h:i A', strtotime( $event['start_time'] ) ) }} - {{ date( 'h:i A', strtotime( $event['end_time'] ) ) }} 
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
										
										@if ($event['created_by'] == Auth::user()->username)
											<a href="event/{{ $event['id'] }}/edit">
												<button class="btn btn-default btn-xs pull-right">Edit</button>	
											</a>
										@endif
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