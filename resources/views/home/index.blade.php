@extends('layouts.sb-admin')

@section('title', 'Student Home')

@section('content')



<div class="container" id="loaded">

@if ( count($sets) > 0 )
    
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Set Tables</h6>
                </div>
                <div class="card-body">
                <a class="btn btn-primary mb-3" href="{{route('join.set')}}"><span class="text">Join New Set</span></a>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th># ID</th>
                            <th>name</th>
                            <th>Question</th>
                            <th>Operation</th>
                        
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th># ID</th>
                            <th>name</th>
                            <th>Question</th>
                            <th>Operation</th>
                        </tr>
                    </tfoot>
                    <tbody>
                    @foreach ($sets as $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->n_o_q}}</td> 
                        <td class="text-center">
                          <a href="{{route('sq',$item->id)}}" class="btn btn-primary">View Questions</a>
                          <a href="{{route('score',$item->id)}}" class="btn btn-success">Score</a>
                        </td>
                        
        
                    </tr>
                    @endforeach
                        
                    </tbody>
                    </table>
                </div>
                </div>
            </div>


@else 
    <div class="row">
        <div class="col-9 text-center mt-5">
            <h3> Sorry! you don't have any records. </h3>
            <a class="btn  btn-primary" href="{{route('join.set')}}">Join New Set </a>
        </div>
    </div>
@endif

</div>
@endsection