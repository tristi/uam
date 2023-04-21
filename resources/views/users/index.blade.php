@extends('layouts.starter')
<!-- Content Header (Page header) -->
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Manage User</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Manage User</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container">
        <form action="/search" method="POST" role="search">
            {{ csrf_field() }}
            <div class="input-group">
				<input type="text" class="form-control" name="q"
					placeholder="Search users"> <span class="input-group-append">
					<button type="submit" class="btn btn-info btn-flat">
                        <i class="fas fa-search"></i>
					</button>
				</span>
			</div>
        </form>
    </div>
    <div class="container">
        @if($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{$message}}</p>
            </div>
        @endif
        @if(isset($data))
        <table class="table table-bordered">
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Roles</th>
                <th width="280px">Action</th>
            </tr>
            @foreach($data as $key => $user)
            <tr>
                <td>{{++$i}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>
                    @if(!empty($user->getRoleNames()))
                        @foreach ($user->getRoleNames() as $v )
                            <label class="badge badge-success">{{$v}}</label>
                        @endforeach
                    @endif
                </td>
                <td>
                    <a class="btn btn-info" href="{{route('users.show',$user->id)}}">Show</a>
                    <a class="btn btn-primary" href="{{route('users.edit',$user->id)}}">Edit</a>
                    {!! Form::open(['method'=>'DELETE','route'=>['users.destroy',$user->id],'style'=>'display:inline']) !!}
                    {!! Form::submit('Delete',['class'=> 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
            @endforeach
        </table>
        <!-- /.row -->
        <div class="d-flex justify-content-center">
            {!! $data->links() !!}
        </div>
        @else
        <table class="table table-bordered">
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Roles</th>
                <th width="280px">Action</th>
            </tr>
        </table>
        @endif
    </div><!-- /.container-fluid -->
    <div class="container">

        @if(isset($details))
        <table class="table table-bordered">
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Roles</th>
                <th width="280px">Action</th>
            </tr>
            @foreach($details as $key => $user)
            <tr>
                <td>{{++$i}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>
                    @if(!empty($user->getRoleNames()))
                        @foreach ($user->getRoleNames() as $v )
                            <label class="badge badge-success">{{$v}}</label>
                        @endforeach
                    @endif
                </td>
                <td>
                    <a class="btn btn-info" href="{{route('users.show',$user->id)}}">Show</a>
                    <a class="btn btn-primary" href="{{route('users.edit',$user->id)}}">Edit</a>
                    {!! Form::open(['method'=>'DELETE','route'=>['users.destroy',$user->id],'style'=>'display:inline']) !!}
                    {!! Form::submit('Delete',['class'=> 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
            @endforeach
        </table>
        <!-- /.row -->
        <div class="d-flex justify-content-center">
            {!! $data->links() !!}
        </div>
        @else
        <table class="table table-bordered">
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Roles</th>
                <th width="280px">Action</th>
            </tr>
        </table>
        @endif
    </div><!-- /.container-fluid -->
</div>
@endsection
<!-- /.content -->
