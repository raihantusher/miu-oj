@extends('layouts.sb-admin')

@section('title', 'Judge Student Answer')

@push("styles")
      <meta name="csrf-token" content="{{ csrf_token() }}">

<style>
  #code-editor {
  position: relative;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  height: 300px !important; 

  }

/*# sourceMappingURL=styles.css.map */
</style>

@endpush


@section("content")

    <div class="container" id="loaded">
        <div class="row justify-content-center">
            <div class="col-6">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th colspan="3" scope="col" class="text-center">Student Details</th>
                        </tr>
                        
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">#{{$answer->user->id}} </th>
                            <td>{{$answer->user->name}} </td>
                            <td>{{$answer->user->email}} </td>
                        </tr>
                    </tbody>
                </table>
            </div>
       
        </div> <!-- row finished here--> 


        <div class="row justify-content-center mt-5">
            <div class="col-8">
                <h4 class="text-center">Question Details !!</h4>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">{{$answer->question->title}}</h6>
                    </div>
                    <div class="card-body">
                       {!! $answer->question->body !!}
                    </div>
                  </div>
            </div>

            <div class="col-8">
                <div class="form-group">
                    <label for="my-input">Answer Code:</label> <br />
                    <small> Write the right answer code bellow. </small>
                    <div  id="code-editor" class="ace_editor" ></div>
                    <textarea id="helper" class="d-none">{{ $answer->answer_body }}</textarea>
                </div>

                <div class="form-group">
                    <label for="input-textarea">Text</label>
                    <textarea id="input-textarea" class="form-control" name="" rows="3">{{$answer->question->test_input}}</textarea>
                </div>

                <div class="form-group">
                    <label for="update-response">Current Status</label>
                    <select id="update-response" class="form-control" name="">
                        <option value='wrong' {{ $answer->response   === 'wrong'   ? 'selected' : '' }}>Wrong</option>
                        <option value='right' {{ $answer->response   === 'right'   ? 'selected' : '' }}>Right</option>
                        <option value='pending' {{ $answer->response === 'pending' ? 'selected' : '' }}>Pending</option>        
                    </select>
                </div>
                <button id="run" class="btn btn-danger float-right">Run</button>
            </div> <!-- col-8 finished -->


        </div> <!-- row finidshed here-->
    </div>
@endsection


@push('scripts')
<!-- use javascript bellow -->
    <!-- code editor text-->
<script src="{{asset("js/ace-editor/ace.js")}}"></script>
<script>
    var codeEditor = ace.edit("code-editor");
    codeEditor.session.setMode("ace/mode/python");
    codeEditor.resize(true);
    codeEditor.setValue($("#helper").val());
</script>


    
<script>

    $(document).ready(function(){
        
      $("#submit").hide();
        $('#update-response').on('change', function() {
            //alert( this.value );
       
            $.ajaxSetup({
               headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                       }
            });

            
            $.ajax({
                url: "{{route('judge.update')}}",
                method: 'post',
                data: {
                       
                       result   : this.value , //selection item value
                       answer_id: {{$answer->id}} //getting answer id from blade
                },
                success: function(response){
                    $.nok({
                        message: "'{{$answer->question->title}}' is updated successfully! ",
                        type: "success",
                        stay:3
                    });
                 },
                error: function(response){
                    //console.log(response)
                    $.nok({
                        message: "Server or Connection problem !!",
                        type: "error",
                        stay:3
                    });
                 }
                
            });


        });


        $("#run").click(function(){
            event.preventDefault();
            $('#run').html('running..');
                
                    dummyInput = $("#dummyInput").val();
                    
                    if (!dummyInput) {
                    dummyInput = '';
                    }
                    

                    
                    $.ajax({
                        url: "{{env('COMPILER_API_LOC')}}",
                        method: 'post',
                        data: {
                            code: codeEditor.getValue(),
                            input: dummyInput,
                        },
                        success: function(response){
                            //------------------------
                                //console.log(response);
                                //let response = JSON.parse(response);
                                // assign dummyOutput 
                                // we will post it with submit button
                                    dummyOutput = response.code;
                                $('#res_message').show();
                                $('#res_message').html(response.code);
                                $('#msg_div').removeClass('d-none');

                                if (response.error == 1) {
                                    //$('#submit').attr("disabled","disabled");
                                    $("#codeOutputModal").css('background-color','red')
                                    //$('#submit').attr("disabled","disabled");
                                    $("#emoji").html("<img src="+emoji(failure)+" class='img-fluid' hieght='120' width='120' />");
                                    $('#submit').prop("disabled",true);
                                }
                                else {
                                
                                    $("#codeOutputModal").css('background-color','green')
                                    // it means cod ran successfully
                                    $("#emoji").html("<img src="+emoji(success)+" class='img-fluid' hieght='120' width='120' />")
                                    $('#submit').attr("disabled",false);
                                }
                            // document.getElementById("contact_us").reset(); 
                                setTimeout(function(){
                                //$('#res_message').hide();
                                //$('#msg_div').hide();
                                $('#run').html('Run');
                                },2000);
                            //--------------------------
                        }
                    });
                        $("#codeOutputModal").modal("show");
                
        }); // click run finished here

             
    });
</script>

@endpush