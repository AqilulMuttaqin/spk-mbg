<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">

	<link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="{{ asset('src/img/icon.png') }}" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/pages-sign-in.html" />

	<title>MBG Kota Malang | Login</title>

	<link href="{{ asset('src/css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('src/css/css2.css') }}" rel="stylesheet">
</head>

<body>
	<main class="d-flex w-100">
		<div class="container d-flex flex-column">
			<div class="row vh-100">
				<div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">

						<div class="text-center mt-4">
                            <a href="/login" class="text-nowrap logo-img text-center d-block py-3 w-100">
                                <img src="{{ asset('src/img/dark-logo.png') }}" width="80" alt="">
                            </a>
                            <p class="lead">Sistem Rekomendasi SDN Penerima Program Makan Bergizi Gratis (MBG)</p>
						</div>

						<div class="card">
							<div class="card-body">
								<div class="m-sm-3">
									<form method="POST" action="{{ route('login') }}">
                                        @csrf
										<div class="mb-3">
											<label class="form-label" for="email">Email</label>
											<input class="form-control form-control-lg" type="email" name="email" id="email" placeholder="Enter your email" required/>
										</div>
										<div class="mb-3">
											<label class="form-label" for="password">Password</label>
											<input class="form-control form-control-lg" type="password" name="password" id="password" placeholder="Enter your password" required/>
										</div>
										<div>
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <div class="form-check align-items-center">
                                                    <input type="checkbox" name="remember" id="remember" class="form-check-input" value="remember-me">
                                                    <label class="form-check-label text-small" for="remember">Remember me</label>
                                                </div>
                                                <a class="text-primary fw-bold" href="{{ route('password.request') }}">Forgot Password ?</a>
                                            </div>
										</div>
										<div class="d-grid gap-2 mt-3">
											<button type="submit" class="btn btn-lg btn-primary">Sign in</button>
										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="text-center mb-3">
							Don't have an account? <a href="{{ route('register') }}">Sign up</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>

	<script src="{{ asset('src/js/app.js') }}"></script>
</body>

</html>