@extends('layouts.admin')

@section('content')
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Add SubCategory</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add SubCategory</li>
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
                    <a href="{{route('subcategory.index')}}" class="btn bnt-sm customBtn"> <i class="fa fa-list"></i> List SubCategory</a>
                  </div>
                  <br>
                </div>
                   <div class="col-lg-12">
                      <form method="post" name="subcategory-form" id="subcategory-form" action="{{route('subcategory.store')}}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group">
                              <label> SubCategory Name </label>
                              <input type="text" name="subcategory_name" class="form-control" placeholder="Enter SubCategory Name" required>
                            </div>
                            
                          </div>
                          <div class="col-sm-6">
                            <label>Category</label>
                            <select class="form-control" name="category">
                                <option value="">Please select</option>
                              @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->category_name}}</option>
                              @endforeach 
                            </select>
                          </div>
                        </div>

                        <div class="row">
                          
                          <div class="col-sm-6">
                            <label>Brand</label>
                            <select class="form-control select2" name="brand[]" data-dropdown-css-class="select2-purple" style="width: 100%;" multiple>
                              <option value="">Please select</option>
                              @foreach($brands as $brand)
                              <option value="{{$brand->id}}">{{$brand->name}}</option>
                              @endforeach
                            </select>
                          </div>

                          <div class="col-sm-6">
                            <div class="form-group">
                              <label> Digital </label>
                              <input type="text" name="digital" class="form-control" placeholder="Enter Digital" required>
                            </div>
                            
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-sm-6">
                                <img id="image" / width="100px">
                            <div class="form-group">
                                <label> SubCategory Image </label> <br>
                               <input type="file" name="subcatImage" id="subcatImage" accept="image/*" required>
                            </div>    
                          </div>
                        </div>

                      <input type="submit" name="submit" value="submit" class="btn customBtn">  
                      </form>
                   </div>
              </div>
            </div><!-- /.card -->
          </div>

        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
<script type="text/javascript">
  document.getElementById('subcatImage').onchange = function () {
  var src = URL.createObjectURL(this.files[0])
  document.getElementById('image').src = src
}
</script>
@endsection           