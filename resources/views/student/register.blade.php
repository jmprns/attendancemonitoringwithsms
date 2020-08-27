@extends('layouts.app')

{{-- HTML Title --}}
@section('html-title')
Register
@endsection

{{-- Top Css --}}
@section('css-top')
<link href="{{ asset('vendor/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('vendor/croppie/croppie.css') }}" rel="stylesheet" type="text/css" />
@endsection

{{-- Bottom Css --}}
@section('css-bot')

@endsection

{{-- Page Title --}}
@section('page-title')
Register
@endsection

{{-- Breadcrumb --}}
@section('breadcrumb')
<li class="active">
	Register
</li>
@endsection

{{-- Main Content --}}
@section('main-content')
<div class="row">
    <div class="col-sm-12">
        <div id="add-student-whirl" class="card-box table-responsive">
            <h4 class="m-t-0 header-title"><b>Add Student</b></h4>
            <p class="text-muted font-13 m-b-30">
                Please fill up the form with correct responding value
            </p>
            <form id="add-student-form" class="form-horizontal" role="form">
              
                <div class="form-group">
                    <label class="col-md-2 control-label">Full Name</label>
                    <div class="col-md-2">
                        <input type="text" id="lname" class="form-control" placeholder="Last Name">
                    </div>
                    <div class="col-md-2">
                        <input type="text" id="fname" class="form-control" placeholder="First Name">
                    </div>
                    <div class="col-md-2">
                        <input type="text" id="mname" class="form-control" placeholder="M.I.">
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group">
                    <label class="col-md-2 control-label">RFID Tag</label>
                    <div class="col-md-6">
                       <input  id="rfid-tag" type="text" class="form-control" placeholder="XXXXXXXXXX" required>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Department</label>
                    <div class="col-md-6">
                       <select id="dept" class="select2 form-control" data-placeholder="Choose Department ...">
                            <option value=""></option>
                            @foreach($years as $year)
                            <option value="{{ $year->id }}">{{ $year->department->name }} - {{ $year->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Phone Number</label>
                    <div class="col-md-6">
                       <input  id="phone-number" type="number" class="form-control" placeholder="09XXXXXXXXXXX" required>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Image</label>
                    <div class="col-md-6">
                        <input type="hidden" id="crop-image" value="">
                       <input type="file" name="upload_image" id="upload_image" accept="image/*" data-buttonbefore="true" class="filestyle">
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
<!-- Modal Image Cropper -->
<div id="uploadimageModal" class="modal" role="dialog">
 <div class="modal-dialog">
  <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Upload & Crop Image</h4>
        </div>
        <div class="modal-body">
          <div class="row">
       <div class="col-md-12 text-center">
        <div id="image_demo"></div>
       </div>
    </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-success crop_image">Crop</button>
        </div>
     </div>
    </div>
</div><!-- /.modal -->
@endsection

{{-- Top Page Js --}}
@section('js-top')
<script src="{{ asset('vendor/select2/js/select2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/croppie/croppie.min.js') }}"></script>
<script src="{{ asset('vendor/croppie/exif.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-filestyle/js/bootstrap-filestyle.min.js') }}"></script>
@endsection

{{-- Bottom Js Script --}}
@section('js-bot')
<script>
$(document).ready(function(){
	$(".select2").select2();

    $image_crop = $('#image_demo').croppie({
        enableExif: true,
        viewport: {
            width:200,
            height:200,
            type:'square' //circle
        },
        boundary:{
            width:300,
            height:300
        }
    });

    $('#upload_image').on('change', function(){
        var reader = new FileReader();
        reader.onload = function (event) {
        $image_crop.croppie('bind', {
            url: event.target.result
        }).then(function(){
          console.log('jQuery bind complete');
        });
        }
        reader.readAsDataURL(this.files[0]);
        $('#uploadimageModal').modal('show');
    });

    $('.crop_image').click(function(event){
        $image_crop.croppie('result', {
            type: 'canvas',
            size: 'viewport',
            format: 'jpeg'
        }).then(function(response){
            console.log(response);
            $('#crop-image').val(response);
            $('#uploadimageModal').modal('toggle');
        })
    });

    $('#add-student-form').submit(function(e){

	    e.preventDefault();

	    $.ajax({
	        url: "/student/store",
	        type: 'POST',
	        dataType: 'json',
	        data:{
	            '_token' : $("meta[name='_token']").attr("content"),
	            'fname'	: $('#fname').val(),
	            'lname' : $('#lname').val(),
	            'mname' : $('#mname').val(),
	            'rfid' : $('#rfid-tag').val(),
	            'dept' : $('#dept').val(),
	            'num' : $('#phone-number').val(),
	            'image' : $('#crop-image').val()

	        },
	        success:function(Result)
	        {   
            	toastr['success']("Student has been registered.");
               	$('#add-student-form').trigger("reset");
                $(".select2").select2();
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
	            var element = document.getElementById('add-student-whirl');
	            element.classList.add("whirl", "traditional");
	        },
	        complete: function(){
	            var element = document.getElementById('add-student-whirl');
	            element.classList.remove("whirl", "traditional");
	        }
	    });
	});

});        
</script>
@endsection