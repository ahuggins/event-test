<!DOCTYPE html>
<html>
<head>
	<title></title>
	{{ HTML::script('js/jquery-1.11.1.min.js'); }}
	{{ HTML::script('js/bootstrap.min.js'); }}
	
	{{ HTML::style('css/bootstrap.min.css'); }}
	{{ HTML::style('css/style.css'); }}
</head>
<body>
		@yield('Content')
</body>
</html>