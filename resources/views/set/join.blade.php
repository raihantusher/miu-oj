@extends('layouts.sb-admin')

@section('title', 'Student Join')

@section('content')
<!-- main page content start here -->
  <div class="container" id="loaded">
    <div class="row justify-content-center">
      <div class="col-6">
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Insert UUID for Joining Set</h6>
          </div>
          <div class="card-body">
          <form  method="POST" action="{{route('joining')}}">
            @csrf
                <div class="form-group">
                  <label for="set-name">Set uuid:</label>
                    <input type="text" name="uuid" class="form-control">
                    <small id="setHelp" class="form-text text-muted"></small>
                </div>
            
              <button type="submit" class="btn btn-primary float-right">Submit</button>
            </form>
          </div>
        </div><!-- card finished here -->
      </div>
    </div>
  </div>
  <!-- main page content finished here -->
@endsection
