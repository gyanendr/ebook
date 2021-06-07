@extends('layouts.layouts')

@section('content')
<!--end::Top-->
<!--begin::Bottom-->

</div>
<style type="text/css">
    .error{color: red;}
    .add_company_div{
        background-color: #fff;
        min-height: 400px;
    }
    #companyForm{
            margin-left: 6%;
    }
</style>
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <h4>Update company account</h4>
                @if(session()->has('message.level'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button> 
                            <strong>Company Updated successfully !</strong>
                    </div>
                 @endif
               
                <div class="row mt-0 mt-lg-3 add_company_div">
                 <form method="post" name="companyForm" class="form-horizontal" action="{{url('super-admin/update-company-account')}}" id="companyForm" autocomplete="off" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="card-body">
                        <div class="row">
                            <div class="symbol symbol-60 symbol-circle symbol-xl-90">
                            <img src="{{url('public/companyLogo/'.$result->company_logo) }}" width="100px">
                        </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4">
                        <div class="form-group">
                            <label>Username :</label>
                            <input type="text" name="username" value="{{ !empty($result->name) ? $result->name : '' }}" class="form-control form-control-solid" placeholder="Enter username" required="" autocomplete="off">
                            @error('username')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                        </div>
                        <div class="col-md-4">
                        <div class="form-group">
                            <label>Email address:</label>
                            <input type="email" name="email" value="{{ !empty($result->email) ? $result->email : '' }}" class="form-control form-control-solid" placeholder="Enter email" required="">
                            @error('email')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Password:</label>
                            <input type="text" name="password" class="form-control form-control-solid" placeholder="Enter password" value="{{ !empty($result->company_pass) ? $result->company_pass : '' }}" required="">
                            @error('password')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    </div>

                    <div class="row">
                        <div class="col-md-4">
                        <div class="form-group">
                            <label>Company name:</label>
                            <input type="text" name="company_name" value="{{ !empty($result->company_name) ? $result->company_name : '' }}" class="form-control form-control-solid" placeholder="Enter company name" required="">
                            @error('company_name')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Location:</label>
                            <input type="text" name="location" class="form-control form-control-solid" placeholder="Enter location" value="{{ !empty($result->location) ? $result->location : '' }}" required="">
                            @error('location')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div> 
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Company logo:</label>
                            <input type="file" class="form-control form-control-solid" 
                            name="company_logo" id="company_logo" accept="image/*">
                            <input type="hidden" name="hiddenCompanyLogo" value="{{ !empty($result->company_logo) ? $result->company_logo : '' }}">
                            @error('company_logo')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    </div>
                    <input type="hidden" name="companyId" value="{{$result->company_id}}">
                    <input type="hidden" name="userId" value="{{$result->id}}">
                        <button type="submit" class="btn btn-primary mr-2">Update Details</button>
                    </div>
                   </form>
              </div>
            </div>
           
        </div>
        
    </div>
    

@endsection           