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
            <div class="card card-warning card-outline">
              <div class="card-body">
                <div class="col-lg-12">
                  <div class="text-right">
                    <a href="{{route('category.create')}}" class="btn bnt-sm customBtn"> <i class="fa fa-plus"></i> Add Category</a>
                  </div>
                  <br>
                </div>
                   <div class="col-lg-12">
                      <table id="example1" class="table table-bordered table-striped" style="width: 100%">
                           <thead>
                               <tr>
                                   <th>Id</th>
                                   <th>Category</th>
                                   <th>Description</th>
                                   <th>Brands</th>
                                   <th>Image</th>
                                   <th>Action</th>
                               </tr>
                           </thead>
                           <tbody>

                            @foreach($categories as $row)
                               <tr>
                                   <td>{{$row->id}}</td>
                                   <td>{{$row->category_name}}</td>
                                   <td>{{$row->description}}</td>
                                   <td><?php
                                    $tmpBrands =  explode(';;;;;;', $row->data_brands);
                                    foreach ($tmpBrands as $row2) {
                                      $brandArr = str_replace(':::', '-',$row2);
                                      echo $brandArr.', ';
                                    }
                                   ?>
                                  </td>
                                   <td>
                                    <img src="{{url('category/'.$row->banner)}}" width="100px">
                                  </td>
                                  <td>
                                    <a href="{{route('category.edit', $row->id)}}" class="btn btn-xs customBtn"><i class="fa fa-edit"></i> 
                                    </a>
                                    
                                  </td>
                                </tr>
                            @endforeach
                           </tbody>
                       </table>
                       <div class="d-flex justify-content-center">
                          {!! $categories->links() !!}
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