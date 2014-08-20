@extends('layouts/soon')

@section('Content')
	<div class="main">
		<div class="container">
			<div class="row">
				<h1 class="text-center">Coming Soon!!</h1>
				{{ $ENV }}
				{{ dd(App::environment()) }}
			</div>
		</div>
	</div>
@stop