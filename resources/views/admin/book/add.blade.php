@extends('layouts.admin')

@section('content')
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Add Book</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Book</li>
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
                   @if(session()->has('message.level'))
                        @if ($message = Session::get('message.content'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button> 
                                <strong>{{ $message }}</strong>
                        </div>
                        @endif
                  @endif

                  <div class="text-right">
                    <a href="{{url('admin/book-listing')}}" class="btn bnt-sm btn-success"> <i class="fa fa-list"></i> List Book</a>
                  </div>
                  <br>
                </div>
                   <div class="col-lg-12">
                      <form method="post" name="category-form" id="category-form" action="{{url('admin/add-book')}}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group">
                                <label> Choose Category </label>
                               <select class="form-control" name="category">
                                  <option value="">Please select</option>
                                  @foreach($categories as $row)
                                  <option value="{{$row->id}}">{{$row->category_name}}</option>
                                  @endforeach
                               </select>
                            </div>    
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group">
                                <label> Book Name </label>
                                <input type="text" name="book_name" class="form-control" placeholder="Enter Category Name" required>
                            </div>    
                          </div>
                        </div>


                        <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group">
                                <label> Book Price </label>
                                <input type="text" name="book_price" class="form-control" placeholder="Enter Category Name" required>
                            </div>    
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group">
                                <label> Book Image </label>
                                <br>
                               <input type="file" name="book_image" accept="image/*" required>
                            </div>    
                          </div>
                        </div>
                        
                      <input type="submit" name="submit" value="submit" class="btn btn-success">  
                      </form>
                   </div>
              </div>
            </div><!-- /.card -->
          </div>

        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

@endsection           