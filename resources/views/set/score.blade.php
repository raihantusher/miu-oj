@extends('layouts.sb-admin')

@section('title', 'Student Scores')

@section("content")

    <div class="container" id="loaded">

        

        <div class="row">
            <div class="col-9">
                 <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Set Tables for: {{$set->name}} </h6>
            </div>
               <div class="card-body" style="background-color:white ">
               
                      
                    <button type="submit" class="btn  btn-danger btn-sm" id="send-mail" >Send Notification Mail to all Students.</button>
                  </form>
                  <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable">
                        <thead>
                            <tr>
                            <th scope="col" >Student IDs</th>
                            <th scope="col" colspan="{{count($set_qs)}}">Question Title</th>
                            <th scope="col">Total</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <tr>
                                <th></th>
                                @foreach($set_qs as $q)
                                    <th scope="col" >{{$q->title}}</th>
                                @endforeach
                                <th ></th>
                            </tr>

                            @foreach($results as $result)
                            <tr>
                                
                                <th scope="row">{{$result->username}}</th>
                                    @for( $i=0; $i<count($result->result);  $i++)
                                        
                                        <td>
                                            <a href="{{route('judge',[$result->userid, $result->result["q_id"][$i]])}}" target="_blank">
                                                {{$result->result["status"][$i]}}
                                            </a>
                                        </td>
                                    @endfor
                            <td>{{$result->total}}</td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                         </table>
                  </div>
                    </div>
                </div> <!--card -->
            </div>
        </div>
    </div>



@endsection


@push('scripts')
            <script>
                $(document).ready(function(){

                            $("#send-mail").click(function(){
                                $('.loader').show();
                                $('#send-mail').prop("disabled",true);
                                $('#send-mail').html("Sending ....");
                                $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                });

                                $.ajax({
                                    type: "POST",
                                    url: "{{url('/notify')}}",
                                    data: {
                                        id : {{$set->id}}
                                    },
                                    
                                    success: function (response) {
                                        $.nok({
                                            message: "All students are notified successfully !!",
                                            type: "success",
                                            stay:2
                                        });
                                        $('.loader').hide();
                                        $('#send-mail').prop("disabled",false);
                                        $('#send-mail').html("Send Again");
                                    },

                                    error: function (response) {
                                        $.nok({
                                            message: "Something wrong with this server configuration !!",
                                            type: "error",
                                            stay:2
                                        });
                                        $('.loader').hide();
                                        $('#send-mail').prop("disabled",false);
                                        $('#send-mail').html("Send Again");
                                    }
                                });
                            })
                
                });
            </script>
    <!-- Page level plugins -->
  <script src="{{asset('startbootstrap/vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('startbootstrap/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

  <!-- Page level custom scripts -->
  <script src="{{asset('startbootstrap/js/demo/datatables-demo.js')}}"></script>
    
@endpush