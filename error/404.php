<?php include '../templates/header.php'; ?>
	<style>
		.bd-placeholder-img {
			font-size: 1.125rem;
			text-anchor: middle;
			-webkit-user-select: none;
			-moz-user-select: none;
			user-select: none;
		}

		@media (min-width: 768px) {
			.bd-placeholder-img-lg {
				font-size: 3.5rem;
			}
		}

		.b-example-divider {
			height: 3rem;
			background-color: rgba(0, 0, 0, .1);
			border: solid rgba(0, 0, 0, .15);
			border-width: 1px 0;
			box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
		}

		.b-example-vr {
			flex-shrink: 0;
			width: 1.5rem;
			height: 100vh;
		}

		.bi {
			vertical-align: -.125em;
			fill: currentColor;
		}

		.nav-scroller {
			position: relative;
			z-index: 2;
			height: 2.75rem;
			overflow-y: hidden;
		}

		.nav-scroller .nav {
			display: flex;
			flex-wrap: nowrap;
			padding-bottom: 1rem;
			margin-top: -1px;
			overflow-x: auto;
			text-align: center;
			white-space: nowrap;
			-webkit-overflow-scrolling: touch;
		}
		html,
		body {
			height: 100%;
		}

		body {
		  display: flex;
		  align-items: center;
		  padding-top: 40px;
		  padding-bottom: 40px;
		  background-color: #f5f5f5;
		}

		.form-signin {
		  max-width: 500px;
		  padding: 15px;
		}

		.form-signin .form-floating:focus-within {
		  z-index: 2;
		}

		.form-signin input[type="email"] {
		  margin-bottom: -1px;
		  border-bottom-right-radius: 0;
		  border-bottom-left-radius: 0;
		}

		.form-signin input[type="password"] {
		  margin-bottom: 10px;
		  border-top-left-radius: 0;
		  border-top-right-radius: 0;
		}

		#pag_anterior:hover {
			text-decoration: underline black;
		}
    </style>

	<main class="text-center form-signin w-100 m-auto">
	  	<form>
		    <img class="mb-4" src="/error/img_404.png" alt="">

		    <h1 class="h3 mb-3 fw-normal">Error 404 Not Found (Recurso no encontrado)</h1>
		    
		    <p class="fs-6 mb-3 fw-lighter">Ups, como que este link no existe... ¿Te perdiste? Si quieres ve a <a href="/index.html" class="text-reset text-decoration-underline">la página de inicio</a>, o a <a id="pag_anterior" onclick="history.back()">la página anterior</a></p>

	    	<!--p class="mt-5 mb-3 text-muted">&copy; 2017–2022</p-->
	  	</form>
	</main>

<?php include '../templates/footer.php'; ?>