@extends('layouts')

@section('styles')
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
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
			max-height: 90vh;
			overflow-y: auto;
		}

		@media (max-width: 768px) {
			.modal-content {
				max-height: 95vh;
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

		.modal-header {
			background: linear-gradient(135deg, #4361ee 0%, #3451d4 100%);
			border-bottom: none;
		}

		.modal-header h5 {
			color: #fff;
			font-size: 18px;
		}

		.modal-header .close-modal-btn {
			color: rgba(255, 255, 255, 0.9);
			transition: all 0.2s ease;
		}

		.modal-header .close-modal-btn:hover {
			color: #fff;
			transform: rotate(90deg);
		}

		.form-section {
			background: #f9fafb;
			padding: 16px;
			border-radius: 8px;
			margin-bottom: 20px;
			border: 1px solid #e5e7eb;
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
			padding: 12px;
			border-radius: 6px;
			border: 1px solid #e5e7eb;
			transition: all 0.2s ease;
		}

		.material-row:hover {
			border-color: #4361ee;
			box-shadow: 0 2px 4px rgba(67, 97, 238, 0.1);
		}

		.add-material-btn {
			background: #fff;
			color: #4361ee;
			border: 1.5px dashed #4361ee;
			padding: 6px 14px;
			border-radius: 6px;
			font-size: 13px;
			font-weight: 500;
			transition: all 0.2s ease;
		}

		.add-material-btn:hover {
			background: #4361ee;
			color: #fff;
			border-style: solid;
		}

		.remove-material-btn {
			background: #fee;
			color: #dc2626;
			border: 1px solid #fecaca;
			padding: 8px 12px;
			border-radius: 6px;
			font-size: 13px;
			transition: all 0.2s ease;
		}

		.remove-material-btn:hover {
			background: #dc2626;
			color: #fff;
			border-color: #dc2626;
		}

		.btn-primary {
			background: linear-gradient(135deg, #4361ee 0%, #3451d4 100%);
			border: none;
			padding: 10px 24px;
			border-radius: 6px;
			font-weight: 500;
			transition: all 0.2s ease;
		}

		.btn-primary:hover {
			transform: translateY(-1px);
			box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
		}

		.btn-outline-danger {
			border: 1px solid #dc2626;
			color: #dc2626;
			padding: 10px 24px;
			border-radius: 6px;
			font-weight: 500;
			transition: all 0.2s ease;
		}

		.btn-outline-danger:hover {
			background: #dc2626;
			color: #fff;
		}

		.material-header {
			display: flex;
			align-items: center;
			justify-content: space-between;
			margin-bottom: 12px;
			padding-bottom: 12px;
			border-bottom: 2px solid #e5e7eb;
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

		.qty-input {
			width: 100px !important;
			text-align: center;
			font-weight: 600;
		}

		.select2-container {
			font-size: 14px;
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
			font-size: 12px;
			font-weight: 600;
			color: #6b7280;
			text-transform: uppercase;
			letter-spacing: 0.5px;
		}

		.info-value {
			font-size: 14px;
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
			grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
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
	</style>
@endsection

@section('title', 'Detail Monitoring')

@section('content')
	<div class="panel mt-6">
		<a href="{{ route('dashboard.monitoring') }}" class="back-link">
			<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M15 5L9 12L15 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
			</svg>
			Kembali ke Dashboard Monitoring
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
						<div class="panel border-0 p-0 rounded-lg overflow-hidden w-full max-w-3xl my-8 modal-content" id="${modalId}">
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

									<div class="form-section">
										<label class="form-label mb-3">
											<svg class="inline-block w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
												<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
											</svg>
											Information Order
										</label>
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
										<div class="photos-section mt-4">
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
										<label class="form-label">
											<svg class="inline-block w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
												<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
												<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
											</svg>
											Titik Koordinat Putus
										</label>
										<div class="flex">
											<span class="input-group-label">📍</span>
											<input type="text" name="coordinate" class="form-input input-with-icon flex-1"
												placeholder="Contoh: -6.200000, 106.816666" required>
										</div>
										<small class="text-gray-500 text-xs mt-1 block">Format: latitude, longitude</small>
									</div>

									<div class="form-section">
										<div class="material-header">
											<label class="form-label mb-0">
												<svg class="inline-block w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
													<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
												</svg>
												Material & Quantity
											</label>
											<button type="button" class="add-material-btn" data-modal-id="${modalId}">
												<svg class="inline-block w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
													<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
												</svg>
												Tambah Material
											</button>
										</div>
										<div class="material-rows space-y-3"></div>
									</div>

									<div class="flex justify-end items-center gap-3 mt-6 pt-4 border-t border-gray-200">
										<button type="button" class="btn-outline-danger close-modal-btn" data-modal-id="${modalId}">
											Batal
										</button>
										<button type="submit" class="btn-primary">
											<svg class="inline-block w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
												<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
											</svg>
											Simpan Planning
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
			}
		}

		function closeModal(modalId) {
			const modal = document.querySelector(`.modal-backdrop[data-modal-id="${modalId}"]`);
			if (modal) {
				modal.classList.add('hidden');
				document.body.style.overflow = '';
			}
		}

		function addMaterialRow(modalId) {
			const modal = document.getElementById(modalId);
			const materialRows = modal.querySelector('.material-rows');

			const rowDiv = document.createElement('div');
			rowDiv.className = 'material-row flex items-center gap-3';
			rowDiv.innerHTML = `
				<div class="flex-1">
					<select name="materials[]" class="form-select material-select w-full" required>
						<option value="">Pilih material...</option>
						${materialsData.map(m => `<option value="${m.id}" data-description="${m.item_description || ''}">${m.item_designator}</option>`).join('')}
					</select>
				</div>
				<div class="flex items-center gap-2">
					<span class="text-sm text-gray-600 font-medium">Qty:</span>
					<input type="number" name="material_qty[]" class="form-input qty-input" min="1" value="1" required>
				</div>
				<button type="button" class="remove-material-btn">
					<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
					</svg>
				</button>
			`;

			materialRows.appendChild(rowDiv);

			const newSelect = rowDiv.querySelector('.material-select');
			setTimeout(() => {
				$(newSelect).select2({
					placeholder: 'Cari material...',
					allowClear: true,
					templateResult: formatMaterialOption,
					templateSelection: formatMaterialSelection,
					width: '100%',
					dropdownParent: $(modal)
				});
			}, 100);
		}

		function initializeMaterialRows(modalId) {
			const modal = document.getElementById(modalId);
			const materialRows = modal.querySelector('.material-rows');

			if (materialRows.children.length === 0) {
				addMaterialRow(modalId);
			} else {
				materialRows.querySelectorAll('.material-select').forEach(select => {
					if (!$(select).data('select2')) {
						$(select).select2({
							placeholder: 'Cari material...',
							allowClear: true,
							templateResult: formatMaterialOption,
							templateSelection: formatMaterialSelection,
							width: '100%',
							dropdownParent: $(modal)
						});
					}
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

				const planningData = {
					row_id: rowId,
					tt_site: ttSite,
					coordinate: coordinate,
					materials: materials.map((mat, idx) => ({
						id: mat,
						qty: materialQty[idx]
					}))
				};

				console.log('Planning Data:', planningData);

				const modalId = `modal-${rowId}`;
				closeModal(modalId);

				alert('Planning berhasil disimpan!');
			}
		});
	</script>
@endsection
