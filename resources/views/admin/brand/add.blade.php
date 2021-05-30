@extends('layouts.admin')

@section('content')
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Add New Brand</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Brand</li>
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
                    <a href="{{route('brands.index')}}" class="btn bnt-sm customBtn"> <i class="fa fa-list"></i> Brand List</a>
                  </div>
                  <br>
                </div>
                   <div class="col-lg-12">
                      <form method="POST" name="brand-form" id="brand-form" action="{{route('brands.store')}}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group">
                                <label> Brand Name </label>
                                <input type="text" name="brand_name" class="form-control" placeholder="Enter Brand Name" required>
                            </div>    
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group">
                              <label> Description </label>
                              <textarea class="form-control" name="brand_desc" placeholder="Enter Description"></textarea>
                            </div>    
                          </div>
                        </div>


                        <div class="row">
                          <div class="col-sm-6">
                                <img id="image" / width="100px">
                            <div class="form-group">
                                <label> Brand Image </label> <br>
                               <input type="file" name="brand_image" id="brand_image" accept="image/*" required>
                            </div>    
                          </div>
                        </div>
                        
                      <input type="submit" name="submit" value="submit" class="btn btn-md customBtn">  
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
  document.getElementById('brand_image').onchange = function () {
  var src = URL.createObjectURL(this.files[0])
  document.getElementById('image').src = src
}
</script>
@endsection           