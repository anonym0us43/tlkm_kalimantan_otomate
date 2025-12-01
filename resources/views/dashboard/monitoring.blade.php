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
			<table class="table table-bordered table-hover detail-table mt-4">
				<thead>
					<tr>
						<th rowspan="2">WITEL</th>
						<th rowspan="2">INDIKASI</th>
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
				<tbody>
					@php
						$witel = ['BALIKPAPAN', 'SAMARINDA', 'TARAKAN', 'BANJARMASIN', 'PALANGKARAYA', 'PONTIANAK'];
						$dummy = [
						    [1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
						    [1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
						    [1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
						    [1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
						    [1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
						    [1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
						];
					@endphp
					@foreach ($witel as $i => $w)
						@php
							$row = $dummy[$i];
							$total = array_sum($row);
						@endphp
						<tr>
							<td>{{ $w }}</td>
							<td>{{ $row[0] }}</td>
							<td>{{ $row[1] }}</td>
							<td>{{ $row[2] }}</td>
							<td>{{ $row[3] }}</td>
							<td>{{ $row[4] }}</td>
							<td>{{ $row[5] }}</td>
							<td>{{ $row[6] }}</td>
							<td>{{ $row[7] }}</td>
							<td>{{ $row[8] }}</td>
							<td>{{ $row[9] }}</td>
							<td class="font-bold">{{ $total }}</td>
						</tr>
					@endforeach
					<tr class="font-bold">
						<td>TOTAL</td>
						@php
							$colTotals = [];
							for ($c = 1; $c <= 10; $c++) {
							    $col = array_map(function ($row) use ($c) {
							        return $row[$c];
							    }, $dummy);
							    $colTotals[$c] = array_sum($col);
							}
							$grandTotal = array_sum($colTotals);
						@endphp
						<td>{{ $colTotals[1] }}</td>
						<td>{{ $colTotals[2] }}</td>
						<td>{{ $colTotals[3] }}</td>
						<td>{{ $colTotals[4] }}</td>
						<td>{{ $colTotals[5] }}</td>
						<td>{{ $colTotals[6] }}</td>
						<td>{{ $colTotals[7] }}</td>
						<td>{{ $colTotals[8] }}</td>
						<td>{{ $colTotals[9] }}</td>
						<td>{{ $colTotals[10] }}</td>
						<td>{{ $grandTotal }}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
@endsection

@section('scripts')
	<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			flatpickr("#date-range", {
				mode: "range",
				dateFormat: "Y-m-d",
				allowInput: true,
				locale: {
					firstDayOfWeek: 1
				}
			});
		});
	</script>
@endsection
