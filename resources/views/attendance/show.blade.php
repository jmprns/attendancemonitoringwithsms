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
Event Attendance <small>({{ $event->name }})</small>
@endsection

{{-- Breadcrumb --}}
@section('breadcrumb')
<a href="/scan/event/{{ $event->id }}" target="_new" class="btn btn-default">Open Scanning Page</a>
@endsection

{{-- Main Content --}}
@section('main-content')
<table id="datatable" class="table table-striped table-bordered">
    <thead>
    <tr>
        <th>Date (yyyy-mm-dd)</th>
        <th>Name</th>
        <th>Department - Year</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach($attendance as $att)
    <tr>
        <td>{{ date('Y-m-d h:i A', $att->timestamp) }}</td>
        <td>{{ $att->student->lname }}, {{ $att->student->fname }} {{ $att->student->mname }}.</td>
        <td>{{ $att->student->year->department->name }} - {{ $att->student->year->name }}</td>
        <td>@if($att->action == 0) TIME IN @else TIME OUT @endif</td>
    </tr>
    @endforeach
    </tbody>
</table>
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
    $('#datatable').dataTable({
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
            responsive: !0,
        "order": [[ 0, "desc" ]]
    });
</script>
@endsection