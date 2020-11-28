@extends('layouts.app')

@section('content')
<div class="container">
    <table class="table">
        <thead>
            <tr class="table-warning">
              <td>ID</td>
              <td>Name</td>
              <td>Email</td>
              <td>Password</td>
              <td>Created at</td>
              <td class="text-center">Action</td>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->password}}</td>
                <td>{{$user->created_at}}</td>
                <td class="text-center">
                    <a href="" class="btn btn-primary btn-sm"">Edit</a>
                    <form action="" method="post" style="display: inline-block">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm"" type="submit">Delete</button>
                      </form>
                </td>
            </tr>
            @endforeach
        </tbody>
      </table>
</div>
@endsection
