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
						<th colspan="3">PLANNING</th>
						<th rowspan="2" colspan="4">PROGRESS</th>
						<th colspan="2">PERMANENISASI</th>
						<th rowspan="3">REKON</th>
						<th rowspan="3">TOTAL</th>
					</tr>
					<tr>
						<th colspan="2">TA</th>
						<th colspan="1">MTEL</th>
						<th colspan="1">TA</th>
						<th colspan="1">MTEL</th>
					</tr>
					<tr>
						<th>INDIKASI</th>
						<th>REJECT</th>
						<th>NEED APPROVE</th>
						<th>&lt;1 HARI</th>
						<th>&gt; 1 HARI</th>
						<th>&gt; 3 HARI</th>
						<th>&gt; 7 HARI</th>
						<th>REJECT</th>
						<th>NEED APPROVE</th>
					</tr>
				</thead>
				<tbody id="monitoring-tbody">
					<tr>
						<td colspan="12">Loading...</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
@endsection

@section('scripts')
	<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
	<script src="/assets/js/simple-datatables.js"></script>
	<script>
		let currentStartDate = '';
		let currentEndDate = '';

		const columnStatusMap = {
			1: 'idle_order',
			2: 'planning_reject_ta',
			3: 'planning_need_approve_mtel',
			4: 'age_under1d',
			5: 'age_1d_to_3d',
			6: 'age_3d_to_7d',
			7: 'age_upper7d',
			8: 'permanenisasi_reject_ta',
			9: 'permanenisasi_need_approve_mtel',
			10: 'permanenisasi_rekon'
		};

		function renderMonitoringTable(data) {
			const tbody = document.getElementById('monitoring-tbody');
			tbody.innerHTML = '';
			if (!data || data.length === 0) {
				tbody.innerHTML = '<tr><td colspan="14">Tidak ada data</td></tr>';
				return;
			}

			let colTotals = Array(11).fill(0);
			data.forEach(row => {
				const cells = [
					row.witel_name || '-',
					row.idle_order || 0,
					row.planning_reject_ta || 0,
					row.planning_need_approve_mtel || 0,
					row.age_under1d || 0,
					row.age_1d_to_3d || 0,
					row.age_3d_to_7d || 0,
					row.age_upper7d || 0,
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
							`<td data-col="${i}" data-witel="${row.witel_name}" data-witel-id="${row.witel_id}" data-regional-id="${row.regional_id}" onclick="navigateToDetail(this)">${c}</td>`;
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

		function navigateToDetail(element) {
			const colIndex = parseInt(element.getAttribute('data-col'));
			const witel = element.getAttribute('data-witel');
			const witelId = element.getAttribute('data-witel-id');
			const regionalId = element.getAttribute('data-regional-id');
			const value = element.innerText;

			if (value === '0' || value === '-') return;

			const status = columnStatusMap[colIndex];
			const table = document.getElementById('monitoring-table');
			const headers = Array.from(table.querySelectorAll('thead th'));
			const columnHeader = headers[colIndex]?.innerText || 'Unknown';

			const params = new URLSearchParams({
				regional_id: regionalId,
				witel_id: witelId,
				start_date: currentStartDate,
				end_date: currentEndDate,
				status: status,
				witel: witel,
				column_header: columnHeader
			});

			window.location.href = `/dashboard/monitoring-detail?${params.toString()}`;
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
			tbody.innerHTML = '<tr><td colspan="12">Loading...</td></tr>';
			fetch(url)
				.then(res => res.json())
				.then(data => renderMonitoringTable(data))
				.catch(() => {
					tbody.innerHTML = '<tr><td colspan="12">Gagal memuat data</td></tr>';
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
