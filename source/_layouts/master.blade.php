<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible"
		  content="ie=edge">
	<title>Blader</title>
	<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
	<link rel="stylesheet"
		  href="{{ mix('/css/app.css') }}">
</head>
<body>
	<div class="master">
		@yield('content')
	</div>
</body>
</html>