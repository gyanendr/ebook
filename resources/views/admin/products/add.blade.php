@extends('layouts.admin')

@section('content')
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Add New Product</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Product</li>
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
                    <a href="{{url('products-list')}}" class="btn bnt-sm customBtn"> <i class="fa fa-list"></i> Product Listing</a>
                  </div>
                  <br>
                </div>
                   <div class="col-lg-12">
                      <form method="POST" name="products-form" id="products-form" action="{{url('products/store')}}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                          <div class="col-sm-12">
                            <div class="form-group">
                                <label> Title </label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Enter Product Title" required>
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
                              <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="summernote" placeholder="Enter Description" required></textarea>

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
                                <option value="{{$category->id}}">{{$category->category_name}}</option>
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
                                  <option value="{{$subcategory->id}}">{{$subcategory->sub_category_name}}</option>
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
                                <option value="{{$brand->id}}">{{$brand->name}}</option>
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
                              <input type="text" placeholder="Sale Price" name="sale_price" class="form-control @error('sale_price') is-invalid @enderror" value="{{ old('sale_price') }}" required>
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
                              <input type="text" placeholder="Purchase Price" name="purchase_price" class="form-control @error('purchase_price') is-invalid @enderror" value="{{ old('purchase_price') }}" required>
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
                              <input type="text" placeholder="Shipping Cost" name="shipping_cost" class="form-control @error('shipping_cost') is-invalid @enderror" value="{{ old('shipping_cost') }}" required>

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
                              <input type="text" class="form-control @error('tags') is-invalid @enderror" value="" id="tags" name="tags[]" data-role="tagsinput" >

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
                              <input type="number" placeholder="Current Stock" min="1" value="{{ old('current_stock') }}" name="current_stock" class="form-control @error('current_stock') is-invalid @enderror" required>
                              
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
                              <input type="number" placeholder="Discount" name="discount" value="{{ old('discount') }}" class="form-control @error('discount') is-invalid @enderror" required>
                              
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
                            <input type="text" class="form-control @error('seo_title') is-invalid @enderror" placeholder="SEO title" name="seo_title" value="{{ old('seo_title') }}">
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
                            <textarea class="form-control @error('seo_descr') is-invalid @enderror" placeholder="SEO Description" name="seo_descr"></textarea>
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
                            <div id="preview"></div>
                            <div class="form-group">
                              <label>Upload Image</label>
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
