@extends('layouts')

@section('styles')
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
	<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
	<style>
		.detail-table th,
		.detail-table td {
			text-align: center !important;
			vertical-align: middle !important;
			padding: 8px !important;
			font-size: 13px !important;
		}

		.detail-table th {
			font-weight: 600 !important;
		}

		.back-link {
			display: inline-flex;
			align-items: center;
			gap: 8px;
			margin-bottom: 1rem;
			color: #4361ee;
			text-decoration: none;
			font-weight: 500;
			transition: all 0.2s ease;
		}

		.back-link:hover {
			color: #3451d4;
			gap: 12px;
		}

		.select2-container--default .select2-results__option {
			padding: 8px 12px;
		}

		.select2-result-item-text {
			display: block;
			font-weight: 500;
			color: #1f2937;
		}

		.select2-result-item-desc {
			font-size: 12px;
			color: #6b7280;
			margin-top: 4px;
			line-height: 1.4;
		}

		.select2-container--default .select2-results__option.select2-results__option--highlighted[aria-selected] .select2-result-item-text {
			color: #fff;
		}

		.select2-container--default .select2-results__option.select2-results__option--highlighted[aria-selected] .select2-result-item-desc {
			color: rgba(255, 255, 255, 0.8);
		}

		.modal-backdrop {
			animation: fadeIn 0.2s ease-out;
			padding: 1rem;
		}

		.modal-content {
			animation: slideUp 0.3s ease-out;
			box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
			max-height: none;
			overflow: visible;
			position: relative;
		}

		@media (max-width: 768px) {
			.modal-content {
				margin: 0;
			}

			.modal-backdrop {
				padding: 0.5rem;
			}

			.material-row {
				flex-direction: column;
				gap: 12px;
			}

			.material-row .flex-1 {
				width: 100%;
			}

			.material-row .flex.items-center {
				width: 100%;
				justify-content: space-between;
			}

			.qty-input {
				width: 80px !important;
			}

			.modal-header h5 {
				font-size: 16px;
			}

			.form-section {
				padding: 12px;
			}

			.info-grid {
				grid-template-columns: 1fr !important;
			}
		}

		@keyframes fadeIn {
			from {
				opacity: 0;
			}

			to {
				opacity: 1;
			}
		}

		@keyframes slideUp {
			from {
				opacity: 0;
				transform: translateY(20px);
			}

			to {
				opacity: 1;
				transform: translateY(0);
			}
		}

		.form-section {
			background: #f9fafb;
			padding: 16px;
			border-radius: 8px;
			margin-bottom: 20px;
			border: 1px solid #e5e7eb;
			overflow: visible;
			position: relative;
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
		}

		.form-input:focus,
		.form-select:focus {
			border-color: #4361ee;
			box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
			outline: none;
		}

		.material-row {
			background: #fff;
			padding: 16px;
			border-radius: 8px;
			border: 1px solid #e5e7eb;
			transition: all 0.2s ease;
			margin-bottom: 12px;
		}

		.material-row:hover {
			border-color: #4361ee;
			box-shadow: 0 2px 4px rgba(67, 97, 238, 0.1);
		}

		.material-main-row {
			display: flex;
			align-items: flex-end;
			gap: 16px;
			margin-bottom: 12px;
		}

		.material-field-group {
			flex: 1;
			min-width: 0;
			display: flex;
			flex-direction: column;
		}

		.material-field-label {
			font-size: 12px;
			font-weight: 600;
			color: #6b7280;
			margin-bottom: 6px;
			display: block;
			text-transform: uppercase;
			letter-spacing: 0.5px;
			height: 18px;
		}

		.material-select-wrapper {
			width: 100%;
		}

		.material-select-wrapper .select2-container {
			width: 100% !important;
		}

		.material-select-wrapper .select2-container .select2-selection--single {
			height: 42px !important;
			display: flex;
			align-items: center;
		}

		.material-select-wrapper .select2-container .select2-selection__rendered {
			line-height: 42px !important;
			padding-left: 12px !important;
		}

		.material-select-wrapper .select2-container .select2-selection__arrow {
			height: 40px !important;
		}

		.qty-field-group {
			flex: 0 0 auto;
			min-width: 180px;
			display: flex;
			flex-direction: column;
		}

		.qty-field-group .form-input {
			height: 42px;
		}

		.material-actions {
			flex: 0 0 auto;
			display: flex;
			align-items: center;
			gap: 8px;
			height: 42px;
		}

		.material-actions .btn {
			height: 42px;
			width: 42px;
			display: flex;
			align-items: center;
			justify-content: center;
			padding: 0;
		}

		.material-header {
			display: flex;
			align-items: center;
			justify-content: space-between;
			margin-bottom: 12px;
		}

		.input-group-label {
			background: #f3f4f6;
			padding: 10px 12px;
			border: 1px solid #d1d5db;
			border-right: none;
			border-radius: 6px 0 0 6px;
			font-size: 13px;
			color: #6b7280;
			font-weight: 500;
		}

		.input-with-icon {
			border-radius: 0 6px 6px 0;
		}

		.qty-wrapper {
			width: 100%;
		}

		.select2-container {
			font-size: 14px;
		}

		@media (max-width: 768px) {
			.material-main-row {
				flex-direction: column;
				gap: 12px;
			}

			.qty-field-group {
				min-width: 100%;
			}

			.material-actions {
				padding-top: 0;
				justify-content: flex-end;
			}
		}

		.coordinate-input-group {
			margin-top: 8px;
			display: none;
			padding: 8px 12px;
			background: #f0f4ff;
			border-radius: 6px;
			border: 1px solid #c7d2fe;
		}

		.coordinate-input-group.show {
			display: block;
		}

		.coordinate-inputs {
			margin-top: 8px;
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

		.dark .coordinate-input-group {
			background: #1e3a8a;
			border-color: #3730a3;
		}

		.dark .coordinate-label {
			color: #a5b4fc;
		}

		.dark .coordinate-input {
			background: #1e293b;
			border-color: #475569;
			color: #e5e7eb;
		}

		.empty-state {
			text-align: center;
			padding: 24px;
			color: #9ca3af;
			font-size: 14px;
		}

		.info-grid {
			display: grid;
			grid-template-columns: repeat(2, 1fr);
			gap: 12px;
		}

		.info-item {
			display: flex;
			flex-direction: column;
			gap: 4px;
		}

		.info-label {
			font-size: 11px;
			font-weight: 600;
			color: #6b7280;
			text-transform: uppercase;
			letter-spacing: 0.5px;
		}

		.info-value {
			font-size: 12px;
			font-weight: 500;
			color: #1f2937;
			word-break: break-word;
		}

		.dark .info-label {
			color: #9ca3af;
		}

		.dark .info-value {
			color: #e5e7eb;
		}

		.dark .form-section {
			background: #1e293b;
			border-color: #334155;
		}

		.dark .form-label {
			color: #e5e7eb;
		}

		.dark .material-row {
			background: #1e293b;
			border-color: #334155;
		}

		.dark .input-group-label {
			background: #334155;
			border-color: #475569;
			color: #cbd5e1;
		}

		.photos-grid {
			display: grid;
			grid-template-columns: repeat(auto-fill, minmax(170px, 1fr));
			gap: 12px;
			margin-top: 12px;
		}

		.photo-item {
			position: relative;
			aspect-ratio: 1;
			border-radius: 6px;
			overflow: hidden;
			border: 1px solid #e5e7eb;
			transition: all 0.2s ease;
			cursor: pointer;
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

		.modal-backdrop .select2-dropdown {
			z-index: 99999 !important;
		}

		.modal-backdrop .select2-container {
			z-index: 99998 !important;
		}

		.modal-backdrop .select2-container--open {
			z-index: 99999 !important;
		}

		.select2-dropdown {
			z-index: 99999 !important;
			background-color: white;
			border: 1px solid #d1d5db;
			border-radius: 6px;
			box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
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
			background-color: #f8f9fa;
			overflow: hidden;
			transition: all 0.2s ease;
			position: relative;
		}

		.upload-box:hover {
			border-color: #4361ee;
			background-color: #f0f4ff;
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
			height: 400px;
			border-radius: 8px;
			overflow: hidden;
			border: 1px solid #e5e7eb;
			margin-top: 12px;
		}

		.leaflet-container {
			font-family: inherit;
		}

		.maps-section h6 {
			font-size: 14px;
			font-weight: 600;
			color: #1f2937;
			margin-bottom: 12px;
			display: flex;
			align-items: center;
			gap: 8px;
		}

		.dark .maps-container {
			border-color: #334155;
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
	</style>
@endsection

@section('title', 'Detail Monitoring')

@section('content')
	<div class="panel mt-6">
		<a href="{{ route('dashboard.monitoring') }}" class="back-link">
			<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M15 5L9 12L15 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
			</svg>
			Kembali
		</a>

		<h5 class="text-lg font-semibold dark:text-white-light mb-4" id="pageTitle">Detail Monitoring</h5>

		<div class="table-responsive">
			<table class="table table-bordered table-hover detail-table" id="detailTable">
				<thead>
					<tr>
						<th>No</th>
						<th>Start Time</th>
						<th>TT Site</th>
						<th>Site Down</th>
						<th>Site Name Down</th>
						<th>Latitude Site Down</th>
						<th>Longitude Site Down</th>
						<th>Site Detect</th>
						<th>Site Name Detect</th>
						<th>Tiket Terima</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody id="detail-tbody">
					<tr>
						<td colspan="11" class="text-center">Loading...</td>
					</tr>
				</tbody>
			</table>
		</div>

		<div id="planningModalContainer"></div>
	</div>
@endsection

@section('scripts')
	<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
	<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
	<script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.min.js"></script>
	<script>
		let detailDatatable = null;
		let materialsData = [];

		function formatMaterialOption(data) {
			if (!data.id) return data.text;

			const description = $(data.element).data('description') || '';
			return $(`
				<div>
					<div class="select2-result-item-text">${data.text}</div>
					${description ? `<div class="select2-result-item-desc">${description}</div>` : ''}
				</div>
			`);
		}

		function formatMaterialSelection(data) {
			return data.text;
		}

		function getUrlParams() {
			const params = new URLSearchParams(window.location.search);
			return {
				regional_id: params.get('regional_id') || 'ALL',
				witel_id: params.get('witel_id') || 'ALL',
				start_date: params.get('start_date') || '',
				end_date: params.get('end_date') || '',
				status: params.get('status') || 'ALL',
				witel: params.get('witel') || '',
				column_header: params.get('column_header') || ''
			};
		}

		function renderDetailTable(data) {
			const tbody = document.getElementById('detail-tbody');

			if (!data || data.length === 0) {
				tbody.innerHTML = '<tr><td colspan="11" class="text-center">Tidak ada data untuk ditampilkan</td></tr>';
				return;
			}

			if (detailDatatable) {
				detailDatatable.destroy();
			}

			tbody.innerHTML = '';
			data.forEach((row, index) => {
				const tr = document.createElement('tr');
				tr.innerHTML = `
					<td>${index + 1}</td>
					<td>${row.tiket_start_time || '-'}</td>
					<td>${row.tt_site || '-'}</td>
					<td>${row.site_down || '-'}</td>
					<td>${row.site_name_down || '-'}</td>
					<td>${row.latitude_site_down || '-'}</td>
					<td>${row.longitude_site_down || '-'}</td>
					<td>${row.site_detect || '-'}</td>
					<td>${row.site_name_detect || '-'}</td>
					<td>${row.tiket_terima || '-'}</td>
					<td>
						<button type="button" class="btn btn-sm btn-primary planning-btn"
							data-row-id="${row.row_id || ''}"
							data-tt-site="${row.tt_site || '-'}">
							Planning
						</button>
					</td>
				`;
				tbody.appendChild(tr);
			});

			detailDatatable = $('#detailTable').DataTable({
				dom: 'Bfrtip',
				buttons: [{
					extend: 'excelHtml5',
					text: 'Export to Excel',
					title: 'Detail Monitoring',
					filename: 'detail-monitoring-' + new Date().toISOString().slice(0, 10),
					exportOptions: {
						columns: ':visible'
					}
				}],
				pageLength: 10,
				lengthMenu: [
					[10, 20, 30, 50, 100],
					[10, 20, 30, 50, 100]
				],
				order: [
					[0, 'asc']
				],
				language: {
					search: 'Cari:',
					lengthMenu: 'Tampilkan _MENU_ data',
					info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
					infoEmpty: 'Menampilkan 0 sampai 0 dari 0 data',
					infoFiltered: '(disaring dari _MAX_ total data)',
					paginate: {
						first: 'Pertama',
						last: 'Terakhir',
						next: 'Selanjutnya',
						previous: 'Sebelumnya'
					},
					zeroRecords: 'Tidak ada data yang ditemukan'
				}
			});
		}

		function fetchDetailData() {
			const urlParams = getUrlParams();

			const pageTitle = document.getElementById('pageTitle');
			if (urlParams.witel && urlParams.column_header) {
				pageTitle.innerText = `Detail - ${urlParams.witel} (${urlParams.column_header})`;
			}

			const params = new URLSearchParams({
				regional_id: urlParams.regional_id,
				witel_id: urlParams.witel_id,
				start_date: urlParams.start_date,
				end_date: urlParams.end_date,
				status: urlParams.status
			});

			fetch(`/ajax/dashboard/monitoring/detail?${params.toString()}`)
				.then(res => res.json())
				.then(data => {
					renderDetailTable(data);
				})
				.catch(err => {
					const tbody = document.getElementById('detail-tbody');
					tbody.innerHTML = '<tr><td colspan="11" class="text-center text-red-500">Gagal memuat data</td></tr>';
					console.error(err);
				});
		}

		function createPlanningModal(rowId, rowData) {
			const modalId = `modal-${rowId}`;
			return `
				<div class="fixed inset-0 bg-[black]/60 z-[999] hidden overflow-y-auto modal-backdrop" data-modal-id="${modalId}">
					<div class="flex items-center justify-center min-h-screen px-4 py-8">
						<div class="panel border-0 p-0 rounded-lg overflow-hidden w-full max-w-6xl my-8 modal-content" id="${modalId}">
							<div class="modal-header flex items-center justify-between px-6 py-4">
								<h5 class="font-bold text-lg m-0">Input Planning</h5>
								<button type="button" class="close-modal-btn" data-modal-id="${modalId}">
									<svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
								</button>
							</div>
							<div class="p-6">
								<form class="planning-form" data-row-id="${rowId}">
									<input type="hidden" name="row_id" value="${rowId}">
									<input type="hidden" name="tt_site" value="${rowData.ttSite}">

									<div class="grid grid-cols-2 gap-6">
										<div class="form-section">
											<span class="info-label block mb-2">
												<svg class="inline-block w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
													<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
												</svg>
												Information Order
											</span>
											<div class="info-grid">
												<div class="info-item">
													<span class="info-label">Start Time</span>
													<span class="info-value">${rowData.startTime}</span>
												</div>
												<div class="info-item">
													<span class="info-label">TT Site</span>
													<span class="info-value">${rowData.ttSite}</span>
												</div>
												<div class="info-item">
													<span class="info-label">Site Down</span>
													<span class="info-value">${rowData.siteDown}</span>
												</div>
												<div class="info-item">
													<span class="info-label">Site Name Down</span>
													<span class="info-value">${rowData.siteNameDown}</span>
												</div>
												<div class="info-item">
													<span class="info-label">Latitude Site Down</span>
													<span class="info-value">${rowData.latitudeSiteDown}</span>
												</div>
												<div class="info-item">
													<span class="info-label">Longitude Site Down</span>
													<span class="info-value">${rowData.longitudeSiteDown}</span>
												</div>
												<div class="info-item">
													<span class="info-label">Site Detect</span>
													<span class="info-value">${rowData.siteDetect}</span>
												</div>
												<div class="info-item">
													<span class="info-label">Site Name Detect</span>
													<span class="info-value">${rowData.siteNameDetect}</span>
												</div>
												<div class="info-item">
													<span class="info-label">Tiket Terima</span>
													<span class="info-value">${rowData.tiketTerima}</span>
												</div>
											</div>

											<div class="maps-section">
												<span class="info-label block mb-2 flex items-center gap-2">
													<svg class="inline-block w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
														<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21s6-4.35 6-9a6 6 0 10-12 0c0 4.65 6 9 6 9z" />
														<circle cx="12" cy="12" r="2.5" stroke-width="2" />
													</svg>
													Location Map
												</span>
												<div
													class="maps-container"
													id="mapContainer-${rowId}"
													data-lat="${rowData.latitudeSiteDown}"
													data-lng="${rowData.longitudeSiteDown}"
													data-site-down="${rowData.siteDown}"
													data-site-name-down="${rowData.siteNameDown}"
													data-site-detect="${rowData.siteDetect}"
													data-site-name-detect="${rowData.siteNameDetect}"
													data-tt-site="${rowData.ttSite}">
												</div>
											</div>
										</div>

										<div class="form-section">
											<span class="info-label block mb-2">
												<svg class="inline-block w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
													<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
												</svg>
												Evidence Photo
											</span>
											<div class="photos-grid" data-row-id="${rowId}">
												<div class="photos-empty">Loading photos...</div>
											</div>
										</div>
									</div>
									<div class="form-section">
									<div class="mb-6">
										<label class="form-label text-sm mb-2">
											Foto Titik Putus
										</label>
										<label for="photoFileInput${modalId}" class="upload-box">
											<span class="camera-icon" id="cameraIcon${modalId}">
												<i class="bi bi-camera-fill"></i>
											</span>
											<img id="previewImage${modalId}" hidden>
										</label>
										<input type="file" id="photoFileInput${modalId}" accept="image/*" data-modal-id="${modalId}">
										<div class="action-area">
											<button type="button" class="btn btn-outline-primary btn-sm" id="uploadBtn${modalId}" data-modal-id="${modalId}" title="Upload Foto">
												<i class="bi bi-camera"></i>
											</button>
											<button type="button" class="btn btn-outline-danger btn-sm" id="deleteBtn${modalId}" hidden data-modal-id="${modalId}" title="Hapus Foto">
												<i class="bi bi-trash"></i>
											</button>
										</div>
									</div>
                                    <div class="mb-6">
											<label class="form-label text-sm mb-2">
												Koordinat Titik Putus
											</label>
											<div class="flex gap-2 mb-2">
												<input type="text" name="coordinate" class="form-input flex-1"
													placeholder="Contoh: -1.2563759829104284, 116.86768575387761" required>
												<button type="button" class="btn btn-primary btn-sm" data-modal-id="${modalId}" title="Ambil lokasi dari GPS">
													<i class="bi bi-geo-alt-fill"></i>
												</button>
											</div>
											<small class="text-gray-500 text-xs block mb-4">Format: latitude, longitude</small>
										</div>

										<div>
											<div class="material-header">
												<label class="form-label mb-0 text-sm">
													Material
												</label>
												<button type="button" class="btn btn-sm btn-primary add-material-btn" data-modal-id="${modalId}">
													<i class="bi bi-plus-circle"></i>
													&nbsp; Tambah Material
												</button>
											</div>
											<div class="material-rows space-y-3"></div>
										</div>
									</div>

									<div class="flex justify-end items-center gap-3 mt-6 pt-4">
										<button type="button" class="btn btn-outline-danger close-modal-btn" data-modal-id="${modalId}">
											<i class="bi bi-x-circle"></i>
											&nbsp; Batal
										</button>
										<button type="submit" class="btn btn-primary">
											<i class="bi bi-check-circle"></i>
											&nbsp; Simpan
										</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			`;
		}

		function openModal(modalId) {
			const modal = document.querySelector(`.modal-backdrop[data-modal-id="${modalId}"]`);
			if (modal) {
				modal.classList.remove('hidden');
				document.body.style.overflow = 'hidden';

				const rowId = modalId.replace('modal-', '');
				loadPhotos(rowId);

				initializePhotoUpload(modalId);

				setTimeout(() => {
					initializeMap(modalId, rowId);
				}, 100);
			}
		}

		function initializePhotoUpload(modalId) {
			const fileInput = document.getElementById(`photoFileInput${modalId}`);
			const previewImage = document.getElementById(`previewImage${modalId}`);
			const cameraIcon = document.getElementById(`cameraIcon${modalId}`);
			const deleteBtn = document.getElementById(`deleteBtn${modalId}`);
			const uploadBtn = document.getElementById(`uploadBtn${modalId}`);

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

					window[`photoFile_${modalId}`] = file;
				};
				reader.readAsDataURL(file);
			});

			deleteBtn.addEventListener('click', function() {
				previewImage.hidden = true;
				previewImage.src = '';
				fileInput.value = '';
				cameraIcon.style.display = 'block';
				deleteBtn.hidden = true;
				window[`photoFile_${modalId}`] = null;
			});
		}

		function closeModal(modalId) {
			const modal = document.querySelector(`.modal-backdrop[data-modal-id="${modalId}"]`);
			if (modal) {
				modal.classList.add('hidden');
				document.body.style.overflow = '';

				window[`photoFile_${modalId}`] = null;

				const mapInstance = window[`map_${modalId}`];
				if (mapInstance) {
					mapInstance.remove();
					window[`map_${modalId}`] = null;
				}
			}
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

		function initializeMap(modalId, rowId) {
			const mapContainer = document.getElementById(`mapContainer-${rowId}`);
			if (!mapContainer) return;

			const siteDown = mapContainer.getAttribute('data-site-down') || '-';
			const siteNameDown = mapContainer.getAttribute('data-site-name-down') || '-';
			const siteDetect = mapContainer.getAttribute('data-site-detect') || '-';
			const siteNameDetect = mapContainer.getAttribute('data-site-name-detect') || '-';
			const ttSite = mapContainer.getAttribute('data-tt-site') || '-';

			let fallbackLat = parseFloat(mapContainer.getAttribute('data-lat'));
			let fallbackLng = parseFloat(mapContainer.getAttribute('data-lng'));

			const renderSinglePoint = (lat, lng) => {
				const singleMap = L.map(`mapContainer-${rowId}`).setView([lat, lng], 15);
				L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
					maxZoom: 19
				}).addTo(singleMap);
				L.marker([lat, lng], {
						icon: createCustomIcon(siteDown, 'marker-site-down')
					}).addTo(singleMap)
					.bindPopup(
						`<div style="text-align:center;">
							<strong>${siteDown}</strong> (${siteNameDown})<br>
							${ttSite}<br>
							${lat.toFixed(6)}, ${lng.toFixed(6)}
						</div>`
					);
				window[`map_${modalId}`] = singleMap;
				setTimeout(() => singleMap.invalidateSize(), 300);
			};

			const renderMapOnly = () => {
				const emptyMap = L.map(`mapContainer-${rowId}`).setView([null, null], 5);
				L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
					maxZoom: 19
				}).addTo(emptyMap);
				window[`map_${modalId}`] = emptyMap;
				setTimeout(() => emptyMap.invalidateSize(), 300);
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

					const map = L.map(`mapContainer-${rowId}`).setView([fromLat, fromLng], 13);
					L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
						maxZoom: 19
					}).addTo(map);

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
								`<div style="text-align:center;">
								<strong>${label}</strong><br>${site} (${name})<br>${wp.latLng.lat.toFixed(6)}, ${wp.latLng.lng.toFixed(6)}
							</div>`
							);
						}
					}).addTo(map);
					window[`map_${modalId}`] = map;
					setTimeout(() => map.invalidateSize(), 300);
				})
				.catch(() => {
					if (!fallbackLat || !fallbackLng || isNaN(fallbackLat) || isNaN(fallbackLng)) {
						renderMapOnly();
						return;
					}
					renderSinglePoint(fallbackLat, fallbackLng);
				});
		}

		function addMaterialRow(modalId) {
			const modal = document.getElementById(modalId);
			const materialRows = modal.querySelector('.material-rows');

			const rowDiv = document.createElement('div');
			rowDiv.className = 'material-row';
			rowDiv.innerHTML = `
			<div class="material-main-row">
				<div class="material-field-group">
					<label class="material-field-label">Material</label>
					<div class="material-select-wrapper">
						<select name="materials[]" class="form-select material-select w-full" required>
							<option value="">Pilih material...</option>
							${materialsData.map(m => `<option value="${m.id}" data-designator="${m.item_designator}" data-description="${m.item_description || ''}">${m.item_designator}</option>`).join('')}
						</select>
					</div>
				</div>
				<div class="qty-field-group">
					<label class="material-field-label">Qty</label>
					<div class="qty-wrapper">
						<input type="number" name="material_qty[]" class="form-input" min="1" value="1" required>
					</div>
				</div>
				<div class="material-actions">
					<button type="button" class="btn btn-sm btn-outline-danger remove-material-btn">
						<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
						</svg>
					</button>
				</div>
			</div>
			<div class="coordinate-input-group">
				<div class="coordinate-label">
					<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
					</svg>
					Koordinat Material (Latitude, Longitude)
				</div>
				<div class="coordinate-inputs">
					<input type="text" name="material_coordinate[]" class="coordinate-input" placeholder="-6.200000, 106.816666">
				</div>
			</div>
		`;
			materialRows.appendChild(rowDiv);

			const newSelect = rowDiv.querySelector('.material-select');
			const modalContent = modal.querySelector('.modal-content');

			if ($(newSelect).hasClass('select2-hidden-accessible')) {
				$(newSelect).select2('destroy');
			}

			$(newSelect).select2({
				placeholder: 'Cari material...',
				allowClear: true,
				templateResult: formatMaterialOption,
				templateSelection: formatMaterialSelection,
				width: '100%',
				dropdownParent: modalContent ? $(modalContent) : $(modal),
				matcher: function(params, data) {
					if ($.trim(params.term) === '') {
						return data;
					}
					if (typeof data.text === 'undefined') {
						return null;
					}
					if (data.text.toUpperCase().indexOf(params.term.toUpperCase()) > -1) {
						return data;
					}
					return null;
				}
			});

			$(newSelect).on('change', function() {
				const selectedOption = $(this).find('option:selected');
				const designator = selectedOption.data('designator') || '';
				const coordinateGroup = $(this).closest('.material-row').find('.coordinate-input-group');
				const coordinateInputs = coordinateGroup.find('.coordinate-input');

				const requiresCoordinate = designator.includes('SC-OF-SM') || designator.includes('PU-S');

				if (requiresCoordinate) {
					coordinateGroup.addClass('show');
					coordinateInputs.prop('required', true);
				} else {
					coordinateGroup.removeClass('show');
					coordinateInputs.prop('required', false);
					coordinateInputs.val('');
				}
			});


		}

		function initializeMaterialRows(modalId) {
			const modal = document.getElementById(modalId);
			if (!modal) return;

			const materialRows = modal.querySelector('.material-rows');
			if (!materialRows) return;

			const modalContent = modal.querySelector('.modal-content');

			if (materialRows.children.length === 0) {
				addMaterialRow(modalId);
			} else {
				materialRows.querySelectorAll('.material-select').forEach((select, index) => {
					if ($(select).hasClass('select2-hidden-accessible')) {
						$(select).select2('destroy');
					}

					$(select).select2({
						placeholder: 'Cari material...',
						allowClear: true,
						templateResult: formatMaterialOption,
						templateSelection: formatMaterialSelection,
						width: '100%',
						dropdownParent: modalContent ? $(modalContent) : $(modal),
						matcher: function(params, data) {
							if ($.trim(params.term) === '') {
								return data;
							}
							if (typeof data.text === 'undefined') {
								return null;
							}
							if (data.text.toUpperCase().indexOf(params.term.toUpperCase()) > -1) {
								return data;
							}
							return null;
						}
					});

					$(select).on('change', function() {
						const selectedOption = $(this).find('option:selected');
						const designator = selectedOption.data('designator') || '';
						const coordinateGroup = $(this).closest('.material-row').find(
							'.coordinate-input-group');
						const coordinateInputs = coordinateGroup.find('.coordinate-input');

						const requiresCoordinate = designator.includes('SC-OF-SM') || designator.includes(
							'PU-S');

						if (requiresCoordinate) {
							coordinateGroup.addClass('show');
							coordinateInputs.prop('required', true);
						} else {
							coordinateGroup.removeClass('show');
							coordinateInputs.prop('required', false);
							coordinateInputs.val('');
						}
					});
				});
			}
		}
		document.addEventListener('DOMContentLoaded', function() {
			fetch('/ajax/setting/designator-khs')
				.then(res => res.json())
				.then(data => {
					materialsData = data;
					fetchDetailData();
				})
				.catch(err => {
					console.error('Error loading materials:', err);
					fetchDetailData();
				});
		});

		document.addEventListener('click', function(e) {
			if (e.target.classList.contains('planning-btn') || e.target.closest('.planning-btn')) {
				const btn = e.target.classList.contains('planning-btn') ? e.target : e.target.closest('.planning-btn');
				const rowId = btn.getAttribute('data-row-id');
				const ttSite = btn.getAttribute('data-tt-site');

				const row = btn.closest('tr');
				const cells = row.querySelectorAll('td');
				const rowData = {
					startTime: cells[1]?.textContent || '-',
					ttSite: cells[2]?.textContent || '-',
					siteDown: cells[3]?.textContent || '-',
					siteNameDown: cells[4]?.textContent || '-',
					latitudeSiteDown: cells[5]?.textContent || '-',
					longitudeSiteDown: cells[6]?.textContent || '-',
					siteDetect: cells[7]?.textContent || '-',
					siteNameDetect: cells[8]?.textContent || '-',
					tiketTerima: cells[9]?.textContent || '-'
				};

				const modalId = `modal-${rowId}`;
				const container = document.getElementById('planningModalContainer');
				if (!document.getElementById(modalId)) {
					container.insertAdjacentHTML('beforeend', createPlanningModal(rowId, rowData));
					initializeMaterialRows(modalId);
				}
				openModal(modalId);
			}

			if (e.target.classList.contains('close-modal-btn') || e.target.closest('.close-modal-btn')) {
				const btn = e.target.classList.contains('close-modal-btn') ? e.target : e.target.closest(
					'.close-modal-btn');
				const modalId = btn.getAttribute('data-modal-id');
				closeModal(modalId);
			}

			if (e.target.hasAttribute('data-modal-id') && e.target.tagName === 'BUTTON' && e.target.getAttribute(
					'title') === 'Ambil lokasi dari GPS') {
				getCoordinateFromLocation(e.target);
			}

			if (e.target.classList.contains('remove-material-btn') || e.target.closest('.remove-material-btn')) {
				const btn = e.target.classList.contains('remove-material-btn') ? e.target : e.target.closest(
					'.remove-material-btn');
				const materialRow = btn.closest('.material-row');
				const materialRows = materialRow.parentElement;

				if (materialRows.children.length > 1) {
					const select = materialRow.querySelector('.material-select');
					if ($(select).data('select2')) {
						$(select).select2('destroy');
					}
					materialRow.remove();
				} else {
					alert('Minimal harus ada satu material');
				}
			}

			if (e.target.classList.contains('add-material-btn') || e.target.closest('.add-material-btn')) {
				const btn = e.target.classList.contains('add-material-btn') ? e.target : e.target.closest(
					'.add-material-btn');
				const modalId = btn.getAttribute('data-modal-id');
				addMaterialRow(modalId);
			}

			if (e.target.classList.contains('modal-backdrop')) {
				const modalId = e.target.getAttribute('data-modal-id');
				closeModal(modalId);
			}
		});

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
					const coordinateInput = form.querySelector('input[name="coordinate"]');
					if (coordinateInput) {
						coordinateInput.value = coordinate;
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

		function loadPhotos(rowId) {
			const photosGrid = document.querySelector(`.photos-grid[data-row-id="${rowId}"]`);
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

		document.addEventListener('submit', function(e) {
			if (e.target.classList.contains('planning-form')) {
				e.preventDefault();

				const formData = new FormData(e.target);
				const rowId = formData.get('row_id');
				const ttSite = formData.get('tt_site');
				const coordinate = formData.get('coordinate');
				const materials = formData.getAll('materials[]');
				const materialQty = formData.getAll('material_qty[]');

				if (materials.length === 0 || materials.some(m => !m)) {
					alert('Mohon pilih minimal satu material');
					return;
				}

				const modalId = `modal-${rowId}`;
				const uploadedFile = window[`photoFile_${modalId}`];

				const planningData = {
					row_id: rowId,
					tt_site: ttSite,
					coordinate: coordinate,
					photo: uploadedFile,
					materials: materials.map((mat, idx) => ({
						id: mat,
						qty: materialQty[idx]
					}))
				};

				console.log('Planning Data:', planningData);

				closeModal(modalId);
				alert('Planning berhasil disimpan!');
			}
		});
	</script>
@endsection
