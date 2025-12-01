@extends('layouts')

@section('styles')
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
	<style>
		.listing-table th,
		.listing-table td {
			text-align: center;
			vertical-align: middle !important;
			padding: 8px !important;
			font-size: 13px !important;
			border: 1px solid #ddd;
		}

		.listing-table th {
			font-weight: 600;
		}

		.listing-table {
			border-collapse: collapse;
			width: 100%;
		}

		.listing-table tbody tr:hover {
			background-color: #f5f5f5 !important;
			transition: background 0.2s;
		}
	</style>
@endsection

@section('title', 'Dashboard Listing')

@section('content')
	<div class="panel mt-6">
		<h5 class="text-lg font-semibold dark:text-white-light mb-4">Dashboard Listing</h5>
		<div class="table-responsive">
			<table class="listing-table" id="listingTable">
				<thead>
					<tr>
						<th>Start</th>
						<th>IT Open</th>
						<th>Tiket</th>
						<th>Witel</th>
						<th>Site Down ID</th>
						<th>Site Down Name</th>
						<th>Site Detector ID</th>
						<th>Site Detector Koordinat</th>
						<th>Jenis Perbaikan</th>
						<th>Segment</th>
						<th>Sub Segment</th>
					</tr>
				</thead>
				<tbody>
					@php
						$data = [
						    [
						        '2025-11-01',
						        'INC-20251101-0009227',
						        'SAMARINDA',
						        '23BLCO062',
						        'SEGUMBANG1_PL',
						        '23BLCO042',
						        'BERINGIN_B - 3.51076542',
						        'ODC',
						        'ODC',
						        'Distribusi',
						        'FO Cut Kabel',
						    ],
						    [
						        '2025-11-01',
						        'INC-20251101-0008189',
						        'SAMARINDA',
						        '22SMR0002',
						        'EKONOMI_LOA_BUAH_PL',
						        '22SMR0008',
						        'LOA_BUAH_PL -0.56477785',
						        'Temporer',
						        'Distribusi',
						        'FO Cut Kabel',
						        'FO Cut Kabel',
						    ],
						    [
						        '2025-11-01',
						        'INC-20251101-0007696',
						        'SAMARINDA',
						        '22SMR0002',
						        'EKONOMI_LOA_BUAH_PL',
						        '22SMR0007',
						        'LOA_BUAH_PL -0.56477365',
						        'Temporer',
						        'Distribusi',
						        'FO Cut Kabel',
						        'FO Cut Kabel',
						    ],
						    [
						        '2025-11-01',
						        'INC-20251101-0001577',
						        'BALIKPAPAN',
						        '23BP00156',
						        'PROJAKAL_AMPAR_BPP_PL',
						        '23BP00156',
						        'GIRI_REO_T -1.19463,116.852',
						        'Hasil pengukuran di site',
						        'Distribusi',
						        'FO Cut Kabel',
						        'FO Cut Kabel',
						    ],
						    [
						        '2025-11-01',
						        'INC-20251101-0001985',
						        'BANJARMASIN',
						        '23ITL0078',
						        'SUNGAL_BULUH_CM',
						        '23ITL0011',
						        'PAWARINGIN -2.2574362281058,115.3',
						        'Hasil pengukuran di site',
						        'Distribusi',
						        'FO Cut Kabel',
						        'FO Cut Kabel',
						    ],
						    [
						        '2025-11-01',
						        'INC-20251101-0001984',
						        'PONTIANAK',
						        '20PTK1050',
						        'TRI_STORE',
						        '20PTK1096',
						        'PERUM_PERI -0.06333750',
						        'Permanen',
						        'ODC',
						        'ODC',
						        'ODC',
						    ],
						];
					@endphp
					@foreach ($data as $row)
						<tr>
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
							<td>{{ $row[10] }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@endsection

@section('scripts')
	<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
	<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
	<script>
		$(document).ready(function() {
			$('#listingTable').DataTable({});
		});
	</script>
@endsection
