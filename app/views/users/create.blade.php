@extends('layouts/default')

@section('Content')
	<div class="login">
		<div class="container">

		 		{{ Form::open( ['route' => 'users.store', 'class' => 'form-signin'] ) }}

				<h2 class="form-signin-heading">Create Account</h2>
				<div>
					{{ Form::email('email', '', array('placeholder' => 'Email Address', 'class' => 'form-control', 'autofocus')) }}
					{{ $errors->first('username', '<span class=error>:message</span>') }}
				</div>
				<div>
					{{ Form::password('password', array('placeholder' => 'Password', 'class' => 'form-control') ) }}
					{{ $errors->first('password', '<span class=error>:message</span>') }}
				</div>
				<div>{{ Form::submit('Create Account', array('class' => 'btn btn-lg btn-primary btn-block')) }}</div>
				{{ Form::close() }}

		</div>
	</div>
	

@stop