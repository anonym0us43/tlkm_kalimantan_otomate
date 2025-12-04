@extends('map.map_fullscreen')

@section('title', 'Coordinate to Coordinate')

@section('content')
	<div id="map"></div>
@endsection

@section('scripts')
	<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
	<script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
	<script>
		const coordinate_from = @json($coordinate_from);
		const coordinate_to = @json($coordinate_to);

		function parseCoord(coord) {
			if (Array.isArray(coord)) return coord.map(Number);
			if (typeof coord === 'string') {
				const parts = coord.split(',').map(Number);
				return [parts[0], parts[1]];
			}
			return [0, 0];
		}

		const start = parseCoord(coordinate_from);
		const end = parseCoord(coordinate_to);

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

		let map = L.map('map', {
			center: start,
			zoom: 13,
			layers: [osm]
		});

		L.control.layers(baseLayers, null, {
			collapsed: false,
			position: 'bottomleft'
		}).addTo(map);

		function createCustomIcon(letter, cssClass) {
			return L.divIcon({
				className: 'custom-div-icon',
				html: `<div class=\"custom-marker ${cssClass}\">${letter}</div>`,
				iconSize: [40, 40],
				iconAnchor: [20, 40],
				popupAnchor: [0, -40]
			});
		}

		const DistanceControl = L.Control.extend({
			options: {
				position: 'topright'
			},
			onAdd: function(map) {
				const wrapper = L.DomUtil.create('div', 'distance-info-wrapper leaflet-control');
				const infoDiv = L.DomUtil.create('div', 'distance-info-control', wrapper);
				infoDiv.id = 'distanceInfo';
				infoDiv.innerHTML = 'Menunggu rute...';
				return wrapper;
			}
		});
		const distanceControl = new DistanceControl();
		map.addControl(distanceControl);

		function setDistanceInfo(text) {
			document.getElementById('distanceInfo').innerHTML = text;
		}

		let routingControl = L.Routing.control({
			waypoints: [
				L.latLng(start[0], start[1]),
				L.latLng(end[0], end[1])
			],
			routeWhileDragging: false,
			show: false,
			addWaypoints: false,
			draggableWaypoints: false,
			fitSelectedRoutes: true,
			showAlternatives: false,
			lineOptions: {
				styles: [{
					color: '#2196F3',
					weight: 6
				}]
			},
			createMarker: function(i, wp, nWps) {
				if (i === 0) {
					return L.marker(wp.latLng, {
						icon: createCustomIcon('A', 'marker-a')
					}).bindPopup('Coordinate From');
				} else {
					return L.marker(wp.latLng, {
						icon: createCustomIcon('B', 'marker-b')
					}).bindPopup('Coordinate To');
				}
			}
		});
		routingControl.addTo(map);

		setTimeout(function() {
			const routingPanel = document.querySelector('.leaflet-routing-container');
			if (routingPanel) {
				routingPanel.style.display = 'none';
			}
		}, 100);

		routingControl.on('routesfound', function(e) {
			const route = e.routes[0];
			const meters = route.summary.totalDistance;
			setDistanceInfo(`Jarak rute: ${meters.toLocaleString()} meter`);
		});

		routingControl.on('routingerror', function(e) {
			setDistanceInfo('Gagal menemukan rute.');
		});
	</script>
@endsection

@section('styles')
	<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
	<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
	<style>
		#map {
			height: 100vh;
			width: 100vw;
		}

		.distance-info-wrapper {
			background: white;
			border-radius: 10px;
			box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
			margin: 10px;
		}

		.distance-info-control {
			padding: 12px 18px;
			font-size: 15px;
			font-weight: 500;
			color: #333;
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
			font-size: 20px;
			color: #222;
			box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
		}

		.marker-a {
			background-color: #4CAF50;
			color: #fff;
			border-color: #2E7D32;
		}

		.marker-b {
			background-color: #2196F3;
			color: #fff;
			border-color: #1565C0;
		}
	</style>
@endsection
