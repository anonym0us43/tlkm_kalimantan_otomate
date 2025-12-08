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
				<tbody id="rekoncile-tbody">
					<tr>
						<td colspan="13">Loading...</td>
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

		function generateDummyData() {
			const witels = [
				'BALIKPAPAN',
				'SAMARINDA',
				'TARAKAN',
				'BANJARMASIN',
				'PALANGKARAYA',
				'PONTIANAK'
			];

			const tbody = document.getElementById('rekoncile-tbody');
			tbody.innerHTML = '';

			let grandTotal = 0;
			const columnTotals = Array(11).fill(0);

			witels.forEach((witel) => {
				const values = [
					Math.floor(Math.random() * 5000000000) + 1000000000,
					Math.floor(Math.random() * 3000000000) + 500000000,
					Math.floor(Math.random() * 4000000000) + 800000000,
					Math.floor(Math.random() * 2000000000) + 500000000,
					Math.floor(Math.random() * 3000000000) + 1000000000,
					Math.floor(Math.random() * 2500000000) + 800000000,
					Math.floor(Math.random() * 1500000000) + 300000000,
					Math.floor(Math.random() * 3000000000) + 1000000000,
					Math.floor(Math.random() * 2000000000) + 500000000,
					Math.floor(Math.random() * 4000000000) + 1000000000,
					Math.floor(Math.random() * 2000000000) + 500000000
				];

				const rowTotal = values.reduce((a, b) => a + b, 0);

				let row = `<tr>
					<td>${witel}</td>`;

				values.forEach((val, idx) => {
					row += `<td>${formatRupiah(val)}</td>`;
					columnTotals[idx] += val;
				});

				row += `<td class="font-bold">${formatRupiah(rowTotal)}</td></tr>`;
				tbody.innerHTML += row;
				grandTotal += rowTotal;
			});

			let totalRow = '<tr class="font-bold bg-gray-100 dark:bg-gray-800"><td>TOTAL</td>';
			columnTotals.forEach((total) => {
				totalRow += `<td>${formatRupiah(total)}</td>`;
			});
			totalRow += `<td>${formatRupiah(grandTotal)}</td></tr>`;
			tbody.innerHTML += totalRow;
		}

		document.addEventListener('DOMContentLoaded', function() {
			generateDummyData();
		});
	</script>
@endsection
