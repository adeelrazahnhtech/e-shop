@extends('admin.layouts.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        {{-- <div class="col-sm-6">
            <h1>Reviews</h1>
        </div> --}}
         {{-- <!-- <div class="col-sm-6 text-right">
                 <a href="{{('reviews.create')}}"><button class="btn btn-primary">Add</button></a>       
         </div>  --> --}}
    
    </div>
    </div>
    </section>
    
    <section class="content">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-md-12">
          <table class="table table-striped">
            <tr>
                <th>Name</th>
                <th>Role</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
            @if (!empty($subAdmins))
            @foreach ($subAdmins as $user)
                <tr>
                    <td>{{$user->first_name." ".$user->last_name}}</td>
                    <td>{{$user->roleType->role_type}}</td>
                    <td>{{$user->email}}</td>
                    <td style="display: flex;">
                    @if ($user->email_verified_at == null)
                        <a href="{{route('sub_admin.approved',$user->id)}}"><button class="btn btn-primary">Approved</button></a>
                    @else
                        <a href="{{route('sub_admin.disapproved',$user->id)}}"><button class="btn btn-danger">Disapproved</button></a>
                    @endif
                    {{-- <a href="{{route('user.permission',$user->id)}}"><button class="btn btn-success">Permission</button></a> --}}
                    </td>
                </tr>
            @endforeach
            @endif
    
          </table>
            </div>
        
        </div>
        </div>
        </section>
    
@endsection


@section('customJs')
    
@endsection