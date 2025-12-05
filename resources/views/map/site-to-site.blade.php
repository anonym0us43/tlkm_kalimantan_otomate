@extends('map.map_fullscreen')

@section('styles')
	<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
	<style>
		#map {
			height: 600px;
			width: 100%;
		}

		.leaflet-container {
			font-family: Arial, sans-serif;
		}

		.custom-marker {
			background-color: #fff;
			border: 3px solid #333;
			border-radius: 50%;
			width: 40px;
			height: 40px;
			display: flex;
			align-items: center;
			justify-content: center;
			font-weight: bold;
			font-size: 18px;
			box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
		}

		.marker-a {
			background-color: #4CAF50;
			color: white;
			border-color: #2E7D32;
		}

		.marker-b {
			background-color: #2196F3;
			color: white;
			border-color: #1565C0;
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
			transition: all 0.3s ease;
		}

		.distance-search-panel.minimized {
			min-width: auto;
			padding: 8px 12px;
		}

		.distance-search-panel.minimized .panel-content {
			display: none;
		}

		.distance-search-panel h6 {
			margin: 0 0 10px 0;
			font-size: 14px;
			font-weight: bold;
			display: flex;
			justify-content: space-between;
			align-items: center;
		}

		.minimize-btn {
			background: none;
			border: none;
			cursor: pointer;
			font-size: 18px;
			padding: 0;
			color: #333;
		}

		.minimize-btn:hover {
			color: #2196F3;
		}

		.direction-toggle {
			display: flex;
			gap: 8px;
			margin-bottom: 10px;
			align-items: center;
		}

		.direction-btn {
			flex: 1;
			padding: 8px;
			border: 2px solid #ddd;
			border-radius: 4px;
			background-color: white;
			cursor: pointer;
			font-size: 13px;
			font-weight: 500;
			transition: all 0.3s ease;
		}

		.direction-btn.active {
			background-color: #2196F3;
			color: white;
			border-color: #2196F3;
		}

		.direction-btn:hover {
			border-color: #2196F3;
		}

		.distance-input-group {
			display: flex;
			gap: 8px;
			margin-bottom: 10px;
		}

		.distance-input-group input {
			flex: 1;
			padding: 8px;
			border: 1px solid #ddd;
			border-radius: 4px;
			font-size: 13px;
		}

		.distance-input-group button {
			padding: 8px 15px;
			background-color: #2196F3;
			color: white;
			border: none;
			border-radius: 4px;
			cursor: pointer;
			font-size: 13px;
			font-weight: 500;
		}

		.distance-input-group button:hover {
			background-color: #1976D2;
		}

		.distance-info {
			font-size: 12px;
			color: #666;
			margin-top: 8px;
			padding-top: 8px;
			border-top: 1px solid #eee;
		}

		.result-marker {
			background-color: #FF5722;
			color: white;
			border-color: #D84315;
		}
	</style>
@endsection

@section('title', 'Site to Site')

@section('content')
	<div class="panel mt-6">
		<div style="position: relative;">
			<div id="map"></div>
			<div class="distance-search-panel" id="searchPanel">
				<h6>
					<span>🔍 Cari Titik Berdasarkan Jarak</span>
					<button class="minimize-btn" onclick="toggleMinimize()" id="minimizeBtn" title="Minimize">−</button>
				</h6>
				<div class="panel-content">
					<div class="direction-toggle">
						<button class="direction-btn active" onclick="setDirection('A-B')" id="dirAB">A → B</button>
						<button class="direction-btn" onclick="setDirection('B-A')" id="dirBA">B → A</button>
					</div>
					<div class="distance-input-group">
						<input type="number" id="distanceInput" placeholder="Jarak (meter)" min="0" step="1">
						<button onclick="findPointByDistance()">Cari</button>
					</div>
					<div class="distance-info" id="distanceInfo">
						Masukkan jarak dari titik A untuk mencari lokasi di jalur
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
	<script src="https://unpkg.com/jszip@3.10.1/dist/jszip.min.js"></script>
	<script src="https://unpkg.com/leaflet-kmz@latest/dist/leaflet-kmz.js"></script>
	<script src="https://unpkg.com/@turf/turf@6/turf.min.js"></script>

	<script>
		let map;
		let kmzLayer;
		let markerA, markerB;
		let resultMarker;
		let userLocationMarker;
		let routeCoordinates = [];
		let currentDirection = 'A-B';

		document.addEventListener('DOMContentLoaded', function() {
			const osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
				attribution: '',
				maxZoom: 19
			});

			const esriSat = L.tileLayer(
				'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
					attribution: '',
					maxZoom: 19
				});

			const baseLayers = {
				"OpenStreetMap": osm,
				"Satellite": esriSat
			};

			map = L.map('map', {
				center: [-1.2379, 116.8529],
				zoom: 16,
				layers: [osm]
			});

			L.control.layers(baseLayers, null, {
				collapsed: false,
				position: 'bottomleft'
			}).addTo(map);

			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(function(position) {
					const userLat = position.coords.latitude;
					const userLng = position.coords.longitude;

					userLocationMarker = L.marker([userLat, userLng], {
						icon: L.divIcon({
							className: 'custom-div-icon',
							html: `<div class="custom-marker" style="background-color: #4CAF50; color: white; border-color: #2E7D32;">👤</div>`,
							iconSize: [40, 40],
							iconAnchor: [20, 40],
							popupAnchor: [0, -40]
						})
					}).addTo(map);

					userLocationMarker.bindPopup(`
						<strong>Lokasi Anda</strong><br>
						Lat: ${userLat.toFixed(6)}<br>
						Lng: ${userLng.toFixed(6)}
					`);
				}, function(error) {
					console.log('Geolocation permission denied or unavailable:', error);
				});
			}

			function createCustomIcon(letter, cssClass) {
				return L.divIcon({
					className: 'custom-div-icon',
					html: `<div class="custom-marker ${cssClass}">${letter}</div>`,
					iconSize: [40, 40],
					iconAnchor: [20, 40],
					popupAnchor: [0, -40]
				});
			}

			const kmzPath = '/kmz-site-to-site/{{ $site_from }}_{{ $site_to }}.kmz';

			kmzLayer = L.kmzLayer(null, {
				ballon: true,
				bindPopup: true,
				preferCanvas: false
			});

			kmzLayer.addTo(map);

			kmzLayer.on('load', function(e) {
				console.log('KMZ loaded successfully');

				const layer = e.layer;
				const bounds = layer.getBounds();

				extractRouteCoordinates(layer);

				if (routeCoordinates.length >= 2) {
					const startPoint = routeCoordinates[0];
					const endPoint = routeCoordinates[routeCoordinates.length - 1];

					markerA = L.marker([startPoint[1], startPoint[0]], {
						icon: createCustomIcon('A', 'marker-a')
					}).addTo(map);
					markerA.bindPopup(`<strong>Point A</strong><br>${'{{ $site_from }}'}`);
					markerA.on('click', function() {
						map.setView([startPoint[1], startPoint[0]], 17);
					});

					markerB = L.marker([endPoint[1], endPoint[0]], {
						icon: createCustomIcon('B', 'marker-b')
					}).addTo(map);
					markerB.bindPopup(`<strong>Point B</strong><br>${'{{ $site_to }}'}`);
					markerB.on('click', function() {
						map.setView([endPoint[1], endPoint[0]], 17);
					});

					const totalDistance = calculateTotalDistance(routeCoordinates);
					updateDistanceInfo(`Total jarak: ${totalDistance.toFixed(2)} meter`);
				}

				if (bounds && bounds.isValid()) {
					const centerLatLng = bounds.getCenter();
					map.setView(centerLatLng, 15);
				}
			});

			kmzLayer.on('error', function(e) {
				console.error('Error loading KMZ file:', e);
				alert('Error: Tidak dapat memuat file KMZ. Pastikan file ada di: ' + kmzPath);
			});

			fetch(kmzPath)
				.then(response => {
					if (!response.ok) {
						throw new Error('File KMZ tidak ditemukan: ' + response.status);
					}
					return response.blob();
				})
				.then(blob => {
					const url = URL.createObjectURL(blob);
					kmzLayer.load(url);
				})
				.catch(error => {
					console.error('Error fetching KMZ:', error);
					alert('Error: ' + error.message);
				});
		});

		function extractRouteCoordinates(layer) {
			routeCoordinates = [];

			layer.eachLayer(function(subLayer) {
				if (subLayer instanceof L.Polyline && !(subLayer instanceof L.Polygon)) {
					const latlngs = subLayer.getLatLngs();

					const coords = Array.isArray(latlngs[0]) ? latlngs[0] : latlngs;

					coords.forEach(function(latlng) {
						routeCoordinates.push([latlng.lng, latlng.lat]);
					});
				}
			});

			console.log('Extracted coordinates:', routeCoordinates.length);
		}

		function calculateTotalDistance(coords) {
			let total = 0;
			for (let i = 0; i < coords.length - 1; i++) {
				const from = turf.point(coords[i]);
				const to = turf.point(coords[i + 1]);
				total += turf.distance(from, to, {
					units: 'meters'
				});
			}
			return total;
		}

		function findPointByDistance() {
			const targetDistance = parseFloat(document.getElementById('distanceInput').value);

			if (isNaN(targetDistance) || targetDistance < 0) {
				alert('Masukkan jarak yang valid (angka positif)');
				return;
			}

			if (routeCoordinates.length < 2) {
				alert('Route belum dimuat');
				return;
			}

			const totalDistance = calculateTotalDistance(routeCoordinates);

			if (targetDistance > totalDistance) {
				alert(`Jarak melebihi total panjang jalur (${totalDistance.toFixed(2)} meter)`);
				return;
			}

			const coords = currentDirection === 'B-A' ? [...routeCoordinates].reverse() : routeCoordinates;

			let accumulatedDistance = 0;
			let foundPoint = null;

			for (let i = 0; i < coords.length - 1; i++) {
				const from = turf.point(coords[i]);
				const to = turf.point(coords[i + 1]);
				const segmentDistance = turf.distance(from, to, {
					units: 'meters'
				});

				if (accumulatedDistance + segmentDistance >= targetDistance) {
					const remainingDistance = targetDistance - accumulatedDistance;
					const fraction = remainingDistance / segmentDistance;

					const line = turf.lineString([coords[i], coords[i + 1]]);
					foundPoint = turf.along(line, remainingDistance / 1000, {
						units: 'kilometers'
					});
					break;
				}

				accumulatedDistance += segmentDistance;
			}

			if (foundPoint) {
				const pointCoords = foundPoint.geometry.coordinates;

				if (resultMarker) {
					map.removeLayer(resultMarker);
				}

				const directionLabel = currentDirection === 'A-B' ? 'dari A' : 'dari B';
				const startPoint = currentDirection === 'A-B' ? 'A' : 'B';

				resultMarker = L.marker([pointCoords[1], pointCoords[0]], {
					icon: L.divIcon({
						className: 'custom-div-icon',
						html: `<div class=\"custom-marker result-marker\">📍</div>`,
						iconSize: [40, 40],
						iconAnchor: [20, 40],
						popupAnchor: [0, -40]
					})
				}).addTo(map);

				resultMarker.bindPopup(`
					<strong>Titik Ditemukan</strong><br>
					Jarak ${directionLabel}: ${targetDistance.toFixed(2)} meter<br>
					Lat: ${pointCoords[1].toFixed(6)}<br>
					Lng: ${pointCoords[0].toFixed(6)}
				`).openPopup();

				resultMarker.on('click', function() {
					map.setView([pointCoords[1], pointCoords[0]], 17);
				});

				map.setView([pointCoords[1], pointCoords[0]], 17);

				updateDistanceInfo(`✓ Titik ditemukan pada jarak ${targetDistance.toFixed(2)} meter ${directionLabel}`);
			}
		}

		function setDirection(direction) {
			currentDirection = direction;

			document.getElementById('dirAB').classList.toggle('active', direction === 'A-B');
			document.getElementById('dirBA').classList.toggle('active', direction === 'B-A');

			if (resultMarker) {
				map.removeLayer(resultMarker);
				resultMarker = null;
			}

			const directionText = direction === 'A-B' ? 'Masukkan jarak dari titik A' : 'Masukkan jarak dari titik B';
			updateDistanceInfo(directionText);
			document.getElementById('distanceInput').value = '';
		}

		function updateDistanceInfo(text) {
			document.getElementById('distanceInfo').textContent = text;
		}

		function toggleMinimize() {
			const panel = document.getElementById('searchPanel');
			const btn = document.getElementById('minimizeBtn');

			panel.classList.toggle('minimized');

			if (panel.classList.contains('minimized')) {
				btn.textContent = '+';
				btn.title = 'Expand';
			} else {
				btn.textContent = '−';
				btn.title = 'Minimize';
			}
		}
	</script>
@endsection
