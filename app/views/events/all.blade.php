@extends('layouts/default')

@section('scripts')
{{ HTML::script('js/isotope.pkgd.min.js'); }}
@stop

@section('ready')
<script>
	$(document).ready(function() {
	  // init Isotope
	  var $container = $('#events').isotope({
	    itemSelector: '.event',
	    layoutMode: 'masonry'
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
						@foreach($tags as $tag)
							<button class="btn btn-default" data-filter=".{{ $tag['filter_text'] }}">{{ $tag['tag_text'] }}</button>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="main">
		<div class="container">
		<h3>Today</h3>
			<div class="row">
				<div id="events">
					@foreach($events as $event)
						<div class="event col-md-3 clearfix @foreach($event['Tags'] as $tag) {{ $tag['filter_text'] }} @endforeach">
							<img src="//lorempixel.com/750/350/nightlife/{{ rand(1,10) }}" alt="" class="img-responsive">
							<div class="details">
							<?php Debugbar::addMessage($event); ?>
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
	</div>
@stop