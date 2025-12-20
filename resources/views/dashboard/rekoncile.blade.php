@extends('layouts')

@section('styles')
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
	</style>
@endsection

@section('title', 'Dashboard Rekonsiliasi')

@section('content')
	<div class="panel mt-6">
		<h5 class="text-lg font-semibold dark:text-white-light mb-4">Dashboard Rekonsiliasi</h5>
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
	<script>
		function formatRupiah(value) {
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

		function fetchRekoncileData() {
			const tbody = document.getElementById('rekoncile-tbody');
			tbody.innerHTML = '<tr><td colspan="9">Loading...</td></tr>';

			fetch('/ajax/dashboard/rekoncile')
				.then(res => res.json())
				.then(data => renderRekoncileTable(data))
				.catch(() => {
					tbody.innerHTML = '<tr><td colspan="9">Gagal memuat data</td></tr>';
				});
		}

		document.addEventListener('DOMContentLoaded', function() {
			fetchRekoncileData();
		});
	</script>
@endsection
