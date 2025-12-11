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
