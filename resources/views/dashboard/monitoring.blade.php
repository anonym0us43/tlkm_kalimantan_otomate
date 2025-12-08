@extends('layouts')

@section('styles')
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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

		.detail-table tbody td:not(:first-child) {
			cursor: pointer;
			user-select: none;
		}

		.detail-table tbody td:not(:first-child):hover {
			background-color: #f0f0f0 !important;
			transition: background-color 0.2s;
		}

		.date-filter-panel {
			margin-bottom: 1.5rem;
		}

		.date-filter-panel .form-input {
			padding: 6px 12px;
			border: 1px solid #ddd;
			border-radius: 4px;
			font-size: 14px;
			width: 220px;
			max-width: 100%;
		}

		.modal {
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background-color: rgba(0, 0, 0, 0.5);
			z-index: 1000;
			display: flex;
			align-items: center;
			justify-content: center;
		}

		.modal-dialog {
			background-color: white;
			border-radius: 8px;
			box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
			max-height: 90vh;
			overflow-y: auto;
		}

		.modal-lg {
			width: 90%;
			max-width: 1200px;
		}

		.modal-content {
			padding: 0;
		}

		.modal-header {
			padding: 20px;
			border-bottom: 1px solid #ddd;
			display: flex;
			justify-content: space-between;
			align-items: center;
		}

		.modal-title {
			margin: 0;
			font-size: 18px;
			font-weight: 600;
		}

		.btn-close {
			background: none;
			border: none;
			font-size: 28px;
			cursor: pointer;
			color: #999;
		}

		.btn-close:hover {
			color: #333;
		}

		.modal-body {
			padding: 20px;
		}

		.modal-footer {
			padding: 15px 20px;
			border-top: 1px solid #ddd;
			display: flex;
			justify-content: space-between;
			gap: 10px;
		}

		.btn {
			padding: 8px 16px;
			border: none;
			border-radius: 4px;
			cursor: pointer;
			font-size: 14px;
		}

		.btn-primary {
			background-color: #4361ee;
			color: white;
		}

		.btn-primary:hover {
			background-color: #3451d4;
		}

		.btn-secondary {
			background-color: #6c757d;
			color: white;
		}

		.btn-secondary:hover {
			background-color: #5a6268;
		}

		.btn-sm {
			padding: 6px 12px;
			font-size: 13px;
		}

		.export-buttons {
			display: flex;
			gap: 8px;
			flex-wrap: wrap;
		}
	</style>
@endsection

@section('title', 'Dashboard Monitoring')

@section('content')
	<div class="panel mt-6">
		<h5 class="text-lg font-semibold dark:text-white-light mb-4">Dashboard Monitoring</h5>
		<div class="date-filter-panel flex items-center gap-2 mb-4">
			<input type="text" id="date-range" class="form-input" placeholder="Filter: Pilih Rentang Tanggal" readonly>
		</div>
		<div class="table-responsive">
			<table class="table table-bordered table-hover detail-table mt-4" id="monitoring-table">
				<thead>
					<tr>
						<th rowspan="3">WITEL</th>
						<th rowspan="3">INDIKASI</th>
						<th colspan="3">PLANNING</th>
						<th rowspan="2" colspan="4">UMUR</th>
						<th colspan="3">PERMANENISASI</th>
						<th rowspan="3">REKON</th>
						<th rowspan="3">TOTAL</th>
					</tr>
					<tr>
						<th colspan="2">TL TA</th>
						<th colspan="1">MTEL</th>
						<th colspan="2">TL TA</th>
						<th colspan="1">MTEL</th>
					</tr>
					<tr>
						<th>NEED APPROVE</th>
						<th>REJECT</th>
						<th>NEED APPROVE</th>
						<th>&lt;1 HARI</th>
						<th>&gt; 1 HARI</th>
						<th>&gt; 3 HARI</th>
						<th>&gt; 7 HARI</th>
						<th>NEED APPROVE</th>
						<th>REJECT</th>
						<th>NEED APPROVE</th>
					</tr>
				</thead>
				<tbody id="monitoring-tbody">
					<tr>
						<td colspan="14">Loading...</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<div id="detailModal" class="modal" style="display: none;">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="detailModalTitle">Detail Data</h5>
					<button type="button" class="btn-close" onclick="closeDetailModal()">×</button>
				</div>
				<div class="modal-body" id="detailModalBody">
					<div class="text-center">
						<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
						Loading...
					</div>
				</div>
				<div class="modal-footer">
					<div class="export-buttons" id="exportButtons" style="display: none;">
						<button type="button" class="btn btn-primary btn-sm" onclick="exportDetailTable('csv')">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
								class="inline mr-1">
								<path
									d="M15.3929 4.05365L14.8912 4.61112L15.3929 4.05365ZM19.3517 7.61654L18.85 8.17402L19.3517 7.61654ZM21.654 10.1541L20.9689 10.4592V10.4592L21.654 10.1541ZM3.17157 20.8284L3.7019 20.2981H3.7019L3.17157 20.8284ZM20.8284 20.8284L20.2981 20.2981L20.2981 20.2981L20.8284 20.8284ZM14 21.25H10V22.75H14V21.25ZM2.75 14V10H1.25V14H2.75ZM21.25 13.5629V14H22.75V13.5629H21.25ZM14.8912 4.61112L18.85 8.17402L19.8534 7.05907L15.8947 3.49618L14.8912 4.61112ZM22.75 13.5629C22.75 11.8745 22.7651 10.8055 22.3391 9.84897L20.9689 10.4592C21.2349 11.0565 21.25 11.742 21.25 13.5629H22.75ZM18.85 8.17402C20.2034 9.3921 20.7029 9.86199 20.9689 10.4592L22.3391 9.84897C21.9131 8.89241 21.1084 8.18853 19.8534 7.05907L18.85 8.17402ZM10.0298 2.75C11.6116 2.75 12.2085 2.76158 12.7405 2.96573L13.2779 1.5653C12.4261 1.23842 11.498 1.25 10.0298 1.25V2.75ZM15.8947 3.49618C14.8087 2.51878 14.1297 1.89214 13.2779 1.5653L12.7405 2.96573C13.2727 3.16993 13.7215 3.55836 14.8912 4.61112L15.8947 3.49618ZM10 21.25C8.09318 21.25 6.73851 21.2484 5.71085 21.1102C4.70476 20.975 4.12511 20.7213 3.7019 20.2981L2.64124 21.3588C3.38961 22.1071 4.33855 22.4392 5.51098 22.5969C6.66182 22.7516 8.13558 22.75 10 22.75V21.25ZM1.25 14C1.25 15.8644 1.24841 17.3382 1.40313 18.489C1.56076 19.6614 1.89288 20.6104 2.64124 21.3588L3.7019 20.2981C3.27869 19.8749 3.02502 19.2952 2.88976 18.2892C2.75159 17.2615 2.75 15.9068 2.75 14H1.25ZM14 22.75C15.8644 22.75 17.3382 22.7516 18.489 22.5969C19.6614 22.4392 20.6104 22.1071 21.3588 21.3588L20.2981 20.2981C19.8749 20.7213 19.2952 20.975 18.2892 21.1102C17.2615 21.2484 15.9068 21.25 14 21.25V22.75ZM21.25 14C21.25 15.9068 21.2484 17.2615 21.1102 18.2892C20.975 19.2952 20.7213 19.8749 20.2981 20.2981L21.3588 21.3588C22.1071 20.6104 22.4392 19.6614 22.5969 18.489C22.7516 17.3382 22.75 15.8644 22.75 14H21.25ZM2.75 10C2.75 8.09318 2.75159 6.73851 2.88976 5.71085C3.02502 4.70476 3.27869 4.12511 3.7019 3.7019L2.64124 2.64124C1.89288 3.38961 1.56076 4.33855 1.40313 5.51098C1.24841 6.66182 1.25 8.13558 1.25 10H2.75ZM10.0298 1.25C8.15538 1.25 6.67442 1.24842 5.51887 1.40307C4.34232 1.56054 3.39019 1.8923 2.64124 2.64124L3.7019 3.7019C4.12453 3.27928 4.70596 3.02525 5.71785 2.88982C6.75075 2.75158 8.11311 2.75 10.0298 2.75V1.25Z"
									fill="currentColor" />
								<path opacity="0.5" d="M13 2.5V5C13 7.35702 13 8.53553 13.7322 9.26777C14.4645 10 15.643 10 18 10H22"
									stroke="currentColor" stroke-width="1.5" />
							</svg>
							CSV
						</button>
						<button type="button" class="btn btn-primary btn-sm" onclick="exportDetailTable('json')">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
								class="inline mr-1">
								<path
									d="M15.3929 4.05365L14.8912 4.61112L15.3929 4.05365ZM19.3517 7.61654L18.85 8.17402L19.3517 7.61654ZM21.654 10.1541L20.9689 10.4592V10.4592L21.654 10.1541ZM3.17157 20.8284L3.7019 20.2981H3.7019L3.17157 20.8284ZM20.8284 20.8284L20.2981 20.2981L20.2981 20.2981L20.8284 20.8284ZM14 21.25H10V22.75H14V21.25ZM2.75 14V10H1.25V14H2.75ZM21.25 13.5629V14H22.75V13.5629H21.25ZM14.8912 4.61112L18.85 8.17402L19.8534 7.05907L15.8947 3.49618L14.8912 4.61112ZM22.75 13.5629C22.75 11.8745 22.7651 10.8055 22.3391 9.84897L20.9689 10.4592C21.2349 11.0565 21.25 11.742 21.25 13.5629H22.75ZM18.85 8.17402C20.2034 9.3921 20.7029 9.86199 20.9689 10.4592L22.3391 9.84897C21.9131 8.89241 21.1084 8.18853 19.8534 7.05907L18.85 8.17402ZM10.0298 2.75C11.6116 2.75 12.2085 2.76158 12.7405 2.96573L13.2779 1.5653C12.4261 1.23842 11.498 1.25 10.0298 1.25V2.75ZM15.8947 3.49618C14.8087 2.51878 14.1297 1.89214 13.2779 1.5653L12.7405 2.96573C13.2727 3.16993 13.7215 3.55836 14.8912 4.61112L15.8947 3.49618ZM10 21.25C8.09318 21.25 6.73851 21.2484 5.71085 21.1102C4.70476 20.975 4.12511 20.7213 3.7019 20.2981L2.64124 21.3588C3.38961 22.1071 4.33855 22.4392 5.51098 22.5969C6.66182 22.7516 8.13558 22.75 10 22.75V21.25ZM1.25 14C1.25 15.8644 1.24841 17.3382 1.40313 18.489C1.56076 19.6614 1.89288 20.6104 2.64124 21.3588L3.7019 20.2981C3.27869 19.8749 3.02502 19.2952 2.88976 18.2892C2.75159 17.2615 2.75 15.9068 2.75 14H1.25ZM14 22.75C15.8644 22.75 17.3382 22.7516 18.489 22.5969C19.6614 22.4392 20.6104 22.1071 21.3588 21.3588L20.2981 20.2981C19.8749 20.7213 19.2952 20.975 18.2892 21.1102C17.2615 21.2484 15.9068 21.25 14 21.25V22.75ZM21.25 14C21.25 15.9068 21.2484 17.2615 21.1102 18.2892C20.975 19.2952 20.7213 19.8749 20.2981 20.2981L21.3588 21.3588C22.1071 20.6104 22.4392 19.6614 22.5969 18.489C22.7516 17.3382 22.75 15.8644 22.75 14H21.25ZM2.75 10C2.75 8.09318 2.75159 6.73851 2.88976 5.71085C3.02502 4.70476 3.27869 4.12511 3.7019 3.7019L2.64124 2.64124C1.89288 3.38961 1.56076 4.33855 1.40313 5.51098C1.24841 6.66182 1.25 8.13558 1.25 10H2.75ZM10.0298 1.25C8.15538 1.25 6.67442 1.24842 5.51887 1.40307C4.34232 1.56054 3.39019 1.8923 2.64124 2.64124L3.7019 3.7019C4.12453 3.27928 4.70596 3.02525 5.71785 2.88982C6.75075 2.75158 8.11311 2.75 10.0298 2.75V1.25Z"
									fill="currentColor" />
								<path opacity="0.5" d="M13 2.5V5C13 7.35702 13 8.53553 13.7322 9.26777C14.4645 10 15.643 10 18 10H22"
									stroke="currentColor" stroke-width="1.5" />
								<path opacity="0.5" d="M7 14L6 15L7 16M11.5 16L12.5 17L11.5 18M10 14L8.5 18" stroke="currentColor"
									stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
							</svg>
							JSON
						</button>
						<button type="button" class="btn btn-primary btn-sm" onclick="printDetailTable()">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
								class="inline mr-1">
								<path
									d="M6 17.9827C4.44655 17.9359 3.51998 17.7626 2.87868 17.1213C2 16.2426 2 14.8284 2 12C2 9.17157 2 7.75736 2.87868 6.87868C3.75736 6 5.17157 6 8 6H16C18.8284 6 20.2426 6 21.1213 6.87868C22 7.75736 22 9.17157 22 12C22 14.8284 22 16.2426 21.1213 17.1213C20.48 17.7626 19.5535 17.9359 18 17.9827"
									stroke="currentColor" stroke-width="1.5" />
								<path opacity="0.5" d="M9 10H6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
								<path d="M19 14L5 14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
								<path
									d="M18 14V16C18 18.8284 18 20.2426 17.1213 21.1213C16.2426 22 14.8284 22 12 22C9.17157 22 7.75736 22 6.87868 21.1213C6 20.2426 6 18.8284 6 16V14"
									stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
								<path opacity="0.5"
									d="M17.9827 6C17.9359 4.44655 17.7626 3.51998 17.1213 2.87868C16.2427 2 14.8284 2 12 2C9.17158 2 7.75737 2 6.87869 2.87868C6.23739 3.51998 6.06414 4.44655 6.01733 6"
									stroke="currentColor" stroke-width="1.5" />
								<circle opacity="0.5" cx="17" cy="10" r="1" fill="currentColor" />
								<path opacity="0.5" d="M15 16.5H9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
								<path opacity="0.5" d="M13 19H9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
							</svg>
							PRINT
						</button>
					</div>
					<button type="button" class="btn btn-secondary" onclick="closeDetailModal()">Close</button>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
	<script src="/assets/js/simple-datatables.js"></script>
	<script>
		let currentStartDate = '';
		let currentEndDate = '';
		let detailDatatable = null;

		const columnStatusMap = {
			1: 'idle_order',
			2: 'planning_need_approve_mtel',
			3: 'planning_reject_ta',
			4: 'planning_need_approve_ta',
			5: 'age_under1d',
			6: 'age_1d_to_3d',
			7: 'age_3d_to_7d',
			8: 'age_upper7d',
			9: 'permanenisasi_need_approve_ta',
			10: 'permanenisasi_reject_ta',
			11: 'permanenisasi_need_approve_mtel'
		};

		function renderMonitoringTable(data) {
			const tbody = document.getElementById('monitoring-tbody');
			tbody.innerHTML = '';
			if (!data || data.length === 0) {
				tbody.innerHTML = '<tr><td colspan="14">Tidak ada data</td></tr>';
				return;
			}

			let colTotals = Array(13).fill(0);
			data.forEach(row => {
				const cells = [
					row.witel_name || '-',
					row.idle_order || 0,
					row.planning_need_approve_mtel || 0,
					row.planning_reject_ta || 0,
					row.planning_need_approve_ta || 0,
					row.age_under1d || 0,
					row.age_1d_to_3d || 0,
					row.age_3d_to_7d || 0,
					row.age_upper7d || 0,
					row.permanenisasi_need_approve_ta || 0,
					row.permanenisasi_reject_ta || 0,
					row.permanenisasi_need_approve_mtel || 0,
					row.permanenisasi_rekon || 0
				];
				const total = cells.slice(1).reduce((a, b) => a + Number(b), 0);
				let html = '<tr>';
				cells.forEach((c, i) => {
					if (i === 0) {
						html += `<td>${c}</td>`;
					} else {
						html +=
							`<td data-col="${i}" data-witel="${row.witel_name}" data-witel-id="${row.witel_id}" data-regional-id="${row.regional_id}" onclick="showDetailModal(this)">${c}</td>`;
					}
					if (i > 0) colTotals[i] += Number(c);
				});
				html += `<td class="font-bold">${total}</td></tr>`;
				tbody.innerHTML += html;
			});
			let totalRow = '<tr class="font-bold"><td>TOTAL</td>';
			for (let i = 1; i < colTotals.length; i++) {
				totalRow += `<td>${colTotals[i]}</td>`;
			}
			totalRow += `<td>${colTotals.slice(1).reduce((a, b) => a + b, 0)}</td></tr>`;
			tbody.innerHTML += totalRow;
		}

		function showDetailModal(element) {
			const colIndex = parseInt(element.getAttribute('data-col'));
			const witel = element.getAttribute('data-witel');
			const witelId = element.getAttribute('data-witel-id');
			const regionalId = element.getAttribute('data-regional-id');
			const value = element.innerText;

			if (value === '0' || value === '-') return;

			const status = columnStatusMap[colIndex];
			const modal = document.getElementById('detailModal');
			const modalBody = document.getElementById('detailModalBody');
			const modalTitle = document.getElementById('detailModalTitle');
			const exportButtons = document.getElementById('exportButtons');

			const table = document.getElementById('monitoring-table');
			const headers = Array.from(table.querySelectorAll('thead th'));
			const columnHeader = headers[colIndex]?.innerText || 'Unknown';

			modalTitle.innerText = `Detail - ${witel} (${columnHeader})`;
			modalBody.innerHTML =
				'<div class="text-center"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...</div>';
			exportButtons.style.display = 'none';
			modal.style.display = 'flex';

			if (detailDatatable) {
				detailDatatable.destroy();
				detailDatatable = null;
			}

			const params = new URLSearchParams({
				regional_id: regionalId,
				witel_id: witelId,
				start_date: currentStartDate,
				end_date: currentEndDate,
				status: status
			});

			fetch(`/ajax/dashboard/monitoring/detail?${params.toString()}`)
				.then(res => res.json())
				.then(data => {
					renderDetailTable(data, witel, columnHeader);
				})
				.catch(err => {
					modalBody.innerHTML = '<div class="alert alert-danger">Gagal memuat data</div>';
				});
		}

		function renderDetailTable(data, witel, columnHeader) {
			const modalBody = document.getElementById('detailModalBody');
			const exportButtons = document.getElementById('exportButtons');

			if (!data || data.length === 0) {
				modalBody.innerHTML = '<div class="alert alert-info">Tidak ada data untuk ditampilkan</div>';
				exportButtons.style.display = 'none';
				return;
			}

			modalBody.innerHTML = '<table id="detailTable" class="whitespace-nowrap"></table>';

			const tableData = data.map((row, index) => [
				index + 1,
				row.tiket_start_time || '-',
				row.tt_site || '-',
				row.site_down || '-',
				row.site_name_down || '-',
				row.latitude_site_down || '-',
				row.longitude_site_down || '-',
				row.site_detect || '-',
				row.site_name_detect || '-',
				row.tiket_terima || '-'
			]);

			detailDatatable = new simpleDatatables.DataTable('#detailTable', {
				data: {
					headings: ['No', 'Start Time', 'TT Site', 'Site Down', 'Site Name Down', 'Latitude Down',
						'Longitude Down', 'Site Detect', 'Site Name Detect', 'Tiket Terima'
					],
					data: tableData
				},
				perPage: 10,
				perPageSelect: [10, 20, 30, 50, 100],
				searchable: true,
				sortable: true,
				fixedHeight: false,
				firstLast: true,
				firstText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M13 19L7 12L13 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path opacity="0.5" d="M16.9998 19L10.9998 12L16.9998 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
				lastText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M11 19L17 12L11 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path opacity="0.5" d="M6.99976 19L12.9998 12L6.99976 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
				prevText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M15 5L9 12L15 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
				nextText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
				labels: {
					perPage: '{select}',
				},
				layout: {
					top: '{search}',
					bottom: '{info}{select}{pager}',
				},
			});

			exportButtons.style.display = 'flex';
		}

		function exportDetailTable(type) {
			if (!detailDatatable) return;

			const data = {
				type: type,
				filename: 'detail-monitoring',
				download: true,
			};

			if (type === 'csv') {
				data.lineDelimiter = '\n';
				data.columnDelimiter = ';';
			}

			detailDatatable.export(data);
		}

		function printDetailTable() {
			if (!detailDatatable) return;
			detailDatatable.print();
		}

		function closeDetailModal() {
			const modal = document.getElementById('detailModal');
			modal.style.display = 'none';
			if (detailDatatable) {
				detailDatatable.destroy();
				detailDatatable = null;
			}
		}

		window.onclick = function(event) {
			const modal = document.getElementById('detailModal');
			if (event.target === modal) {
				closeDetailModal();
			}
		}

		function fetchMonitoringData(startDate, endDate) {
			currentStartDate = startDate;
			currentEndDate = endDate;

			const params = new URLSearchParams({
				regional_id: 'ALL',
				witel_id: 'ALL',
				start_date: startDate,
				end_date: endDate
			});
			const url = `/ajax/dashboard/monitoring?${params.toString()}`;
			const tbody = document.getElementById('monitoring-tbody');
			tbody.innerHTML = '<tr><td colspan="14">Loading...</td></tr>';
			fetch(url)
				.then(res => res.json())
				.then(data => renderMonitoringTable(data))
				.catch(() => {
					tbody.innerHTML = '<tr><td colspan="14">Gagal memuat data</td></tr>';
				});
		}

		document.addEventListener('DOMContentLoaded', function() {
			flatpickr("#date-range", {
				mode: "range",
				dateFormat: "Y-m-d",
				allowInput: true,
				locale: {
					firstDayOfWeek: 1
				},
				onClose: function(selectedDates, dateStr, instance) {
					if (selectedDates.length === 2) {
						const start = instance.formatDate(selectedDates[0], 'Y-m-d');
						const end = instance.formatDate(selectedDates[1], 'Y-m-d');
						fetchMonitoringData(start, end);
					}
				}
			});
			const today = new Date();
			const yyyy = today.getFullYear();
			const mm = String(today.getMonth() + 1).padStart(2, '0');
			const dd = String(today.getDate()).padStart(2, '0');
			const firstDayOfMonth = `${yyyy}-${mm}-01`;
			const todayStr = `${yyyy}-${mm}-${dd}`;
			fetchMonitoringData(firstDayOfMonth, todayStr);
		});
	</script>
@endsection
