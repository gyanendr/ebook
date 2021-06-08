@extends('layouts.admin')

@section('content')
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Add New Advertisement</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Advertisement</li>
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
                   @if(session()->has('message.level'))
                        @if ($message = Session::get('message.content'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button> 
                                <strong>{{ $message }}</strong>
                        </div>
                        @endif
                  @endif

                  <div class="text-right">
                    <a href="{{url('advertise-list')}}" class="btn bnt-sm customBtn"> <i class="fa fa-list"></i> Advertisement Listing</a>
                  </div>
                  <br>
                </div>
                <div class="col-lg-12">
                    <form method="POST" name="advertisement-form" id="advertisement-form" action="{{route('advertise.store')}}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                      <div class="row">
                         
                         <div class="col-sm-6">
                           <div class="form-group">
                             <label> Product </label> <br>
                              <select class="form-control @error('product') is-invalid @enderror" name="product" id="product" required>
                                <option value="">Please select</option>
                                   @foreach($products as $product)
                                     <option value="{{$product->id}}">{{$product->title}}</option>
                                   @endforeach
                               </select> 
                              @error('product')
                              <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div> 
                        </div>        

                        <div class="col-sm-6">
                           <div class="form-group">
                             <label> Price </label>
                               <input type="text" name="price" class="form-control @error('price') is-invalid @enderror" placeholder="Enter price" required>
                                 @error('price')
                                  <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                  </span>
                                 @enderror
                            </div>    
                          </div>                        
                   </div>           

                <div class="row">  

                     <div class="col-sm-6">                              
                        <div class="form-group">
                             <label> Advertisement Image </label> <br>
                               <input type="file" name="advertiseImage" id="advertisImage" accept="image/*" required>
                               
                            </div> 
                            <img id="image" / width="100px">  
                      </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                           <label> Status </label> <br>
                            <div class="icheck-primary d-inline">
                                <input type="radio" id="radioPrimary1" name="status" value="1" checked="checked">
                                <label for="radioPrimary1">Active</label>
                            </div>  

                            <div class="icheck-primary d-inline">
                                <input type="radio" id="radioPrimary2" name="status" value="0" >
                                <label for="radioPrimary2">InActive
                                </label>
                              </div>
                        </div>    
                    </div>
                 </div>
                               
                                       

                <div class="row">
                     <div class="col-sm-4">
                     </div>
                     <div class="col-sm-4">
                        <input type="submit" name="submit" value="submit" class="btn btn-md customBtn btn-block">
                      </div>

                </div>                         
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
  document.getElementById('product_image').onchange = function () {
  var src = URL.createObjectURL(this.files[0])
  document.getElementById('image').src = src
  }
</script>

@endsection           
