@extends('layouts.admin')

@section('content')
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit Category</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Category</li>
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
                    <a href="{{url('category-list')}}" class="btn bnt-sm btn-success"> <i class="fa fa-list"></i> List Category</a>
                  </div>
                  <br>
                </div>
                    <form method="post" name="category-form" id="category-form" action="{{route('category.update',$getDetails->id)}}" enctype="multipart/form-data">
                      @method('PATCH')   
                     {{ csrf_field() }}
                     <div class="row">
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label> Category </label>
                              <input type="text" name="category_name" class="form-control" placeholder="Enter Category Name " value="{{$getDetails->category_name}}" required>
                              @error('category_name')
                              <div class="alert alert-danger" role="alert">
                                 {{$message}}    
                              </div>
                              @enderror
                           </div>
                        </div>
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label> Digital </label>
                              <input type="text" id="digital" name="digital" class="form-control" placeholder="Enter Digital" value=" {{$getDetails->digital}}" required>
                              @error('digital')
                              <div class="alert alert-danger" role="alert">
                                 {{$message}}    
                              </div>
                              @enderror
                           </div>
                        </div>
                        <div class="col-md-6">
                           <label for="" class="">Brand </label>
                           <select id="data_brands" name="data_brands[]" class="form-control select2 "  multiple=",multiple" >
                        
                              @foreach($brands as $brand)
                              <option  value="{{$brand->id.':::'.$brand->name}}" {{(in_array($brand->id,$brand_id)) ? 'selected=' : ''}}> 
                                 {{$brand->name}}
                              </option>
                              @endforeach
                           </select>
                           @error('data_brands')
                           <div class="alert alert-danger" role="alert">
                              {{$message}}    
                           </div>
                           @enderror                       
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label for="" class="">SubCategory </label>
                              <select id="data_subdets" name="data_subdets[]" class="form-control select2" multiple="multiple" >
                                 <option value="" >Select</option>
                  
                                     @foreach($subcategories as $subcategory)      


                                 <option value="{{$subcategory->id}}" {{(in_array($subcategory->id,$sub_cat)) ? 'selected=' : ''}}> {{$subcategory->sub_category_name}}</option>
                                 @endforeach  
                                                     
                              </select>
                              @error('data_subdets')
                              <div class="alert alert-danger" role="alert">
                                 {{$message}}    
                              </div>
                              @enderror  
                           </div>
                        </div>
                       
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label> Image </label>
                              <input type="file" class="form-control"  id="category_image" name="category_image" value="{{$getDetails->banner}}" accept="image/*">
                              @error('category_image')
                              <div class="alert alert-danger" role="alert">
                                 {{$message}}    
                              </div>
                              @enderror
                           </div>
                           @error('banner')
                           <div class="alert alert-danger" role="alert">
                              {{$message}}    
                           </div>
                           @enderror 
                          @if(!empty($getDetails->banner))
                            <img src="{{url('category/'.$getDetails->banner)}}" id="image" width="100px">
                          @endif 
                          <input type="hidden" name="hiddenBanner" value="{{$getDetails->banner}}">
                          
                        </div>

                        
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label>Description  </label>                           
                              <textarea class="form-control rounded-0" id="description" name="description" value="" rows="3"> {{$getDetails->description}}</textarea>
                              @error('description')
                              <div class="alert alert-danger" role="alert">
                                 {{$message}}    
                              </div>
                              @enderror  
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-sm-4">
                        </div>
                        <div class="col-sm-4 ">
                           <div class="form-group ">
                              <input type="submit" name="submit"   value="submit" class="btn customBtn btn-block "> 
                           </div>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
            <!-- /.card -->
         </div>
      </div>
      <!-- /.row -->
   </div>
   <!-- /.container-fluid -->
</div>
<script type="text/javascript">
  document.getElementById('category_image').onchange = function () {
  var src = URL.createObjectURL(this.files[0])
  document.getElementById('image').src = src
}
</script>

@endsection           