@extends('layouts/soon')

@section('Content')
	<div class="login">
		<div class="container">
		 	{{ Form::open( ['route' => 'session.store', 'class' => 'form-signin narrow'] ) }}
		 		<h2 class="form-signin-heading">Login Below</h2>
		 		{{ Session::get('flash_message') }}
		 		{{ $errors->first('email', '<span class=bg-danger>:message</span>') }}
		 		<div>
					{{ Form::email('email', '', array('placeholder' => 'Email Address', 'class' => 'form-control', 'autofocus')) }}
				</div>

				<div>
					{{ Form::password('password', array('placeholder' => 'Password', 'class' => 'form-control') ) }}
				</div>
				<div>{{ Form::submit('Login', array('class' => 'btn btn-lg btn-primary btn-block')) }}</div>
				<div class="text-center">
					<a href="{{ URL::to('users/create') }}">Sign Up</a> if you haven't already
				</div>
			{{ Form::close() }}

		</div>
	</div>
@stop