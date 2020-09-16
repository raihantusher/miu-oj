@extends('layouts.sb-admin')


@section('title', 'Question List')
@section('content')
<!-- main page content start here -->
 
        <!-- Begin Page Content -->
        <div class="container-fluid" id="loaded">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">All questions</h1>
          
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Question Tables</h6>
            </div>
            <div class="card-body">
              <a class="btn btn-primary" href="{{route('qs.set', $set_id)}}"><span class="text">Add New Question</span></a>
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th># ID</th>
                      <th>Question title</th>
                      
                      <th>Operation</th>
                     
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th># ID</th>
                      <th>Question title</th>
                      
                      <th>Operation</th>
                     
                    </tr>
                  </tfoot>
                  <tbody>
                   @foreach ($questions as $item)
                   <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->title}}</td>
                    
                    <td class="text-center">
                     
                    <form method="POST" action="{{route('qs.destroy',$item->id)}}">
                      @csrf
                      @method('DELETE')
                      <a class="btn  btn-success btn-sm" href="{{route("qs.edit",$item->id)}}">Edit</a>
                      <button type="submit" class="btn  btn-danger btn-sm" onclick="return confirm('Do you want to delete?');">Delete</button>
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
