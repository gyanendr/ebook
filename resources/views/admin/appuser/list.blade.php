@extends('layouts.admin')

@section('content')
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">AppUsers Listing</h1>
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
            <div class="card card-warning card-outline">
              <div class="card-body">
                   <div class="col-lg-12">
                      <table id="example1" class="table table-bordered table-striped" style="width: 100%">
                           <thead>
                               <tr>
                                   <th>Name</th>
                                   <th>Email</th>
                                   <th>Mobile Number</th>
                                   <th>Address</th>
                                   <th>City</th>
                                   <th>Action</th>
                               </tr>
                           </thead>
                           <tbody>

                            @foreach($users as $row)
                               <tr>
                                   <td>{{$row->username.' '.$row->surname}}</td>
                                   <td>{{$row->email}}</td>
                                   <td>{{$row->phone}}</td>
                                   <td>{{$row->address1}}</td>
                                   <td>{{$row->city}}</td>
                                   <td>
                                    <form action="{{ route('appuser.destroy', $row->id) }}" method="POST" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button class="btn btn-xs btn-danger"><i class="fa fa-trash-alt"></i></button>
                                    </form>
                                    
                                  </td>
                               </tr>
                            @endforeach
                           </tbody>
                       </table>

                       <div class="d-flex justify-content-center">
                          {!! $users->links() !!}
                      </div>
                   </div>
              </div>
            </div><!-- /.card -->
          </div>

        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

@endsection           