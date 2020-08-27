@extends('layouts.app')

{{-- HTML Title --}}
@section('html-title')

@endsection

{{-- Top Css --}}
@section('css-top')

@endsection

{{-- Bottom Css --}}
@section('css-bot')
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/croppie/croppie.css') }}">
<link href="{{ asset('vendor/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

{{-- Page Title --}}
@section('page-title')
Edit Student Information
@endsection

{{-- Breadcrumb --}}
@section('breadcrumb')

@endsection

{{-- Main Content --}}
@section('main-content')
<!-- Add Candidate Box -->
<div class="row">
    <div class="col-sm-12">
        <div id="add-student-whirl" class="card-box table-responsive">
            <h4 class="m-t-0 header-title"><b>Edit Student</b></h4>
            <p class="text-muted font-13 m-b-30">
                Please fill up the form with correct responding value
            </p>
            <div class="row">
                <div class="col-md-8">
                    <form id="edit-student-form" class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Full Name</label>
                            <div class="col-md-3">
                                <input type="text" id="lname" value="{{ $student->lname }}" required class="form-control" placeholder="Last Name">
                            </div>
                            <div class="col-md-3">
                                <input type="text" id="fname" value="{{ $student->fname }}" required class="form-control" placeholder="First Name">
                            </div>
                            <div class="col-md-2">
                                <input type="text" id="mname" value="{{ $student->mname }}" required class="form-control" placeholder="MI">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">RFID Tag</label>
                            <div class="col-md-8">
                               <input  id="rfid-tag" type="text" value="{{ $student->rfid }}" class="form-control" placeholder="XXXXXXXXX" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Department & Year</label>
                            <div class="col-md-8">
                                <select id="dept-select" class="form-control" required>
                                    <option>Choose...</option>
                                   @foreach($years as $year)
                                   		<option value="{{ $year->id }}" @if($year->id == $student->id) selected @endif>{{ $year->department->name }} - {{ $year->name }}</option>
                                   @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-3 control-label">Number</label>
                            <div class="col-md-8">
                               <input  id="phone-number" type="text" value="{{ $student->number }}" class="form-control" placeholder="09XXXXXXXXX" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Image</label>
                            <div class="col-md-8">
                                <input type="hidden" id="crop-image" value="">
                               <input type="file" name="upload_image" id="upload_image" accept="image/*" data-buttonbefore="true" class="filestyle">
                            </div>
                        </div>

                        <div class="clearfix"></div>
                        <div class="form-group">
                            <label class="col-md-2"></label>
                            <div class="col-md-10">
                                <button type="reset" class="btn btn-danger btn-bordered waves-effect m-t-10 waves-light">Reset</button>
                                <button type="submit" class="btn btn-success btn-bordered waves-effect m-t-10 waves-light">Submit</button>
                            </div>
                            </div>
                    </form>
                </div>
                <div class="col-md-4">
                    <img id="cand-image" src="{{ asset('images/students') }}/{{ $student->image }}" alt="" class="img-thumbnail">
                </div>
            </div>
            
        </div>
    </div>
</div>

<!-- Modal Add -->
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
<script src="{{ asset('vendor/croppie/croppie.min.js') }}"></script>
<script src="{{ asset('vendor/croppie/exif.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-filestyle/js/bootstrap-filestyle.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>
@endsection

{{-- Bottom Js Script --}}
@section('js-bot')
<script type="text/javascript">
	$("#dept-select").select2();
	$(document).ready(function(){

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
            $('#crop-image').val(response);
            $("#cand-image").attr("src", response);
            $('#uploadimageModal').modal('toggle');
        })
    });

    $('#edit-student-form').submit(function(e){

        e.preventDefault();

        $.ajax({
            url: "/student/update",
            type: 'POST',
            dataType: 'json',
            data:{
                '_token' : $("meta[name='_token']").attr("content"),
                'id' : {{ $student->id }},
                'fname' : $('#fname').val(),
                'lname' : $('#lname').val(),
                'mname' : $('#mname').val(),
                'rfid' : $('#rfid-tag').val(),
                'dept' : $('#dept-select').val(),
                'num' : $('#phone-number').val(),
                'image' : $('#crop-image').val()

            },
            success:function(Result)
            {   
                toastr['success']("Student has been updated.");
                window.location = '/student';
                
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