@extends('layouts')

@section('styles')
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
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

		@if (session('success'))
			<script>
				document.addEventListener('DOMContentLoaded', function() {
					showSuccessMessage('{{ session('success') }}');
				});
			</script>
		@endif

		@if (session('error'))
			<script>
				document.addEventListener('DOMContentLoaded', function() {
					showErrorMessage('{{ session('error') }}');
				});
			</script>
		@endif

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
						<th>Action</th>
					</tr>
				</thead>
				<tbody id="detail-tbody">
					<tr>
						<td colspan="11" class="text-center">Loading...</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
@endsection

@section('scripts')
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
                    <a href="/order/${row.row_id}" class="inline-flex items-center justify-center w-8 h-8 text-primary hover:text-primary-dark transition-colors">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.5" d="M22 10.5V12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2H13.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                            <path d="M17.3009 2.80624L16.652 3.45506L10.6872 9.41993C10.2832 9.82394 10.0812 10.0259 9.90743 10.2487C9.70249 10.5114 9.52679 10.7957 9.38344 11.0965C9.26191 11.3515 9.17157 11.6225 8.99089 12.1646L8.41242 13.9L8.03811 15.0229C7.9492 15.2897 8.01862 15.5837 8.21744 15.7826C8.41626 15.9814 8.71035 16.0508 8.97709 15.9619L10.1 15.5876L11.8354 15.0091C12.3775 14.8284 12.6485 14.7381 12.9035 14.6166C13.2043 14.4732 13.4886 14.2975 13.7513 14.0926C13.9741 13.9188 14.1761 13.7168 14.5801 13.3128L20.5449 7.34795L21.1938 6.69914C22.2687 5.62415 22.2687 3.88124 21.1938 2.80624C20.1188 1.73125 18.3759 1.73125 17.3009 2.80624Z" stroke="currentColor" stroke-width="1.5"></path>
                            <path opacity="0.5" d="M16.6522 3.45508C16.6522 3.45508 16.7333 4.83381 17.9499 6.05034C19.1664 7.26687 20.5451 7.34797 20.5451 7.34797M10.1002 15.5876L8.4126 13.9" stroke="currentColor" stroke-width="1.5"></path>
                        </svg>
                    </a>
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

		document.addEventListener('DOMContentLoaded', function() {
			fetchDetailData();
		});
	</script>
@endsection
