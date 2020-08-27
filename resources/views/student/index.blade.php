@extends('layouts.app')

{{-- HTML Title --}}
@section('html-title')
Student List
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
Student List
@endsection

{{-- Breadcrumb --}}
@section('breadcrumb')

@endsection

{{-- Main Content --}}
@section('main-content')
<table id="datatable" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th width="8%"></th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>RFID Tag</th>
                    <th>Department - Year</th>
                    <th>Phone Number</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($students as $student)
                <tr>
                    <td align="center">
                        <div class="checkbox checkbox-success">
                            <input id="student-checkbox-{{ $student->id }}" name="remember[]" type="checkbox" onchange="check({{ $student->id }})">
                            <label for="student-checkbox-{{ $student->id }}"></label>
                        </div>
                    </td>
                    <td align="center">
                        <a href="javascript:void(0)" onclick="show_images('{{ $student->image }}')">
                            <img src="{{ asset('images/students') }}/{{ $student->image }}" alt="user" class="thumb-sm" />
                        </a>
                    </td>
                    <td>{{ $student->lname }}, {{ $student->fname }} {{ $student->mname }}.</td>
                    <td>{{ $student->rfid }}</td>
                    <td>{{ $student->year->department->name }} - {{ $student->year->name }}</td>
                    <td>{{ $student->number }}</td>
                    <td align="center">
                        <a href="/student/edit/{{ $student->id }}" class="table-action-btn h3"><i class="mdi mdi-pencil-box-outline text-success"></i></a>
                        <a href="javascript:void(0)" onclick="delete_student('{{ $student->id }}')" class="table-action-btn h3"><i class="mdi mdi-close-box-outline text-danger"></i></a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>

            <button class="btn btn-default" onclick="dms()">Delete selected students</button>
{{-- Modal Candidate Image --}}
<div id="modal-student-image" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Student Image</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" style="display: flex; justify-content: center; align-items: center;">
                        <img id="cand-image" src="" alt="" class="img-thumbnail">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
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


function show_images(src){
    $("#cand-image").attr("src", '{{ asset('images/students') }}/'+src);
    $("#modal-student-image").modal('show');
}

function delete_student(id)
{
    if(confirm('Delete the student?')){
        window.location = '/student/delete/'+id;
    }
}

function removeA(arr) {
    var what, a = arguments, L = a.length, ax;
    while (L > 1 && arr.length) {
        what = a[--L];
        while ((ax= arr.indexOf(what)) !== -1) {
            arr.splice(ax, 1);
        }
    }
    return arr;
}

var ids = [];

function check(id){
    if(ids.includes(id) == true){
        removeA(ids, id)
    }else{
        ids.push(id);
    }
}

function dms()
{
    if(confirm('Delete selected students?')){
        $.ajax({
            url: "/student/delete",
            type: 'POST',
            dataType: 'json',
            data:{
                '_token' : $("meta[name='_token']").attr("content"),
                'ids' : ids
            },
            success:function(Result)
            {   
                alert('Success');
                location.reload();
            },
            error:function(xhr)
            {
                alert('Error');
            }
        });
    }
}

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
</script>
@endsection