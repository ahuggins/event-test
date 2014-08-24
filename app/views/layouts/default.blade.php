<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="UTF-8">
	<title></title>
	{{ HTML::script('js/jquery-1.11.1.min.js'); }}
	{{ HTML::script('js/bootstrap.min.js'); }}
	@yield('scripts')
	
	{{ HTML::style('css/bootstrap.min.css'); }}
	{{ HTML::style('css/style.css'); }}
	<link href='http://fonts.googleapis.com/css?family=Lato:100,400,900' rel='stylesheet' type='text/css'>
	
	@yield('ready')
	
</head>
<body>
	<nav class="navbar navbar-default" role="navigation">
		<div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{{ URL::to('/') }}">Lex.events</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li class="active"><a href="/events">All Events</a></li>
				</ul>
				<form class="navbar-form navbar-left" role="search">
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Search">
					</div>
					<button type="submit" class="btn btn-default">Submit</button>
				</form>
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							@if( Auth::user() )
								Hello {{ Auth::user()->username }} 
							@else 
								Menu
							@endif
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu" role="menu">
							@if(Auth::user())
								<li><a href="{{ URL::to('event.create') }}">Create Event</a></li>
								<li><a href="{{ URL::to('profile/edit') }}">Edit Profile</a></li>
								<li class="divider"></li>
								<li><a href="{{ URL::to('/logout') }}">Logout</a></li>
							@else
								<li><a href="{{ URL::to('/login') }}">Sign In</a></li>
								<li><a href="{{ URL::to('/users.create') }}">Sign Up</a></li>
							@endif						
						</ul>
					</li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>
	@yield('Content')
	
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-6603214-3', 'auto');
	  ga('send', 'pageview');

	</script>

</body>
</html>