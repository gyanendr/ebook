@extends('layouts.admin')

@section('content')
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Brand Listing</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Brand Listing</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card card-primary card-outline ">
              <div class="card-body">
                <div class="col-lg-12">
                   @if(session()->has('message.level'))
                        @if ($message = Session::get('message.content'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button> 
                                <strong>{{ $message }}</strong>
                        </div>
                        @endif
                  @endif


                  <div class="text-right">
                    <a href="{{route('brands.create')}}" class="btn bnt-sm customBtn"> <i class="fa fa-plus"></i> Add New Brand</a>
                  </div>
                  <br>
                </div>
                   <div class="col-lg-12">
                      <table id="example1" class="table table-bordered table-striped" style="width: 100%">
                           <thead>
                               <tr>
                                   <th>Id</th>
                                   <th>Name</th>
                                   <th>Description</th>
                                   <th>Logo</th>
                                   <th>Action</th>
                               </tr>
                           </thead>
                           <tbody>

                            @foreach($brands as $row)
                               <tr>
                                  <td>{{$row->id}}</td>
                                  <td>{{$row->name}}</td>
                                  <td>{{$row->description}}</td>
                                  <td>
                                    <img alt="brand logo" src="{{url('brand/'.$row->logo)}}" width="100px">
                                  </td>
                                  <td>
                                    <a href="{{route('brands.edit', $row->id)}}" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></a>

                                    <a href="{{route('brands.show', $row->id)}}" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i></a>
                                    
                                    <form action="{{ route('brands.destroy', $row->id) }}" method="POST" style="display: inline-block;">
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
                          {!! $brands->links() !!}
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