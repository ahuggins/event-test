@extends('layouts/default')

@section('Content')
	<div class="login">
		<div class="container">

		 		{{ Form::open( ['route' => 'users.update', 'class' => 'form-signin narrow', 'method' => 'put'] ) }}
	
				<h2 class="form-signin-heading">Update Profile</h2>
				<div>
					{{ Form::email('email', Input::old('email', $user->email), array('placeholder' => 'Email Address', 'class' => 'form-control', 'autofocus')) }}
					{{ $errors->first('email', '<span class=bg-danger>:message</span>') }}
				</div>
				<div>
					{{ Form::text('first_name', Input::old('first_name', $user->first_name), array('placeholder' => 'First Name', 'class' => 'form-control')) }}
					{{ $errors->first('first_name', '<span class=bg-danger>:message</span>') }}
				</div>
				<div>
					{{ Form::text('last_name', Input::old('last_name', $user->last_name), array('placeholder' => 'Last Name', 'class' => 'form-control')) }}
					{{ $errors->first('last_name', '<span class=bg-danger>:message</span>') }}
				</div>
				<div>{{ Form::submit('Update Profile', array('class' => 'btn btn-lg btn-primary btn-block')) }}</div>
				{{ Form::close() }}

		</div>
	</div>
	

@stop