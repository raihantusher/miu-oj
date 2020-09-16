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
                      <form method="POST" action="{{route('post.store')}}">
                        @csrf
                        <div class="form-group">
                          <label for="exampleInputEmail1">Title:</label>
                          <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="title">
                          <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                        </div>
                        <div class="form-group">
                          <label for="article">Body</label>
                          
                          <textarea class="form-control" id="article" rows="3" name="body"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Category</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="cat_id">
                              @foreach($cats as $cat)
                                  <option value="{{$cat->id}}">{{$cat->name}}</option>
                              @endforeach
                            </select>
                        </div>
                        
                       

                        <button type="submit" class="btn btn-primary">Submit</button>
                      </form>
                    </div>
               

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
