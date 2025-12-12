@if ($errors->any())
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			@if ($errors->has('login'))
				showErrorMessage('{{ $errors->first('login') }}', 5000);
			@endif

			@if ($errors->has('register'))
				showErrorMessage('{{ $errors->first('register') }}', 5000);
			@endif

			@if ($errors->has('captcha'))
				showErrorMessage('{{ $errors->first('captcha') }}', 5000);
			@endif

			@if ($errors->has('nik'))
				showErrorMessage('{{ $errors->first('nik') }}', 5000);
			@endif

			@if ($errors->has('password'))
				showErrorMessage('{{ $errors->first('password') }}', 5000);
			@endif
		});
	</script>
@endif

@if (session('success'))
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			showSuccessMessage('{{ session('success') }}', 5000);
		});
	</script>
@endif

<script>
	showMessage = (msg = 'Example notification text.', position = 'top', showCloseButton = true, closeButtonHtml = '',
		duration = 3000) => {
		const toast = window.Swal.mixin({
			toast: true,
			position: position,
			showConfirmButton: false,
			timer: duration,
			padding: '10px 20px',
		});
		toast.fire({
			icon: 'info',
			title: msg,
			padding: '10px 20px',
		});
	};

	showSuccessMessage = (msg = 'Operasi berhasil dilakukan!', duration = 3000) => {
		const toast = window.Swal.mixin({
			toast: true,
			position: 'top',
			showConfirmButton: false,
			timer: duration,
			padding: '10px 20px',
		});
		toast.fire({
			icon: 'success',
			title: msg,
			padding: '10px 20px',
		});
	};

	showErrorMessage = (msg = 'Terjadi kesalahan!', duration = 3000) => {
		const toast = window.Swal.mixin({
			toast: true,
			position: 'top',
			showConfirmButton: false,
			timer: duration,
			padding: '10px 20px',
		});
		toast.fire({
			icon: 'error',
			title: msg,
			padding: '10px 20px',
		});
	};

	showWarningMessage = (msg = 'Peringatan!', duration = 3000) => {
		const toast = window.Swal.mixin({
			toast: true,
			position: 'top',
			showConfirmButton: false,
			timer: duration,
			padding: '10px 20px',
		});
		toast.fire({
			icon: 'warning',
			title: msg,
			padding: '10px 20px',
		});
	};

	showInfoMessage = (msg = 'Informasi!', duration = 3000) => {
		const toast = window.Swal.mixin({
			toast: true,
			position: 'top',
			showConfirmButton: false,
			timer: duration,
			padding: '10px 20px',
		});
		toast.fire({
			icon: 'info',
			title: msg,
			padding: '10px 20px',
		});
	};
</script>
