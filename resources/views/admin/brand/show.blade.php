@extends('layouts.admin')

@section('content')
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Brand Details</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Brand Details</li>
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
                    <a href="{{route('brands.index')}}" class="btn bnt-sm customBtn"> <i class="fa fa-list"></i> Brand Listing</a>
                  </div>
                  <br>
                </div>
                   <div class="col-lg-12">
                      <table id="example1" class="table table-bordered table-striped" style="width: 100%">
                          
                           <tbody>
                               <tr>
                                  <th>Id</th>
                                  <td>{{$getDetails->id}}</td>
                                </tr>
                                  <tr>
                                    <th> Name</th>
                                  <td>{{$getDetails->name}}</td>
                                  </tr>
                                </tr>
                                  <tr>
                                    <th>Description </th>
                                    <td>{{$getDetails->description}}</td>
                                  </tr>
                                  <tr>
                                    <th>Logo </th>
                                    <td><img alt="brand logo" src="{{url('public/brand/'.$getDetails->logo)}}" width="100px"></td>
                                  </tr>                        
                           </tbody>
                       </table>
                      
                   </div>
              </div>
            </div><!-- /.card -->
          </div>

        </div>
       
      </div><!-- /.container-fluid -->
    </div>

@endsection           