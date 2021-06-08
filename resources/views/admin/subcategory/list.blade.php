@extends('layouts.admin')

@section('content')
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">SubCategory Listing</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">SubCategory Listing</li>
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
                  <div class="text-right">
                    <a href="{{route('subcategory.create')}}" class="btn bnt-sm customBtn"> <i class="fa fa-plus"></i> Add SubCategory</a>
                  </div>
                  <br>
                </div>
                   <div class="col-lg-12">
                      <table id="example1" class="table table-bordered table-striped" style="width: 100%">
                           <thead>
                               <tr>
                                   <th>Id</th>
                                   <th>Category</th>
                                   <th>SubCategory</th>
                                   <th>Image</th>
                                   <th>Action</th>
                               </tr>
                           </thead>
                           <tbody>

                            @foreach($subcategories as $row)
                               <tr>
                                   <td>{{$row->id}}</td>
                                   <td>{{!empty($row->getCategory->category_name) ? $row->getCategory->category_name : ''}}</td>
                                   <td>{{$row->sub_category_name}}</td>
                                   <td> 
                                    <img src="{{url('public/subcategory/'.$row->banner)}}" width="100px">  
                                  </td>
                                    <td>
                                    <a href="{{route('subcategory.edit', $row->id)}}" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></a>

                                    <a href="{{route('subcategory.show', $row->id)}}" class="btn btn-xs customBtn"><i class="fa fa-eye"></i></a>
                                    
                                   <!--  <form action="{{ route('subcategory.destroy', $row->id) }}" method="POST" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button class="btn btn-xs btn-danger"><i class="fa fa-trash-alt"></i></button>
                                    </form> -->
                                    
                                  </td>
                                </tr>
                            @endforeach
                           </tbody>
                       </table>

                       <div class="d-flex justify-content-center">
                          {!! $subcategories->links() !!}
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