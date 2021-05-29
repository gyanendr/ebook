@extends('layouts.admin')

@section('content')
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Category Listing</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Category Listing</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card card-primary card-outline">
              <div class="card-body">
                <div class="col-lg-12">
                  <div class="text-right">
                    <a href="{{url('admin/add-category')}}" class="btn bnt-sm btn-success"> <i class="fa fa-plus"></i> Add Category</a>
                  </div>
                  <br>
                </div>
                   <div class="col-lg-12">
                      <table id="example1" class="table table-bordered table-striped" style="width: 100%">
                           <thead>
                               <tr>
                                   <th>Id</th>
                                   <th>Name</th>
                                   <th>Status</th>
                                   <th>Action</th>
                               </tr>
                           </thead>
                           <tbody>

                            @foreach($categories as $row)
                               <tr>
                                   <td>{{$row->id}}</td>
                                   <td>{{$row->category_name}}</td>
                                   <td>
                                    @if($row->status == 1)
                                      <a href="#" class="btn bnt-sm btn-success">Active</a>
                                    @else
                                    <a href="#" class="btn bnt-sm btn-danger">InActive</a>
                                    @endif
                                  </td>
                                  <td>
                                    <a href="{{url('admin/edit-category/'.$row->id)}}" class="btn btn-sm btn-info">Edit</a>
                                    <a class="btn btn-sm btn-danger" href="{{url('admin/delete-category/'.$row->id)}}">Delete</a>
                                  </td>
                                </tr>
                            @endforeach
                           </tbody>
                       </table>
                   </div>
              </div>
            </div><!-- /.card -->
          </div>

        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

@endsection           