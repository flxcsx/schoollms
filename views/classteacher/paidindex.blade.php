@extends('classteacher/layout') 
@section('title','Students') 
@section('Dashboard_select','active extra') 
@section('container')
<style type="text/css">
    ::placeholder{
        background-color: blue;
    }
</style> 
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
<div class="container-fluid">
    @if(session()->has('success'))
        <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
            <span class="badge badge-pill badge-success"></span>
            {{session('success')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
    @endif
    <div class="row">
        <div class="col-12">
            <form action="{{url('classteacher/fees/index/students/bysection')}}" method="post">
    @csrf
    <div class="form-row">
        <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display: flex;flex-direction: column;">
            <label>CLASS :</label>
            <select class="form-control" name="class" required id="topbranch" readonly>
                @foreach($classes as $list)
                <option value="{{$list->id}}">{{$list->categories}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display: flex;flex-direction: column;">
            <label>SECTION :</label>
            <select class="form-control" name="section" required id="mainbranch" readonly>
                @foreach($sections as $list)
                <option value="{{$list->id}}">{{$list->section}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display:flex;flex-direction: column;">
            <label>ACTION :</label>
            <button type="submit" class="btn btn-success form-control" id="getjobroles">Fetch</button>
          </div>
        </div>
    </form>   
            <div class="card" style="margin-top:20px">
                <div class="card-header d-flex p-0">
                    <h3 class="card-title p-3">Students List</h3>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="col-12">
                        </div>
                        <div class="tab-pane active" id="tab_1">
                            <div class="table-responsive table" style="padding:20px">
                                <table id="example1" class="display nowrap" style="width:100%   ">
                                    <thead>
                                        <tr>
                                            <th>Registration No</th>
                                            <th>Student</th>
                                            <th>Father</th>
                                            <th>Number</th>
                                            <th>Fees</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($students as $list)
                                        <tr class="tr-shadow">
                                            <td>{{$list->sregistrationnumber}}</td>
                                            <td>{{$list->sname}} {{$list->slname}}</td>
                                            <td>{{$list->sfathername}}</td> 
                                            <td>{{$list->snumber}}</td>
                                            <td>
                                            @if($list->visible==1)
                                            <a href="{{url('classteacher/fees/index/students/view/structure')}}/{{$list->id}}">
                                               <button class="btn btn-primary btn-sm">View</button>
                                            </a>
                                            @else
                                               <button class="btn btn-primary btn-sm disabled">Not Selected By Student</button>
                                            @endif
                                           </td>  
                                           <td>
                                            @if($list->visible==1)
                                            <a href="{{url('classteacher/fees/index/students/export')}}/{{$list->id}}">
                                               <button class="btn btn-info btn-sm">Export</button>
                                            </a>
                                            @else
                                               <button class="btn btn-info btn-sm disabled">Export</button>
                                            @endif
                                           </td>  
                                        </tr>
                                        @endforeach 
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src=" https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js" defer></script>
<script type="text/javascript" src=" https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.1/js/buttons.print.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#example1').DataTable({
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        });
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>   
@endsection