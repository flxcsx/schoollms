@extends('admin/layout')
@section('title','Content')
@section('Dashboard_select','active')
@section('container')

@if(session()->has('success'))
        <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
            <span class="badge badge-pill badge-success"></span>
            {{session('success')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
@endif
<form action="{{url('admin/content/skillattribute/byskillset')}}" method="post">
    @csrf
    <div class="form-row">
        <div class="col-12 col-sm-3 mt-4 mt-sm-0">
            <label>Standard</label>
            <select class="form-control" aria-required="true" aria-invalid="false" name="category" id="category">
                <option value="">Select</option>
                @foreach($category as $list)
                <option value="{{$list->id}}">{{$list->categories}}</option>
                @endforeach 
            </select>
        </div>
        <div class="col-12 col-sm-3 mt-4 mt-sm-0">
            <label>Subject</label>
            <select class="form-control" id="domain" aria-required="true"aria-invalid="false"name="domain">
                <option value="">Select</option>
            </select>
        </div>
        <div class="col-12 col-sm-3 mt-4 mt-sm-0">
            <label>Module</label>
            <select class="form-control" required="true" name="skillset" id="skillset" onchange="yesnoChecked(this)">
                <option selected="selected" value="">Select</option>
            </select>
        </div>

        <div class="col-12 col-sm-3 mt-4 mt-sm-0">
            <label>Action</label><br>
           <a href="{{url('admin/content/skillattribute/addskillattribute')}}">
            <button type="button" class="btn btn-primary">Add</button>  </a>
        </div>
        
        <div class="col-md-6" style="display:flex !important; align-items: flex-end !important;">
            <button type="submit" class="btn btn-sm btn-success" id="getskillattributes" hidden="true">Get Skillset Related
            </button>
        </div>
    </div>
    <div class="form-row mt-4"></div>
</form>


<div class="row">
    <div class="col-md-12">
        <div class="card-body table-responsive p-0">
            <table class="table table-borderless table-data3">
                <thead>
                    <tr>
                        <th>Chapter</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $list)
                    <tr>
                        <td>{{$list->skillattribute}}</td>
                        <td>
                            <a href="{{url('admin/content/skillattribute/addskillattribute')}}/{{$list->id}}"><button type="button" class="btn btn-success">Edit</button>
                            </a>
                            <a href="{{url('admin/content/skillattribute')}}/{{$list->id}}"><button type="button" class="btn btn-danger">Delete</button>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


<script>
  function yesnoChecked(that) {
    if (that.value != "") {
        document.getElementById('getskillattributes').click();    
     } 
  }
</script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

jQuery(document).ready(function(){

           jQuery('#category').change(function (){
             let cid=jQuery(this).val();
             jQuery.ajax({
              url:'{{url("admin/questionbank/getdomain")}}',
              type:'get',
              data:'cid='+cid+
              '&_token={{csrf_token()}}',
              success:function(result){
                jQuery('#domain').html(result)
              }
             });
           });

            jQuery('#domain').change(function (){
            var sid=jQuery(this).val();
             jQuery.ajax({
              url:'{{url("admin/questionbank/getskillset")}}',
              type:'post',
              data:'sid='+sid+
              '&_token={{csrf_token()}}',
              success:function(result){
                jQuery('#skillset').html(result)
              }
             });
           });



});


 

</script>
@endsection