@extends('layouts.admin')

@section('content')
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Add New Blog</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Blog</li>
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
                    <a href="{{url('blog-list')}}" class="btn bnt-sm customBtn"> <i class="fa fa-list"></i> Blog Listing</a>
                  </div>
                  <br>
                </div>
                   <div class="col-lg-12">
                      <form method="POST" name="blog-form" id="blog-form" action="{{route('blog.store')}}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group">
                                <label> Title </label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" placeholder="Enter blog Title" required>
                              @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>    
                          </div>

                            <div class="col-sm-6">
                            <div class="form-group">
                                <label> Author </label>
                                <input type="text" name="author" class="form-control @error('author') is-invalid @enderror" placeholder="Enter Author" required>
                              @error('author')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>    
                          </div>

                         
                        </div>


                  <div class="row">                            
                     <div class="col-sm-12">
                        <div class="form-group">
                           <label> Summery </label>
                           <textarea class="form-control summernote @error('summery') is-invalid @enderror" name="summery" id="summernote1" placeholder="Enter Summery" required></textarea>

                            @error('summery')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                           @enderror

                         </div>    
                     </div>

                     <div class="col-sm-12">
                         <div class="form-group">
                           <label>  Description  </label>
                           <textarea class="form-control summernote @error('description') is-invalid @enderror" name="description" id="summernote2" placeholder="Enter Description" required></textarea>

                           @error('description')
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
                        <label> Blog Category </label> <br>
                        <select class="form-control @error('blog_category') is-invalid @enderror" name="blog_category" id="blog_category" required>
                          <option value="">Please select</option>
                           @foreach($adsCategories as $blogcategory)
                            <option value="{{$blogcategory->id}}">{{$blogcategory->name}}</option>
                                @endforeach
                        </select> 
                        @error('blog_category')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                                </span>
                         @enderror
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

@endsection           
