@extends('nontechmanager/hostel/layout')
@section('title','Infrastructure Items')
@section('Dashboard_select','active')
@section('container')

<style type="text/css">
    td,a,button{
        font-size: 12px;
        word-wrap: break-word !important;
    }
    th{
        font-size: 14px;

    }
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
@if(session()->has('success'))
        <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
            <span class="badge badge-pill badge-success"></span>
            {{session('success')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
    @endif
<form action="{{url('nontech/manager/hostel/bed/byfilter')}}" method="post">
    @csrf
    <div class="form-row">
        <div class="col-12 col-sm-3 mt-4 mt-sm-0">
            <label>Hostels</label>
            <select class="form-control" aria-required="true" aria-invalid="false" name="hostel" id="category">
                <option value="">Select</option>
                @foreach($hostels as $list)
                     <option value="{{$list->id}}">{{$list->hostel}}</option>
                @endforeach 
            </select>
        </div>
        <div class="col-12 col-sm-3 mt-4 mt-sm-0">
            <label>Room</label>
            <select class="form-control" id="domain" aria-required="true"aria-invalid="false" name="roomno" onchange="yesnoChecked(this)">
                <option value="">Select</option>
            </select>
        </div>
        <div class="col-12 col-sm-3 mt-4 mt-sm-0">
            <label>Action</label><br>
            @if(count($data)>0)
                <a href="{{url('nontech/manager/hostel/bed/byfilter/export')}}/{{$aid}}"><button type="button"class="btn btn-success">Export</button></a>
            @endif
        </div>
       
        <div class="col-md-6" style="display:flex !important; align-items: flex-end !important;">
            <button type="submit" class="btn btn-sm btn-success" id="getskillattributes" hidden="true">Get Related Info
            </button>
        </div>
    </div>
    <div class="form-row mt-4"></div>
</form>
<div class="card">
    
    <!-- /.card-header -->
  
         <div class="table-responsive table" style="padding:20px" style="width:100%">
                          
                                      <table id="example1" class="display wrap" style="width:100%">
      <thead>
               
                <tr>
                    <th>Hostel</th>
                    <th>Room Name</th>
                    <th>Bed No</th>
                    <th>Current Status</th>  
                        
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $list)
            <tr>
                  <td>{{$list->hostel}}</td>
                  <td>{{$list->roomname}}</td>
                  <td>{{$list->itemno}}</td>
                  <td>
                      @if($list->stu_id==0)
                       <span class="right badge badge-success">Free</span>
                      @else
                       <span class="right badge badge-danger">Occupied</span>
                      @endif
                  </td>
                  <td>
                    @if($list->stu_id==0)
                       <a href="{{url('nontech/manager/hostel/bed/assign')}}/{{$list->id}}" class="btn btn-sm btn-success">Assign</a>
                      @else
                       <a href="{{url('nontech/manager/hostel/bed/reassign')}}/{{$list->id}}" class="btn btn-sm btn-primary">
                           Re - Assign
                       </a>
                        <a href="{{url('nontech/manager/hostel/bed/retire')}}/{{$list->id}}" class="btn btn-sm btn-danger">Retire</a>
                      @endif
                      
                  </td>
            </tr>
          @endforeach
            </tbody>
       </table>
              </div>

</div>


<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script type="text/javascript"  src=" https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"  defer></script>
    <script type="text/javascript"  src=" https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>


    
 <script type="text/javascript"  src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/pdfmake.min.js" ></script>
    <script type="text/javascript"  src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.1/js/buttons.print.min.js"></script>




<script>
  function yesnoChecked(that) {
    if (that.value != "") {
        document.getElementById('getskillattributes').click();    
     } 
  }

</script>
<script type="text/javascript"> 
  $(document).ready(function() {
   $('#example1').DataTable({
                        dom: 'Bfrtip',
                        buttons: [
                            'copy', 'csv', 'excel', 'pdf', 'print'
                        ]
                    });
} );
</script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

jQuery(document).ready(function(){

           jQuery('#category').change(function (){
            
             
           let cid=jQuery(this).val();
        
                        
           $('#domain').html('');
            $.ajax({
              url:'{{url("nontech/manager/infrastructure/hostels/getroom")}}',
              type:'GET',
              data:{cid:cid},
              dataType: "json",
              success:function(data)
              {
                 $('#domain').prop('disabled', false).append('<option value="">Select</option>');
                 $.each(data, function(key,section)
                 {   
                   
                        $('#domain').prop('disabled', false).append('<option value="'+section.id+'">'+section.roomname+'</option>');
                   
                });
              }
          });
         
           });         

});


 

</script>

@endsection