@extends('layouts.app')

{{-- HTML Title --}}
@section('html-title')
Register
@endsection

{{-- Top Css --}}
@section('css-top')

@endsection

{{-- Bottom Css --}}
@section('css-bot')

@endsection

{{-- Page Title --}}
@section('page-title')
Profile
@endsection

{{-- Breadcrumb --}}
@section('breadcrumb')
@endsection

{{-- Main Content --}}
@section('main-content')
<div class="row">
    <div class="col-sm-6">
        <div id="edit-user-whirl" class="card-box table-responsive">
            <h4 class="m-t-0 header-title"><b>Profile</b></h4>
            <p class="text-muted font-13 m-b-30">
                Please fill up the form with correct responding value
            </p>
            <form id="edit-user-form" class="form-horizontal" role="form">
                <div class="form-group">
                    <label class="col-md-3 control-label">Full Name</label>
                    <div class="col-md-3">
                        <input type="text" id="lname" class="form-control" value="{{ Auth::user()->lname }}" placeholder="Last Name" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" id="fname" class="form-control" value="{{ Auth::user()->fname }}" placeholder="First Name" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" id="mname" class="form-control" value="{{ Auth::user()->mname }}" placeholder="M.I.">
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Email Address</label>
                    <div class="col-md-9">
                       <input  id="user-email" type="email" class="form-control" placeholder="Email Address" value="{{ Auth::user()->email }}" readonly required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2"></label>
                    <div class="col-md-10">
                        <button type="reset" class="btn btn-danger btn-bordered waves-effect m-t-10 waves-light">Reset</button>
                        <button type="submit" class="btn btn-success btn-bordered waves-effect m-t-10 waves-light">Save</button>
                    </div>
                    </div>
            </form>
        </div>
    </div>
    <div class="col-sm-6">
        <div id="edit-pass-whirl" class="card-box table-responsive">
            <h4 class="m-t-0 header-title"><b>Change Password</b></h4>
            <p class="text-muted font-13 m-b-30">
                Please fill up the form with correct responding value
            </p>
            <form id="edit-pass-form" class="form-horizontal" role="form">
  
                <div class="form-group">
                    <label class="col-md-3 control-label">Old Password</label>
                    <div class="col-md-9">
                       <input  id="old-pass" type="password" class="form-control" placeholder="Old Password" required>
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="form-group">
                    <label class="col-md-3 control-label">New Password</label>
                    <div class="col-md-9">
                       <input id="new-pass" type="text" class="form-control" placeholder="New Password" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2"></label>
                    <div class="col-md-10">
                        <button type="reset" class="btn btn-danger btn-bordered waves-effect m-t-10 waves-light">Reset</button>
                        <button type="submit" class="btn btn-success btn-bordered waves-effect m-t-10 waves-light">Save</button>
                    </div>
                    </div>
            </form>
        </div>
    </div>
</div>
@endsection

{{-- Top Page Js --}}
@section('js-top')
@endsection

{{-- Bottom Js Script --}}
@section('js-bot')
<script>
$(document).ready(function(){

    $('#edit-user-form').submit(function(e){

	    e.preventDefault();

	    $.ajax({
	        url: "/settings/profile",
	        type: 'POST',
	        dataType: 'json',
	        data:{
	            '_token' : $("meta[name='_token']").attr("content"),
	            'fname'	: $('#fname').val(),
	            'lname' : $('#lname').val(),

	        },
	        success:function(Result)
	        {   
            	toastr['success']("Profile has been updated.");
	        },
	        error: function(xhr)
	        {
	        	if(xhr.status == 422){
	        		toastr['error']("Certain fields are required!");
	        	}else if(xhr.status == 406){
                    var message_er = JSON.parse(xhr.responseText);
                    toastr['error'](message_er['message']);
                }else if(xhr.status == 500){
	        		toastr['error']("Server error.");
	        	}else{
	        		toastr['error']("Something went wrong.");
	        	}
	            
	        },
	        beforeSend: function(){
	            var element = document.getElementById('edit-user-whirl');
	            element.classList.add("whirl", "traditional");
	        },
	        complete: function(){
	            var element = document.getElementById('edit-user-whirl');
	            element.classList.remove("whirl", "traditional");
	        }
	    });
	});

	$('#edit-pass-form').submit(function(e){

	    e.preventDefault();

	    $.ajax({
	        url: "/settings/profile/password",
	        type: 'POST',
	        dataType: 'json',
	        data:{
	            '_token' : $("meta[name='_token']").attr("content"),
	            'old'	: $('#old-pass').val(),
	            'new' : $('#new-pass').val()

	        },
	        success:function(Result)
	        {   
            	toastr['success']("Password has been updated.");
            	$('#edit-pass-form').trigger("reset");
	        },
	        error: function(xhr)
	        {
	        	if(xhr.status == 422){
	        		toastr['error']("All fields are required!");
	        	}else if(xhr.status == 406){
                    var message_er = JSON.parse(xhr.responseText);
                    toastr['error'](message_er['message']);
                }else if(xhr.status == 500){
	        		toastr['error']("Server error.");
	        	}else{
	        		toastr['error']("Something went wrong.");
	        	}
	            
	        },
	        beforeSend: function(){
	            var element = document.getElementById('edit-pass-whirl');
	            element.classList.add("whirl", "traditional");
	        },
	        complete: function(){
	            var element = document.getElementById('edit-pass-whirl');
	            element.classList.remove("whirl", "traditional");
	        }
	    });
	});

});        
</script>
@endsection