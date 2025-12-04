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
		}

		.distance-search-panel h6 {
			margin: 0 0 10px 0;
			font-size: 14px;
			font-weight: bold;
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
			<div class="distance-search-panel">
				<h6>🔍 Cari Titik Berdasarkan Jarak</h6>
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
		let routeCoordinates = [];

		document.addEventListener('DOMContentLoaded', function() {
			const osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
				attribution: '© OpenStreetMap contributors',
				maxZoom: 19
			});

			const esriSat = L.tileLayer(
				'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
					attribution: 'Tiles © Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community',
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

					markerB = L.marker([endPoint[1], endPoint[0]], {
						icon: createCustomIcon('B', 'marker-b')
					}).addTo(map);
					markerB.bindPopup(`<strong>Point B</strong><br>${'{{ $site_to }}'}`);

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

			let accumulatedDistance = 0;
			let foundPoint = null;

			for (let i = 0; i < routeCoordinates.length - 1; i++) {
				const from = turf.point(routeCoordinates[i]);
				const to = turf.point(routeCoordinates[i + 1]);
				const segmentDistance = turf.distance(from, to, {
					units: 'meters'
				});

				if (accumulatedDistance + segmentDistance >= targetDistance) {
					const remainingDistance = targetDistance - accumulatedDistance;
					const fraction = remainingDistance / segmentDistance;

					const line = turf.lineString([routeCoordinates[i], routeCoordinates[i + 1]]);
					foundPoint = turf.along(line, remainingDistance / 1000, {
						units: 'kilometers'
					});
					break;
				}

				accumulatedDistance += segmentDistance;
			}

			if (foundPoint) {
				const coords = foundPoint.geometry.coordinates;

				if (resultMarker) {
					map.removeLayer(resultMarker);
				}

				resultMarker = L.marker([coords[1], coords[0]], {
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
					Jarak dari A: ${targetDistance.toFixed(2)} meter<br>
					Lat: ${coords[1].toFixed(6)}<br>
					Lng: ${coords[0].toFixed(6)}
				`).openPopup();

				map.setView([coords[1], coords[0]], 17);

				updateDistanceInfo(`✓ Titik ditemukan pada jarak ${targetDistance.toFixed(2)} meter dari A`);
			}
		}

		function updateDistanceInfo(text) {
			document.getElementById('distanceInfo').textContent = text;
		}
	</script>
@endsection
