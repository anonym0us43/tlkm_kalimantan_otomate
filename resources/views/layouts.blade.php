<!DOCTYPE html>
<html lang="en" dir="ltr">

	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<title>@yield('title', 'Home') - OTOMATE</title>
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
		@yield('styles')
	</head>

	<body x-data="main" class="relative overflow-x-hidden font-nunito text-sm font-normal antialiased"
		:class="[$store.app.sidebar ? 'toggle-sidebar' : '', $store.app.theme === 'dark' || $store.app.isDarkMode ? 'dark' : '',
		    $store.app.menu, $store.app.layout, $store.app.rtlClass
		]">
		<div x-cloak class="fixed inset-0 z-50 bg-[black]/60 lg:hidden" :class="{ 'hidden': !$store.app.sidebar }"
			@click="$store.app.toggleSidebar()"></div>

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

		<div class="fixed bottom-6 z-50 ltr:right-6 rtl:left-6" x-data="scrollToTop">
			<template x-if="showTopButton">
				<button type="button"
					class="btn btn-outline-primary animate-pulse rounded-full bg-[#fafafa] p-2 dark:bg-[#060818] dark:hover:bg-primary"
					@click="goToTop">
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

		<div x-data="customizer">
			<div class="fixed inset-0 z-[51] hidden bg-[black]/60 px-4 transition-[display]"
				:class="{ '!block': showCustomizer }" @click="showCustomizer = false"></div>

			<nav
				class="fixed bottom-0 top-0 z-[51] w-full max-w-[400px] bg-white p-4 shadow-[5px_0_25px_0_rgba(94,92,154,0.1)] transition-[right] duration-300 ltr:-right-[400px] rtl:-left-[400px] dark:bg-[#0e1726]"
				:class="{ 'ltr:!right-0 rtl:!left-0': showCustomizer }">
				<a href="javascript:;"
					class="absolute bottom-0 top-0 my-auto flex h-10 w-12 cursor-pointer items-center justify-center bg-primary text-white ltr:-left-12 ltr:rounded-bl-full ltr:rounded-tl-full rtl:-right-12 rtl:rounded-br-full rtl:rounded-tr-full"
					@click="showCustomizer = !showCustomizer">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
						class="h-5 w-5 animate-[spin_3s_linear_infinite]">
						<circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.5" />
						<path opacity="0.5"
							d="M13.7654 2.15224C13.3978 2 12.9319 2 12 2C11.0681 2 10.6022 2 10.2346 2.15224C9.74457 2.35523 9.35522 2.74458 9.15223 3.23463C9.05957 3.45834 9.0233 3.7185 9.00911 4.09799C8.98826 4.65568 8.70226 5.17189 8.21894 5.45093C7.73564 5.72996 7.14559 5.71954 6.65219 5.45876C6.31645 5.2813 6.07301 5.18262 5.83294 5.15102C5.30704 5.08178 4.77518 5.22429 4.35436 5.5472C4.03874 5.78938 3.80577 6.1929 3.33983 6.99993C2.87389 7.80697 2.64092 8.21048 2.58899 8.60491C2.51976 9.1308 2.66227 9.66266 2.98518 10.0835C3.13256 10.2756 3.3397 10.437 3.66119 10.639C4.1338 10.936 4.43789 11.4419 4.43786 12C4.43783 12.5581 4.13375 13.0639 3.66118 13.3608C3.33965 13.5629 3.13248 13.7244 2.98508 13.9165C2.66217 14.3373 2.51966 14.8691 2.5889 15.395C2.64082 15.7894 2.87379 16.193 3.33973 17C3.80568 17.807 4.03865 18.2106 4.35426 18.4527C4.77508 18.7756 5.30694 18.9181 5.83284 18.8489C6.07289 18.8173 6.31632 18.7186 6.65204 18.5412C7.14547 18.2804 7.73556 18.27 8.2189 18.549C8.70224 18.8281 8.98826 19.3443 9.00911 19.9021C9.02331 20.2815 9.05957 20.5417 9.15223 20.7654C9.35522 21.2554 9.74457 21.6448 10.2346 21.8478C10.6022 22 11.0681 22 12 22C12.9319 22 13.3978 22 13.7654 21.8478C14.2554 21.6448 14.6448 21.2554 14.8477 20.7654C14.9404 20.5417 14.9767 20.2815 14.9909 19.902C15.0117 19.3443 15.2977 18.8281 15.781 18.549C16.2643 18.2699 16.8544 18.2804 17.3479 18.5412C17.6836 18.7186 17.927 18.8172 18.167 18.8488C18.6929 18.9181 19.2248 18.7756 19.6456 18.4527C19.9612 18.2105 20.1942 17.807 20.6601 16.9999C21.1261 16.1929 21.3591 15.7894 21.411 15.395C21.4802 14.8691 21.3377 14.3372 21.0148 13.9164C20.8674 13.7243 20.6602 13.5628 20.3387 13.3608C19.8662 13.0639 19.5621 12.558 19.5621 11.9999C19.5621 11.4418 19.8662 10.9361 20.3387 10.6392C20.6603 10.4371 20.8675 10.2757 21.0149 10.0835C21.3378 9.66273 21.4803 9.13087 21.4111 8.60497C21.3592 8.21055 21.1262 7.80703 20.6602 7C20.1943 6.19297 19.9613 5.78945 19.6457 5.54727C19.2249 5.22436 18.693 5.08185 18.1671 5.15109C17.9271 5.18269 17.6837 5.28136 17.3479 5.4588C16.8545 5.71959 16.2644 5.73002 15.7811 5.45096C15.2977 5.17191 15.0117 4.65566 14.9909 4.09794C14.9767 3.71848 14.9404 3.45833 14.8477 3.23463C14.6448 2.74458 14.2554 2.35523 13.7654 2.15224Z"
							stroke="currentColor" stroke-width="1.5" />
					</svg>
				</a>
				<div class="perfect-scrollbar h-full overflow-y-auto overflow-x-hidden">
					<div class="relative pb-5 text-center">
						<a href="javascript:;" class="absolute top-0 opacity-30 hover:opacity-100 ltr:right-0 rtl:left-0 dark:text-white"
							@click="showCustomizer = false">
							<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none"
								stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
								<line x1="18" y1="6" x2="6" y2="18"></line>
								<line x1="6" y1="6" x2="18" y2="18"></line>
							</svg>
						</a>
						<h4 class="mb-1 dark:text-white">TEMPLATE CUSTOMIZER</h4>
					</div>
					<div class="mb-3 rounded-md border border-dashed border-[#e0e6ed] p-3 dark:border-[#1b2e4b]">
						<h5 class="mb-1 text-base leading-none dark:text-white">Color Scheme</h5>
						<p class="text-xs text-white-dark">Overall light or dark presentation.</p>
						<div class="mt-3 grid grid-cols-3 gap-2">
							<button type="button" class="btn"
								:class="[$store.app.theme === 'light' ? 'btn-primary' : 'btn-outline-primary']"
								@click="$store.app.toggleTheme('light')">
								<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
									class="h-5 w-5 shrink-0 ltr:mr-2 rtl:ml-2">
									<circle cx="12" cy="12" r="5" stroke="currentColor" stroke-width="1.5"></circle>
									<path d="M12 2V4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
									<path d="M12 20V22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
									<path d="M4 12L2 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
									<path d="M22 12L20 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
									<path opacity="0.5" d="M19.7778 4.22266L17.5558 6.25424" stroke="currentColor" stroke-width="1.5"
										stroke-linecap="round"></path>
									<path opacity="0.5" d="M4.22217 4.22266L6.44418 6.25424" stroke="currentColor" stroke-width="1.5"
										stroke-linecap="round"></path>
									<path opacity="0.5" d="M6.44434 17.5557L4.22211 19.7779" stroke="currentColor" stroke-width="1.5"
										stroke-linecap="round"></path>
									<path opacity="0.5" d="M19.7778 19.7773L17.5558 17.5551" stroke="currentColor" stroke-width="1.5"
										stroke-linecap="round"></path>
								</svg>
								Light
							</button>
							<button type="button" class="btn"
								:class="[$store.app.theme === 'dark' ? 'btn-primary' : 'btn-outline-primary']"
								@click="$store.app.toggleTheme('dark')">
								<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
									class="h-5 w-5 shrink-0 ltr:mr-2 rtl:ml-2">
									<path
										d="M21.0672 11.8568L20.4253 11.469L21.0672 11.8568ZM12.1432 2.93276L11.7553 2.29085V2.29085L12.1432 2.93276ZM21.25 12C21.25 17.1086 17.1086 21.25 12 21.25V22.75C17.9371 22.75 22.75 17.9371 22.75 12H21.25ZM12 21.25C6.89137 21.25 2.75 17.1086 2.75 12H1.25C1.25 17.9371 6.06294 22.75 12 22.75V21.25ZM2.75 12C2.75 6.89137 6.89137 2.75 12 2.75V1.25C6.06294 1.25 1.25 6.06294 1.25 12H2.75ZM15.5 14.25C12.3244 14.25 9.75 11.6756 9.75 8.5H8.25C8.25 12.5041 11.4959 15.75 15.5 15.75V14.25ZM20.4253 11.469C19.4172 13.1373 17.5882 14.25 15.5 14.25V15.75C18.1349 15.75 20.4407 14.3439 21.7092 12.2447L20.4253 11.469ZM9.75 8.5C9.75 6.41182 10.8627 4.5828 12.531 3.57467L11.7553 2.29085C9.65609 3.5593 8.25 5.86509 8.25 8.5H9.75ZM12 2.75C11.9115 2.75 11.8077 2.71008 11.7324 2.63168C11.6686 2.56527 11.6538 2.50244 11.6503 2.47703C11.6461 2.44587 11.6482 2.35557 11.7553 2.29085L12.531 3.57467C13.0342 3.27065 13.196 2.71398 13.1368 2.27627C13.0754 1.82126 12.7166 1.25 12 1.25V2.75ZM21.7092 12.2447C21.6444 12.3518 21.5541 12.3539 21.523 12.3497C21.4976 12.3462 21.4347 12.3314 21.3683 12.2676C21.2899 12.1923 21.25 12.0885 21.25 12H22.75C22.75 11.2834 22.1787 10.9246 21.7237 10.8632C21.286 10.804 20.7293 10.9658 20.4253 11.469L21.7092 12.2447Z"
										fill="currentColor"></path>
								</svg>
								Dark
							</button>
							<button type="button" class="btn"
								:class="[$store.app.theme === 'system' ? 'btn-primary' : 'btn-outline-primary']"
								@click="$store.app.toggleTheme('system')">
								<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
									class="h-5 w-5 shrink-0 ltr:mr-2 rtl:ml-2">
									<path
										d="M3 9C3 6.17157 3 4.75736 3.87868 3.87868C4.75736 3 6.17157 3 9 3H15C17.8284 3 19.2426 3 20.1213 3.87868C21 4.75736 21 6.17157 21 9V14C21 15.8856 21 16.8284 20.4142 17.4142C19.8284 18 18.8856 18 17 18H7C5.11438 18 4.17157 18 3.58579 17.4142C3 16.8284 3 15.8856 3 14V9Z"
										stroke="currentColor" stroke-width="1.5"></path>
									<path opacity="0.5" d="M22 21H2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
									<path opacity="0.5" d="M15 15H9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
								</svg>
								System
							</button>
						</div>
					</div>

					<div class="mb-3 rounded-md border border-dashed border-[#e0e6ed] p-3 dark:border-[#1b2e4b]">
						<h5 class="mb-1 text-base leading-none dark:text-white">Navigation Position</h5>
						<p class="text-xs text-white-dark">Select the primary navigation paradigm for your app.</p>
						<div class="mt-3 grid grid-cols-3 gap-2">
							<button type="button" class="btn"
								:class="[$store.app.menu === 'horizontal' ? 'btn-primary' : 'btn-outline-primary']"
								@click="$store.app.toggleMenu('horizontal')">
								Horizontal
							</button>
							<button type="button" class="btn"
								:class="[$store.app.menu === 'vertical' ? 'btn-primary' : 'btn-outline-primary']"
								@click="$store.app.toggleMenu('vertical')">
								Vertical
							</button>
							<button type="button" class="btn"
								:class="[$store.app.menu === 'collapsible-vertical' ? 'btn-primary' : 'btn-outline-primary']"
								@click="$store.app.toggleMenu('collapsible-vertical')">
								Collapsible
							</button>
						</div>
						<div class="mt-5 text-primary">
							<label class="mb-0 inline-flex">
								<input x-model="$store.app.semidark" type="checkbox" :value="true" class="form-checkbox"
									@change="$store.app.toggleSemidark()" />
								<span>Semi Dark (Sidebar & Header)</span>
							</label>
						</div>
					</div>
					<div class="mb-3 rounded-md border border-dashed border-[#e0e6ed] p-3 dark:border-[#1b2e4b]">
						<h5 class="mb-1 text-base leading-none dark:text-white">Layout Style</h5>
						<p class="text-xs text-white-dark">Select the primary layout style for your app.</p>
						<div class="mt-3 flex gap-2">
							<button type="button" class="btn flex-auto"
								:class="[$store.app.layout === 'boxed-layout' ? 'btn-primary' : 'btn-outline-primary']"
								@click="$store.app.toggleLayout('boxed-layout')">
								Box
							</button>
							<button type="button" class="btn flex-auto"
								:class="[$store.app.layout === 'full' ? 'btn-primary' : 'btn-outline-primary']"
								@click="$store.app.toggleLayout('full')">
								Full
							</button>
						</div>
					</div>
					<div class="mb-3 rounded-md border border-dashed border-[#e0e6ed] p-3 dark:border-[#1b2e4b]">
						<h5 class="mb-1 text-base leading-none dark:text-white">Direction</h5>
						<p class="text-xs text-white-dark">Select the direction for your app.</p>
						<div class="mt-3 flex gap-2">
							<button type="button" class="btn flex-auto"
								:class="[$store.app.rtlClass === 'ltr' ? 'btn-primary' : 'btn-outline-primary']"
								@click="$store.app.toggleRTL('ltr')">
								LTR
							</button>
							<button type="button" class="btn flex-auto"
								:class="[$store.app.rtlClass === 'rtl' ? 'btn-primary' : 'btn-outline-primary']"
								@click="$store.app.toggleRTL('rtl')">
								RTL
							</button>
						</div>
					</div>

					<div class="mb-3 rounded-md border border-dashed border-[#e0e6ed] p-3 dark:border-[#1b2e4b]">
						<h5 class="mb-1 text-base leading-none dark:text-white">Navbar Type</h5>
						<p class="text-xs text-white-dark">Sticky or Floating.</p>
						<div class="mt-3 flex items-center gap-3 text-primary">
							<label class="mb-0 inline-flex">
								<input x-model="$store.app.navbar" type="radio" value="navbar-sticky" class="form-radio"
									@change="$store.app.toggleNavbar()" />
								<span>Sticky</span>
							</label>
							<label class="mb-0 inline-flex">
								<input x-model="$store.app.navbar" type="radio" value="navbar-floating" class="form-radio"
									@change="$store.app.toggleNavbar()" />
								<span>Floating</span>
							</label>
							<label class="mb-0 inline-flex">
								<input x-model="$store.app.navbar" type="radio" value="navbar-static" class="form-radio"
									@change="$store.app.toggleNavbar()" />
								<span>Static</span>
							</label>
						</div>
					</div>

					<div class="mb-3 rounded-md border border-dashed border-[#e0e6ed] p-3 dark:border-[#1b2e4b]">
						<h5 class="mb-1 text-base leading-none dark:text-white">Router Transition</h5>
						<p class="text-xs text-white-dark">Animation of main content.</p>
						<div class="mt-3">
							<select x-model="$store.app.animation" class="form-select border-primary text-primary"
								@change="$store.app.toggleAnimation()">
								<option value="">None</option>
								<option value="animate__fadeIn">Fade</option>
								<option value="animate__fadeInDown">Fade Down</option>
								<option value="animate__fadeInUp">Fade Up</option>
								<option value="animate__fadeInLeft">Fade Left</option>
								<option value="animate__fadeInRight">Fade Right</option>
								<option value="animate__slideInDown">Slide Down</option>
								<option value="animate__slideInLeft">Slide Left</option>
								<option value="animate__slideInRight">Slide Right</option>
								<option value="animate__zoomIn">Zoom In</option>
							</select>
						</div>
					</div>
				</div>
			</nav>
		</div>

		<div class="main-container min-h-screen text-black dark:text-white-dark" :class="[$store.app.navbar]">
			<div :class="{ 'dark text-white-dark': $store.app.semidark }">
				<nav x-data="sidebar"
					class="sidebar fixed bottom-0 top-0 z-50 h-full min-h-screen w-[260px] shadow-[5px_0_25px_0_rgba(94,92,154,0.1)] transition-all duration-300">
					<div class="h-full bg-white dark:bg-[#0e1726]">
						<div class="flex items-center justify-between px-4 py-3">
							<a href="{{ route('home') }}" class="main-logo flex shrink-0 items-center">
								<img class="ml-[5px] w-8 flex-none" src="/logo-otomate-black.png" alt="image" />
								<span class="align-middle text-2xl font-semibold ltr:ml-1.5 rtl:mr-1.5 dark:text-white-light lg:inline">O T O M
									A T E</span>
							</a>
							<a href="javascript:;"
								class="collapse-icon flex h-8 w-8 items-center rounded-full transition duration-300 hover:bg-gray-500/10 rtl:rotate-180 dark:text-white-light dark:hover:bg-dark-light/10"
								@click="$store.app.toggleSidebar()">
								<svg class="m-auto h-5 w-5" width="20" height="20" viewBox="0 0 24 24" fill="none"
									xmlns="http://www.w3.org/2000/svg">
									<path d="M13 19L7 12L13 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
										stroke-linejoin="round" />
									<path opacity="0.5" d="M16.9998 19L10.9998 12L16.9998 5" stroke="currentColor" stroke-width="1.5"
										stroke-linecap="round" stroke-linejoin="round" />
								</svg>
							</a>
						</div>
						<ul
							class="perfect-scrollbar relative h-[calc(100vh-80px)] space-y-0.5 overflow-y-auto overflow-x-hidden p-4 py-0 font-semibold"
							x-data="{ activeDropdown: (window.location.pathname.startsWith('/dashboard') ? 'dashboard' : null) }">

							<li class="nav-item">
								<a href="{{ route('home') }}" class="{{ Request::is('/') ? 'active' : '' }} group nav-link">
									<div class="flex items-center">
										<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path fill-rule="evenodd" clip-rule="evenodd"
												d="M2.5192 7.82274C2 8.77128 2 9.91549 2 12.2039V13.725C2 17.6258 2 19.5763 3.17157 20.7881C4.34315 22 6.22876 22 10 22H14C17.7712 22 19.6569 22 20.8284 20.7881C22 19.5763 22 17.6258 22 13.725V12.2039C22 9.91549 22 8.77128 21.4808 7.82274C20.9616 6.87421 20.0131 6.28551 18.116 5.10812L16.116 3.86687C14.1106 2.62229 13.1079 2 12 2C10.8921 2 9.88939 2.62229 7.88403 3.86687L5.88403 5.10813C3.98695 6.28551 3.0384 6.87421 2.5192 7.82274ZM9 17.25C8.58579 17.25 8.25 17.5858 8.25 18C8.25 18.4142 8.58579 18.75 9 18.75H15C15.4142 18.75 15.75 18.4142 15.75 18C15.75 17.5858 15.4142 17.25 15 17.25H9Z"
												fill="#1C274C" />
										</svg>

										<span class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Home</span>
									</div>
								</a>
							</li>

							<h2
								class="-mx-4 mb-1 flex items-center bg-white-light/30 py-3 px-7 font-extrabold uppercase dark:bg-dark dark:bg-opacity-[0.08]">
								<svg class="hidden h-5 w-4 flex-none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"
									fill="none" stroke-linecap="round" stroke-linejoin="round">
									<line x1="5" y1="12" x2="19" y2="12"></line>
								</svg>
								<span>Dashboard</span>
							</h2>
							<li class="nav-item">
								<ul>
									<li class="nav-item">
										<a href="{{ route('dashboard.monitoring') }}"
											class="{{ Request::is('dashboard/monitoring') ? 'active' : '' }} group nav-link">
											<div class="flex items-center">
												<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
													xmlns="http://www.w3.org/2000/svg">
													<path
														d="M20 13.75C20 13.3358 19.6642 13 19.25 13H16.25C15.8358 13 15.5 13.3358 15.5 13.75V20.5H14V4.25C14 3.52169 13.9984 3.05091 13.9518 2.70403C13.908 2.37872 13.8374 2.27676 13.7803 2.21967C13.7232 2.16258 13.6213 2.09197 13.296 2.04823C12.9491 2.00159 12.4783 2 11.75 2C11.0217 2 10.5509 2.00159 10.204 2.04823C9.87872 2.09197 9.77676 2.16258 9.71967 2.21967C9.66258 2.27676 9.59196 2.37872 9.54823 2.70403C9.50159 3.05091 9.5 3.52169 9.5 4.25V20.5H8V8.75C8 8.33579 7.66421 8 7.25 8H4.25C3.83579 8 3.5 8.33579 3.5 8.75V20.5H2H1.75C1.33579 20.5 1 20.8358 1 21.25C1 21.6642 1.33579 22 1.75 22H21.75C22.1642 22 22.5 21.6642 22.5 21.25C22.5 20.8358 22.1642 20.5 21.75 20.5H21.5H20V13.75Z"
														fill="#1C274C" />
												</svg>
												<span
													class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Monitoring</span>
											</div>
										</a>
									</li>
									<li class="nav-item">
										<a href="{{ route('dashboard.rekoncile') }}"
											class="{{ Request::is('dashboard/rekoncile') ? 'active' : '' }} group nav-link">
											<div class="flex items-center">
												<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
													xmlns="http://www.w3.org/2000/svg">
													<path fill-rule="evenodd" clip-rule="evenodd"
														d="M7.24502 2H16.755C17.9139 2 18.4933 2 18.9606 2.16261C19.8468 2.47096 20.5425 3.18719 20.842 4.09946C21 4.58055 21 5.17705 21 6.37006V20.3742C21 21.2324 20.015 21.6878 19.3919 21.1176C19.0258 20.7826 18.4742 20.7826 18.1081 21.1176L17.625 21.5597C16.9834 22.1468 16.0166 22.1468 15.375 21.5597C14.7334 20.9726 13.7666 20.9726 13.125 21.5597C12.4834 22.1468 11.5166 22.1468 10.875 21.5597C10.2334 20.9726 9.26659 20.9726 8.625 21.5597C7.98341 22.1468 7.01659 22.1468 6.375 21.5597L5.8919 21.1176C5.52583 20.7826 4.97417 20.7826 4.6081 21.1176C3.985 21.6878 3 21.2324 3 20.3742V6.37006C3 5.17705 3 4.58055 3.15795 4.09946C3.45748 3.18719 4.15322 2.47096 5.03939 2.16261C5.50671 2 6.08614 2 7.24502 2ZM7 6.75C6.58579 6.75 6.25 7.08579 6.25 7.5C6.25 7.91421 6.58579 8.25 7 8.25H7.5C7.91421 8.25 8.25 7.91421 8.25 7.5C8.25 7.08579 7.91421 6.75 7.5 6.75H7ZM10.5 6.75C10.0858 6.75 9.75 7.08579 9.75 7.5C9.75 7.91421 10.0858 8.25 10.5 8.25H17C17.4142 8.25 17.75 7.91421 17.75 7.5C17.75 7.08579 17.4142 6.75 17 6.75H10.5ZM7 10.25C6.58579 10.25 6.25 10.5858 6.25 11C6.25 11.4142 6.58579 11.75 7 11.75H7.5C7.91421 11.75 8.25 11.4142 8.25 11C8.25 10.5858 7.91421 10.25 7.5 10.25H7ZM10.5 10.25C10.0858 10.25 9.75 10.5858 9.75 11C9.75 11.4142 10.0858 11.75 10.5 11.75H17C17.4142 11.75 17.75 11.4142 17.75 11C17.75 10.5858 17.4142 10.25 17 10.25H10.5ZM7 13.75C6.58579 13.75 6.25 14.0858 6.25 14.5C6.25 14.9142 6.58579 15.25 7 15.25H7.5C7.91421 15.25 8.25 14.9142 8.25 14.5C8.25 14.0858 7.91421 13.75 7.5 13.75H7ZM10.5 13.75C10.0858 13.75 9.75 14.0858 9.75 14.5C9.75 14.9142 10.0858 15.25 10.5 15.25H17C17.4142 15.25 17.75 14.9142 17.75 14.5C17.75 14.0858 17.4142 13.75 17 13.75H10.5Z"
														fill="#1C274C" />
												</svg>
												<span
													class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Rekoncile</span>
											</div>
										</a>
									</li>
								</ul>
							</li>

							<h2
								class="-mx-4 mb-1 flex items-center bg-white-light/30 py-3 px-7 font-extrabold uppercase dark:bg-dark dark:bg-opacity-[0.08]">
								<svg class="hidden h-5 w-4 flex-none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"
									fill="none" stroke-linecap="round" stroke-linejoin="round">
									<line x1="5" y1="12" x2="19" y2="12"></line>
								</svg>
								<span>Maps & Routing</span>
							</h2>
							<li class="nav-item">
								<ul>
									<li class="nav-item">
										<a href="{{ route('map.upload-kml') }}"
											class="{{ Request::is('map/upload-kml') ? 'active' : '' }} group nav-link">
											<div class="flex items-center">
												<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
													xmlns="http://www.w3.org/2000/svg">
													<path
														d="M21 16.8292V11.1625C21 10.1189 21 9.5971 20.7169 9.20427C20.4881 8.88694 20.1212 8.71828 19.4667 8.49121C19.3328 10.0974 18.8009 11.7377 17.9655 13.1734C16.9928 14.845 15.5484 16.3395 13.697 17.1472C12.618 17.6179 11.382 17.6179 10.303 17.1472C8.45164 16.3395 7.00718 14.845 6.03449 13.1734C5.40086 12.0844 4.9418 10.8778 4.69862 9.65752C4.31607 9.60117 4.0225 9.63008 3.76917 9.77142C3.66809 9.82781 3.57388 9.89572 3.48841 9.97378C3 10.4199 3 11.2493 3 12.9082V17.8379C3 18.8815 3 19.4033 3.28314 19.7961C3.56627 20.189 4.06129 20.354 5.05132 20.684L5.43488 20.8118L5.43489 20.8118C7.01186 21.3375 7.80035 21.6003 8.60688 21.6018C8.8498 21.6023 9.09242 21.5851 9.33284 21.5503C10.131 21.4347 10.8809 21.0597 12.3806 20.3099C13.5299 19.7352 14.1046 19.4479 14.715 19.3146C14.9292 19.2678 15.1463 19.2352 15.3648 19.2169C15.9875 19.1648 16.6157 19.2695 17.8721 19.4789C19.1455 19.6911 19.7821 19.7972 20.247 19.5303C20.4048 19.4396 20.5449 19.321 20.6603 19.1802C21 18.7655 21 18.1201 21 16.8292Z"
														fill="#1C274C" />
													<path fill-rule="evenodd" clip-rule="evenodd"
														d="M12 2C8.68629 2 6 4.55211 6 7.70031C6 10.8238 7.91499 14.4687 10.9028 15.7721C11.5993 16.076 12.4007 16.076 13.0972 15.7721C16.085 14.4687 18 10.8238 18 7.70031C18 4.55211 15.3137 2 12 2ZM12 10C13.1046 10 14 9.10457 14 8C14 6.89543 13.1046 6 12 6C10.8954 6 10 6.89543 10 8C10 9.10457 10.8954 10 12 10Z"
														fill="#1C274C" />
												</svg>
												<span class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Upload
													KML</span>
											</div>
										</a>
									</li>
								</ul>
							</li>

						</ul>
					</div>
				</nav>
			</div>

			<div class="main-content flex min-h-screen flex-col">
				<header class="z-40" :class="{ 'dark': $store.app.semidark && $store.app.menu === 'horizontal' }">
					<div class="shadow-sm">
						<div class="relative flex w-full items-center bg-white px-5 py-2.5 dark:bg-[#0e1726]">
							<div class="horizontal-logo flex items-center justify-between ltr:mr-2 rtl:ml-2 lg:hidden">
								<a href="{{ route('home') }}" class="main-logo flex shrink-0 items-center">
									<img class="inline w-8 ltr:-ml-1 rtl:-mr-1" src="/logo-otomate-black.png" alt="image" />
									<span
										class="hidden align-middle text-2xl font-semibold transition-all duration-300 ltr:ml-1.5 rtl:mr-1.5 dark:text-white-light md:inline">OTOMATE</span>
								</a>

								<a href="javascript:;"
									class="collapse-icon flex flex-none rounded-full bg-white-light/40 p-2 hover:bg-white-light/90 hover:text-primary ltr:ml-2 rtl:mr-2 dark:bg-dark/40 dark:text-[#d0d2d6] dark:hover:bg-dark/60 dark:hover:text-primary lg:hidden"
									@click="$store.app.toggleSidebar()">
									<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M20 7L4 7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
										<path opacity="0.5" d="M20 12L4 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
										<path d="M20 17L4 17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
									</svg>
								</a>
							</div>
							<div x-data="header"
								class="flex items-center space-x-1.5 ltr:ml-auto rtl:mr-auto rtl:space-x-reverse dark:text-[#d0d2d6] sm:flex-1 ltr:sm:ml-0 sm:rtl:mr-0 lg:space-x-2">
								<div class="sm:ltr:mr-auto sm:rtl:ml-auto" x-data="{ search: false }" @click.outside="search = false">
									<form
										class="absolute inset-x-0 top-1/2 z-10 mx-4 hidden -translate-y-1/2 sm:relative sm:top-0 sm:mx-0 sm:block sm:translate-y-0"
										:class="{ '!block': search }" @submit.prevent="search = false">
										<div class="relative">
											<input type="text"
												class="peer form-input bg-gray-100 placeholder:tracking-widest ltr:pl-9 ltr:pr-9 rtl:pl-9 rtl:pr-9 sm:bg-transparent ltr:sm:pr-4 rtl:sm:pl-4"
												placeholder="Search..." />
											<button type="button"
												class="absolute inset-0 h-9 w-9 appearance-none peer-focus:text-primary ltr:right-auto rtl:left-auto">
												<svg class="mx-auto" width="16" height="16" viewBox="0 0 24 24" fill="none"
													xmlns="http://www.w3.org/2000/svg">
													<circle cx="11.5" cy="11.5" r="9.5" stroke="currentColor" stroke-width="1.5"
														opacity="0.5" />
													<path d="M18.5 18.5L22 22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
												</svg>
											</button>
											<button type="button"
												class="absolute top-1/2 block -translate-y-1/2 hover:opacity-80 ltr:right-2 rtl:left-2 sm:hidden"
												@click="search = false">
												<svg width="20" height="20" viewBox="0 0 24 24" fill="none"
													xmlns="http://www.w3.org/2000/svg">
													<circle opacity="0.5" cx="12" cy="12" r="10" stroke="currentColor"
														stroke-width="1.5" />
													<path d="M14.5 9.50002L9.5 14.5M9.49998 9.5L14.5 14.5" stroke="currentColor" stroke-width="1.5"
														stroke-linecap="round" />
												</svg>
											</button>
										</div>
									</form>
									<button type="button"
										class="search_btn rounded-full bg-white-light/40 p-2 hover:bg-white-light/90 dark:bg-dark/40 dark:hover:bg-dark/60 sm:hidden"
										@click="search = ! search">
										<svg class="mx-auto h-4.5 w-4.5 dark:text-[#d0d2d6]" width="20" height="20" viewBox="0 0 24 24"
											fill="none" xmlns="http://www.w3.org/2000/svg">
											<circle cx="11.5" cy="11.5" r="9.5" stroke="currentColor" stroke-width="1.5" opacity="0.5" />
											<path d="M18.5 18.5L22 22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
										</svg>
									</button>
								</div>
								<div>
									<a href="javascript:;" x-cloak x-show="$store.app.theme === 'light'" href="javascript:;"
										class="flex items-center rounded-full bg-white-light/40 p-2 hover:bg-white-light/90 hover:text-primary dark:bg-dark/40 dark:hover:bg-dark/60"
										@click="$store.app.toggleTheme('dark')">
										<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
											<circle cx="12" cy="12" r="5" stroke="currentColor" stroke-width="1.5" />
											<path d="M12 2V4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
											<path d="M12 20V22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
											<path d="M4 12L2 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
											<path d="M22 12L20 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
											<path opacity="0.5" d="M19.7778 4.22266L17.5558 6.25424" stroke="currentColor" stroke-width="1.5"
												stroke-linecap="round" />
											<path opacity="0.5" d="M4.22217 4.22266L6.44418 6.25424" stroke="currentColor" stroke-width="1.5"
												stroke-linecap="round" />
											<path opacity="0.5" d="M6.44434 17.5557L4.22211 19.7779" stroke="currentColor" stroke-width="1.5"
												stroke-linecap="round" />
											<path opacity="0.5" d="M19.7778 19.7773L17.5558 17.5551" stroke="currentColor" stroke-width="1.5"
												stroke-linecap="round" />
										</svg>
									</a>
									<a href="javascript:;" x-cloak x-show="$store.app.theme === 'dark'" href="javascript:;"
										class="flex items-center rounded-full bg-white-light/40 p-2 hover:bg-white-light/90 hover:text-primary dark:bg-dark/40 dark:hover:bg-dark/60"
										@click="$store.app.toggleTheme('system')">
										<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path
												d="M21.0672 11.8568L20.4253 11.469L21.0672 11.8568ZM12.1432 2.93276L11.7553 2.29085V2.29085L12.1432 2.93276ZM21.25 12C21.25 17.1086 17.1086 21.25 12 21.25V22.75C17.9371 22.75 22.75 17.9371 22.75 12H21.25ZM12 21.25C6.89137 21.25 2.75 17.1086 2.75 12H1.25C1.25 17.9371 6.06294 22.75 12 22.75V21.25ZM2.75 12C2.75 6.89137 6.89137 2.75 12 2.75V1.25C6.06294 1.25 1.25 6.06294 1.25 12H2.75ZM15.5 14.25C12.3244 14.25 9.75 11.6756 9.75 8.5H8.25C8.25 12.5041 11.4959 15.75 15.5 15.75V14.25ZM20.4253 11.469C19.4172 13.1373 17.5882 14.25 15.5 14.25V15.75C18.1349 15.75 20.4407 14.3439 21.7092 12.2447L20.4253 11.469ZM9.75 8.5C9.75 6.41182 10.8627 4.5828 12.531 3.57467L11.7553 2.29085C9.65609 3.5593 8.25 5.86509 8.25 8.5H9.75ZM12 2.75C11.9115 2.75 11.8077 2.71008 11.7324 2.63168C11.6686 2.56527 11.6538 2.50244 11.6503 2.47703C11.6461 2.44587 11.6482 2.35557 11.7553 2.29085L12.531 3.57467C13.0342 3.27065 13.196 2.71398 13.1368 2.27627C13.0754 1.82126 12.7166 1.25 12 1.25V2.75ZM21.7092 12.2447C21.6444 12.3518 21.5541 12.3539 21.523 12.3497C21.4976 12.3462 21.4347 12.3314 21.3683 12.2676C21.2899 12.1923 21.25 12.0885 21.25 12H22.75C22.75 11.2834 22.1787 10.9246 21.7237 10.8632C21.286 10.804 20.7293 10.9658 20.4253 11.469L21.7092 12.2447Z"
												fill="currentColor" />
										</svg>
									</a>
									<a href="javascript:;" x-cloak x-show="$store.app.theme === 'system'" href="javascript:;"
										class="flex items-center rounded-full bg-white-light/40 p-2 hover:bg-white-light/90 hover:text-primary dark:bg-dark/40 dark:hover:bg-dark/60"
										@click="$store.app.toggleTheme('light')">
										<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path
												d="M3 9C3 6.17157 3 4.75736 3.87868 3.87868C4.75736 3 6.17157 3 9 3H15C17.8284 3 19.2426 3 20.1213 3.87868C21 4.75736 21 6.17157 21 9V14C21 15.8856 21 16.8284 20.4142 17.4142C19.8284 18 18.8856 18 17 18H7C5.11438 18 4.17157 18 3.58579 17.4142C3 16.8284 3 15.8856 3 14V9Z"
												stroke="currentColor" stroke-width="1.5" />
											<path opacity="0.5" d="M22 21H2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
											<path opacity="0.5" d="M15 15H9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
										</svg>
									</a>
								</div>
								<div class="dropdown flex-shrink-0" x-data="dropdown" @click.outside="open = false">
									<a href="javascript:;" class="group relative" @click="toggle()">
										<span><img class="h-9 w-9 rounded-full object-cover saturate-50 group-hover:saturate-100"
												src="/assets/images/user-profile.jpeg" alt="image" /></span>
									</a>
									<ul x-cloak x-show="open" x-transition x-transition.duration.300ms
										class="top-11 w-[230px] !py-0 font-semibold text-dark ltr:right-0 rtl:left-0 dark:text-white-dark dark:text-white-light/90">
										<li>
											<div class="flex items-center px-4 py-4">
												<div class="flex-none">
													<img class="h-10 w-10 rounded-md object-cover" src="/assets/images/user-profile.jpeg" alt="image" />
												</div>
												<div class="truncate ltr:pl-4 rtl:pr-4">
													<h4 class="text-base">
														{{ session('first_name') }} {{ session('last_name') }}
													</h4>
													<a class="text-black/60 hover:text-primary dark:text-dark-light/60 dark:hover:text-white"
														href="javascript:;">{{ session('nik') }}</a>
												</div>
											</div>
										</li>
										<li>
											<a href="{{ route('profile') }}" class="dark:hover:text-white" @click="toggle">
												<svg class="h-4.5 w-4.5 shrink-0 ltr:mr-2 rtl:ml-2" width="18" height="18" viewBox="0 0 24 24"
													fill="none" xmlns="http://www.w3.org/2000/svg">
													<circle cx="12" cy="6" r="4" stroke="currentColor" stroke-width="1.5" />
													<path opacity="0.5"
														d="M20 17.5C20 19.9853 20 22 12 22C4 22 4 19.9853 4 17.5C4 15.0147 7.58172 13 12 13C16.4183 13 20 15.0147 20 17.5Z"
														stroke="currentColor" stroke-width="1.5" />
												</svg>
												Profile</a>
										</li>
										<li class="border-t border-white-light dark:border-white-light/10">
											<a href="{{ route('logout') }}" class="!py-3 text-danger" @click="toggle">
												<svg class="h-4.5 w-4.5 shrink-0 rotate-90 ltr:mr-2 rtl:ml-2" width="18" height="18"
													viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path opacity="0.5"
														d="M17 9.00195C19.175 9.01406 20.3529 9.11051 21.1213 9.8789C22 10.7576 22 12.1718 22 15.0002V16.0002C22 18.8286 22 20.2429 21.1213 21.1215C20.2426 22.0002 18.8284 22.0002 16 22.0002H8C5.17157 22.0002 3.75736 22.0002 2.87868 21.1215C2 20.2429 2 18.8286 2 16.0002L2 15.0002C2 12.1718 2 10.7576 2.87868 9.87889C3.64706 9.11051 4.82497 9.01406 7 9.00195"
														stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
													<path d="M12 15L12 2M12 2L15 5.5M12 2L9 5.5" stroke="currentColor" stroke-width="1.5"
														stroke-linecap="round" stroke-linejoin="round" />
												</svg>
												Sign Out
											</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</header>

				<div class="animate__animated p-6" :class="[$store.app.animation]">
					<div x-data="layouts">
						<ol class="flex text-gray-500 font-semibold dark:text-white-dark">
							<li>
								<a href="javascript:;"
									class="hover:text-gray-500/70 dark:hover:text-white-dark/70">{{ ucwords(request()->segment(1)) ?: 'Home' }}</a>
							</li>
							@if (request()->segment(2))
								<li
									class="before:w-1 before:h-1 before:rounded-full before:bg-primary before:inline-block before:relative before:-top-0.5 before:mx-4">
									<a href="javascript:;"
										class="text-primary">{{ ucwords(str_replace(['-', '_'], ' ', request()->segment(2))) }}</a>
								</li>
							@endif
							@if (request()->segment(3))
								<li
									class="before:w-1 before:h-1 before:rounded-full before:bg-primary before:inline-block before:relative before:-top-0.5 before:mx-4">
									<a href="javascript:;"
										class="hover:text-gray-500/70 dark:hover:text-white-dark/70">{{ ucwords(str_replace(['-', '_'], ' ', request()->segment(3))) }}</a>
								</li>
							@endif
							@if (request()->segment(4))
								<li
									class="before:w-1 before:h-1 before:rounded-full before:bg-primary before:inline-block before:relative before:-top-0.5 before:mx-4">
									<a href="javascript:;"
										class="hover:text-gray-500/70 dark:hover:text-white-dark/70">{{ ucwords(str_replace(['-', '_'], ' ', request()->segment(4))) }}</a>
								</li>
							@endif
						</ol>

						<div class="pt-5">
							@yield('content')
						</div>
					</div>
				</div>

				<div class="mt-auto p-6 pt-0 text-center dark:text-white-dark ltr:sm:text-left rtl:sm:text-right">
					© <span id="footer-year">{{ date('Y') }}</span>. Optimizing Troubleshooting Mitratel and Management Core
					(OTOMATE)
				</div>
			</div>
		</div>

		<script src="/assets/js/alpine-collaspe.min.js"></script>
		<script src="/assets/js/alpine-persist.min.js"></script>
		<script defer src="/assets/js/alpine-ui.min.js"></script>
		<script defer src="/assets/js/alpine-focus.min.js"></script>
		<script defer src="/assets/js/alpine.min.js"></script>
		<script src="/assets/js/custom.js"></script>

		@include('partial.alerts')

		@yield('scripts')
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

				Alpine.data('customizer', () => ({
					showCustomizer: false,
				}));

				Alpine.data('sidebar', () => ({
					init() {
						const selector = document.querySelector('.sidebar ul a[href="' + window.location
							.pathname + '"]');
						if (selector) {
							selector.classList.add('active');
							const ul = selector.closest('ul.sub-menu');
							if (ul) {
								let ele = ul.closest('li.menu').querySelectorAll('.nav-link');
								if (ele) {
									ele = ele[0];
									setTimeout(() => {
										ele.click();
									});
								}
							}
						}
					},
				}));

				Alpine.data('header', () => ({
					init() {
						const selector = document.querySelector('ul.horizontal-menu a[href="' + window.location
							.pathname + '"]');
						if (selector) {
							selector.classList.add('active');
							const ul = selector.closest('ul.sub-menu');
							if (ul) {
								let ele = ul.closest('li.menu').querySelectorAll('.nav-link');
								if (ele) {
									ele = ele[0];
									setTimeout(() => {
										ele.classList.add('active');
									});
								}
							}
						}
					},
				}));

				Alpine.data('layouts', () => ({
					init() {
						isDark = this.$store.app.theme === 'dark' || this.$store.app.isDarkMode ? true : false;
						isRtl = this.$store.app.rtlClass === 'rtl' ? true : false;

						this.$watch('$store.app.theme', () => {
							isDark = this.$store.app.theme === 'dark' || this.$store.app.isDarkMode ?
								true : false;
						});

						this.$watch('$store.app.rtlClass', () => {
							isRtl = this.$store.app.rtlClass === 'rtl' ? true : false;
						});
					},
				}));
			});
		</script>
	</body>

</html>
