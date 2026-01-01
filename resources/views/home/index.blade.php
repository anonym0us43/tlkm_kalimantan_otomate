@extends('layouts')

@section('styles')
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
		integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
	<style>
		#map {
			height: 600px;
			width: 100%;
		}
	</style>
@endsection

@section('title', 'Home')

@section('content')
	<div class="container mt-4">
		<div id="map"></div>
	</div>
@endsection

@section('scripts')
	<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
		integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
	<script>
		let map = L.map('map').setView([0, 117], 5);

		let satelliteLayer = L.tileLayer(
			'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
				maxZoom: 18
			}).addTo(map);

		let mapLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
			attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
			maxZoom: 19
		});

		let baseLayers = {
			"Satellite": satelliteLayer,
			"Map": mapLayer
		};

		L.control.layers(baseLayers).addTo(map);

		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(function(position) {
				let lat = position.coords.latitude;
				let lon = position.coords.longitude;

				map.setView([lat, lon], 13);

				L.marker([lat, lon]).addTo(map)
					.bindPopup('Lokasi Anda')
					.openPopup();
			}, function(error) {
				console.error('Error mendapatkan lokasi:', error);
				alert('Tidak dapat mengakses lokasi GPS. Menggunakan lokasi default.');
				map.setView([0, 117], 5);
			});
		} else {
			alert('Browser Anda tidak mendukung Geolocation.');
			map.setView([0, 117], 5);
		}
	</script>
@endsection
