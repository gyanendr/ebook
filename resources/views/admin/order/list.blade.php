@extends('layouts.admin')

@section('content')
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Order Listing</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Order Listing</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <?php 
      
      $booksArr = [];
      foreach ($books as $book) {
        $booksArr[$book->id] = $book->book_name;
      }

      $usersArr = [];
      foreach ($users as $user) {
        $usersArr[$user->id] = $user->name;
      }


    ?>


    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card card-primary card-outline">
              <div class="card-body">
             
               <div class="col-lg-12">
                      <table id="example1" class="table table-bordered table-striped" style="width: 100%">
                           <thead>
                               <tr>
                                   <th>Order Id</th>
                                   <th>User Name</th>
                                   <th>Book Name</th>
                                   <th>Order Date</th>
                                   <th>Return Date</th>
                                
                               </tr>
                           </thead>
                           <tbody>

                            @foreach($orders as $row)
                               <tr>
                                   <td>{{$row->id}}</td>
                                   <td>{{$usersArr[$row->user_id]}}</td>
                                   <td>{{$booksArr[$row->book_id]}}</td>
                                   <td>{{date('d-m-Y', strtotime($row->created_at))}}</td>
                                   <td>{{date('d-m-Y', $row->return_date)}}</td>
                                  
                                 
                                </tr>
                            @endforeach
                           </tbody>
                       </table>
                   </div>
              
              </div>
            </div><!-- /.card -->
          </div>

        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

@endsection           