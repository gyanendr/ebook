@extends('layouts.admin')

@section('content')
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit New Brand</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Brand</li>
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
                        <div class="alert customBtn alert-block">
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
                      <form name="brand-form" id="brand-form" action="{{route('brands.update', $getDetails->id)}}" method="post" enctype="multipart/form-data">
                        @method('PATCH')   
                        {{ csrf_field() }}
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group">
                                <label> Brand Name </label>
                                <input type="text" name="brand_name" value="{{!empty($getDetails->name) ? $getDetails->name : '' }}" class="form-control" placeholder="Enter Brand Name" required>
                            </div>    
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group">
                              <label> Description </label>
                              <textarea class="form-control" name="brand_desc" placeholder="Enter Description">{{!empty($getDetails->description) ? $getDetails->description : '' }}</textarea>
                            </div>    
                          </div>
                        </div>


                        <div class="row">
                          <div class="col-sm-6">
                              <img id="image" / width="100px" src="{{!empty($getDetails->logo) ? url('brand/'.$getDetails->logo) : ''}}">
                            <div class="form-group">
                                <label> Brand Image </label> <br>
                              <input type="hidden" name="hiddenLogo" value="{{!empty($getDetails->logo) ? $getDetails->logo : '' }}">  
                              <input type="file" name="brand_image" id="brand_image" accept="image/*">
                            </div>    
                          </div>
                        </div>
                        
                      <input type="submit" name="submit" value="Update" class="btn btn-md customBtn">  
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