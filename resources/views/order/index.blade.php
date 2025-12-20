@extends('layouts')

@section('styles')
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
	<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
	<style>
		.select2-container--default .select2-selection--single {
			background-color: #ffffff00 !important;
		}

		.select2-container--default .select2-results__option {
			padding: 8px 12px;
		}

		.select2-result-item-text {
			display: block;
			font-weight: 500;
			color: #1f2937;
		}

		.form-label {
			font-weight: 600;
			color: #374151;
			margin-bottom: 8px;
			display: block;
			font-size: 14px;
		}

		.form-input,
		.form-select {
			border-radius: 6px;
			border: 1px solid #d1d5db;
			padding: 10px 12px;
			font-size: 14px;
			transition: all 0.2s ease;
			width: 100%;
			box-sizing: border-box;
		}

		.form-input:focus,
		.form-select:focus {
			border-color: #4361ee;
			box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
			outline: none;
		}

		.coordinate-input-group {
			margin-top: 8px;
			display: none;
			padding: 8px 12px;
			background: #f0f4ff;
			border-radius: 6px;
			border: 1px solid #c7d2fe;
			width: 100%;
			box-sizing: border-box;
		}

		.coordinate-input-group.show {
			display: block;
		}

		.coordinate-label {
			font-size: 12px;
			font-weight: 600;
			color: #4338ca;
			margin-bottom: 4px;
			display: flex;
			align-items: center;
			gap: 4px;
		}

		.coordinate-input {
			width: 100%;
			padding: 6px 10px;
			border: 1px solid #c7d2fe;
			border-radius: 4px;
			font-size: 13px;
		}

		.coordinate-input:focus {
			border-color: #4361ee;
			outline: none;
			box-shadow: 0 0 0 2px rgba(67, 97, 238, 0.1);
		}

		.info-grid {
			width: 100%;
			border-collapse: collapse;
			margin-top: 6px;
			font-size: 11px;
		}

		.info-label {
			font-size: 11px;
			font-weight: 600;
			color: #6b7280;
			text-transform: uppercase;
			padding: 2px 6px;
			white-space: nowrap;
			border: none;
			background: transparent;
		}

		.info-label::after {
			content: ':';
			margin-left: 2px;
		}

		.info-value {
			font-size: 11px;
			font-weight: 500;
			color: #1f2937;
			padding: 2px 6px;
			border: none;
			background: transparent;
			word-break: break-word;
		}

		.photos-grid {
			display: grid;
			grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
			gap: 8px;
			margin-top: 12px;
			width: 100%;
			box-sizing: border-box;
		}

		.photo-item {
			position: relative;
			aspect-ratio: 1;
			border-radius: 6px;
			overflow: hidden;
			border: 1px solid #e5e7eb;
			transition: all 0.2s ease;
			cursor: pointer;
			width: 100%;
		}

		.photo-item:hover {
			border-color: #4361ee;
			box-shadow: 0 4px 12px rgba(67, 97, 238, 0.2);
		}

		.photo-item img {
			width: 100%;
			height: 100%;
			object-fit: cover;
			display: block;
		}

		.photo-item .photo-error {
			display: flex;
			align-items: center;
			justify-content: center;
			width: 100%;
			height: 100%;
			background: #f3f4f6;
			color: #9ca3af;
			font-size: 12px;
			text-align: center;
			padding: 4px;
		}

		.photos-empty {
			text-align: center;
			padding: 24px 12px;
			color: #9ca3af;
			font-size: 13px;
		}

		.photo-modal {
			display: none;
			position: fixed;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			background: rgba(0, 0, 0, 0.8);
			z-index: 9999;
			align-items: center;
			justify-content: center;
			padding: 1rem;
		}

		.photo-modal.active {
			display: flex;
		}

		.photo-modal-content {
			max-width: 90vh;
			max-height: 90vh;
			position: relative;
		}

		.photo-modal img {
			max-width: 100%;
			max-height: 80vh;
			width: auto;
			height: auto;
			display: block;
			border-radius: 8px;
		}

		.photo-modal-close {
			position: absolute;
			top: -40px;
			right: 0;
			background: rgba(255, 255, 255, 0.2);
			border: none;
			color: white;
			font-size: 28px;
			cursor: pointer;
			width: 40px;
			height: 40px;
			display: flex;
			align-items: center;
			justify-content: center;
			border-radius: 4px;
			transition: all 0.2s ease;
		}

		.photo-modal-close:hover {
			background: rgba(255, 255, 255, 0.3);
		}

		.qc-modal {
			display: none;
			position: fixed;
			inset: 0;
			background: rgba(0, 0, 0, 0.55);
			z-index: 10000;
			align-items: center;
			justify-content: center;
			padding: 1rem;
		}

		.qc-modal.show {
			display: flex;
		}

		.qc-modal-content {
			background: #fff;
			border-radius: 10px;
			padding: 20px;
			max-width: 520px;
			width: 100%;
			box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
		}

		.qc-modal-header {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 12px;
		}

		.qc-modal-close {
			background: transparent;
			border: none;
			font-size: 22px;
			cursor: pointer;
			line-height: 1;
			color: #6b7280;
		}

		.qc-modal-close:hover {
			color: #111827;
		}

		.qc-actions {
			display: flex;
			gap: 10px;
			justify-content: flex-end;
			margin-top: 14px;
		}

		.upload-box {
			width: 100%;
			min-height: 250px;
			border: 2px dashed #d1d5db;
			border-radius: 10px;
			cursor: pointer;
			display: flex;
			justify-content: center;
			align-items: center;
			overflow: hidden;
			transition: all 0.2s ease;
			position: relative;
		}

		.upload-box:hover {
			border-color: #4361ee;
		}

		.upload-box img {
			max-width: 100%;
			max-height: 200px;
			object-fit: contain;
		}

		.camera-icon {
			font-size: 48px;
			color: #9ca3af;
			width: 100%;
			display: flex;
			justify-content: center;
			align-items: center;
		}

		.camera-icon i {
			font-size: 48px;
		}

		input[type="file"] {
			display: none;
		}

		.action-area {
			margin-top: 12px;
			display: flex;
			justify-content: center;
			gap: 12px;
		}

		.maps-section {
			margin-top: 16px;
			padding-top: 0;
			border-top: none;
		}

		.maps-container {
			width: 100%;
			height: 100%;
			min-height: 500px;
			border-radius: 8px;
			overflow: hidden;
			border: 1px solid #e5e7eb;
			position: relative;
			z-index: 0;
			isolation: isolate;
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

		.marker-site-down {
			background-color: #4CAF50;
			color: white;
			border-color: #2E7D32;
		}

		.marker-site-down::after {
			border-top-color: #4CAF50;
		}

		.marker-site-detect {
			background-color: #2196F3;
			color: white;
			border-color: #1565C0;
		}

		.marker-site-detect::after {
			border-top-color: #2196F3;
		}

		.panel-header {
			display: flex;
			align-items: center;
			justify-content: space-between;
			cursor: pointer;
			user-select: none;
			padding: 4px 0;
		}

		.panel-header:hover h5 {
			color: #4361ee;
		}

		.collapse-icon {
			transition: transform 0.3s ease;
			font-size: 20px;
			color: #6b7280;
		}

		.collapse-icon.collapsed {
			transform: rotate(-90deg);
		}

		.panel-content {
			max-height: 10000px;
			overflow: hidden;
			transition: max-height 0.4s ease, opacity 0.3s ease, padding 0.3s ease;
			opacity: 1;
		}

		.panel-content.collapsed {
			max-height: 0 !important;
			opacity: 0;
			padding-top: 0;
			padding-bottom: 0;
		}

		.material-modal {
			position: fixed;
			inset: 0;
			background: rgba(0, 0, 0, 0.55);
			display: none;
			align-items: center;
			justify-content: center;
			z-index: 1100;
			padding: 24px;
		}

		.material-modal.show {
			display: flex;
		}

		.material-modal-content {
			background: #fff;
			border-radius: 12px;
			width: min(1800px, 98vw);
			max-height: 95vh;
			display: flex;
			flex-direction: column;
			box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
			overflow: hidden;
		}

		.material-modal-header {
			display: flex;
			align-items: center;
			justify-content: space-between;
			padding: 16px 20px;
			border-bottom: 1px solid #e5e7eb;
		}

		.material-modal-body {
			padding: 16px 20px 12px;
			overflow: auto;
		}

		.material-modal-footer {
			display: flex;
			justify-content: flex-end;
			gap: 10px;
			padding: 12px 20px 16px;
			border-top: 1px solid #e5e7eb;
			background: #f9fafb;
		}

		.material-modal-close {
			background: transparent;
			border: none;
			font-size: 22px;
			line-height: 1;
			cursor: pointer;
			color: #6b7280;
		}

		.material-table-wrapper {
			overflow: auto;
			border: 1px solid #e5e7eb;
			border-radius: 8px;
		}

		.material-table {
			width: 100%;
			border-collapse: collapse;
			min-width: 900px;
		}

		.material-table th,
		.attachment-table th,
		.material-table td,
		.attachment-table td {
			text-align: center !important;
			vertical-align: middle !important;
			padding: 8px !important;
			font-size: 13px !important;
			padding: 10px 12px;
			border-bottom: 1px solid #e5e7eb;
		}

		.material-table th,
		.attachment-table th {
			background: #f3f4f6;
			font-weight: 700;
			color: #374151;
			position: sticky;
			top: 0;
			z-index: 1;
		}

		.material-table tfoot th {
			font-weight: 700;
			color: #1f2937;
			text-align: right;
			padding: 12px;
			position: static;
		}

		.material-table tfoot th:last-child {
			text-align: center;
			font-size: 14px;
			color: #059669;
		}

		.material-price,
		.material-service,
		.material-total,
		.material-total-service {
			font-variant-numeric: tabular-nums;
		}

		.material-table .qty-input {
			width: 90px;
			text-align: center;
			vertical-align: middle;
		}

		.material-table td:last-child {
			text-align: center !important;
			vertical-align: middle !important;
		}

		.material-table .remove-material-btn {
			color: #dc2626;
			border-color: #fca5a5;
			display: inline-flex;
			align-items: center;
			justify-content: center;
		}

		.material-table .remove-material-btn:hover {
			background: #fee2e2;
		}

		.material-actions-bar {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 12px;
		}

		.material-modal .select2-container--default .select2-selection--single {
			min-height: 42px;
			display: flex;
			align-items: center;
			position: relative;
		}

		.material-modal .select2-container--default .select2-selection__rendered {
			width: 100%;
			text-align: left;
			padding-left: 12px;
			padding-right: 50px;
		}

		.material-modal .select2-container--default .select2-results__option {
			text-align: left;
		}

		.material-modal .select2-container--default .select2-selection__arrow {
			position: absolute;
			right: 8px;
			top: 50%;
			transform: translateY(-50%);
			height: 100%;
		}

		.material-modal .select2-container--default .select2-selection__clear {
			position: absolute;
			right: 28px;
			top: 50%;
			transform: translateY(-50%);
			font-size: 18px;
			line-height: 1;
			margin-right: 0;
		}

		.select2-container--open {
			z-index: 1200 !important;
		}

		@media (max-width: 768px) {
			.grid.grid-cols-2 {
				grid-template-columns: 1fr;
			}

			.photos-grid {
				grid-template-columns: repeat(2, 1fr);
			}
		}
	</style>
@endsection

@section('title', 'Order #' . $id)

@section('content')
	<div class="flex items-center gap-3 mt-6 mb-6">
		<a href="javascript:history.back()" class="btn btn-sm btn-outline-secondary">
			<i class="bi bi-arrow-left"></i>
			&nbsp; Kembali
		</a>
		<button type="submit" form="orderForm" class="btn btn-sm btn-outline-success">
			<i class="bi bi-check-circle"></i>
			&nbsp; Simpan
		</button>
		<button type="button" class="btn btn-sm btn-outline-danger" id="qcModalOpenBtn"
			{{ empty($data->assign_order_id) ? 'disabled' : '' }}>
			<i class="bi bi-clipboard-check"></i>
			&nbsp; Quality Check (QC)
		</button>
	</div>

	@if (session('success'))
		<div class="mb-4 mt-4 flex items-center p-3.5 rounded text-white bg-success">
			<span class="ltr:pr-2 rtl:pl-2"><strong>Success!</strong> {{ session('success') }}</span>
		</div>
	@endif

	@if (session('error'))
		<div class="mb-4 mt-4 flex items-center p-3.5 rounded text-white bg-danger">
			<span class="ltr:pr-2 rtl:pl-2"><strong>Error!</strong> {{ session('error') }}</span>
		</div>
	@endif

	@php
		$showAttachmentEvidence = !in_array((int) ($data->status_qc_id ?? 0), [0, 1, 2]);
	@endphp

	<form action="{{ route('order.post') }}" method="POST" enctype="multipart/form-data" id="orderForm">
		@csrf
		<input type="hidden" name="row_id" value="{{ $id }}">
		<input type="hidden" name="order_id" value="{{ $data->tt_site_id }}">
		<input type="hidden" name="order_code" value="{{ $data->tt_site }}">
		<input type="hidden" name="status_qc_id" value="{{ $data->status_qc_id ?? 2 }}">

		<div class="grid grid-cols-1 gap-6 lg:grid-cols-2 mt-6">
			<div class="panel h-full w-full">
				<div class="mb-5 panel-header" onclick="togglePanel(this)">
					<h5 class="text-lg font-semibold dark:text-white-light">Information Orders</h5>
					<i class="bi bi-chevron-down collapse-icon"></i>
				</div>
				<div class="panel-content">
					<div class="space-y-4">
						<table class="info-grid">
							<tbody>
								<tr class="info-item">
									<td class="info-label">Created At</td>
									<td class="info-value">{{ $data->created_at }}</td>
								</tr>
								<tr class="info-item">
									<td class="info-label">TT Site</td>
									<td class="info-value">{{ $data->tt_site }}</td>
								</tr>
								<tr class="info-item">
									<td class="info-label">Technician</td>
									<td class="info-value">{{ $data->tacc_nama }} ({{ $data->tacc_nik }})</td>
								</tr>
								<tr class="info-item">
									<td class="info-label">Site Down</td>
									<td class="info-value">{{ $data->site_down }}</td>
								</tr>
								<tr class="info-item">
									<td class="info-label">Site Name Down</td>
									<td class="info-value">{{ $data->site_name_down }}</td>
								</tr>
								<tr class="info-item">
									<td class="info-label">Latitude Site Down</td>
									<td class="info-value">{{ $data->latitude_site_down }}</td>
								</tr>
								<tr class="info-item">
									<td class="info-label">Longitude Site Down</td>
									<td class="info-value">{{ $data->longitude_site_down }}</td>
								</tr>
								<tr class="info-item">
									<td class="info-label">Site Detect</td>
									<td class="info-value">{{ $data->site_detect }}</td>
								</tr>
								<tr class="info-item">
									<td class="info-label">Site Name Detect</td>
									<td class="info-value">{{ $data->site_name_detect }}</td>
								</tr>
								<tr class="info-item">
									<td class="info-label">Tiket Terima</td>
									<td class="info-value">{{ $data->tiket_terima }}</td>
								</tr>
							</tbody>
						</table>

						<div class="mt-6">
							<div class="flex flex-col md:flex-row gap-4">
								<div class="flex-1 mb-6 photo-upload-section" data-upload-id="titik-putus">
									<label class="form-label text-sm mb-2">
										Foto Titik Putus
									</label>
									<label class="upload-box">
										<span class="camera-icon">
											<i class="bi bi-camera-fill"></i>
										</span>
										<img class="previewImage" hidden>
									</label>
									<input type="file" name="Foto_Titik_Putus" class="photoFileInput" accept="image/*">
									<div class="action-area">
										<button type="button" class="btn btn-outline-primary btn-sm uploadBtn" title="Upload Foto">
											<i class="bi bi-camera"></i>
										</button>
										<button type="button" class="btn btn-outline-danger btn-sm deleteBtn" hidden title="Hapus Foto">
											<i class="bi bi-trash"></i>
										</button>
									</div>
								</div>

								<div class="flex-1 mb-6 photo-upload-section" data-upload-id="foto-otdr">
									<label class="form-label text-sm mb-2">
										Foto OTDR
									</label>
									<label class="upload-box">
										<span class="camera-icon">
											<i class="bi bi-camera-fill"></i>
										</span>
										<img class="previewImage" hidden>
									</label>
									<input type="file" name="Foto_OTDR" class="photoFileInput" accept="image/*">
									<div class="action-area">
										<button type="button" class="btn btn-outline-primary btn-sm uploadBtn" title="Upload Foto">
											<i class="bi bi-camera"></i>
										</button>
										<button type="button" class="btn btn-outline-danger btn-sm deleteBtn" hidden title="Hapus Foto">
											<i class="bi bi-trash"></i>
										</button>
									</div>
								</div>
							</div>

							<div class="mb-6">
								<label class="form-label text-sm mb-2">
									Koordinat Titik Putus
								</label>
								<div class="flex gap-2 mb-2">
									<input type="text" name="coordinates_site" class="form-input flex-1"
										placeholder="Contoh: -1.2563759829104284, 116.86768575387761" value="{{ $data->coordinates_site ?? '' }}"
										required>
									<button type="button" class="btn btn-primary btn-sm get-coordinate-btn" title="Ambil lokasi dari GPS">
										<i class="bi bi-geo-alt-fill"></i>
									</button>
								</div>
								<small class="text-gray-500 text-xs block mb-4">Format: latitude, longitude</small>
							</div>

							<div class="flex items-center justify-end gap-2">
								<button type="button" class="btn btn-sm btn-outline-primary" id="materialModalOpenBtn">
									<i class="bi bi-pencil-square"></i>
									&nbsp; BoQ Materials
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="panel h-full w-full flex flex-col">
				<div class="mb-5 panel-header" onclick="togglePanel(this)">
					<h5 class="text-lg font-semibold dark:text-white-light">Location Map</h5>
					<i class="bi bi-chevron-down collapse-icon"></i>
				</div>
				<div class="panel-content flex-1">
					<div class="maps-container" id="mapContainer" data-lat="{{ $data->latitude_site_down }}"
						data-lng="{{ $data->longitude_site_down }}" data-site-down="{{ $data->site_down }}"
						data-site-name-down="{{ $data->site_name_down }}" data-site-detect="{{ $data->site_detect }}"
						data-site-name-detect="{{ $data->site_name_detect }}" data-tt-site="{{ $data->tt_site }}">
					</div>
				</div>
			</div>
		</div>

		<div class="panel w-full mt-6">
			<div class="mb-5 panel-header" onclick="togglePanel(this)">
				<h5 class="text-lg font-semibold dark:text-white-light">Photo Evidence</h5>
				<i class="bi bi-chevron-down collapse-icon"></i>
			</div>
			<div class="panel-content">
				<div class="photos-grid" data-row-id="{{ $id }}">
					<div class="photos-empty">Loading photos...</div>
				</div>
			</div>
		</div>

		@if ($showAttachmentEvidence)
			<div class="panel w-full mt-6">
				<div class="mb-5 panel-header" onclick="togglePanel(this)">
					<h5 class="text-lg font-semibold dark:text-white-light">Attachment Evidence</h5>
					<i class="bi bi-chevron-down collapse-icon"></i>
				</div>
				<div class="panel-content">
					<div class="table-responsive">
						<table class="table table-bordered table-hover text-center attachment-table">
							<thead>
								<tr>
									<th rowspan="2">Designator</th>
									<th rowspan="2">Volume</th>
									<th colspan="3">Photo</th>
								</tr>
								<tr>
									<th width="15%">Before</th>
									<th width="15%">Progress</th>
									<th width="15%">After</th>
								</tr>
							</thead>
							<tbody id="attachmentTableBody">
								<tr>
									<td colspan="5" class="text-gray-500">Tidak ada material</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		@endif

		<div class="material-modal" id="materialModal">
			<div class="material-modal-content">
				<div class="material-modal-header">
					<h5 class="text-lg font-semibold mb-0">BoQ Material</h5>
					<button type="button" class="material-modal-close" id="materialModalCloseBtn">&times;</button>
				</div>
				<div class="material-modal-body">
					<div class="material-actions-bar">
						<div class="text-sm text-gray-600"></div>
						<button type="button" class="btn btn-sm btn-primary add-material-btn">
							<i class="bi bi-plus-circle"></i>
							&nbsp; Tambah Material
						</button>
					</div>
					<div class="material-table-wrapper table-responsive">
						<table class="table table-bordered table-hover text-center material-table" style="text">
							<thead>
								<tr>
									<th rowspan="2" width="15%">Designator</th>
									<th rowspan="2">Uraian Pekerjaan</th>
									<th rowspan="2">Satuan</th>
									<th colspan="2">Paket</th>
									<th rowspan="2">Volume</th>
									<th colspan="2">Total Harga</th>
									<th rowspan="2">Action</th>
								</tr>
								<tr>
									<th>Material</th>
									<th>Jasa</th>
									<th>Material</th>
									<th>Jasa</th>
								</tr>
							</thead>
							<tbody class="material-rows"></tbody>
							<tfoot>
								<tr>
									<th colspan="7">Total Material</th>
									<th colspan="2" id="totalMaterial">Rp</th>
								</tr>
								<tr>
									<th colspan="7">Total Jasa</th>
									<th colspan="2" id="totalJasa">Rp</th>
								</tr>
								<tr>
									<th colspan="7">Total Material + Total Jasa</th>
									<th colspan="2" id="totalMaterialJasa">Rp</th>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
				<div class="material-modal-footer">
					<button type="button" class="btn btn-outline-secondary" id="materialModalCancelBtn">Batal</button>
					<button type="button" class="btn btn-primary" id="materialModalSaveBtn">Selesai</button>
				</div>
			</div>
		</div>
	</form>

	<div class="qc-modal" id="qcModal">
		<div class="qc-modal-content">
			<div class="qc-modal-header">
				<h5 class="text-lg font-semibold mb-0">Quality Check (QC)</h5>
				<button type="button" class="qc-modal-close" id="qcModalCloseBtn">&times;</button>
			</div>
			@php
				$qcEditable = session('partner_alias') === 'MTEL' && in_array((int) ($data->status_qc_id ?? 0), [2, 5]);
			@endphp
			<form id="qcForm" action="{{ route('order.status.post') }}" method="POST">
				@csrf
				<input type="hidden" name="assign_order_id" value="{{ $data->assign_order_id }}">
				<input type="hidden" name="status_qc_id" value="{{ $data->status_qc_id ?? 0 }}">

				<label class="form-label" for="qcNoDoc">Nomor Dokumen</label>
				<input type="text" id="qcNoDoc" name="no_document" class="form-input"
					value="{{ $data->no_document ?? '' }}" {{ $qcEditable ? '' : 'readonly' }} required>
				<br>
				<label class="form-label" for="qcNotes">Catatan</label>
				<textarea id="qcNotes" name="notes" class="form-input" rows="4" {{ $qcEditable ? '' : 'readonly' }}
				 required>{{ $data->qc_notes ?? '' }}</textarea>

				<div class="qc-actions">
					@if ($qcEditable)
						@if ((int) ($data->status_qc_id ?? 0) === 2)
							<button type="button" class="btn btn-sm btn-danger" id="qcRejectBtn" data-status="1">
								<i class="bi bi-x-circle"></i>&nbsp; Reject
							</button>
							<button type="button" class="btn btn-sm btn-success" id="qcApproveBtn" data-status="3">
								<i class="bi bi-check-circle"></i>&nbsp; Approve
							</button>
						@elseif ((int) ($data->status_qc_id ?? 0) === 5)
							<button type="button" class="btn btn-sm btn-danger" id="qcRejectBtn" data-status="4">
								<i class="bi bi-x-circle"></i>&nbsp; Reject
							</button>
							<button type="button" class="btn btn-sm btn-success" id="qcApproveBtn" data-status="6">
								<i class="bi bi-check-circle"></i>&nbsp; Approve
							</button>
						@endif
					@endif
				</div>
			</form>
		</div>
	</div>
@endsection

@section('scripts')
	<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
	<script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.min.js"></script>
	<script>
		let materialsData = [];
		let mapInstance = null;
		const existingMaterials = @json($materials ?? []);
		const existingPhotoUrl = @json($existingPhotoUrl ?? null);
		const existingPhotoOtdrUrl = @json($existingPhotoOtdrUrl ?? null);
		const existingAttachments = @json($existingAttachments ?? []);
		const canEditAttachmentEvidence = @json($showAttachmentEvidence);

		function togglePanel(header) {
			const content = header.nextElementSibling;
			const icon = header.querySelector('.collapse-icon');

			content.classList.toggle('collapsed');
			icon.classList.toggle('collapsed');

			if (!content.classList.contains('collapsed') && content.querySelector('#mapContainer')) {
				setTimeout(() => {
					if (mapInstance) {
						mapInstance.invalidateSize();
					}
				}, 300);
			}
		}

		function formatMaterialOption(data) {
			if (!data.id) return data.text;
			return $(
				`<div><div class="select2-result-item-text">${data.text}</div></div>`
			);
		}

		function formatMaterialSelection(data) {
			return data.text;
		}

		const formatCurrency = (value) => {
			const number = Number(value) || 0;
			return 'Rp ' + number.toLocaleString('id-ID');
		};

		const updateMaterialTotals = () => {
			let totalMaterial = 0;
			let totalJasa = 0;

			const materialRows = document.querySelectorAll('.material-row');
			materialRows.forEach(row => {
				const select = row.querySelector('.material-select');
				const qtyInput = row.querySelector('.qty-input');
				const qty = Number(qtyInput?.value) || 0;

				if (select && select.value) {
					const material = findMaterialById(select.value);
					if (material) {
						const materialPrice = Number(material.material_price_mtel) || 0;
						const servicePrice = Number(material.service_price_mtel) || 0;
						totalMaterial += materialPrice * qty;
						totalJasa += servicePrice * qty;
					}
				}
			});

			const totalMaterialEl = document.getElementById('totalMaterial');
			const totalJasaEl = document.getElementById('totalJasa');
			const totalMaterialJasaEl = document.getElementById('totalMaterialJasa');

			if (totalMaterialEl) totalMaterialEl.textContent = formatCurrency(totalMaterial);
			if (totalJasaEl) totalJasaEl.textContent = formatCurrency(totalJasa);
			if (totalMaterialJasaEl) totalMaterialJasaEl.textContent = formatCurrency(totalMaterial + totalJasa);

			if (canEditAttachmentEvidence) {
				updateAttachmentTable();
			}
		};

		const findMaterialById = (id) => {
			if (!materialsData || !materialsData.length) return null;
			return materialsData.find(m => String(m.id) === String(id)) || null;
		};

		const COORDINATE_DESIGNATOR_PREFIXES = ['SC-OF-SM', 'PU-S'];

		const designatorRequiresCoordinate = (designator = '') => {
			const normalized = String(designator || '').toUpperCase();
			return COORDINATE_DESIGNATOR_PREFIXES.some(prefix => normalized.startsWith(prefix));
		};

		const parseCoordinateValues = (value) => {
			if (!value) return [];
			if (Array.isArray(value)) {
				return value.map(v => (v || '').trim()).filter(Boolean);
			}
			if (typeof value === 'string') {
				try {
					const parsed = JSON.parse(value);
					if (Array.isArray(parsed)) {
						return parsed.map(v => (v || '').trim()).filter(Boolean);
					}
				} catch (err) {}
				return value.split(/\r?\n|;/).map(v => v.trim()).filter(Boolean);
			}
			return [];
		};

		const getCoordinateBaseName = (row) => {
			const qtyInput = row.querySelector('.qty-input');
			if (!qtyInput || !qtyInput.name) return '';
			return qtyInput.name.replace(/\[qty\]$/, '[coordinates_material]');
		};

		const createCoordinateField = (baseName, index, value = '') => {
			const wrapper = document.createElement('div');
			wrapper.className = 'coordinate-item mb-2';
			const inputName = `${baseName}[${index}]`;
			wrapper.innerHTML = `
				<div class="coordinate-label">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Koordinat Material (${index + 1})
                </div>
				<div class="flex gap-2">
					<input type="text" name="${inputName}" class="coordinate-input flex-1" placeholder="-6.200000, 106.816666" value="${value}">
					<button type="button" class="btn btn-primary btn-sm get-coordinate-btn" data-target="${inputName}" title="Ambil lokasi dari GPS">
						<i class="bi bi-geo-alt-fill"></i>
					</button>
				</div>
			`;
			return wrapper;
		};

		const syncCoordinateInputs = (row, qty, options = {}) => {
			const coordinateRow = row.nextElementSibling;
			const coordinateGroup = coordinateRow ? coordinateRow.querySelector('.coordinate-input-group') : null;
			const coordinateInputs = coordinateGroup ? coordinateGroup.querySelector('.coordinate-inputs') : null;

			if (!coordinateGroup || !coordinateInputs) {
				return;
			}

			if (!options.show) {
				coordinateGroup.classList.remove('show');
				coordinateInputs.innerHTML = '';
				return;
			}

			const baseName = getCoordinateBaseName(row);
			if (!baseName) {
				return;
			}

			const currentValues = Array.from(coordinateInputs.querySelectorAll('.coordinate-input')).map(input => input
				.value.trim());
			let seedValues = currentValues.filter(Boolean);

			if (!seedValues.length && coordinateGroup.dataset.existingCoordinates) {
				try {
					const parsed = JSON.parse(coordinateGroup.dataset.existingCoordinates);
					if (Array.isArray(parsed)) {
						seedValues = parsed;
					}
				} catch (err) {}
				coordinateGroup.dataset.existingCoordinates = '';
			}

			coordinateInputs.innerHTML = '';
			const totalInputs = Math.max(1, Number(qty) || 0);

			for (let i = 0; i < totalInputs; i++) {
				const value = seedValues[i] || '';
				const field = createCoordinateField(baseName, i, value);
				coordinateInputs.appendChild(field);
			}

			coordinateInputs.querySelectorAll('.coordinate-input').forEach(input => {
				input.required = true;
			});

			coordinateGroup.classList.add('show');
		};

		const updateMaterialRowDisplay = (row, material) => {
			const descEl = row.querySelector('.material-desc');
			const unitEl = row.querySelector('.material-unit');
			const priceEl = row.querySelector('.material-price');
			const serviceEl = row.querySelector('.material-service');
			const totalMaterialEl = row.querySelector('.material-total');
			const totalServiceEl = row.querySelector('.material-total-service');
			const qtyInput = row.querySelector('.qty-input');
			const coordinateRow = row.nextElementSibling;
			const coordinateGroup = coordinateRow ? coordinateRow.querySelector('.coordinate-input-group') : null;
			const qty = Number(qtyInput?.value) || 0;

			if (!material) {
				descEl.textContent = '-';
				unitEl.textContent = '-';
				priceEl.textContent = 'Rp 0';
				serviceEl.textContent = 'Rp 0';
				totalMaterialEl.textContent = 'Rp 0';
				totalServiceEl.textContent = 'Rp 0';
				if (coordinateGroup) {
					syncCoordinateInputs(row, 0, {
						show: false
					});
				}
				return;
			}

			descEl.textContent = material.item_description || '-';
			unitEl.textContent = material.unit || '-';
			const materialPrice = Number(material.material_price_mtel) || 0;
			const servicePrice = Number(material.service_price_mtel) || 0;
			priceEl.textContent = formatCurrency(materialPrice);
			serviceEl.textContent = formatCurrency(servicePrice);
			totalMaterialEl.textContent = formatCurrency(materialPrice * qty);
			totalServiceEl.textContent = formatCurrency(servicePrice * qty);

			const designator = material.item_designator || '';
			const requiresCoordinate = designatorRequiresCoordinate(designator);

			if (coordinateGroup) {
				syncCoordinateInputs(row, qty || 1, {
					show: requiresCoordinate
				});
			}

			updateMaterialTotals();
		};

		function addMaterialRow(existing = null) {
			const materialRows = document.querySelector('.material-rows');
			if (!materialRows) return;

			const index = document.querySelectorAll('.material-row').length;
			const rowWrapper = document.createElement('tbody');
			rowWrapper.innerHTML = `
				<tr class="material-row">
					<td>
						<select name="materials[${index}][designator_id]" class="form-select material-select w-full" required>
							<option value="">Pilih material...</option>
							${materialsData.map(m => `<option value="${m.id}" data-designator="${m.item_designator}">${m.item_designator}</option>`).join('')}
						</select>
					</td>
					<td><div class="material-desc">-</div></td>
					<td class="material-unit">-</td>
					<td class="material-price">Rp 0</td>
					<td class="material-service">Rp 0</td>
					<td>
						<input type="text" name="materials[${index}][qty]" class="form-input qty-input" value="${existing?.qty || 1}" inputmode="numeric" required>
					</td>
					<td class="material-total">Rp 0</td>
					<td class="material-total-service">Rp 0</td>
					<td>
						<button type="button" class="btn btn-sm btn-outline-danger remove-material-btn">
							<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1 1v3M4 7h16"/>
							</svg>
						</button>
					</td>
				</tr>
				<tr class="material-coordinate-row">
					<td colspan="9">
						<div class="coordinate-input-group">
							<div class="coordinate-inputs"></div>
						</div>
					</td>
				</tr>
			`;

			const rows = Array.from(rowWrapper.children);
			const coordinateGroup = rowWrapper.querySelector('.coordinate-input-group');
			const existingCoordinates = parseCoordinateValues(existing?.coordinates_material);

			if (coordinateGroup && existingCoordinates.length) {
				coordinateGroup.dataset.existingCoordinates = JSON.stringify(existingCoordinates);
			}
			rows.forEach(r => materialRows.appendChild(r));

			const mainRow = rows[0];
			const newSelect = mainRow.querySelector('.material-select');
			$(newSelect).select2({
				placeholder: 'Cari material...',
				allowClear: true,
				templateResult: formatMaterialOption,
				templateSelection: formatMaterialSelection,
				width: '100%',
				dropdownParent: $('#materialModal')
			});

			if (existing) {
				$(newSelect).val(existing.designator_id).trigger('change');
				const coordInput = mainRow.nextElementSibling?.querySelector(
					`input[name="materials[${index}][coordinates_material]"]`);
				if (coordInput) {
					coordInput.value = existing.coordinates_material || '';
				}
			}

			const qtyInput = mainRow.querySelector(`input[name="materials[${index}][qty]"]`);
			const applyUpdate = () => {
				const material = findMaterialById(newSelect.value);
				updateMaterialRowDisplay(rows[0], material);
			};

			$(newSelect).on('change', applyUpdate);
			if (qtyInput) {
				qtyInput.addEventListener('input', (e) => {
					e.target.value = e.target.value.replace(/[^0-9]/g, '');
					applyUpdate();
				});
				qtyInput.addEventListener('keydown', (e) => {
					if (!/[0-9]/.test(e.key) && !['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'Tab'].includes(e
							.key)) {
						e.preventDefault();
					}
				});
			}

			applyUpdate();
		}

		function initializePhotoUpload() {
			document.querySelectorAll('.photo-upload-section').forEach(section => {
				const fileInput = section.querySelector('.photoFileInput');
				const previewImage = section.querySelector('.previewImage');
				const cameraIcon = section.querySelector('.camera-icon');
				const deleteBtn = section.querySelector('.deleteBtn');
				const uploadBtn = section.querySelector('.uploadBtn');

				if (!fileInput || !previewImage || !cameraIcon || !deleteBtn || !uploadBtn) return;

				const uploadId = section.getAttribute('data-upload-id');
				if (uploadId === 'titik-putus' && existingPhotoUrl) {
					previewImage.src = existingPhotoUrl;
					previewImage.hidden = false;
					cameraIcon.style.display = 'none';
					deleteBtn.hidden = false;
				}
				if (uploadId === 'foto-otdr' && existingPhotoOtdrUrl) {
					previewImage.src = existingPhotoOtdrUrl;
					previewImage.hidden = false;
					cameraIcon.style.display = 'none';
					deleteBtn.hidden = false;
				}

				uploadBtn.addEventListener('click', () => {
					fileInput.click();
				});

				fileInput.addEventListener('change', function(event) {
					const file = event.target.files[0];
					if (!file) return;

					const reader = new FileReader();
					reader.onload = (e) => {
						previewImage.src = e.target.result;
						previewImage.hidden = false;
						cameraIcon.style.display = 'none';
						deleteBtn.hidden = false;
					};
					reader.readAsDataURL(file);
				});

				deleteBtn.addEventListener('click', function() {
					previewImage.hidden = true;
					previewImage.src = '';
					fileInput.value = '';
					cameraIcon.style.display = 'block';
					deleteBtn.hidden = true;
				});
			});
		}

		function updateAttachmentTable() {
			if (!canEditAttachmentEvidence) return;
			const tableBody = document.getElementById('attachmentTableBody');
			if (!tableBody) return;

			const materialRows = document.querySelectorAll('.material-row');
			tableBody.innerHTML = '';

			if (materialRows.length === 0) {
				tableBody.innerHTML = '<tr><td colspan="5" class="text-gray-500">Tidak ada material</td></tr>';
				return;
			}

			materialRows.forEach((row, rowIndex) => {
				const select = row.querySelector('.material-select');
				const qtyInput = row.querySelector('.qty-input');
				const qty = Number(qtyInput?.value) || 1;

				if (!select || !select.value) return;

				const material = findMaterialById(select.value);
				if (!material) return;

				const designator = material.item_designator || '';
				const requiresMultiple = designatorRequiresCoordinate(designator);
				const count = requiresMultiple ? qty : 1;

				for (let i = 0; i < count; i++) {
					const tr = document.createElement('tr');
					const labelSuffix = requiresMultiple && count > 1 ? ` (${i + 1})` : '';

					tr.innerHTML = `
						<td>${designator}${labelSuffix}</td>
						<td>${requiresMultiple && count > 1 ? '1' : qty}</td>
						<td>
							<div class="photo-upload-section" data-upload-id="attach-${rowIndex}-${i}-before" data-material-index="${rowIndex}" data-photo-index="${i}" data-photo-type="before">
								<label class="upload-box">
									<span class="camera-icon">
										<i class="bi bi-camera-fill"></i>
									</span>
									<img class="previewImage" hidden>
								</label>
								<input type="file" name="attachment_${rowIndex}_${i}_before" class="photoFileInput" accept="image/*">
								<div class="action-area">
									<button type="button" class="btn btn-outline-primary btn-sm uploadBtn" title="Upload Foto">
										<i class="bi bi-camera"></i>
									</button>
									<button type="button" class="btn btn-outline-danger btn-sm deleteBtn" hidden title="Hapus Foto">
										<i class="bi bi-trash"></i>
									</button>
								</div>
							</div>
						</td>
						<td>
							<div class="photo-upload-section" data-upload-id="attach-${rowIndex}-${i}-progress" data-material-index="${rowIndex}" data-photo-index="${i}" data-photo-type="progress">
								<label class="upload-box">
									<span class="camera-icon">
										<i class="bi bi-camera-fill"></i>
									</span>
									<img class="previewImage" hidden>
								</label>
								<input type="file" name="attachment_${rowIndex}_${i}_progress" class="photoFileInput" accept="image/*">
								<div class="action-area">
									<button type="button" class="btn btn-outline-primary btn-sm uploadBtn" title="Upload Foto">
										<i class="bi bi-camera"></i>
									</button>
									<button type="button" class="btn btn-outline-danger btn-sm deleteBtn" hidden title="Hapus Foto">
										<i class="bi bi-trash"></i>
									</button>
								</div>
							</div>
						</td>
						<td>
							<div class="photo-upload-section" data-upload-id="attach-${rowIndex}-${i}-after" data-material-index="${rowIndex}" data-photo-index="${i}" data-photo-type="after">
								<label class="upload-box">
									<span class="camera-icon">
										<i class="bi bi-camera-fill"></i>
									</span>
									<img class="previewImage" hidden>
								</label>
								<input type="file" name="attachment_${rowIndex}_${i}_after" class="photoFileInput" accept="image/*">
								<div class="action-area">
									<button type="button" class="btn btn-outline-primary btn-sm uploadBtn" title="Upload Foto">
										<i class="bi bi-camera"></i>
									</button>
									<button type="button" class="btn btn-outline-danger btn-sm deleteBtn" hidden title="Hapus Foto">
										<i class="bi bi-trash"></i>
									</button>
								</div>
							</div>
						</td>
					`;
					tableBody.appendChild(tr);
				}
			});

			initializePhotoUpload();

			setTimeout(() => {
				if (existingAttachments && Object.keys(existingAttachments).length > 0) {
					Object.keys(existingAttachments).forEach(materialIndex => {
						if (existingAttachments[materialIndex]) {
							Object.keys(existingAttachments[materialIndex]).forEach(volumeIndex => {
								const photos = existingAttachments[materialIndex][volumeIndex];

								if (photos) {
									['before', 'progress', 'after'].forEach(photoType => {
										if (photos[photoType]) {
											const uploadId =
												`attach-${materialIndex}-${volumeIndex}-${photoType}`;
											const section = document.querySelector(
												`[data-upload-id="${uploadId}"]`);

											if (section) {
												const previewImage = section.querySelector(
													'.previewImage');
												const cameraIcon = section.querySelector(
													'.camera-icon');
												const deleteBtn = section.querySelector(
													'.deleteBtn');

												if (previewImage && cameraIcon && deleteBtn) {
													previewImage.src = photos[photoType];
													previewImage.hidden = false;
													cameraIcon.style.display = 'none';
													deleteBtn.hidden = false;
												}
											}
										}
									});
								}
							});
						}
					});
				}
			}, 100);
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

		function initializeMap() {
			const mapContainer = document.getElementById('mapContainer');
			if (!mapContainer) return;

			const siteDown = mapContainer.getAttribute('data-site-down') || '-';
			const siteNameDown = mapContainer.getAttribute('data-site-name-down') || '-';
			const siteDetect = mapContainer.getAttribute('data-site-detect') || '-';
			const siteNameDetect = mapContainer.getAttribute('data-site-name-detect') || '-';
			const ttSite = mapContainer.getAttribute('data-tt-site') || '-';

			let fallbackLat = parseFloat(mapContainer.getAttribute('data-lat'));
			let fallbackLng = parseFloat(mapContainer.getAttribute('data-lng'));

			const renderSinglePoint = (lat, lng) => {
				mapInstance = L.map('mapContainer').setView([lat, lng], 15);
				L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
					maxZoom: 19
				}).addTo(mapInstance);
				L.marker([lat, lng], {
						icon: createCustomIcon(siteDown, 'marker-site-down')
					}).addTo(mapInstance)
					.bindPopup(
						`<div style="text-align:center;"><strong>${siteDown}</strong> (${siteNameDown})<br>${ttSite}<br>${lat.toFixed(6)}, ${lng.toFixed(6)}</div>`
					);
			};

			const renderMapOnly = () => {
				mapInstance = L.map('mapContainer').setView([0, 0], 5);
				L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
					maxZoom: 19
				}).addTo(mapInstance);
			};

			fetch(
					`/ajax/map/sites/site-to-site?site_from=${encodeURIComponent(siteDown)}&site_to=${encodeURIComponent(siteDetect)}`
				)
				.then(res => res.json())
				.then(data => {
					const fromLat = parseFloat(data.site_from_latitude);
					const fromLng = parseFloat(data.site_from_longitude);
					const toLat = parseFloat(data.site_to_latitude);
					const toLng = parseFloat(data.site_to_longitude);

					if ([fromLat, fromLng, toLat, toLng].some(v => v === undefined || v === null || isNaN(parseFloat(
							v)))) {
						if (!fallbackLat || !fallbackLng || isNaN(fallbackLat) || isNaN(fallbackLng)) {
							renderMapOnly();
							return;
						}
						renderSinglePoint(fallbackLat, fallbackLng);
						return;
					}

					mapInstance = L.map('mapContainer').setView([fromLat, fromLng], 13);
					L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
						maxZoom: 19
					}).addTo(mapInstance);

					L.Routing.control({
						waypoints: [
							L.latLng(fromLat, fromLng),
							L.latLng(toLat, toLng)
						],
						lineOptions: {
							styles: [{
								color: '#4361ee',
								weight: 5,
								opacity: 0.8
							}]
						},
						addWaypoints: false,
						draggableWaypoints: false,
						fitSelectedRoutes: true,
						show: false,
						createMarker: function(i, wp) {
							const isStart = i === 0;
							const label = isStart ? 'Site Down' : 'Site Detect';
							const name = isStart ? siteNameDown : siteNameDetect;
							const site = isStart ? siteDown : siteDetect;
							const cssClass = isStart ? 'marker-site-down' : 'marker-site-detect';
							return L.marker(wp.latLng, {
								icon: createCustomIcon(site, cssClass)
							}).bindPopup(
								`<div style="text-align:center;"><strong>${label}</strong><br>${site} (${name})<br>${wp.latLng.lat.toFixed(6)}, ${wp.latLng.lng.toFixed(6)}</div>`
							);
						}
					}).addTo(mapInstance);
				})
				.catch(() => {
					if (!fallbackLat || !fallbackLng || isNaN(fallbackLat) || isNaN(fallbackLng)) {
						renderMapOnly();
						return;
					}
					renderSinglePoint(fallbackLat, fallbackLng);
				});
		}

		function loadPhotos(rowId) {
			const photosGrid = document.querySelector('.photos-grid');
			if (!photosGrid) return;

			photosGrid.innerHTML = '<div class="photos-empty">Loading photos...</div>';

			fetch(`/ajax/order/tacc-ticket-alita-detail?id=${rowId}`)
				.then(res => res.json())
				.then(data => {
					if (!data || data.length <= 1) {
						photosGrid.innerHTML = '<div class="photos-empty">No photos available</div>';
						return;
					}

					const photos = data.slice(1).filter(url => url && url.trim());

					if (photos.length === 0) {
						photosGrid.innerHTML = '<div class="photos-empty">No photos available</div>';
						return;
					}

					photosGrid.innerHTML = photos.map((photoUrl, index) => `
						<div class="photo-item" data-photo-index="${index}" data-photo-url="${photoUrl}">
							<img src="${photoUrl}" alt="Photo ${index + 1}" onerror="this.parentElement.innerHTML='<div class=\\'photo-error\\'>Error loading<br/>image</div>'">
						</div>
					`).join('');

					photosGrid.querySelectorAll('.photo-item').forEach(item => {
						item.addEventListener('click', function() {
							const photoUrl = this.getAttribute('data-photo-url');
							openPhotoModal(photoUrl);
						});
					});
				})
				.catch(err => {
					console.error('Error loading photos:', err);
					photosGrid.innerHTML = '<div class="photos-empty">Error loading photos</div>';
				});
		}

		function openPhotoModal(photoUrl) {
			const modal = document.getElementById('photoModal') || createPhotoModal();
			const img = modal.querySelector('img');
			img.src = photoUrl;
			modal.classList.add('active');
		}

		function closePhotoModal() {
			const modal = document.getElementById('photoModal');
			if (modal) {
				modal.classList.remove('active');
			}
		}

		function createPhotoModal() {
			const modal = document.createElement('div');
			modal.id = 'photoModal';
			modal.className = 'photo-modal';
			modal.innerHTML = `
				<div class="photo-modal-content">
					<button class="photo-modal-close" onclick="closePhotoModal()">×</button>
					<img src="" alt="Photo Preview">
				</div>
			`;
			document.body.appendChild(modal);

			modal.addEventListener('click', function(e) {
				if (e.target === this) {
					closePhotoModal();
				}
			});

			return modal;
		}

		function getCoordinateFromLocation(btn) {
			btn.classList.add('loading');
			btn.disabled = true;

			if (!navigator.geolocation) {
				alert('Geolocation tidak didukung oleh browser Anda');
				btn.classList.remove('loading');
				btn.disabled = false;
				return;
			}

			navigator.geolocation.getCurrentPosition(
				(position) => {
					const lat = position.coords.latitude.toFixed(6);
					const lon = position.coords.longitude.toFixed(6);
					const coordinate = `${lat}, ${lon}`;

					const form = btn.closest('form');
					const targetName = btn.getAttribute('data-target');

					if (targetName) {
						const coordinateInput = form.querySelector(`input[name="${targetName}"]`);
						if (coordinateInput) {
							coordinateInput.value = coordinate;
						}
					} else {
						const coordinateInput = form.querySelector('input[name="coordinates_site"]');
						if (coordinateInput) {
							coordinateInput.value = coordinate;
						}
					}

					btn.classList.remove('loading');
					btn.disabled = false;
				},
				(error) => {
					let errorMsg = 'Gagal mendapatkan lokasi';
					switch (error.code) {
						case error.PERMISSION_DENIED:
							errorMsg = 'Izin akses lokasi ditolak. Silakan aktifkan akses lokasi di browser Anda.';
							break;
						case error.POSITION_UNAVAILABLE:
							errorMsg = 'Informasi lokasi tidak tersedia.';
							break;
						case error.TIMEOUT:
							errorMsg = 'Permintaan lokasi timeout.';
							break;
					}
					alert(errorMsg);
					btn.classList.remove('loading');
					btn.disabled = false;
				}, {
					enableHighAccuracy: true,
					timeout: 10000,
					maximumAge: 0
				}
			);
		}

		document.addEventListener('DOMContentLoaded', function() {
			fetch('/ajax/setting/designator-khs')
				.then(res => res.json())
				.then(data => {
					materialsData = data;
					if (existingMaterials && existingMaterials.length > 0) {
						existingMaterials.forEach(item => addMaterialRow(item));
					} else {
						addMaterialRow();
					}
					updateMaterialTotals();
				})
				.catch(err => {
					console.error('Error loading materials:', err);
				});

			initializePhotoUpload();

			setTimeout(() => {
				initializeMap();
			}, 100);

			const rowId = '{{ $id }}';
			loadPhotos(rowId);

			const materialModal = document.getElementById('materialModal');
			const materialOpenBtn = document.getElementById('materialModalOpenBtn');
			const materialCloseBtn = document.getElementById('materialModalCloseBtn');
			const materialCancelBtn = document.getElementById('materialModalCancelBtn');
			const materialSaveBtn = document.getElementById('materialModalSaveBtn');

			const toggleMaterialModal = (show) => {
				if (!materialModal) return;
				materialModal.classList[show ? 'add' : 'remove']('show');
			};

			[materialOpenBtn, materialCloseBtn, materialCancelBtn, materialSaveBtn].forEach(btn => {
				if (btn) {
					btn.addEventListener('click', () => toggleMaterialModal(btn === materialOpenBtn));
				}
			});

			if (materialModal) {
				materialModal.addEventListener('click', (e) => {
					if (e.target === materialModal) {
						toggleMaterialModal(false);
					}
				});
			}

			const qcModal = document.getElementById('qcModal');
			const qcOpenBtn = document.getElementById('qcModalOpenBtn');
			const qcCloseBtn = document.getElementById('qcModalCloseBtn');
			const qcForm = document.getElementById('qcForm');
			const qcNotes = document.getElementById('qcNotes');
			const qcRejectBtn = document.getElementById('qcRejectBtn');
			const qcApproveBtn = document.getElementById('qcApproveBtn');

			const toggleQcModal = (show) => {
				if (!qcModal) return;
				qcModal.classList[show ? 'add' : 'remove']('show');
				if (show && qcNotes) {
					setTimeout(() => qcNotes.focus(), 50);
				}
			};

			if (qcOpenBtn) {
				qcOpenBtn.addEventListener('click', () => {
					const assignInput = qcForm ? qcForm.querySelector('input[name="assign_order_id"]') : null;
					if (!assignInput || !assignInput.value) {
						alert('Assign order belum tersedia untuk QC.');
						return;
					}
					toggleQcModal(true);
				});
			}

			if (qcRejectBtn && qcForm) {
				qcRejectBtn.addEventListener('click', () => {
					const statusInput = qcForm.querySelector('input[name="status_qc_id"]');
					if (statusInput) {
						statusInput.value = qcRejectBtn.getAttribute('data-status');
					}
					qcForm.submit();
				});
			}
			if (qcApproveBtn && qcForm) {
				qcApproveBtn.addEventListener('click', () => {
					const statusInput = qcForm.querySelector('input[name="status_qc_id"]');
					if (statusInput) {
						statusInput.value = qcApproveBtn.getAttribute('data-status');
					}
					qcForm.submit();
				});
			}

			[qcCloseBtn].forEach(btn => {
				if (btn) {
					btn.addEventListener('click', () => toggleQcModal(false));
				}
			});

			if (qcModal) {
				qcModal.addEventListener('click', (e) => {
					if (e.target === qcModal) {
						toggleQcModal(false);
					}
				});
			}
		});

		document.addEventListener('click', function(e) {
			if (e.target.classList.contains('remove-material-btn') || e.target.closest('.remove-material-btn')) {
				const btn = e.target.classList.contains('remove-material-btn') ? e.target : e.target.closest(
					'.remove-material-btn');
				const materialRow = btn.closest('.material-row');
				const coordinateRow = materialRow ? materialRow.nextElementSibling : null;
				const materialRowCount = document.querySelectorAll('.material-row').length;

				if (materialRowCount > 1 && materialRow) {
					const select = materialRow.querySelector('.material-select');
					if ($(select).data('select2')) {
						$(select).select2('destroy');
					}
					materialRow.remove();
					if (coordinateRow && coordinateRow.classList.contains('material-coordinate-row')) {
						coordinateRow.remove();
					}
					updateMaterialTotals();
				} else {
					alert('Minimal harus ada satu material');
				}
			}

			if (e.target.classList.contains('add-material-btn') || e.target.closest('.add-material-btn')) {
				addMaterialRow();
				updateMaterialTotals();
			}
			if (e.target.classList.contains('get-coordinate-btn') || e.target.closest('.get-coordinate-btn')) {
				const btn = e.target.classList.contains('get-coordinate-btn') ? e.target : e.target.closest(
					'.get-coordinate-btn');
				getCoordinateFromLocation(btn);
			}
		});

		document.getElementById('orderForm').addEventListener('submit', function(e) {
			const materialRows = document.querySelectorAll('.material-row');
			if (materialRows.length === 0) {
				e.preventDefault();
				alert('Mohon pilih minimal satu material');
				return;
			}

			let hasEmptyMaterial = false;
			materialRows.forEach((row, index) => {
				const select = row.querySelector('.material-select');
				if (!select.value) {
					hasEmptyMaterial = true;
				}
			});

			if (hasEmptyMaterial) {
				e.preventDefault();
				alert('Mohon pilih material untuk semua baris');
				return;
			}
		});
	</script>
@endsection
