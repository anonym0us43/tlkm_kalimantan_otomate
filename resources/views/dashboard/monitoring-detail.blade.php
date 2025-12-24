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

		.doc-modal {
			position: fixed;
			inset: 0;
			display: none;
			align-items: center;
			justify-content: center;
			background: rgba(17, 24, 39, 0.35);
			z-index: 50;
			padding: 16px;
		}

		.doc-modal.show {
			display: flex;
		}

		.doc-modal-card {
			background: #ffffff;
			border-radius: 12px;
			padding: 20px;
			width: 100%;
			max-width: 420px;
			box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
		}

		.doc-modal-header {
			display: flex;
			align-items: center;
			justify-content: space-between;
			margin-bottom: 12px;
		}

		.doc-modal-title {
			font-weight: 600;
			font-size: 16px;
			margin: 0;
			color: #111827;
		}

		.doc-modal-close {
			border: none;
			background: none;
			font-size: 20px;
			cursor: pointer;
			color: #6b7280;
		}

		.doc-list {
			display: grid;
			gap: 10px;
			margin: 0;
			padding: 0;
			list-style: none;
		}

		.doc-item a {
			display: flex;
			align-items: center;
			justify-content: space-between;
			padding: 12px 14px;
			border: 1px solid #e5e7eb;
			border-radius: 10px;
			color: #111827;
			text-decoration: none;
			transition: all 0.15s ease;
			font-weight: 500;
		}

		.doc-item a:hover {
			border-color: #4f46e5;
			color: #312e81;
			box-shadow: 0 6px 16px rgba(79, 70, 229, 0.12);
		}

		.doc-item small {
			color: #6b7280;
			font-weight: 400;
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
						<th>#</th>
						<th>Created At</th>
						<th>TT Site</th>
						<th>Site Down</th>
						<th>Site Name Down</th>
						<th>Latitude Site Down</th>
						<th>Longitude Site Down</th>
						<th>Site Detect</th>
						<th>Site Name Detect</th>
						<th>Tiket Terima</th>
						<th>Technician</th>
						<th></th>
					</tr>
				</thead>
				<tbody id="detail-tbody">
					<tr>
						<td colspan="12" class="text-center">Loading...</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<div class="doc-modal" id="documentModal" aria-hidden="true">
		<div class="doc-modal-card">
			<div class="doc-modal-header">
				<h6 class="doc-modal-title">Dokumen</h6>
				<button type="button" class="doc-modal-close" id="documentModalClose" aria-label="Tutup">&times;</button>
			</div>
			<ul class="doc-list" id="documentList"></ul>
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
		let documentModal = null;
		let documentList = null;
		let documentModalClose = null;

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
				tbody.innerHTML = '<tr><td colspan="12" class="text-center">Tidak ada data untuk ditampilkan</td></tr>';
				return;
			}

			if (detailDatatable) {
				detailDatatable.destroy();
			}

			tbody.innerHTML = '';
			data.forEach((row, index) => {
				const tr = document.createElement('tr');
				const hasDocs = Boolean(row.no_spk) || Boolean(row.no_ba_recovery);
				const documentBtn = hasDocs ? `
					<button type="button" class="document-modal-trigger inline-flex items-center justify-center w-9 h-9 rounded-md text-primary hover:text-primary-dark transition-colors"
						data-ticket-id="${row.ticket_alita_id}" data-no-spk="${row.no_spk || ''}" data-no-ba-recovery="${row.no_ba_recovery || ''}">
							<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path opacity="0.5" d="M3 10C3 6.22876 3 4.34315 4.17157 3.17157C5.34315 2 7.22876 2 11 2H13C16.7712 2 18.6569 2 19.8284 3.17157C21 4.34315 21 6.22876 21 10V14C21 17.7712 21 19.6569 19.8284 20.8284C18.6569 22 16.7712 22 13 22H11C7.22876 22 5.34315 22 4.17157 20.8284C3 19.6569 3 17.7712 3 14V10Z" stroke="#1C274C" stroke-width="1.5"/>
								<path d="M8 10H16" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"/>
								<path d="M8 14H13" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"/>
							</svg>
						</button>
				` : '';

				tr.innerHTML = `
					<td>${index + 1}</td>
					<td>${row.created_at || '-'}</td>
					<td>${row.tt_site || '-'}</td>
					<td>${row.site_down || '-'}</td>
					<td>${row.site_name_down || '-'}</td>
					<td>${row.latitude_site_down || '-'}</td>
					<td>${row.longitude_site_down || '-'}</td>
					<td>${row.site_detect || '-'}</td>
					<td>${row.site_name_detect || '-'}</td>
					<td>${row.tiket_terima || '-'}</td>
					<td>${(row.tacc_nama || row.tacc_nik) ? `${row.tacc_nama || '-'}` + ' (' + `${row.tacc_nik || '-'}` + ')' : '-'}</td>
					<td class="p-3 border-b border-[#ebedf2] dark:border-[#191e3a] text-center">
						<div class="flex items-center justify-center gap-2">
							<a href="/order/${row.ticket_alita_id}" x-tooltip="Edit"
								class="inline-flex items-center justify-center w-9 h-9 rounded-md text-primary hover:text-primary-dark transition-colors">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M18.18 8.03933L18.6435 7.57589C19.4113 6.80804 20.6563 6.80804 21.4241 7.57589C22.192 8.34374 22.192 9.58868 21.4241 10.3565L20.9607 10.82M18.18 8.03933C18.18 8.03933 18.238 9.02414 19.1069 9.89309C19.9759 10.762 20.9607 10.82 20.9607 10.82M18.18 8.03933L13.9194 12.2999C13.6308 12.5885 13.4865 12.7328 13.3624 12.8919C13.2161 13.0796 13.0906 13.2827 12.9882 13.4975C12.9014 13.6797 12.8368 13.8732 12.7078 14.2604L12.2946 15.5L12.1609 15.901M20.9607 10.82L16.7001 15.0806C16.4115 15.3692 16.2672 15.5135 16.1081 15.6376C15.9204 15.7839 15.7173 15.9094 15.5025 16.0118C15.3203 16.0986 15.1268 16.1632 14.7396 16.2922L13.5 16.7054L13.099 16.8391M13.099 16.8391L12.6979 16.9728C12.5074 17.0363 12.2973 16.9867 12.1553 16.8447C12.0133 16.7027 11.9637 16.4926 12.0272 16.3021L12.1609 15.901M13.099 16.8391L12.1609 15.901" stroke="#1C274C" stroke-width="1.5"/>
                                    <path d="M8 13H10.5" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"/>
                                    <path d="M8 9H14.5" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"/>
                                    <path d="M8 17H9.5" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"/>
                                    <path opacity="0.5" d="M3 10C3 6.22876 3 4.34315 4.17157 3.17157C5.34315 2 7.22876 2 11 2H13C16.7712 2 18.6569 2 19.8284 3.17157C21 4.34315 21 6.22876 21 10V14C21 17.7712 21 19.6569 19.8284 20.8284C18.6569 22 16.7712 22 13 22H11C7.22876 22 5.34315 22 4.17157 20.8284C3 19.6569 3 17.7712 3 14V10Z" stroke="#1C274C" stroke-width="1.5"/>
                                </svg>
							</a>
							${documentBtn}
						</div>
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

		function buildDocumentItem(label, href, subtitle) {
			return `
				<li class="doc-item">
					<a href="${href}">
						<span>${label}</span>
						<small>${subtitle}</small>
					</a>
				</li>
			`;
		}

		function openDocumentModal({
			ticketId,
			noSpk,
			noBaRecovery
		}) {
			if (!documentModal || !documentList) return;

			documentList.innerHTML = '';

			if (noSpk) {
				documentList.innerHTML += buildDocumentItem('Surat Perintah Kerja (SPK)', `/document/generate-spk/${ticketId}`,
					noSpk);
			}

			if (noBaRecovery) {
				documentList.innerHTML += buildDocumentItem('Berita Acara Recovery',
					`/document/generate-ba-recovery/${ticketId}`, noBaRecovery);
			}

			if (!documentList.innerHTML) {
				documentList.innerHTML =
					'<li class="doc-item"><a href="#" onclick="return false;">Dokumen belum tersedia</a></li>';
			}

			documentModal.classList.add('show');
			documentModal.setAttribute('aria-hidden', 'false');
		}

		function closeDocumentModal() {
			if (!documentModal) return;
			documentModal.classList.remove('show');
			documentModal.setAttribute('aria-hidden', 'true');
		}

		function fetchDetailData() {
			const urlParams = getUrlParams();

			const pageTitle = document.getElementById('pageTitle');
			if (urlParams.witel && urlParams.column_header) {
				pageTitle.innerText =
					`${urlParams.witel.charAt(0).toUpperCase() + urlParams.witel.slice(1).toLowerCase()} • ${urlParams.column_header}`;
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
					tbody.innerHTML = '<tr><td colspan="12" class="text-center text-red-500">Gagal memuat data</td></tr>';
					console.error(err);
				});
		}

		document.addEventListener('DOMContentLoaded', function() {
			documentModal = document.getElementById('documentModal');
			documentList = document.getElementById('documentList');
			documentModalClose = document.getElementById('documentModalClose');

			const tbody = document.getElementById('detail-tbody');
			tbody.addEventListener('click', function(event) {
				const trigger = event.target.closest('.document-modal-trigger');
				if (!trigger) return;

				openDocumentModal({
					ticketId: trigger.dataset.ticketId,
					noSpk: trigger.dataset.noSpk,
					noBaRecovery: trigger.dataset.noBaRecovery
				});
			});

			documentModalClose.addEventListener('click', closeDocumentModal);
			documentModal.addEventListener('click', function(event) {
				if (event.target === documentModal) {
					closeDocumentModal();
				}
			});

			fetchDetailData();
		});
	</script>
@endsection
