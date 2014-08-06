<!DOCTYPE html>
<html>
<head>
	<title></title>
	{{ HTML::script('js/jquery-1.11.1.min.js'); }}
	{{ HTML::script('js/bootstrap.min.js'); }}
	{{ HTML::script('js/masonry.pkgd.min.js'); }}
	
	
	{{ HTML::style('css/bootstrap.min.css'); }}
	{{ HTML::style('css/style.css'); }}
	<link href='http://fonts.googleapis.com/css?family=Lato:100,400,900' rel='stylesheet' type='text/css'>
	<script>
		var $container = $('#events');
			// initialize
			$container.masonry({
			  columnWidth: 300,
			  itemSelector: '.event'
			});
		

	</script>
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
					<!-- <li><a href="#">Link</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="#">Action</a></li>
							<li><a href="#">Another action</a></li>
							<li><a href="#">Something else here</a></li>
							<li class="divider"></li>
							<li><a href="#">Separated link</a></li>
							<li class="divider"></li>
							<li><a href="#">One more separated link</a></li>
						</ul>
					</li> -->
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
								<li><a href="{{ URL::to('/event/create') }}">Create Event</a></li>
								<li class="divider"></li>
								<li><a href="{{ URL::to('/logout') }}">Logout</a></li>
							@else
								<li><a href="{{ URL::to('/login') }}">Sign In</a></li>
								<li><a href="{{ URL::to('/users/create') }}">Sign Up</a></li>
							@endif						
						</ul>
					</li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>
	@yield('Content')
</body>
</html>