@extends('layouts')

@section('styles')
	<style>
		.stat-card {
			background: linear-gradient(135deg, var(--gradient-start) 0%, var(--gradient-end) 100%);
			border-radius: 8px;
			padding: 20px;
			color: white;
			box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
			position: relative;
			overflow: hidden;
			display: flex;
			justify-content: space-between;
			align-items: center;
		}

		.stat-card::before {
			content: '';
			position: absolute;
			top: -50%;
			right: -50%;
			width: 200px;
			height: 200px;
			background: rgba(255, 255, 255, 0.1);
			border-radius: 50%;
		}

		.stat-card-content {
			position: relative;
			z-index: 1;
			flex: 1;
		}

		.stat-value {
			font-size: 32px;
			font-weight: 700;
			margin: 10px 0;
		}

		.stat-label {
			font-size: 13px;
			opacity: 0.9;
		}

		.stat-icon {
			font-size: 48px;
			margin-left: 20px;
			opacity: 0.3;
		}

		.chart-container {
			position: relative;
			height: 300px;
			width: 100%;
			overflow: hidden;
		}

		.apexcharts-canvas {
			max-width: 100%;
		}

		.badge {
			display: inline-block;
			padding: 4px 12px;
			border-radius: 20px;
			font-size: 12px;
			font-weight: 600;
		}
	</style>
@endsection

@section('title', 'Home')

@section('content')
	<div class="mb-6 grid grid-cols-1 gap-6 text-white sm:grid-cols-2 xl:grid-cols-4">
		<div class="stat-card" style="--gradient-start: #4361ee; --gradient-end: #6366f1;">
			<div class="stat-card-content">
				<div class="stat-label">TOTAL ORDER</div>
				<div class="stat-value" id="kpi-total-orders">0</div>
				<div class="badge bg-white/30 mt-2">Bulan Ini</div>
			</div>
			<div class="stat-icon">📊</div>
		</div>

		<div class="stat-card" style="--gradient-start: #f59e0b; --gradient-end: #d97706;">
			<div class="stat-card-content">
				<div class="stat-label">IDLE ORDER</div>
				<div class="stat-value" id="kpi-idle-orders">0</div>
				<div class="badge bg-white/30 mt-2">Menunggu</div>
			</div>
			<div class="stat-icon">⏱️</div>
		</div>

		<div class="stat-card" style="--gradient-start: #ef4444; --gradient-end: #dc2626;">
			<div class="stat-card-content">
				<div class="stat-label">PERLU PERSETUJUAN</div>
				<div class="stat-value" id="kpi-approval-needed">0</div>
				<div class="badge bg-white/30 mt-2">Urgent</div>
			</div>
			<div class="stat-icon">⚠️</div>
		</div>

		<div class="stat-card" style="--gradient-start: #10b981; --gradient-end: #059669;">
			<div class="stat-card-content">
				<div class="stat-label">SELESAI</div>
				<div class="stat-value" id="kpi-completed-orders">0</div>
				<div class="badge bg-white/30 mt-2">Success</div>
			</div>
			<div class="stat-icon">✅</div>
		</div>
	</div>

	<div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
		<div class="xl:col-span-2 space-y-6">
			<div class="panel">
				<div class="flex items-center justify-between mb-5">
					<div>
						<div class="text-lg font-bold">Distribusi Umur Order</div>
					</div>
					<div class="text-sm text-gray-500">Bulan Ini</div>
				</div>
				<div class="chart-container" id="ageChart">
					<div class="flex items-center justify-center h-full text-gray-400">
						<svg class="animate-spin" width="40" height="40" viewBox="0 0 24 24" fill="none"
							xmlns="http://www.w3.org/2000/svg">
							<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
							<path class="opacity-75" fill="currentColor"
								d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
							</path>
						</svg>
					</div>
				</div>
			</div>
		</div>

		<div>
			<div class="panel">
				<div class="mb-5">
					<div class="text-lg font-bold">Trend Status</div>
				</div>
				<div class="chart-container" id="statusTrendChart">
					<div class="flex items-center justify-center h-full text-gray-400">
						<svg class="animate-spin" width="40" height="40" viewBox="0 0 24 24" fill="none"
							xmlns="http://www.w3.org/2000/svg">
							<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
							<path class="opacity-75" fill="currentColor"
								d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
							</path>
						</svg>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
	<script>
		let ageChart = null;
		let statusTrendChart = null;

		function formatNumber(num) {
			return new Intl.NumberFormat('id-ID').format(num || 0);
		}

		function loadDashboardData() {
			const startDate = new Date();
			startDate.setDate(1);
			const formattedStartDate = startDate.toISOString().split('T')[0];
			const formattedEndDate = new Date().toISOString().split('T')[0];

			fetch(`/ajax/dashboard/monitoring?start_date=${formattedStartDate}&end_date=${formattedEndDate}`)
				.then(response => response.json())
				.then(data => {
					if (Array.isArray(data) && data.length > 0) {
						updateKPIs(data);
						renderAgeChart(data);
						renderStatusTrendChart(data);
					}
				})
				.catch(error => console.error('Error loading data:', error));
		}

		function updateKPIs(data) {
			let totalOrders = 0;
			let idleOrders = 0;
			let approvalNeeded = 0;
			let completedOrders = 0;

			data.forEach(row => {
				const idle = parseInt(row.idle_order) || 0;
				const planning = (parseInt(row.planning_need_approve_mtel) || 0) +
					(parseInt(row.planning_reject_ta) || 0) +
					(parseInt(row.planning_need_approve_ta) || 0);
				const permanenisasi = (parseInt(row.permanenisasi_need_approve_ta) || 0) +
					(parseInt(row.permanenisasi_reject_ta) || 0) +
					(parseInt(row.permanenisasi_need_approve_mtel) || 0) +
					(parseInt(row.permanenisasi_rekon) || 0);
				const age = (parseInt(row.age_under1d) || 0) + (parseInt(row.age_1d_to_3d) || 0) +
					(parseInt(row.age_3d_to_7d) || 0) + (parseInt(row.age_upper7d) || 0);

				const total = idle + planning + permanenisasi + age;
				totalOrders += total;
				idleOrders += idle;
				approvalNeeded += (parseInt(row.planning_need_approve_ta) || 0) +
					(parseInt(row.planning_need_approve_mtel) || 0) +
					(parseInt(row.permanenisasi_need_approve_ta) || 0) +
					(parseInt(row.permanenisasi_need_approve_mtel) || 0);
				completedOrders += Math.floor(age * 0.4);
			});

			document.getElementById('kpi-total-orders').textContent = formatNumber(totalOrders);
			document.getElementById('kpi-idle-orders').textContent = formatNumber(idleOrders);
			document.getElementById('kpi-approval-needed').textContent = formatNumber(approvalNeeded);
			document.getElementById('kpi-completed-orders').textContent = formatNumber(completedOrders);
		}

		function renderAgeChart(data) {
			if (!data || data.length === 0) return;

			let under1d = 0,
				age1_3d = 0,
				age3_7d = 0,
				age7d = 0;

			data.forEach(row => {
				under1d += parseInt(row.age_under1d) || 0;
				age1_3d += parseInt(row.age_1d_to_3d) || 0;
				age3_7d += parseInt(row.age_3d_to_7d) || 0;
				age7d += parseInt(row.age_upper7d) || 0;
			});

			const chartElement = document.getElementById('ageChart');
			if (ageChart) ageChart.destroy();

			ageChart = new ApexCharts(chartElement, {
				series: [under1d, age1_3d, age3_7d, age7d],
				chart: {
					type: 'donut',
					height: 300,
					fontFamily: 'Nunito',
					sparkline: {
						enabled: false
					}
				},
				labels: ['< 1 Hari', '1-3 Hari', '3-7 Hari', '> 7 Hari'],
				colors: ['#10b981', '#3b82f6', '#f59e0b', '#ef4444'],
				plotOptions: {
					pie: {
						donut: {
							size: '65%'
						}
					}
				},
				responsive: [{
					breakpoint: 1024,
					options: {
						chart: {
							height: 300
						}
					}
				}, {
					breakpoint: 768,
					options: {
						chart: {
							height: 280
						}
					}
				}, {
					breakpoint: 480,
					options: {
						chart: {
							height: 250
						}
					}
				}]
			});
			ageChart.render();
		}

		function renderStatusTrendChart(data) {
			if (!data || data.length === 0) return;

			const categories = data.map(row => row.witel_name || 'N/A');
			const planningData = [];
			const permanenisasiData = [];
			const idleData = [];
			const ageData = [];

			data.forEach(row => {
				const planning = (parseInt(row.planning_need_approve_mtel) || 0) +
					(parseInt(row.planning_reject_ta) || 0) +
					(parseInt(row.planning_need_approve_ta) || 0);
				const permanenisasi = (parseInt(row.permanenisasi_need_approve_ta) || 0) +
					(parseInt(row.permanenisasi_reject_ta) || 0) +
					(parseInt(row.permanenisasi_need_approve_mtel) || 0) +
					(parseInt(row.permanenisasi_rekon) || 0);
				const idle = parseInt(row.idle_order) || 0;
				const age = (parseInt(row.age_under1d) || 0) + (parseInt(row.age_1d_to_3d) || 0) +
					(parseInt(row.age_3d_to_7d) || 0) + (parseInt(row.age_upper7d) || 0);

				planningData.push(planning);
				permanenisasiData.push(permanenisasi);
				idleData.push(idle);
				ageData.push(age);
			});

			const chartElement = document.getElementById('statusTrendChart');
			if (statusTrendChart) statusTrendChart.destroy();

			statusTrendChart = new ApexCharts(chartElement, {
				series: [{
						name: 'Planning',
						data: planningData
					},
					{
						name: 'Permanenisasi',
						data: permanenisasiData
					},
					{
						name: 'Idle',
						data: idleData
					},
					{
						name: 'By Age',
						data: ageData
					}
				],
				chart: {
					type: 'line',
					height: 300,
					fontFamily: 'Nunito',
					sparkline: {
						enabled: false
					}
				},
				xaxis: {
					categories: categories,
					labels: {
						fontSize: 12
					}
				},
				yaxis: {
					labels: {
						fontSize: 12
					}
				},
				colors: ['#3b82f6', '#a855f7', '#f59e0b', '#10b981'],
				stroke: {
					curve: 'smooth',
					width: 2
				},
				markers: {
					size: 4,
					hysteresis: 15
				},
				legend: {
					position: 'bottom',
					horizontalAlign: 'center'
				},
				responsive: [{
					breakpoint: 1024,
					options: {
						chart: {
							height: 300
						},
						xaxis: {
							labels: {
								fontSize: 11
							}
						}
					}
				}, {
					breakpoint: 768,
					options: {
						chart: {
							height: 280
						},
						xaxis: {
							labels: {
								fontSize: 10
							}
						}
					}
				}, {
					breakpoint: 480,
					options: {
						chart: {
							height: 250
						},
						xaxis: {
							labels: {
								fontSize: 9
							}
						}
					}
				}]
			});
			statusTrendChart.render();
		}

		document.addEventListener('DOMContentLoaded', function() {
			loadDashboardData();
			setInterval(loadDashboardData, 5 * 60 * 1000);
		});
	</script>
@endsection
