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
						<th rowspan="2">WITEL</th>
						<th rowspan="2">IDLE<br />ORDER</th>
						<th colspan="5">TEMPORER</th>
						<th colspan="3">PERMANENISASI</th>
						<th rowspan="3">REKON</th>
						<th rowspan="3">TOTAL</th>
					</tr>
					<tr>
						<th>&lt; 3 D</th>
						<th>&lt; 7 D</th>
						<th>&lt; 14 D</th>
						<th>&lt; 30 D</th>
						<th>&gt; 30 D</th>
						<th>NOT VALID</th>
						<th>VALID</th>
						<th>DONE</th>
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
	<script>
		function renderMonitoringTable(data) {
			const tbody = document.getElementById('monitoring-tbody');
			tbody.innerHTML = '';
			if (!data || data.length === 0) {
				tbody.innerHTML = '<tr><td colspan="12">Tidak ada data</td></tr>';
				return;
			}

			let colTotals = Array(11).fill(0); // 11 columns to sum
			data.forEach(row => {
				// Map data fields to columns
				// Adjust field names as per your API result
				const cells = [
					row.witel_name || '-',
					row.idle_order || 0,
					row.under3d_order || 0,
					row.under7d_order || 0,
					row.under14d_order || 0,
					row.under30d_order || 0,
					row.upper30d_order || 0,
					row.reject_ta || 0,
					row.approval_ta || 0,
					row.done_mtel || 0,
					row.reconcile_mtel || 0
				];
				// Calculate total for this row
				const total = cells.slice(1).reduce((a, b) => a + Number(b), 0);
				let html = '<tr>';
				cells.forEach((c, i) => {
					html += `<td>${c}</td>`;
					if (i > 0) colTotals[i] += Number(c);
				});
				html += `<td class="font-bold">${total}</td></tr>`;
				tbody.innerHTML += html;
			});
			// Render total row
			let totalRow = '<tr class="font-bold"><td>TOTAL</td>';
			for (let i = 1; i < colTotals.length; i++) {
				totalRow += `<td>${colTotals[i]}</td>`;
			}
			totalRow += `<td>${colTotals.slice(1).reduce((a, b) => a + b, 0)}</td></tr>`;
			tbody.innerHTML += totalRow;
		}

		function fetchMonitoringData(startDate, endDate) {
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
			// Load today by default
			const today = new Date();
			const yyyy = today.getFullYear();
			const mm = String(today.getMonth() + 1).padStart(2, '0');
			const dd = String(today.getDate()).padStart(2, '0');
			const todayStr = `${yyyy}-${mm}-${dd}`;
			fetchMonitoringData(todayStr, todayStr);
		});
	</script>
@endsection
