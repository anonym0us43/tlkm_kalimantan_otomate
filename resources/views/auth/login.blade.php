<!DOCTYPE html>
<html lang="en" dir="ltr">

	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<title>Sign In - OTOMATE</title>
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="icon" type="image/x-icon" href="favicon.png" />
		<link rel="preconnect" href="https://fonts.googleapis.com" />
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
		<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
		<link rel="stylesheet" type="text/css" media="screen" href="/assets/css/perfect-scrollbar.min.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="/assets/css/style.css" />
		<link defer rel="stylesheet" type="text/css" media="screen" href="/assets/css/animate.css" />
		<script src="/assets/js/perfect-scrollbar.min.js"></script>
		<script defer src="/assets/js/popper.min.js"></script>
		<script defer src="/assets/js/tippy-bundle.umd.min.js"></script>
		<script defer src="/assets/js/sweetalert.min.js"></script>
	</head>

	@include('partial.alerts')

	<body x-data="main" class="relative overflow-x-hidden font-nunito text-sm font-normal antialiased"
		:class="[$store.app.sidebar ? 'toggle-sidebar' : '', $store.app.theme === 'dark' || $store.app.isDarkMode ? 'dark' : '',
		    $store.app.menu, $store.app.layout, $store.app.rtlClass
		]">
		<div
			class="screen_loader animate__animated fixed inset-0 z-[60] grid place-content-center bg-[#fafafa] dark:bg-[#060818]">
			<svg width="64" height="64" viewBox="0 0 135 135" xmlns="http://www.w3.org/2000/svg" fill="#4361ee">
				<path
					d="M67.447 58c5.523 0 10-4.477 10-10s-4.477-10-10-10-10 4.477-10 10 4.477 10 10 10zm9.448 9.447c0 5.523 4.477 10 10 10 5.522 0 10-4.477 10-10s-4.478-10-10-10c-5.523 0-10 4.477-10 10zm-9.448 9.448c-5.523 0-10 4.477-10 10 0 5.522 4.477 10 10 10s10-4.478 10-10c0-5.523-4.477-10-10-10zM58 67.447c0-5.523-4.477-10-10-10s-10 4.477-10 10 4.477 10 10 10 10-4.477 10-10z">
					<animateTransform attributeName="transform" type="rotate" from="0 67 67" to="-360 67 67" dur="2.5s"
						repeatCount="indefinite" />
				</path>
				<path
					d="M28.19 40.31c6.627 0 12-5.374 12-12 0-6.628-5.373-12-12-12-6.628 0-12 5.372-12 12 0 6.626 5.372 12 12 12zm30.72-19.825c4.686 4.687 12.284 4.687 16.97 0 4.686-4.686 4.686-12.284 0-16.97-4.686-4.687-12.284-4.687-16.97 0-4.687 4.686-4.687 12.284 0 16.97zm35.74 7.705c0 6.627 5.37 12 12 12 6.626 0 12-5.373 12-12 0-6.628-5.374-12-12-12-6.63 0-12 5.372-12 12zm19.822 30.72c-4.686 4.686-4.686 12.284 0 16.97 4.687 4.686 12.285 4.686 16.97 0 4.687-4.686 4.687-12.284 0-16.97-4.685-4.687-12.283-4.687-16.97 0zm-7.704 35.74c-6.627 0-12 5.37-12 12 0 6.626 5.373 12 12 12s12-5.374 12-12c0-6.63-5.373-12-12-12zm-30.72 19.822c-4.686-4.686-12.284-4.686-16.97 0-4.686 4.687-4.686 12.285 0 16.97 4.686 4.687 12.284 4.687 16.97 0 4.687-4.685 4.687-12.283 0-16.97zm-35.74-7.704c0-6.627-5.372-12-12-12-6.626 0-12 5.373-12 12s5.374 12 12 12c6.628 0 12-5.373 12-12zm-19.823-30.72c4.687-4.686 4.687-12.284 0-16.97-4.686-4.686-12.284-4.686-16.97 0-4.687 4.686-4.687 12.284 0 16.97 4.686 4.687 12.284 4.687 16.97 0z">
					<animateTransform attributeName="transform" type="rotate" from="0 67 67" to="360 67 67" dur="8s"
						repeatCount="indefinite" />
				</path>
			</svg>
		</div>

		<div class="fixed bottom-6 right-6 z-50" x-data="scrollToTop">
			<template x-if="showTopButton">
				<button type="button" class="btn btn-outline-primary animate-pulse rounded-full p-2" @click="goToTop">
					<svg width="24" height="24" class="h-4 w-4" viewBox="0 0 24 24" fill="none"
						xmlns="http://www.w3.org/2000/svg">
						<path opacity="0.5" fill-rule="evenodd" clip-rule="evenodd"
							d="M12 20.75C12.4142 20.75 12.75 20.4142 12.75 20L12.75 10.75L11.25 10.75L11.25 20C11.25 20.4142 11.5858 20.75 12 20.75Z"
							fill="currentColor" />
						<path
							d="M6.00002 10.75C5.69667 10.75 5.4232 10.5673 5.30711 10.287C5.19103 10.0068 5.25519 9.68417 5.46969 9.46967L11.4697 3.46967C11.6103 3.32902 11.8011 3.25 12 3.25C12.1989 3.25 12.3897 3.32902 12.5304 3.46967L18.5304 9.46967C18.7449 9.68417 18.809 10.0068 18.6929 10.287C18.5768 10.5673 18.3034 10.75 18 10.75L6.00002 10.75Z"
							fill="currentColor" />
					</svg>
				</button>
			</template>
		</div>

		<div class="main-container min-h-screen text-black dark:text-white-dark">
			<div x-data="auth">
				<div class="absolute inset-0">
					<img src="/assets/images/auth/bg-gradient.png" alt="image" class="h-full w-full object-cover" />
				</div>
				<div
					class="relative flex min-h-screen items-center justify-center bg-[url(../images/auth/map.png)] bg-cover bg-center bg-no-repeat px-6 py-10 dark:bg-[#060818] sm:px-16">
					<img src="/assets/images/auth/coming-soon-object1.png" alt="image"
						class="absolute left-0 top-1/2 h-full max-h-[893px] -translate-y-1/2" />
					<img src="/assets/images/auth/coming-soon-object2.png" alt="image"
						class="absolute left-24 top-0 h-40 md:left-[30%]" />
					<img src="/assets/images/auth/coming-soon-object3.png" alt="image" class="absolute right-0 top-0 h-[300px]" />
					<img src="/assets/images/auth/polygon-object.svg" alt="image" class="absolute bottom-0 end-[28%]" />
					<div
						class="relative flex w-full max-w-[1502px] flex-col justify-between overflow-hidden rounded-md bg-white/60 backdrop-blur-lg dark:bg-black/50 lg:min-h-[758px] lg:flex-row lg:gap-10 xl:gap-0">
						<div
							class="relative hidden w-full items-center justify-center bg-[linear-gradient(225deg,rgba(239,18,98,1)_0%,rgba(67,97,238,1)_100%)] p-5 lg:inline-flex lg:max-w-[835px] xl:-ms-32 ltr:xl:skew-x-[14deg] rtl:xl:skew-x-[-14deg]">
							<div
								class="absolute inset-y-0 w-8 from-primary/10 via-transparent to-transparent ltr:-right-10 ltr:bg-gradient-to-r rtl:-left-10 rtl:bg-gradient-to-l xl:w-16 ltr:xl:-right-20 rtl:xl:-left-20">
							</div>
							<div class="ltr:xl:-skew-x-[14deg] rtl:xl:skew-x-[14deg]">
								<a href="{{ route('home') }}" class="block w-48 lg:w-72 ms-10">
									<img src="/img-otomate-white.png" alt="Logo" class="w-full" />
								</a>
								<div class="mt-24 hidden w-full max-w-[430px] lg:block">
									<img src="/assets/images/auth/login.svg" alt="Cover Image" class="w-full" />
								</div>
							</div>
						</div>
						<div
							class="relative flex w-full flex-col items-center justify-center gap-6 px-4 pb-16 pt-6 sm:px-6 lg:max-w-[667px]">
							<div class="flex w-full max-w-[440px] items-center gap-2 lg:absolute lg:end-6 lg:top-6 lg:max-w-full">
								<a href="{{ route('home') }}" class="block w-8 lg:hidden">
									<img src="/img-otomate-white.png" alt="Logo" class="w-full" />
								</a>
							</div>
							<div class="w-full max-w-[440px] lg:mt-16">
								<div class="mb-10">
									<h1 class="text-3xl font-extrabold uppercase !leading-snug text-primary md:text-4xl">Sign in</h1>
									<p class="text-base font-bold leading-normal text-white-dark">Enter your NIK and password to login</p>
								</div>
								<form method="POST" action="{{ route('login.post') }}" class="space-y-5 dark:text-white">
									@csrf
									<div>
										<label for="nik">NIK</label>
										<div class="relative text-white-dark">
											<input id="nik" type="text" name="nik" placeholder="Enter NIK"
												class="form-input ps-10 placeholder:text-white-dark @error('nik') border-red-500 @enderror"
												value="{{ old('nik') }}" />
											<span class="absolute start-4 top-1/2 -translate-y-1/2">
												<svg width="18" height="18" viewBox="0 0 18 18" fill="none">
													<path opacity="0.5"
														d="M10.65 2.25H7.35C4.23873 2.25 2.6831 2.25 1.71655 3.23851C0.75 4.22703 0.75 5.81802 0.75 9C0.75 12.182 0.75 13.773 1.71655 14.7615C2.6831 15.75 4.23873 15.75 7.35 15.75H10.65C13.7613 15.75 15.3169 15.75 16.2835 14.7615C17.25 13.773 17.25 12.182 17.25 9C17.25 5.81802 17.25 4.22703 16.2835 3.23851C15.3169 2.25 13.7613 2.25 10.65 2.25Z"
														fill="currentColor" />
													<path
														d="M14.3465 6.02574C14.609 5.80698 14.6445 5.41681 14.4257 5.15429C14.207 4.89177 13.8168 4.8563 13.5543 5.07507L11.7732 6.55931C11.0035 7.20072 10.4691 7.6446 10.018 7.93476C9.58125 8.21564 9.28509 8.30993 9.00041 8.30993C8.71572 8.30993 8.41956 8.21564 7.98284 7.93476C7.53168 7.6446 6.9973 7.20072 6.22761 6.55931L4.44652 5.07507C4.184 4.8563 3.79384 4.89177 3.57507 5.15429C3.3563 5.41681 3.39177 5.80698 3.65429 6.02574L5.4664 7.53583C6.19764 8.14522 6.79033 8.63914 7.31343 8.97558C7.85834 9.32604 8.38902 9.54743 9.00041 9.54743C9.6118 9.54743 10.1425 9.32604 10.6874 8.97558C11.2105 8.63914 11.8032 8.14522 12.5344 7.53582L14.3465 6.02574Z"
														fill="currentColor" />
												</svg>
											</span>
										</div>
										@error('nik')
											<p class="mt-1 text-xs text-red-500">{{ $message }}</p>
										@enderror
									</div>
									<div>
										<label for="password">Password</label>
										<div class="relative text-white-dark">
											<input id="password" type="password" name="password" placeholder="Enter Password"
												class="form-input ps-10 placeholder:text-white-dark @error('password') border-red-500 @enderror" />
											<span class="absolute start-4 top-1/2 -translate-y-1/2">
												<svg width="18" height="18" viewBox="0 0 18 18" fill="none">
													<path opacity="0.5"
														d="M1.5 12C1.5 9.87868 1.5 8.81802 2.15901 8.15901C2.81802 7.5 3.87868 7.5 6 7.5H12C14.1213 7.5 15.182 7.5 15.841 8.15901C16.5 8.81802 16.5 9.87868 16.5 12C16.5 14.1213 16.5 15.182 15.841 15.841C15.182 16.5 14.1213 16.5 12 16.5H6C3.87868 16.5 2.81802 16.5 2.15901 15.841C1.5 15.182 1.5 14.1213 1.5 12Z"
														fill="currentColor" />
													<path
														d="M6 12.75C6.41421 12.75 6.75 12.4142 6.75 12C6.75 11.5858 6.41421 11.25 6 11.25C5.58579 11.25 5.25 11.5858 5.25 12C5.25 12.4142 5.58579 12.75 6 12.75Z"
														fill="currentColor" />
													<path
														d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z"
														fill="currentColor" />
													<path
														d="M12.75 12C12.75 12.4142 12.4142 12.75 12 12.75C11.5858 12.75 11.25 12.4142 11.25 12C11.25 11.5858 11.5858 11.25 12 11.25C12.4142 11.25 12.75 11.5858 12.75 12Z"
														fill="currentColor" />
													<path
														d="M5.0625 6C5.0625 3.82538 6.82538 2.0625 9 2.0625C11.1746 2.0625 12.9375 3.82538 12.9375 6V7.50268C13.363 7.50665 13.7351 7.51651 14.0625 7.54096V6C14.0625 3.20406 11.7959 0.9375 9 0.9375C6.20406 0.9375 3.9375 3.20406 3.9375 6V7.54096C4.26488 7.51651 4.63698 7.50665 5.0625 7.50268V6Z"
														fill="currentColor" />
												</svg>
											</span>
										</div>
										@error('password')
											<p class="mt-1 text-xs text-red-500">{{ $message }}</p>
										@enderror
									</div>
									<div>
										<div class="flex items-center justify-between mb-2">
											<label for="captcha">Captcha</label>
											<span id="captcha-timer" class="text-xs font-semibold text-primary">
												Refresh in <span id="countdown">60</span>s
											</span>
										</div>
										<div class="flex gap-3">
											<div class="flex-1">
												<img id="captcha-img" src="{{ route('captcha') }}" alt="Captcha"
													class="w-full rounded border border-gray-300 dark:border-gray-600" />
											</div>
											<button type="button" id="refresh-captcha" class="btn btn-outline-primary px-4 py-2"
												title="Refresh Captcha">
												<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
													stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
													<path d="M3 12a9 9 0 0 1 15-6.7L21 5M21 12a9 9 0 0 1-15 6.7L3 19M9 22h6M9 2h6" />
												</svg>
											</button>
										</div>
									</div>
									<div>
										<label for="captcha_input">Enter Captcha</label>
										<div class="relative text-white-dark">
											<input id="captcha_input" type="text" name="captcha" placeholder="Enter the captcha above"
												class="form-input ps-4 placeholder:text-white-dark @error('captcha') border-red-500 @enderror" />
										</div>
										@error('captcha')
											<p class="mt-1 text-xs text-red-500">{{ $message }}</p>
										@enderror
									</div>
									<div>
										<label class="flex cursor-pointer items-center">
											<input type="checkbox" name="remember" class="form-checkbox bg-white dark:bg-black" />
											<span class="text-white-dark">Remember Me</span>
										</label>
									</div>
									@if ($errors->has('login') || $errors->has('register'))
										<div
											class="rounded-lg border border-red-500 bg-red-50 p-3 text-red-700 dark:bg-red-900/20 dark:text-red-300">
											{{ $errors->first('login') ?? $errors->first('register') }}
										</div>
									@endif
									<button type="submit"
										class="btn btn-gradient !mt-6 w-full border-0 uppercase shadow-[0_10px_20px_-10px_rgba(67,97,238,0.44)]">
										Sign in
									</button>
								</form>
							</div>
							<p class="absolute bottom-6 w-full text-center dark:text-white">
								© <span id="footer-year">{{ date('Y') }}</span>. Optimizing Troubleshooting Mitratel and Management Core
								(OTOMATE)
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<script src="/assets/js/alpine-collaspe.min.js"></script>
		<script src="/assets/js/alpine-persist.min.js"></script>
		<script defer src="/assets/js/alpine-ui.min.js"></script>
		<script defer src="/assets/js/alpine-focus.min.js"></script>
		<script defer src="/assets/js/alpine.min.js"></script>

		<script src="/assets/js/custom.js"></script>

		<script>
			document.addEventListener('alpine:init', () => {
				Alpine.data('scrollToTop', () => ({
					showTopButton: false,
					init() {
						window.onscroll = () => {
							this.scrollFunction();
						};
					},

					scrollFunction() {
						if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
							this.showTopButton = true;
						} else {
							this.showTopButton = false;
						}
					},

					goToTop() {
						document.body.scrollTop = 0;
						document.documentElement.scrollTop = 0;
					},
				}));

				Alpine.data('auth', () => ({}));
			});

			let captchaCountdown = 60;
			let captchaTimer = null;

			function startCaptchaTimer() {
				captchaCountdown = 60;
				updateCountdownDisplay();

				if (captchaTimer) clearInterval(captchaTimer);

				captchaTimer = setInterval(() => {
					captchaCountdown--;
					updateCountdownDisplay();

					if (captchaCountdown <= 0) {
						clearInterval(captchaTimer);
						refreshCaptcha();
						startCaptchaTimer();
					}
				}, 1000);
			}

			function updateCountdownDisplay() {
				const countdownEl = document.getElementById('countdown');
				if (countdownEl) {
					countdownEl.textContent = captchaCountdown;
				}
			}

			function refreshCaptcha() {
				const captchaImg = document.getElementById('captcha-img');
				captchaImg.src = '{{ route('captcha') }}?' + new Date().getTime();
				document.getElementById('captcha_input').value = '';
				document.getElementById('captcha_input').focus();
			}

			document.getElementById('refresh-captcha').addEventListener('click', function(e) {
				e.preventDefault();
				refreshCaptcha();
				startCaptchaTimer();
			});

			window.addEventListener('load', () => {
				startCaptchaTimer();
			});
		</script>
	</body>

</html>
