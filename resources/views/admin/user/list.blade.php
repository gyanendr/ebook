@extends('layouts.admin')

@section('content')
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Users Listing</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Users Listing</li>
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
                      <table id="example1" class="table table-bordered table-striped" style="width: 100%">
                           <thead>
                               <tr>
                                   <th>Name</th>
                                   <th>Email</th>
                                   <th>Address</th>
                                   <th>Mobile Number</th>
                                   <th>Status</th>
                                   <th>Action</th>
                               </tr>
                           </thead>
                           <tbody>

                            @foreach($users as $row)
                               <tr>
                                  <td>{{$row->name}}</td>
                                  <td>{{$row->email}}</td>
                                  <td>{{$row->address}}</td>
                                  <td>{{$row->mobile_num}}</td>
                                  <td>
                                   @if($row->status == 1)
                                   <a href="javascript:void(0)" class="btn btn-sm btn-success">Active</a>
                                   @else
                                    <a href="javascript:void(0)" class="btn btn-sm btn-warning">InActive</a>
                                   @endif
                                   </td>
                                   <td>
                                    <a href="javascript:void(0)" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></a>

                                    <a href="javascript:void(0)" class="btn btn-xs btn-danger"><i class="fa fa-trash-alt"></i></a>
                                    
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