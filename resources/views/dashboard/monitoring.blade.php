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
			background-color: #f9fafb;
			border-radius: 6px;
			padding: 10px 12px;
		}

		.dark .date-filter-panel {
			background-color: #1b2e4b;
		}

		.date-filter-panel .form-label {
			display: block;
			font-weight: 500;
			margin-bottom: 3px;
			font-size: 12px;
			color: #666;
		}

		.dark .date-filter-panel .form-label {
			color: #a3b5d6;
		}

		.date-filter-panel .form-input {
			width: 100%;
			padding: 6px 10px;
			border: 1px solid #ddd;
			border-radius: 4px;
			font-size: 13px;
		}

		.dark .date-filter-panel .form-input {
			background-color: #0e1726;
			border-color: #17263c;
			color: #fff;
		}

		.date-input-wrapper {
			position: relative;
		}
	</style>
@endsection

@section('title', 'Dashboard Monitoring')

@section('content')
	<div class="panel mt-4 py-3 px-4">
		<div class="date-filter-panel grid grid-cols-1 lg:grid-cols-3 gap-2 lg:gap-3 px-0 py-0">
			<div class="date-input-wrapper">
				<label for="start-date" class="form-label">Tanggal Mulai</label>
				<input type="text" id="start-date" class="form-input" placeholder="YYYY-MM-DD" readonly>
			</div>

			<div class="hidden lg:flex items-end justify-center pb-1 text-gray-400">
				<span class="text-sm">→</span>
			</div>

			<div class="date-input-wrapper">
				<label for="end-date" class="form-label">Tanggal Selesai</label>
				<input type="text" id="end-date" class="form-input" placeholder="YYYY-MM-DD" readonly>
			</div>
		</div>
	</div>

	<div class="panel mt-6">
		<h5 class="text-lg font-semibold dark:text-white-light mb-4">Dashboard Monitoring</h5>
		<div class="table-responsive">
			<table class="table table-bordered table-hover detail-table mt-4" id="monitoring-table">
				<thead>
					<tr>
						<th rowspan="3">WITEL</th>
						<th colspan="3">PLANNING</th>
						<th rowspan="3">PROGRESS</th>
						<th colspan="2">PERMANENISASI</th>
						<th rowspan="3">REKON</th>
						<th rowspan="3">ACH %</th>
						<th rowspan="3">TOTAL</th>
					</tr>
					<tr>
						<th colspan="2">TA</th>
						<th colspan="1">MTEL</th>
						<th colspan="2">MTEL</th>
					</tr>
					<tr>
						<th>INDIKASI</th>
						<th>REJECT</th>
						<th>NEED<br>APPROVE</th>
						<th>REJECT</th>
						<th>NEED<br>APPROVE</th>
					</tr>
				</thead>
				<tbody id="monitoring-tbody">
					<tr>
						<td colspan="10">Loading...</td>
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
			4: 'planning_approve_mtel',
			5: 'permanenisasi_reject_ta',
			6: 'permanenisasi_need_approve_mtel',
			7: 'permanenisasi_rekon'
		};

		const columnHeaderMap = {
			1: 'Planning - TA - Indikasi',
			2: 'Planning - TA - Reject',
			3: 'Planning - MTEL - Need Approve',
			4: 'Planning - MTEL - Approve',
			5: 'Permanenisasi - MTEL - Reject',
			6: 'Permanenisasi - MTEL - Need Approve',
			7: 'Rekon'
		};

		function renderMonitoringTable(data) {
			const tbody = document.getElementById('monitoring-tbody');
			tbody.innerHTML = '';
			if (!data || data.length === 0) {
				tbody.innerHTML = '<tr><td colspan="13">Tidak ada data</td></tr>';
				return;
			}

			const achIndex = 8;
			let colTotals = Array(9).fill(0);
			let totalRekonSum = 0;
			let totalWithoutRekonSum = 0;
			let totalAdjustedSum = 0;
			let totalIdleSum = 0;

			data.forEach(row => {
				const cells = [
					row.witel_name || '-',
					row.idle_order || 0,
					row.planning_reject_ta || 0,
					row.planning_need_approve_mtel || 0,
					row.planning_approve_mtel || 0,
					row.permanenisasi_reject_ta || 0,
					row.permanenisasi_need_approve_mtel || 0,
					row.permanenisasi_rekon || 0
				];
				const totalWithoutRekon = cells.slice(1, 8).reduce((a, b) => a + Number(b), 0);
				const idleVal = Number(cells[1]) || 0;
				const rekonVal = Number(cells[8]) || 0;
				const totalAdjusted = totalWithoutRekon + rekonVal;
				const numerator = totalAdjusted - idleVal;
				const achVal = totalAdjusted > 0 ? (numerator / totalAdjusted) * 100 : 0;

				totalWithoutRekonSum += totalWithoutRekon;
				totalRekonSum += rekonVal;
				totalAdjustedSum += totalAdjusted;
				totalIdleSum += idleVal;

				let html = '<tr>';
				cells.forEach((c, i) => {
					if (i === 0) {
						html += `<td>${c}</td>`;
					} else {
						const clickable = i !== achIndex;
						html += clickable ?
							`<td data-col="${i}" data-witel="${row.witel_name}" data-witel-id="${row.witel_id}" data-regional-id="${row.regional_id}" onclick="navigateToDetail(this)">${c}</td>` :
							`<td>${c}</td>`;
					}
					if (i > 0) colTotals[i] += Number(c);
				});

				html += `<td>${achVal.toFixed(2)}%</td>`;
				colTotals[achIndex] += achVal;
				html += `<td class="font-bold">${totalWithoutRekon}</td></tr>`;
				tbody.innerHTML += html;
			});

			const totalAch = totalAdjustedSum > 0 ? ((totalAdjustedSum - totalIdleSum) / totalAdjustedSum) * 100 : 0;

			let totalRow = '<tr class="font-bold"><td>TOTAL</td>';
			for (let i = 1; i < colTotals.length - 1; i++) {
				totalRow += `<td>${colTotals[i]}</td>`;
			}
			totalRow += `<td>${totalAch.toFixed(2)}%</td>`;
			totalRow += `<td>${totalWithoutRekonSum}</td></tr>`;
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
			const columnHeader = columnHeaderMap[colIndex] || 'Unknown';

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
			tbody.innerHTML = '<tr><td colspan="10">Loading...</td></tr>';
			fetch(url)
				.then(res => res.json())
				.then(data => renderMonitoringTable(data))
				.catch(() => {
					tbody.innerHTML = '<tr><td colspan="10">Gagal memuat data</td></tr>';
				});
		}

		document.addEventListener('DOMContentLoaded', function() {
			const fpStart = flatpickr('#start-date', {
				dateFormat: 'Y-m-d',
				allowInput: true,
				locale: {
					firstDayOfWeek: 1
				},
				onChange: function(selectedDates) {
					if (selectedDates.length) {
						const d = selectedDates[0];
						fpEnd.set('minDate', d);
						updateRangeAndFetch();
					}
				}
			});

			const fpEnd = flatpickr('#end-date', {
				dateFormat: 'Y-m-d',
				allowInput: true,
				locale: {
					firstDayOfWeek: 1
				},
				onChange: function(selectedDates) {
					if (selectedDates.length) {
						const d = selectedDates[0];
						fpStart.set('maxDate', d);
						updateRangeAndFetch();
					}
				}
			});

			function updateRangeAndFetch() {
				const start = fpStart.input.value;
				const end = fpEnd.input.value;
				if (start && end) {
					fetchMonitoringData(start, end);
				}
			}

			const today = new Date();
			const yyyy = today.getFullYear();
			const mm = String(today.getMonth() + 1).padStart(2, '0');
			const dd = String(today.getDate()).padStart(2, '0');
			const firstDayOfMonth = `${yyyy}-${mm}-01`;
			const todayStr = `${yyyy}-${mm}-${dd}`;
			fpStart.setDate(firstDayOfMonth, true);
			fpEnd.setDate(todayStr, true);
			fpEnd.set('minDate', firstDayOfMonth);
			fpStart.set('maxDate', todayStr);
			fetchMonitoringData(firstDayOfMonth, todayStr);
		});
	</script>
@endsection
