@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            .<div class="card">
                <div class="card-body">
                    <ul class="list-group">
                    <li class="list-group-item"><a href="{{route('cat.index')}}">Category</a></li>
                        <li class="list-group-item"><a href="{{route('post.index')}}">Post</a></li>
                       
                      </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Posts</div>

                <div class="card-body">
                    <a href="{{route('post.create')}}" class="btn btn-sm btn-primary mb-1">add</a>


                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Category</th>
                            <th scope="col">User</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($posts as $post)
                            @can("view-post",$post)
                              <tr>
                                <th scope="row">{{$post->id}}</th>
                                <td>{{$post->title}}</td>
                                <td>{{$post->cat->name}}</td>
                                <td>{{$post->user->name}}</td>
                              </tr
                            @endcan
                          @endforeach
                         
                        </tbody>
                      </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
