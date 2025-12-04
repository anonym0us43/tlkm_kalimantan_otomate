<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>@yield('title', 'Site to Site Map') - OTOMATE</title>
		<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
		@yield('styles')
		<style>
			html,
			body {
				height: 100%;
				margin: 0;
				padding: 0;
				width: 100%;
				overflow: hidden;
			}

			body {
				background: #f8f9fa;
			}

			#map {
				height: 100vh;
				width: 100vw;
			}

			.distance-search-panel {
				position: absolute;
				top: 10px;
				right: 10px;
				background: white;
				padding: 15px;
				border-radius: 8px;
				box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
				z-index: 1000;
				min-width: 280px;
			}
		</style>
	</head>

	<body>
		@yield('content')
		@yield('scripts')
	</body>

</html>
