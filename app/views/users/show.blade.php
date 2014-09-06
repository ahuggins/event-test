@extends('layouts/default')

@section('Content')
{{--This is terrible but I don't care. TODO: refactor--}}
<div class="login">
    <div class="container">
        <h2 class="form-signin-heading">{{$user->username}}'s Profile</h2>
        <div class="row">
            <div class="col-md-6">
                <div class="col-md-3">
                    Username:
                </div>
                <div class="col-md-3">
                    {{ $user->username }}<br/>
                </div>
            </div>
            <div class="col-md-6">
                <div class="col-md-3">
                    Email:
                </div>
                <div class="col-md-3">
                    {{ $user->email }}<br/>
                </div>
            </div>
            <div class="col-md-6">
                <div class="col-md-3">
                    Join Date:
                </div>
                <div class="col-md-3">
                    {{ date('m-d-Y', strtotime($user->created_at)) }}<br/>
                </div>
            </div>
            @if ($user->id === Auth::user()->id)
                <div class="col-md-6">
                    <a href="{{ URL::action('UsersController@edit') }}">
                        <button class="btn btn-default btn-xs pull-left">Edit Your Profile</button>
                    </a>
                </div>
             @endif
        </div>
    </div>
</div>
@stop