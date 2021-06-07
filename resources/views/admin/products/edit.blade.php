@extends('layouts.admin')

@section('content')
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit Product Details</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Product</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

  <style type="text/css">
    .bootstrap-tagsinput{
        width: 100%;
    }
    .label-info{
        background-color: #17a2b8;

    }
    .label {
        display: inline-block;
        padding: .25em .4em;
        font-size: 100%;
        font-weight: 700;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: .25rem;
        transition: color .15s ease-in-out,background-color .15s ease-in-out,
        border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    }
</style>

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
                    <a href="{{url('products-list')}}" class="btn bnt-sm customBtn"> <i class="fa fa-list"></i> &nbsp; Product Listing</a>
                  </div>
                  <br>
                </div>
                   <div class="col-lg-12">
                      <form method="POST" name="products-form" id="products-form" action="{{route('products.update', $getDetails->id)}}" enctype="multipart/form-data">
                        @method('PATCH') 
                        {{ csrf_field() }}
                        <div class="row">
                          <div class="col-sm-12">
                            <div class="form-group">
                                <label> Title </label>
                                <input type="text" name="title" value="{{!empty($getDetails->title) ? $getDetails->title : '' }}" class="form-control @error('title') is-invalid @enderror" placeholder="Enter Product Title" required>
                              @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>    
                          </div>
                          <div class="col-sm-12">
                            <div class="form-group">
                              <label> Description </label>
                              <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="summernote" placeholder="Enter Description" required>{{!empty($getDetails->description) ? $getDetails->description : '' }}</textarea>

                              @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror

                            </div>    
                          </div>
                        </div>


                        <div class="row">
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label> Category </label> <br>
                              <select class="form-control @error('category') is-invalid @enderror" name="category" id="category" onchange="getSusbcategory(this)" required>
                                <option value="">Please select</option>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}" {{($category->id == $getDetails->category) ? 'selected' : ''}} >{{$category->category_name}}</option>
                                @endforeach
                              </select> 
                              @error('category')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>    

                          </div>  

                         <div class="col-sm-4">
                            <div class="form-group">
                              <label> SubCategory </label> <br>
                              <select class="form-control @error('subcategory') is-invalid @enderror" name="subcategory" id="subcategory" required>
                                <option value="">Please select</option>
                                 @foreach($subcategories as $subcategory)
                                  <option value="{{$subcategory->id}}" {{($subcategory->id == $getDetails->sub_category) ? 'selected' : ''}} >{{$subcategory->sub_category_name}}</option>
                                @endforeach
                              </select> 

                              @error('subcategory')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror

                            </div>    
                          </div>   


                          <div class="col-sm-4">
                            <div class="form-group">
                              <label> Brand </label> <br>
                              <select class="form-control @error('brand') is-invalid @enderror" name="brand" id="brand" required>
                                <option value="">Please select</option>
                                 @foreach($brands as $brand)
                                <option value="{{$brand->id}}" {{($brand->id == $getDetails->brand) ? 'selected' : ''}}>{{$brand->name}}</option>
                                @endforeach
                              </select> 
                              @error('brand')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror

                            </div>    
                          </div>  
                        </div> 

                        <div class="row">
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Sale Price</label>
                              <input type="text" value="{{!empty($getDetails->sale_price) ? $getDetails->sale_price : '' }}" placeholder="Sale Price" name="sale_price" class="form-control @error('sale_price') is-invalid @enderror" required>
                              @error('sale_price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror

                            </div>
                          </div>

                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Purchase Price</label>
                              <input type="text" value="{{!empty($getDetails->purchase_price) ? $getDetails->purchase_price : '' }}" placeholder="Purchase Price" name="purchase_price" class="form-control @error('purchase_price') is-invalid @enderror" required>
                              @error('purchase_price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                          </div>

                          <div class="col-sm-4">
                            <div class="form-group">
                              <label class="control-lable">Shipping Cost</label>
                              <input type="text" value="{{!empty($getDetails->shipping_cost) ? $getDetails->shipping_cost : '' }}" placeholder="Shipping Cost" name="shipping_cost" class="form-control @error('shipping_cost') is-invalid @enderror" required>

                              @error('shipping_cost')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror

                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label> Tags </label>
                              <input type="text" class="form-control @error('tags') is-invalid @enderror" value="{{!empty($getDetails->tag) ? $getDetails->tag : '' }}" id="tags" name="tags[]" data-role="tagsinput">

                              @error('tags')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror

                            </div>
                          </div>
                          
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label class="control-lable">Current Stock</label>
                              <input type="number" value="{{!empty($getDetails->current_stock) ? $getDetails->current_stock : '' }}" placeholder="Current Stock" min="1" name="current_stock" class="form-control @error('current_stock') is-invalid @enderror" required>
                              
                              @error('current_stock')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror

                            </div>
                          </div>

                          <div class="col-sm-4">
                            <div class="form-group">
                              <label class="control-lable">Discount</label>
                              <input type="number" value="{{!empty($getDetails->discount) ? $getDetails->discount : '' }}" placeholder="Discount" name="discount" class="form-control @error('discount') is-invalid @enderror" required>
                              
                              @error('discount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror

                            </div>
                          </div>

                        </div>

                        <div class="row">
                          <div class="col-lg-12">
                            <div class="form-group">
                            <label>SEO title</label>
                            <input type="text" class="form-control @error('seo_title') is-invalid @enderror" placeholder="SEO title" value="{{!empty($getDetails->seo_title) ? $getDetails->seo_title : '' }}" name="seo_title" required>
                              @error('seo_title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror

                          </div>
                          </div>

                          <div class="col-lg-12">
                            <div class="form-group">
                            <label>SEO Description</label>
                            <textarea class="form-control @error('seo_descr') is-invalid @enderror" placeholder="SEO Description" name="seo_descr" required>{{!empty($getDetails->seo_description) ? $getDetails->seo_description : '' }}</textarea>
                            @error('seo_descr')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                            @enderror

                          </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-lg-12">
                          @if(!empty($getDetails->getProductImages))
                            <div id="preview">
                          @foreach($getDetails->getProductImages as $image)
                            <img src="{{url('products/'.$image->image)}}" width="100px">
                          @endforeach
                            </div>
                          @endif
                       
                            <div id="preview"></div>
                            <div class="form-group">
                              <label>Upload Image </label>
                              <br>
                            <input type="file" class="@error('image') is-invalid @enderror" name="image[]" id="productImage" accept="image/*" multiple>

                              @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror

                          </div>
                        </div>
                        </div>
                        <input type="hidden" name="totalImage" value="{{ !empty($getDetails->getProductImages) ? count($getDetails->getProductImages) : '' }}">
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
  
  function previewImages() {

  var preview = document.querySelector('#preview');
  
  if (this.files) {
    [].forEach.call(this.files, readAndPreview);
  }

  function readAndPreview(file) {

    // Make sure `file.name` matches our extensions criteria
    if (!/\.(jpe?g|png|gif)$/i.test(file.name)) {
      return alert(file.name + " is not an image");
    } // else...
    
    var reader = new FileReader();
    
    reader.addEventListener("load", function() {
      var image = new Image();
      image.height = 100;
      image.width = 100;
      image.title  = file.name;
      image.src    = this.result;
      preview.appendChild(image);
    });
    
    reader.readAsDataURL(file);
    
  }

}

document.querySelector('#productImage').addEventListener("change", previewImages);

  function getSusbcategory(element) {
    var categoryId = $(element).val();
    $('#subcategory').html('');
    $('#subcategory').append('<option value="">Select Details </option>');

     $.ajax({
      url: '{{url("getsubcategory") }}',
      type: 'POST',
      data: {"_token": "{{ csrf_token() }}", categoryId:categoryId },
      success:function(result){
       var res = JSON.parse(result); 
        $.each(res, function(key, value) { 
            $('#subcategory').append("<option  title='" + value.sub_category_name + "' value='" + value.id + "'>" + value.sub_category_name + "</option>");
                           
        });
      }
   });
  return false;
  }
  
</script>
@endsection           