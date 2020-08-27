<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="_token" content="{{ csrf_token() }}">
	<!-- App css -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/core.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/components.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/icons.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/pages.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/menu.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/responsive.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/scan.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendor/whirl/whirl.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendor/toastr/toastr.min.css') }}" rel="stylesheet" type="text/css" />
</head>
<body id="body-whirl" class="">

<div class="row">
	<div class="col-sm-4 row-a-a">
		<span id="time-action"></span>
	</div>
	<div class="col-sm-8 row-a-b">
		<span id="real-time">{{ date('F d, Y h:i:s A') }}</span>
	</div>
</div>
<div class="row">
	<div class="col-sm-4 row-b-a">
		<div class="row">
			<div class="col-sm-12 row-center">
				<img id="student-img" src="{{ asset('images/students/00.png') }}" width="300px" height="300px" style="border: 1px solid black;">
			</div>
			<br><br><br>
			<div class="col-sm-12 row-center">
				<h1 id="student-rfid">0000000000</h1>
			</div>
			<div class="col-sm-12 row-center">
				<form id="attendance-form">
					<input type="text" class="scanCore" id="student-rfid-form" autofocus required>
					<button type="submit" class="btnScanCore" name="scanBtn"></button>
				</form>
			</div>
		</div>
	</div>
	<div class="col-sm-8 row-b-b row-center">
		<div class="row">
			<div class="col-sm-12 row-center">
				<h4><strong>FULL NAME:</strong></h4>
			</div>
			<div class="col-sm-12 row-center">
				<h2 id="student-name"></h2>
			</div>
			<div class="col-sm-12 row-center">
				<h2>============================</h2>
			</div>
			<div class="col-sm-12 row-center">
				<h4><strong>DEPARTMENT:</strong></h4>
			</div>
			<div class="col-sm-12 row-center">
				<h2 id="student-dept"></h2>
			</div>
			<div class="col-sm-12 row-center">
				<h2>============================</h2>
			</div>
			<div class="col-sm-12 row-center">
				<h4><strong>DATE/TIME:</strong></h4>
			</div>
			<div class="col-sm-12 row-center">
				<h2 id="student-time"></h2>
			</div>

		</div>
		
	</div>
</div>
<div class="row">
	<div class="col-sm-12 row-c">REGULAR ATTENDANCE</div>
</div>


<!-- jQuery  -->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/detect.js') }}"></script>
<script src="{{ asset('js/fastclick.js') }}"></script>
<script src="{{ asset('js/jquery.blockUI.js') }}"></script>
<script src="{{ asset('js/waves.js') }}"></script>
<script src="{{ asset('js/jquery.slimscroll.js') }}"></script>
<script src="{{ asset('js/jquery.scrollTo.min.js') }}"></script>
<script src="{{ asset('js/moment.js') }}"></script>
<script src="{{ asset('vendor/toastr/toastr.min.js') }}"></script>

<script type="text/javascript">
$(document).ready(function() {


    var interval = setInterval(function() {
        $('#real-time').html(moment().format('LL LTS'));
    }, 100);

    


    $('#attendance-form').submit(function(e){

	    e.preventDefault();

	    $.ajax({
	        url: "/scan",
	        type: 'POST',
	        dataType: 'json',
	        data:{
	            '_token' : $("meta[name='_token']").attr("content"),
	            'rfid'	: $('#student-rfid-form').val(),
	            'event'	: 0

	        },
	        success:function(Result)
	        {   

            	$('#student-rfid-form').val('');
            	$('#student-rfid-form').focus();

            	$('#student-rfid').html(Result.rfid);
            	$('#student-name').html(Result.name);
            	$('#student-dept').html(Result.dept);
            	$('#student-time').html(Result.date);
            	$('#time-action').html(Result.action);
            	$("#student-img").attr("src", '{{ asset('images/students') }}/'+Result.image);
	        
            	var interval2 = setTimeout(function() {
			       	$('#student-rfid').html('0000000000');
			        $('#student-name').html('');
			        $('#student-dept').html('');
			        $('#student-time').html('');
			        $('#time-action').html('');
			        $("#student-img").attr("src", '{{ asset('images/students') }}/00.png');
			    }, 5000);

	        },
	        error: function(xhr)
	        {
	        	if(xhr.status == 406){
                    var message_er = JSON.parse(xhr.responseText);
                    $('#time-action').html(message_er['message']);
                    $('#student-rfid-form').val('');
            		$('#student-rfid-form').focus();
                }
	        },
	        beforeSend: function(){
	        	
	            var element = document.getElementById('body-whirl');
	            element.classList.add("whirl", "traditional");
	        },
	        complete: function(){
	            var element = document.getElementById('body-whirl');
	            element.classList.remove("whirl", "traditional");
	        }
	    });
	});




});
</script>

</body>
</html>