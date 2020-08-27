@extends('layouts.app')

{{-- HTML Title --}}
@section('html-title')
Attendance
@endsection

{{-- Top Css --}}
@section('css-top')
<!-- DataTables -->
<link href="{{ asset('vendor/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('vendor/datatables/buttons.bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('vendor/datatables/dataTables.bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection

{{-- Bottom Css --}}
@section('css-bot')

@endsection

{{-- Page Title --}}
@section('page-title')
Events
@endsection

{{-- Breadcrumb --}}
@section('breadcrumb')
<button class="btn btn-default" data-toggle="modal" data-target="#add-event">Add event</button>
@endsection

{{-- Main Content --}}
@section('main-content')
<table id="datatable" class="table table-striped table-bordered">
    <thead>
    <tr>
        <th>#</th>
        <th>Event Name</th>
        <th>Start</th>
        <th>End</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach($events as $event)
    <tr>
        <td></td>
        <td><a href="/attendance/events/show/{{ $event->id }}"><b>{{ $event->name }}</b></a></td>
        <td>{{ date('Y-m-d h:i A', $event->start) }}</td>
        <td>{{ date('Y-m-d h:i A', $event->end) }}</td>
        <td align="center">
            <a href="/scan/event/{{ $event->id }}" class="table-action-btn h3" title="Open Scanning Page"><i class="mdi mdi-barcode-scan text-primary"></i></a>
            <a href="javascript:void(0)" data-toggle="modal" data-target="#edit-event" onclick="editEvent('{{ $event->id }}', '{{ $event->name }}', '{{ date('Y-m-d', $event->start) }}', '{{ date('H:i', $event->start) }}', '{{ date('Y-m-d', $event->end) }}', '{{ date('H:i', $event->end) }}')" class="table-action-btn h3" title="Edit"><i class="mdi mdi-pencil-box-outline text-success"></i></a>
            <a href="javascript:void(0)" onclick="deleteEvent('{{ $event->id }}')" class="table-action-btn h3" title="Delete"><i class="mdi mdi-close-box-outline text-danger"></i></a>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>

<!-- Modal Add -->
<div id="add-event" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content" id="add-event-whirl">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Add Event</h4>
            </div>
            <div class="modal-body">
            <form id="add-event-form" method="POST">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="field-3" class="control-label">Event Name</label>
                            <input type="text" id="name" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-1" class="control-label">Start Date</label>
                            <input type="date" id="startDate" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-2" class="control-label">Start Time</label>
                            <input type="time" id="startTime" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-1" class="control-label">End Date</label>
                            <input type="date" id="endDate" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-2" class="control-label">End Time</label>
                            <input type="time" id="endTime" class="form-control">
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                <button id="add-btn" type="submit" class="btn btn-info waves-effect waves-light">Add</button>
            </div>
        </form>
        </div>
    </div>
</div><!-- /.modal -->

<!-- Modal Edit -->
<div id="edit-event" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div id="edit-event-whirl" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Edit Event</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="field-3" class="control-label">Event Name</label>
                            <input type="hidden" id="edit-id" value="">
                            <input type="text" class="form-control" id="edit-name" value="">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-1" class="control-label">Start Date</label>
                            <input type="date" class="form-control" id="edit-sd" value="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-2" class="control-label">Start Time</label>
                            <input type="time" class="form-control" id="edit-st" value="">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-1" class="control-label">End Date</label>
                            <input type="date" class="form-control" id="edit-ed" value="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-2" class="control-label">End Time</label>
                            <input type="time" class="form-control" id="edit-et" value="">
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                <button type="submit" onclick="edit_event()" class="btn btn-info waves-effect waves-light">Save changes</button>
            </div>
        </div>
    </div>
</div><!-- /.modal -->
@endsection

{{-- Top Page Js --}}
@section('js-top')
<script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendor/datatables/dataTables.bootstrap.js')}}"></script>

<script src="{{asset('vendor/datatables/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('vendor/datatables/buttons.bootstrap.min.js')}}"></script>
<script src="{{asset('vendor/datatables/jszip.min.js')}}"></script>
<script src="{{asset('vendor/datatables/pdfmake.min.js')}}"></script>
<script src="{{asset('vendor/datatables/vfs_fonts.js')}}"></script>
<script src="{{asset('vendor/datatables/buttons.html5.min.js')}}"></script>
<script src="{{asset('vendor/datatables/buttons.print.min.js')}}"></script>
<script src="{{asset('vendor/datatables/dataTables.fixedHeader.min.js')}}"></script>
<script src="{{asset('vendor/datatables/dataTables.keyTable.min.js')}}"></script>
<script src="{{asset('vendor/datatables/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('vendor/datatables/responsive.bootstrap.min.js')}}"></script>
<script src="{{asset('vendor/datatables/dataTables.scroller.min.js')}}"></script>
<script src="{{asset('vendor/datatables/dataTables.colVis.js')}}"></script>
<script src="{{asset('vendor/datatables/dataTables.fixedColumns.min.js')}}"></script>
@endsection

{{-- Bottom Js Script --}}
@section('js-bot')
<script type="text/javascript">
$(document).ready(function () {
    $('#datatable').DataTable({
    dom: "Bfrtip",
            buttons: [{
                extend: "copy",
                className: "btn-sm"
            }, {
                extend: "csv",
                className: "btn-sm"
            }, {
                extend: "excel",
                className: "btn-sm"
            }, {
                extend: "pdf",
                className: "btn-sm"
            }, {
                extend: "print",
                className: "btn-sm"
            }],
            responsive: !0
});
});

$('#add-event-form').submit(function(e){

    e.preventDefault();
    $.ajax({
        url: "/attendance/events/store",
        type: 'POST',
        dataType: 'json',
        data:{
            '_token' : $("input[name='_token']").val(),
            'name' : $('#name').val(),
            'startDate' : $('#startDate').val(),
            'startTime' : $('#startTime').val(),
            'endDate' : $('#endDate').val(),
            'endTime' : $('#endTime').val()
        },
        success:function(Result)
        {     
            alert('Event has been added.');
            $("#add-event").modal('toggle');
            location.reload();
        },
        error:function(xhr){
            if(xhr.status == 406){
                var message_er = JSON.parse(xhr.responseText);
                toastr['error'](message_er['message']);
            }else if(xhr.status == 422){
                toastr['error']("All fields are required!");
            }
        },
        beforeSend: function(){
            var element = document.getElementById('add-event-whirl');
            element.classList.add("whirl", "traditional");
        },
        complete: function(){
            var element = document.getElementById('add-event-whirl');
            element.classList.remove("whirl", "traditional");
        }
    });
});
 
function editEvent(id, name, sd, st, ed, et){
     $('#edit-id').val(id);
     $('#edit-name').val(name);
     $('#edit-sd').val(sd);
     $('#edit-st').val(st);
     $('#edit-ed').val(ed);
     $('#edit-et').val(et);
}

function edit_event()
{
    if(confirm('Update the event?')){
        $.ajax({
        url: "/attendance/events/update",
        type: 'POST',
        dataType: 'json',
        data:{
            '_token' : $("input[name='_token']").val(),
            'id' : $('#edit-id').val(),
            'name' : $('#edit-name').val(),
            'startDate' : $('#edit-sd').val(),
            'startTime' : $('#edit-st').val(),
            'endDate' : $('#edit-ed').val(),
            'endTime' : $('#edit-et').val()
        },
        success:function(Result)
        {     
            alert('Event has been added.');
            $("#edit-event").modal('toggle');
            location.reload();
        },
        error:function(xhr){
            if(xhr.status == 406){
                var message_er = JSON.parse(xhr.responseText);
                toastr['error'](message_er['message']);
            }else if(xhr.status == 422){
                toastr['error']("All fields are required!");
            }
        },
        beforeSend: function(){
            var element = document.getElementById('edit-event-whirl');
            element.classList.add("whirl", "traditional");
        },
        complete: function(){
            var element = document.getElementById('edit-event-whirl');
            element.classList.remove("whirl", "traditional");
        }
    });
    }
}

function deleteEvent(id){
    if(confirm('Delete the event?')){
        window.location = '/attendance/events/delete/'+id;
    }
}
</script>
@endsection