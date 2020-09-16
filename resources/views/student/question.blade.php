@extends('layouts.sb-admin')

@section('title', 'Question List')
@section('content')



<div class="container" id="loaded">

    
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Question Tables</h6>
                </div>
                <div class="card-body">
                
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th># ID</th>
                            <th>title</th>
                            <th>Status</th>
                            <th>Operation</th>
                        
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th># ID</th>
                            <th>title</th>
                            <th>Status</th>
                            <th>Operation</th>
                        </tr>
                    </tfoot>
                    <tbody>
                    @foreach ($questions as $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td>{{$item->title}}</td>
                        <td>{{isset($item->answer)? 'Answer Submitted' : 'Not attempted'}}</td>
                        <td class="text-center">
                        <a href="{{route('ap',$item->id)}}" class="btn btn-success">View </a>
                        </td>
                        
        
                    </tr>
                    @endforeach
                        
                    </tbody>
                    </table>
                </div>
                </div>
            </div>
</div>


@endsection