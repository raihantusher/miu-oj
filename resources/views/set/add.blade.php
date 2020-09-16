@extends('layouts.sb-admin')


@section('title', 'Create or Edit Set')
@section('content')
<!-- main page content start here -->
  <div class="container" id="loaded">
    <div class="row justify-content-center">
      <div class="col-6">
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Set Creation Field</h6>
          </div>
          <div class="card-body">
          <form  method="POST" action="{{isset($set)?route('set.update',$set->id):route('set.store')}}">
            @csrf
            @isset($set)
              @method("PUT")
            @endisset
                <div class="form-group">
                  <label>Set Name:</label>
                <input type="text" name="name" class="form-control"   value="{{isset($set)?$set->name:''}}">
                  
                </div>
                <div class="form-group">
                  <label>Max Questuion Number:</label>
                  <input type="number" name="number_of_question" class="form-control"  value="{{isset($set)?$set->n_o_q:''}}">
                 
                </div>

                <div class="form-group">
                  <label >Expire After:</label>
                  <input type="number" name="expire_after" class="form-control"  aria-describedby="setHelp" value="{{isset($set)?$set->expire_after:3}}">
                  
                </div>

                <div class="form-group">
                  <label >Judge System</label>
                  <select class="form-control" name="judge_by" >
                    <option value="automatic"  {{ (isset($set) && $set->judge_by)   === 'automatic'   ? 'selected' : '' }}>Automatic</option>
                    <option value="manual"     {{ (isset($set) && $set->judge_by)   === 'manual'      ? 'selected' : '' }}>Manual</option>
                  </select>
                </div>
                
                <div class="form-group">
                  <label for="set-name">Set UUID:</label>
                  <input type="text" name="uuid" class="form-control"  value="{{isset($set)?$set->uuid:''}}">
                  
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
