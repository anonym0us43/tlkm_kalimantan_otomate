@extends('layouts')

@section('styles')
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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
		}

		.back-link:hover {
			color: #3451d4;
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
					</tr>
				</thead>
				<tbody id="detail-tbody">
					<tr>
						<td colspan="10" class="text-center">Loading...</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
@endsection

@section('scripts')
	<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
	<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
	<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
	<script>
		let detailDatatable = null;

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
				tbody.innerHTML = '<tr><td colspan="10" class="text-center">Tidak ada data untuk ditampilkan</td></tr>';
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
					tbody.innerHTML = '<tr><td colspan="10" class="text-center text-red-500">Gagal memuat data</td></tr>';
					console.error(err);
				});
		}

		document.addEventListener('DOMContentLoaded', function() {
			fetchDetailData();
		});
	</script>
@endsection
