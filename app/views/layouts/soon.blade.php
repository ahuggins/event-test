<!DOCTYPE html>
<html>
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
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

	@yield('ready')

</head>
<body>
	<nav class="navbar navbar-default" role="navigation">
		<div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<a class="navbar-brand" href="{{ URL::to('/') }}">Lex.events</a>
			</div>
		</div><!-- /.container-fluid -->
	</nav>
	@yield('Content')
</body>
</html>
