@extends('sub-admin.layouts.master')

@section('content')

<section class="container-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                 <h1>Dashboard</h1>
            </div>
            <div class="col-sm-6">
            </div>
    
        </div>
    </div>

</section>


<section class="content">
    <div class="container-fluid">
        <div class="row mb-2">
                <!-- Default box -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-4 col-md-6">							
                             <div class="small-box card">
                                <div class="inner">
                                    <h3>$0</h3>
                                    <p>Total Orders</p>
                                </div>
                                <div class="icon">
                                     <i class="ion ion-bag"></i>
                                 </div>
                                 <a href="#" class="small-box-footer text-dark">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                                    
                        <div class="col-lg-4 col-md-6">							
                            <div class="small-box card">
                                <div class="inner">
                                    <h3>$0</h3>
                                    <p>Total Customers</p>
                                </div>
                                 <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="#" class="small-box-footer text-dark">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                                    
                        <div class="col-lg-4 col-md-6">							
                            <div class="small-box card">
                                <div class="inner">
                                    <h3>$0</h3>
                                    <p>Total Sale</p>
                                </div>
                                 <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="#" class="small-box-footer text-dark">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>					
            <!-- /.card -->
        </div>
    </div>

</section>
    
@endsection

@section('customJs')
    
@endsection