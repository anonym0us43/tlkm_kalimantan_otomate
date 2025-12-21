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

		.date-input-wrapper .calendar-icon {
			position: absolute;
			right: 10px;
			bottom: 8px;
			pointer-events: none;
			color: #9ca3af;
		}

		.dark .date-input-wrapper .calendar-icon {
			color: #6b7280;
		}
	</style>
@endsection

@section('title', 'Dashboard Rekonsiliasi')

@section('content')
	<div class="panel mt-6">
		<h5 class="text-lg font-semibold dark:text-white-light mb-4">Dashboard Rekonsiliasi</h5>

		<div class="date-filter-panel grid grid-cols-1 lg:grid-cols-3 gap-2 lg:gap-3 px-0 py-0">
			<div class="date-input-wrapper">
				<label for="start-date" class="form-label">Tanggal Mulai</label>
				<input type="text" id="start-date" class="form-input" placeholder="YYYY-MM-DD" readonly>
				<svg class="calendar-icon" width="20" height="20" viewBox="0 0 24 24" fill="none"
					xmlns="http://www.w3.org/2000/svg">
					<path
						d="M8 2V5M16 2V5M3.5 9.09H20.5M21 8.5V17C21 20 19.5 22 16 22H8C4.5 22 3 20 3 17V8.5C3 5.5 4.5 3.5 8 3.5H16C19.5 3.5 21 5.5 21 8.5Z"
						stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
					<path
						d="M15.6947 13.7H15.7037M15.6947 16.7H15.7037M11.9955 13.7H12.0045M11.9955 16.7H12.0045M8.29431 13.7H8.30329M8.29431 16.7H8.30329"
						stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
				</svg>
			</div>

			<div class="hidden lg:flex items-end justify-center pb-1 text-gray-400">
				<span class="text-sm">→</span>
			</div>

			<div class="date-input-wrapper">
				<label for="end-date" class="form-label">Tanggal Selesai</label>
				<input type="text" id="end-date" class="form-input" placeholder="YYYY-MM-DD" readonly>
				<svg class="calendar-icon" width="20" height="20" viewBox="0 0 24 24" fill="none"
					xmlns="http://www.w3.org/2000/svg">
					<path
						d="M8 2V5M16 2V5M3.5 9.09H20.5M21 8.5V17C21 20 19.5 22 16 22H8C4.5 22 3 20 3 17V8.5C3 5.5 4.5 3.5 8 3.5H16C19.5 3.5 21 5.5 21 8.5Z"
						stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
					<path
						d="M15.6947 13.7H15.7037M15.6947 16.7H15.7037M11.9955 13.7H12.0045M11.9955 16.7H12.0045M8.29431 13.7H8.30329M8.29431 16.7H8.30329"
						stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
				</svg>
			</div>
		</div>

		<div class="table-responsive">
			<table class="table table-bordered table-hover detail-table mt-4" id="rekoncile-table">
				<thead>
					<tr>
						<th rowspan="3">WITEL</th>
						<th colspan="3">PLANNING</th>
						<th rowspan="3">PROGRESS</th>
						<th colspan="2">PERMANENISASI</th>
						<th rowspan="3">REKON</th>
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
				<tbody id="rekoncile-tbody">
					<tr>
						<td colspan="9">Loading...</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
@endsection

@section('scripts')
	<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
	<script>
		let currentStartDate = '';
		let currentEndDate = '';

		function formatRupiah(value) {
			if (value === 0 || value === null || value === undefined) {
				return '-';
			}
			return new Intl.NumberFormat('id-ID', {
				style: 'currency',
				currency: 'IDR',
				minimumFractionDigits: 0,
				maximumFractionDigits: 0
			}).format(value);
		}

		function renderRekoncileTable(data) {
			const tbody = document.getElementById('rekoncile-tbody');
			tbody.innerHTML = '';

			if (!data || data.length === 0) {
				tbody.innerHTML = '<tr><td colspan="9">Tidak ada data</td></tr>';
				return;
			}

			let grandTotal = 0;
			const columnTotals = Array(7).fill(0);

			data.forEach((row) => {
				const values = [
					Number(row.planning_indikasi) || 0,
					Number(row.planning_reject) || 0,
					Number(row.planning_need_approve) || 0,
					Number(row.progress) || 0,
					Number(row.permanenisasi_reject) || 0,
					Number(row.permanenisasi_need_approve) || 0,
					Number(row.rekon) || 0
				];

				const rowTotal = values.reduce((a, b) => a + b, 0);

				let rowHtml = `<tr>
					<td>${row.witel}</td>`;

				values.forEach((val, idx) => {
					rowHtml += `<td>${formatRupiah(val)}</td>`;
					columnTotals[idx] += val;
				});

				rowHtml += `<td class="font-bold">${formatRupiah(rowTotal)}</td></tr>`;
				tbody.innerHTML += rowHtml;
				grandTotal += rowTotal;
			});

			let totalRow = '<tr class="font-bold bg-gray-100 dark:bg-gray-800"><td>TOTAL</td>';
			columnTotals.forEach((total) => {
				totalRow += `<td>${formatRupiah(total)}</td>`;
			});
			totalRow += `<td>${formatRupiah(grandTotal)}</td></tr>`;
			tbody.innerHTML += totalRow;
		}

		function fetchRekoncileData(startDate, endDate) {
			currentStartDate = startDate;
			currentEndDate = endDate;

			const params = new URLSearchParams({
				start_date: startDate,
				end_date: endDate
			});
			const url = `/ajax/dashboard/rekoncile?${params.toString()}`;
			const tbody = document.getElementById('rekoncile-tbody');
			tbody.innerHTML = '<tr><td colspan="9">Loading...</td></tr>';

			fetch(url)
				.then(res => res.json())
				.then(data => renderRekoncileTable(data))
				.catch(() => {
					tbody.innerHTML = '<tr><td colspan="9">Gagal memuat data</td></tr>';
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
					if (fpStart.input.value && fpEnd.input.value) {
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
					if (fpStart.input.value && fpEnd.input.value) {
						updateRangeAndFetch();
					}
				}
			});

			function updateRangeAndFetch() {
				const start = fpStart.input.value;
				const end = fpEnd.input.value;
				if (start && end) {
					fpEnd.set('minDate', start);
					fpStart.set('maxDate', end);
					fetchRekoncileData(start, end);
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
			fetchRekoncileData(firstDayOfMonth, todayStr);
		});
	</script>
@endsection
