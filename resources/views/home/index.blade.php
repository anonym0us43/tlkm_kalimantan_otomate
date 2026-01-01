@extends('layouts')

@section('styles')
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
	<style>
		#home-map {
			height: calc(100vh - 220px);
			min-height: 520px;
			width: 100%;
			border-radius: 8px;
			overflow: hidden;
			position: relative;
			isolation: isolate;
			box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
		}

		#location-status {
			position: absolute;
			top: 10px;
			left: 10px;
			z-index: 500;
			background: rgba(0, 0, 0, 0.7);
			color: #fff;
			padding: 6px 10px;
			border-radius: 6px;
			font-size: 12px;
			pointer-events: none;
		}
	</style>
@endsection

@section('title', 'Home')

@section('content')
	<div class="panel">
		<div class="panel-body p-0">
			<div id="home-map">
				<div id="location-status">Meminta izin lokasi...</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const fallbackCenter = [-1.2563764620545537, 116.86768671889595];
			const map = L.map('home-map').setView(fallbackCenter, 18);
			let userMarker;
			const statusEl = document.getElementById('location-status');

			const mapLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
				maxZoom: 19,
				attribution: '© OpenStreetMap'
			});

			const satelliteLayer = L.tileLayer(
				'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
					maxZoom: 19,
					attribution: 'Tiles © Esri'
				});

			satelliteLayer.addTo(map);

			L.control.layers({
				Map: mapLayer,
				Satellite: satelliteLayer
			}, {}, {
				position: 'topright'
			}).addTo(map);

			function setUserLocation(lat, lng) {
				if (userMarker) {
					map.removeLayer(userMarker);
				}
				userMarker = L.circleMarker([lat, lng], {
					radius: 10,
					color: '#2e7d32',
					weight: 2,
					fillColor: '#4caf50',
					fillOpacity: 0.9
				}).addTo(map).bindPopup('Lokasi Anda').openPopup();
				if (statusEl) statusEl.textContent = 'Lokasi Anda ditemukan';
			}

			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(function(position) {
					const {
						latitude,
						longitude
					} = position.coords;
					map.setView([latitude, longitude], 18);
					setUserLocation(latitude, longitude);
				}, function(err) {
					setUserLocation(fallbackCenter[0], fallbackCenter[1]);
					if (statusEl) {
						statusEl.textContent = 'Lokasi tidak tersedia: izinkan GPS dan gunakan HTTPS.';
					}
				}, {
					enableHighAccuracy: true,
					timeout: 15000,
					maximumAge: 0
				});
			} else {
				setUserLocation(fallbackCenter[0], fallbackCenter[1]);
				if (statusEl) statusEl.textContent = 'Perangkat tidak mendukung geolokasi.';
			}
		});
	</script>
@endsection
