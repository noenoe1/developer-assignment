<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" value="{{ csrf_token() }}"/>

		@vite(['resources/css/app.css', 'resources/js/app.js'])

		<title>Laravel + Vue 3 with Vite</title>

	</head>
	<body>

		<div id="app"></div>
		
	</body>
</html>