@extends('layouts.lte')
<!-- Content Header (Page header) -->
@push('head-script')

@endpush
@include('users.base')
@section('content')
    <div class="row">
        <div class="col-md-12">
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
    </div>
    <div class="row">
        <div class="col-md-12">
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
    <div class="col-md-12">

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
@push('footer-script')

@endpush
