@extends('layouts.sb-admin')

@section('title', 'Set List')

@section('content')
<!-- main page content start here -->
 
        <!-- Begin Page Content -->
        <div class="container-fluid" id="loaded">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">All Sets</h1>
          
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Set Tables</h6>
            </div>
            <div class="card-body">
              <a class="btn btn-primary" href="{{route('set.create')}}"><span class="text">Add New Set</span></a>
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable"  width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th># ID</th>
                      <th>Set Name</th>
                      <th>Question Number</th>
                      <th>Operation</th>
                     
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th># ID</th>
                      <th>Set Name</th>
                      <th>Question Number</th>
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
                           
                            <form method="POST" action="{{url("/launch/{$item->id}")}}">
                              @csrf
                              <a class="btn  btn-success btn-sm" href="{{route("set.edit",$item->id)}}">Edit</a>
                              <a class="btn  btn-primary btn-sm" href="{{route("set.show",$item->id)}}">View</a>
                              <a class="btn  btn-info btn-sm" href="{{route("set.score",$item->id)}}">Score</a>
                              <button type="submit" class="btn  btn-danger btn-sm"  onclick="return confirm('Do you want to relaunch?');">Relaunch</button>
                            </form>

                            
                          </td>
                        </tr>
                    @endforeach
                    
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->
  <!-- main page content finished here -->
@endsection


@push('scripts')
    <!-- Page level plugins -->
  <script src="{{asset('startbootstrap/vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('startbootstrap/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

  <!-- Page level custom scripts -->
  <script src="{{asset('startbootstrap/js/demo/datatables-demo.js')}}"></script>
@endpush
