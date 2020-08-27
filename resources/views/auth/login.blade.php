
<!DOCTYPE html>
<html lang="en">
<head>
	<title>WU-P RFID Attendance Monitoring System</title>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="_token" content="{{ csrf_token() }}">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
    
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('logins')}}/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('logins')}}/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('logins')}}/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="{{asset('logins')}}/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('logins')}}/vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('logins')}}/css/util.css">
	<link rel="stylesheet" type="text/css" href="{{asset('logins')}}/css/main.css">
<!--===============================================================================================-->

<style>
    .container-login100{
        background-color: #57b846 !important;
    }
</style>
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				
				<div class="login100-pic js-tilt" data-tilt>
                    <img src="{{asset('images/seal.png')}}" alt="IMG">
				</div>

				<form method="POST" class="login100-form validate-form form-horizontal" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                    @csrf
					<span class="login100-form-title">
						WU-P AURORA ELECTRONIC GATE MONITORING SYSTEM
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" id="email" type="email" placeholder="Email Address" name="email" value="{{ old('email') }}" required autofocus>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100"  id="password" type="password" name="password" placeholder="Password" required>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Login
						</button>
                    </div>
                    
                    <div class="text-center p-t-12">
						.
					</div>

					<div class="text-center p-t-136">
						<a href="/sms/server">Open SMS Server</a>
					</div>
				
				</form>
			</div>
		</div>
	</div>
	
	

	
<!--===============================================================================================-->	
	<script src="{{asset('logins')}}/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="{{asset('logins')}}/vendor/bootstrap/js/popper.js"></script>
	<script src="{{asset('logins')}}/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="{{asset('logins')}}/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="{{asset('logins')}}/vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="{{asset('logins')}}/js/main.js"></script>

</body>
</html>