@extends('map.map-fullscreen')

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
			border: 2px solid #333;
			border-radius: 8px;
			padding: 4px 8px;
			display: inline-flex;
			align-items: center;
			justify-content: center;
			font-weight: bold;
			font-size: 11px;
			box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
			white-space: nowrap;
			max-width: 150px;
			overflow: visible;
			text-overflow: ellipsis;
			position: relative;
		}

		.custom-marker::after {
			content: '';
			position: absolute;
			bottom: -8px;
			left: 50%;
			transform: translateX(-50%);
			width: 0;
			height: 0;
			border-left: 8px solid transparent;
			border-right: 8px solid transparent;
			border-top: 8px solid;
			border-top-color: inherit;
		}

		.marker-a {
			background-color: #4CAF50;
			color: white;
			border-color: #2E7D32;
		}

		.marker-a::after {
			border-top-color: #4CAF50;
		}

		.marker-b {
			background-color: #2196F3;
			color: white;
			border-color: #1565C0;
		}

		.marker-b::after {
			border-top-color: #2196F3;
		}

		.site-input-panel {
			position: absolute;
			top: 8px;
			right: 8px;
			background: white;
			border-radius: 6px;
			box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
			z-index: 1000;
			max-width: 280px;
			width: calc(100vw - 20px);
			transition: all 0.3s ease;
			overflow: hidden;
		}

		.site-input-panel.collapsed {
			width: auto;
			max-width: 220px;
		}

		.site-input-panel.disabled {
			opacity: 0.6;
			pointer-events: none;
		}

		.panel-header {
			padding: 10px 12px;
			background: linear-gradient(135deg, #000 0%, #1a1a1a 100%);
			color: #fff;
			cursor: pointer;
			display: flex;
			justify-content: space-between;
			align-items: center;
			user-select: none;
			transition: background 0.3s ease;
		}

		.panel-header:hover {
			background: linear-gradient(135deg, #000 0%, #1a1a1a 100%);
		}

		.panel-header h6 {
			margin: 0;
			font-size: 12px;
			font-weight: bold;
			display: flex;
			align-items: center;
			gap: 6px;
		}

		.collapse-icon {
			font-size: 16px;
			transition: transform 0.3s ease;
			font-weight: bold;
		}

		.site-input-panel.collapsed .collapse-icon {
			transform: rotate(180deg);
		}

		.panel-content {
			padding: 10px;
			max-height: 500px;
			overflow-y: auto;
			transition: max-height 0.3s ease, padding 0.3s ease;
		}

		.site-input-panel.collapsed .panel-content {
			max-height: 0;
			padding: 0 10px;
			overflow: hidden;
		}

		.input-group {
			margin-bottom: 8px;
		}

		.input-group label {
			display: block;
			font-size: 11px;
			font-weight: 500;
			margin-bottom: 3px;
			color: #666;
		}

		.input-group input {
			width: 100%;
			padding: 6px 8px;
			border: 1px solid #ddd;
			border-radius: 4px;
			font-size: 12px;
			box-sizing: border-box;
			transition: border-color 0.3s ease;
		}

		.input-group input:focus {
			outline: none;
			border-color: #667eea;
			box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.1);
		}

		.load-btn {
			width: 100%;
			padding: 8px;
			background-color: #4CAF50;
			color: white;
			border: none;
			border-radius: 4px;
			cursor: pointer;
			font-size: 12px;
			font-weight: 600;
			margin-top: 6px;
			transition: all 0.3s ease;
		}

		.load-btn:hover {
			background-color: #45a049;
			transform: translateY(-1px);
			box-shadow: 0 2px 6px rgba(76, 175, 80, 0.3);
		}

		.load-btn:active {
			transform: translateY(0);
		}

		.load-btn:disabled {
			background-color: #ccc;
			cursor: not-allowed;
			transform: none;
		}

		.swap-btn {
			width: 28px;
			height: 28px;
			padding: 0;
			background: #2196F3;
			color: white;
			border: none;
			border-radius: 4px;
			cursor: pointer;
			font-size: 12px;
			margin-top: 0;
			transition: all 0.3s ease;
			flex-shrink: 0;
		}

		.swap-btn:hover {
			background: #1976D2;
			transform: rotate(180deg);
		}

		.status-message {
			font-size: 11px;
			padding: 6px;
			border-radius: 4px;
			margin-top: 8px;
			display: none;
			animation: slideIn 0.3s ease;
		}

		@keyframes slideIn {
			from {
				opacity: 0;
				transform: translateY(-10px);
			}

			to {
				opacity: 1;
				transform: translateY(0);
			}
		}

		.status-message.error {
			background-color: #ffebee;
			color: #c62828;
			border: 1px solid #ef9a9a;
			display: block;
		}

		.status-message.success {
			background-color: #e8f5e9;
			color: #2e7d32;
			border: 1px solid #a5d6a7;
			display: block;
		}

		.status-message.info {
			background-color: #e3f2fd;
			color: #1565c0;
			border: 1px solid #90caf9;
			display: block;
		}

		.divider {
			height: 1px;
			background: linear-gradient(90deg, transparent, #ddd, transparent);
			margin: 10px 0;
		}

		.distance-input-group {
			display: flex;
			gap: 6px;
			margin-bottom: 8px;
		}

		.distance-input-group input {
			flex: 1;
			padding: 6px 8px;
			border: 1px solid #ddd;
			border-radius: 4px;
			font-size: 12px;
			transition: border-color 0.3s ease;
		}

		.distance-input-group input:focus {
			outline: none;
			border-color: #667eea;
			box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.1);
		}

		.distance-input-group button {
			padding: 6px 12px;
			background-color: #2196F3;
			color: white;
			border: none;
			border-radius: 4px;
			cursor: pointer;
			font-size: 12px;
			font-weight: 500;
			transition: all 0.3s ease;
			flex-shrink: 0;
		}

		.distance-input-group button:hover {
			background-color: #1976D2;
			transform: translateY(-1px);
			box-shadow: 0 2px 6px rgba(33, 150, 243, 0.3);
		}

		.distance-input-group button:active {
			transform: translateY(0);
		}

		.distance-info {
			font-size: 10px;
			color: #666;
			margin-top: 6px;
			padding: 6px;
			background: #f5f5f5;
			border-radius: 4px;
			border-left: 3px solid #667eea;
			line-height: 1.4;
		}

		.result-marker {
			background-color: #FF5722;
			color: white;
			border-color: #D84315;
		}

		.popup-link {
			display: inline-block;
			margin-top: 8px;
			padding: 6px 12px;
			background-color: #4285F4;
			color: white !important;
			text-decoration: none;
			border-radius: 4px;
			font-size: 12px;
			font-weight: 500;
			transition: background-color 0.3s ease;
		}

		.popup-link:hover {
			background-color: #357AE8;
		}

		.leaflet-popup-content {
			text-align: center;
		}

		.popup-table {
			border: none;
			border-collapse: collapse;
			margin: 8px auto;
			text-align: left;
			font-size: 12px;
		}

		.popup-table td {
			padding: 2px 4px;
			border: none;
		}

		.popup-table td:first-child {
			text-align: right;
			padding-right: 8px;
		}

		.panel-content::-webkit-scrollbar {
			width: 4px;
		}

		.panel-content::-webkit-scrollbar-track {
			background: #f1f1f1;
			border-radius: 2px;
		}

		.panel-content::-webkit-scrollbar-thumb {
			background: #888;
			border-radius: 2px;
		}

		.panel-content::-webkit-scrollbar-thumb:hover {
			background: #555;
		}

		@media (max-width: 480px) {
			.site-input-panel {
				max-width: calc(100vw - 16px);
				top: 6px;
				right: 6px;
			}

			.panel-header h6 {
				font-size: 11px;
			}

			.custom-marker {
				font-size: 10px;
				padding: 3px 6px;
				max-width: 120px;
			}

			.input-group input,
			.distance-input-group input {
				font-size: 11px;
			}

			.distance-info {
				font-size: 9px;
			}
		}
	</style>
@endsection

@section('title', 'Site to Site')

@section('content')
	<div class="panel mt-6">
		<div style="position: relative;">
			<div id="map"></div>

			<div class="site-input-panel" id="searchPanel">
				<div class="panel-header" onclick="toggleCollapse()">
					<h6>
						<span>📍</span>
						<span>Rute Jarak Site ke Site</span>
					</h6>
					<span class="collapse-icon">▼</span>
				</div>
				<div class="panel-content" id="panelContent">
					<div class="input-group" style="display: flex; gap: 8px; align-items: flex-end;">
						<div style="flex: 1;">
							<label for="siteFromInput">Site From:</label>
							<input type="text" id="siteFromInput" placeholder="Masukkan nama site asal" value="{{ $site_from ?? '' }}"
								readonly>
						</div>
						<button type="button" class="swap-btn" title="Tukar Site" onclick="swapSites()">⇄</button>
						<div style="flex: 1;">
							<label for="siteToInput">Site To:</label>
							<input type="text" id="siteToInput" placeholder="Masukkan nama site tujuan" value="{{ $site_to ?? '' }}"
								readonly>
						</div>
					</div>
					<div class="status-message" id="statusMessage"></div>

					<div class="divider"></div>

					<div class="distance-input-group">
						<input type="number" id="distanceInput" placeholder="Jarak (meter)" min="0" step="1">
						<button onclick="findPointByDistance()">Cari</button>
					</div>
					<div class="distance-info" id="distanceInfo">
						Masukkan jarak dari titik awal (Site From) untuk mencari lokasi di jalur. Jarak otomatis ditambah 15m setiap 200m.
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
		let currentSiteFrom = '';
		let currentSiteTo = '';
		let isReversed = false;
		let autoLoadTimeout;

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
							iconSize: [32, 32],
							iconAnchor: [16, 32],
							popupAnchor: [0, -32]
						})
					}).addTo(map);

					const latLngText = `${userLat.toFixed(6)},${userLng.toFixed(6)}`;
					const gmapsUrl = `https://www.google.com/maps?q=${userLat},${userLng}`;

					userLocationMarker.bindPopup(`
						<strong>Lokasi Anda</strong><br>
						${latLngText}<br>
						<a href="${gmapsUrl}" target="_blank" class="popup-link">📍 Buka Gmaps</a>
					`);
				}, function(error) {
					console.log('Geolocation permission denied or unavailable:', error);
				});
			}

			const fromInput = document.getElementById('siteFromInput');
			const toInput = document.getElementById('siteToInput');

			['input', 'change'].forEach(eventName => {
				fromInput.addEventListener(eventName, () => scheduleAutoLoad(200));
				toInput.addEventListener(eventName, () => scheduleAutoLoad(200));
			});

			const siteFrom = '{{ $site_from ?? '' }}';
			const siteTo = '{{ $site_to ?? '' }}';
			if (siteFrom && siteTo) {
				scheduleAutoLoad(500);
			}
		});

		function scheduleAutoLoad(delay = 0) {
			clearTimeout(autoLoadTimeout);
			autoLoadTimeout = setTimeout(() => loadKMZRoute(), delay);
		}

		function createCustomIcon(text, cssClass) {
			return L.divIcon({
				className: 'custom-div-icon',
				html: `<div class="custom-marker ${cssClass}">${text}</div>`,
				iconSize: [null, 32],
				iconAnchor: [0, 32],
				popupAnchor: [0, -32]
			});
		}

		function showStatus(message, type) {
			const statusEl = document.getElementById('statusMessage');
			statusEl.textContent = message;
			statusEl.className = `status-message ${type}`;

			if (type === 'success') {
				setTimeout(() => {
					statusEl.style.display = 'none';
				}, 5000);
			}
		}

		function clearRoute() {
			if (kmzLayer) {
				map.removeLayer(kmzLayer);
			}
			if (markerA) {
				map.removeLayer(markerA);
				markerA = null;
			}
			if (markerB) {
				map.removeLayer(markerB);
				markerB = null;
			}
			if (resultMarker) {
				map.removeLayer(resultMarker);
				resultMarker = null;
			}
			routeCoordinates = [];
		}

		function loadKMZRoute() {
			const siteFrom = document.getElementById('siteFromInput').value.trim();
			const siteTo = document.getElementById('siteToInput').value.trim();

			if (!siteFrom || !siteTo) {
				showStatus('Harap isi Site From dan Site To', 'error');
				return;
			}

			const panel = document.getElementById('searchPanel');
			if (panel.classList.contains('disabled')) {
				return;
			}

			currentSiteFrom = siteFrom;
			currentSiteTo = siteTo;

			clearRoute();

			panel.classList.add('disabled');

			showStatus('Memuat route...', 'info');

			tryLoadKMZ(siteFrom, siteTo);
		}

		async function tryLoadKMZ(siteFrom, siteTo) {
			const primaryPath = `/kmz-site-to-site/${siteFrom}_${siteTo}.kmz`;

			try {
				const response = await fetch(primaryPath, {
					method: 'HEAD'
				});
				if (response.ok) {
					loadKMZFile(primaryPath, false);
					return;
				}
			} catch (error) {
				console.log('Primary path not found, trying reverse...');
			}

			const reversePath = `/kmz-site-to-site/${siteTo}_${siteFrom}.kmz`;

			try {
				const response = await fetch(reversePath, {
					method: 'HEAD'
				});
				if (response.ok) {
					loadKMZFile(reversePath, true);
					return;
				}
			} catch (error) {
				console.log('Reverse path not found');
			}

			showStatus(`File KMZ tidak ditemukan: ${siteFrom}_${siteTo}.kmz atau ${siteTo}_${siteFrom}.kmz`, 'error');
			clearRoute();
			document.getElementById('searchPanel').classList.remove('disabled');
		}

		function loadKMZFile(kmzPath, shouldReverse) {
			isReversed = shouldReverse;

			kmzLayer = L.kmzLayer(null, {
				ballon: true,
				bindPopup: true,
				preferCanvas: false
			});

			kmzLayer.addTo(map);

			kmzLayer.on('load', function(e) {
				const layer = e.layer;
				const bounds = layer.getBounds();

				extractRouteCoordinates(layer);

				if (isReversed) {
					routeCoordinates.reverse();
				}

				layer.eachLayer(function(subLayer) {
					if (subLayer instanceof L.Marker) {
						const latlng = subLayer.getLatLng();
						const latLngText = `${latlng.lat.toFixed(6)},${latlng.lng.toFixed(6)}`;
						const gmapsUrl = `https://www.google.com/maps?q=${latlng.lat},${latlng.lng}`;

						const originalPopup = subLayer.getPopup();
						let popupContent = '';

						if (originalPopup) {
							const originalContent = originalPopup.getContent();
							if (originalContent && originalContent.trim() !== '') {
								popupContent = originalContent + '<br>';
							}
						}

						popupContent +=
							`${latLngText}<br><a href="${gmapsUrl}" target="_blank" class="popup-link">📍 Buka Gmaps</a>`;

						subLayer.bindPopup(popupContent);
					}
				});

				if (routeCoordinates.length >= 2) {
					const startPoint = routeCoordinates[0];
					const endPoint = routeCoordinates[routeCoordinates.length - 1];

					const startLatLngText = `${startPoint[1].toFixed(6)},${startPoint[0].toFixed(6)}`;
					const startGmapsUrl = `https://www.google.com/maps?q=${startPoint[1]},${startPoint[0]}`;

					markerA = L.marker([startPoint[1], startPoint[0]], {
						icon: createCustomIcon(currentSiteFrom, 'marker-a')
					}).addTo(map);
					markerA.bindPopup(`
						<strong>${currentSiteFrom}</strong><br>
						${startLatLngText}<br>
						<a href="${startGmapsUrl}" target="_blank" class="popup-link">📍 Buka Gmaps</a>
					`);
					markerA.on('click', function() {
						map.setView([startPoint[1], startPoint[0]], 17);
					});

					const endLatLngText = `${endPoint[1].toFixed(6)},${endPoint[0].toFixed(6)}`;
					const endGmapsUrl = `https://www.google.com/maps?q=${endPoint[1]},${endPoint[0]}`;

					markerB = L.marker([endPoint[1], endPoint[0]], {
						icon: createCustomIcon(currentSiteTo, 'marker-b')
					}).addTo(map);
					markerB.bindPopup(`
						<strong>${currentSiteTo}</strong><br>
						${endLatLngText}<br>
						<a href="${endGmapsUrl}" target="_blank" class="popup-link">📍 Buka Gmaps</a>
					`);
					markerB.on('click', function() {
						map.setView([endPoint[1], endPoint[0]], 17);
					});

					const totalDistance = calculateTotalDistance(routeCoordinates);
					updateDistanceInfo(`Total jarak: ${totalDistance.toFixed(2)} meter`);

					const directionNote = isReversed ? ' (menggunakan jalur terbalik)' : '';
					showStatus(`Route berhasil dimuat${directionNote}! Total jarak: ${totalDistance.toFixed(2)} meter`,
						'success');

					document.getElementById('searchPanel').classList.remove('disabled');
				}

				if (bounds && bounds.isValid()) {
					const centerLatLng = bounds.getCenter();
					map.setView(centerLatLng, 15);
				}
			});

			kmzLayer.on('error', function(e) {
				console.error('Error loading KMZ file:', e);
				showStatus(`Error memuat file KMZ`, 'error');
				clearRoute();
				document.getElementById('searchPanel').classList.remove('disabled');
			});

			fetch(kmzPath)
				.then(response => {
					if (!response.ok) {
						throw new Error(`File KMZ tidak ditemukan (${response.status})`);
					}
					return response.blob();
				})
				.then(blob => {
					const url = URL.createObjectURL(blob);
					kmzLayer.load(url);
				})
				.catch(error => {
					console.error('Error fetching KMZ:', error);
					showStatus(error.message, 'error');
					clearRoute();
					document.getElementById('searchPanel').classList.remove('disabled');
				});
		}

		function checkIfNeedsReversal(siteFrom, siteTo) {
			return false;
		}

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

		function calculateAdjustedDistance(inputDistance) {
			const segments = Math.floor(inputDistance / 200);
			const additionalMeters = segments * 15;
			return inputDistance + additionalMeters;
		}

		function findPointByDistance() {
			const inputDistance = parseFloat(document.getElementById('distanceInput').value);

			if (isNaN(inputDistance) || inputDistance < 0) {
				alert('Masukkan jarak yang valid (angka positif)');
				return;
			}

			if (routeCoordinates.length < 2) {
				alert('Route belum dimuat');
				return;
			}

			const targetDistance = calculateAdjustedDistance(inputDistance);

			const totalDistance = calculateTotalDistance(routeCoordinates);

			if (targetDistance > totalDistance) {
				alert(
					`Jarak tersesuaikan (${targetDistance.toFixed(2)} meter) melebihi total panjang jalur (${totalDistance.toFixed(2)} meter)`
				);
				return;
			}

			const coords = routeCoordinates;

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

				resultMarker = L.marker([pointCoords[1], pointCoords[0]], {
					icon: L.divIcon({
						className: 'custom-div-icon',
						html: `<div class="custom-marker result-marker">📍</div>`,
						iconSize: [32, 32],
						iconAnchor: [16, 32],
						popupAnchor: [0, -32]
					})
				}).addTo(map);

				const latLngText = `${pointCoords[1].toFixed(6)},${pointCoords[0].toFixed(6)}`;
				const gmapsUrl = `https://www.google.com/maps?q=${pointCoords[1]},${pointCoords[0]}`;

				const inputDistanceDisplay = Math.round(inputDistance);
				const targetDistanceDisplay = Math.round(targetDistance);

				resultMarker.bindPopup(`
					<strong>Titik Ditemukan</strong><br>
					<table class="popup-table">
						<tr>
							<td>Jarak input</td>
							<td>: ${inputDistanceDisplay} meter</td>
						</tr>
						<tr>
							<td>Jarak tersesuaikan</td>
							<td>: ${targetDistanceDisplay} meter</td>
						</tr>
					</table>
					${latLngText}<br>
					<a href="${gmapsUrl}" target="_blank" class="popup-link">📍 Buka Gmaps</a>
				`).openPopup();

				resultMarker.on('click', function() {
					map.setView([pointCoords[1], pointCoords[0]], 17);
				});

				map.setView([pointCoords[1], pointCoords[0]], 17);

				updateDistanceInfo(
					`✓ Titik ditemukan pada jarak tersesuaikan ${targetDistanceDisplay} meter (input: ${inputDistanceDisplay} meter) dari Site From`
				);
			}
		}

		function swapSites() {
			const fromInput = document.getElementById('siteFromInput');
			const toInput = document.getElementById('siteToInput');
			const temp = fromInput.value;
			fromInput.value = toInput.value;
			toInput.value = temp;

			scheduleAutoLoad(150);
		}

		function updateDistanceInfo(text) {
			document.getElementById('distanceInfo').textContent = text;
		}

		function toggleCollapse() {
			const panel = document.getElementById('searchPanel');
			panel.classList.toggle('collapsed');
		}
	</script>
@endsection
