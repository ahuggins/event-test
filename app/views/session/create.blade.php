@extends('layouts/soon')

@section('Content')
	<div class="login">
		<div class="container">

		 	{{ Form::open( ['route' => 'session.store', 'class' => 'form-signin narrow'] ) }}
		 		<h2 class="form-signin-heading">Login Below</h2>
				@if($error = Session::get('error'))
					<span class="bg-danger">{{ $error }}</span>
				@endif


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

					<h4>OR</h4>

					<a class="btn btn-block btn-social btn-facebook btn-lg" href="login/facebook">
					  <i class="fa fa-facebook"></i>
					  Sign in with Facebook
					</a>

					<h4>OR</h4>

					<a href="{{ URL::to('users/create') }}">Sign Up</a> if you haven't already
				</div>
			{{ Form::close() }}
		</div>
	</div>
@stop



@section('Content')
	<div class="login">
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-md-offset-2">



				</div>
				<div class="col-md-4">

					Facebook Login Button

				</div>

			</div>

		</div>
	</div>
@stop
