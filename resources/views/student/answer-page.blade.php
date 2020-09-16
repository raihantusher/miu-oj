@extends('layouts.sb-admin')

@section('title', 'Question Attempt Area')

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

@section('content')

<div class="container" id="loaded">
    
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card">
                <div class="card-header">{{$question->title}}</div>
                <div class="card-body">
                    {!! $question->body !!}
                </div>
            </div>
        </div>
        <!-- col-8 end here -->
        <div class="col-8 mt-3">
                 <textarea id="code" class="d-none" {{isset($answer)?'readonly':''}}>{{$answer->answer_body ?? ''}}</textarea>
                <div class="form-group">
                    <label for="my-input">Write your code bellow:</label>
                    <div id="code-editor" class="ace-editor"></div>
                </div>
                <div class="form-group">
                    <label for="my-input">Type input if neccessary:</label>
                    <textarea  row='6' id="dummyInput" class="form-control"></textarea>
                </div>
                <button  id="run" class="btn btn-danger" >Run</button>
            
        </div>
    </div> <!-- row ended here -->
   
  
</div>



@endsection


@push('scripts')

   <!-- code editor text-->
<script src="{{asset("js/ace-editor/ace.js")}}"></script>
   <script>
    var codeEditor = ace.edit("code-editor");
    codeEditor.session.setMode("ace/mode/python");
    codeEditor.resize(true);
    codeEditor.setValue($("#code").val());

    
  </script>


<script>
    //-----------------
    $(document).ready(function(){
        
        $('#submit').html("Upload Code");

        $("test-output").hide();

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
                                    $("#codeOutputModal").css('background-color','red')
                                    //$('#submit').attr("disabled","disabled");
                                    $("#emoji").html("<img src="+emoji(failure)+" class='img-fluid' hieght='120' width='120' />")
                                    $('#submit').prop("disabled",true);
                                }
                                else {
                                    // it means cod ran successfully
                                    $("#codeOutputModal").css('background-color','green')
                                    // it means cod ran successfully
                                    $("#emoji").html("<img src="+emoji(success)+" class='img-fluid' hieght='120' width='120' />")
                                    $('#submit').attr("disabled",false);
                                    ;
                                }
                            // document.getElementById("contact_us").reset(); 
                                setTimeout(function(){
                                //$('#res_message').hide();
                                //$('#msg_div').hide();
                                $('#run').html('Run');
                                     },2000);
                                //  --------------------------
                                $("#codeOutputModal").modal("show");
                            }
                    });
                      
                
                }); // click run finished here

                $("#submit").click(function(){
              event.preventDefault();

              $.ajaxSetup({
               headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                       }
              });

              $.ajax({
                url: "{{route('ap', $question->id)}}",
                method: 'post',
                data: {
                       //title: $("#qtitle").val(),
                      // body      : editor.getData(),
                       code    : codeEditor.getValue(),
                      // dummyInput : dummyInput,
                       dummyOutput: dummyOutput,
                       //set_id     : $('#setID').val(),
                },
                success: function(response){

                    $("#codeOutputModal").modal("hide");
                   // success toast
                     $.nok({
                          message: "Code is uploaded.",
                          type: "success",
                          stay:3
                        });

                        @isset($answer)
                            $.nok({
                                message: "Duplicate entry is restricted.",
                                type: "error",
                                stay:4
                            });
                        @endisset
                        $("#run").html("Run");
                    },
                error:function(response) {
                  //  console.log(response);
                    $("#codeOutputModal").modal("hide");
                          // success toast
                          $.nok({
                            message: "API Server or Network problem  is occured!!",
                             type: "error",
                             stay:4
                        });

                        $("#run").html("Run");
                }
            });
        });
    });

    </script>
@endpush