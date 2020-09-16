@extends('layouts.sb-admin')

@section('title', 'Question Add/Edit Form')
@push("styles")
     

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
<!-- main page content start here -->

  <div class="container" id="loaded">
    <div class="row justify-content-center">
      <div class="col-9">
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Question Creation Field</h6>
          </div>
          <div class="card-body">
          <form  method="POST" action="{{isset($qs)? route('qs.update',$qs->id):route('qs.store')}}">
            @csrf
            @isset($qs)
              @method("PUT")
            @endisset
                <div class="form-group">
                       <input type="hidden" id="setID" name="set_id" value="{{isset($qs)?$qs->set_id:$set->id}}" />
                  <label for="qtitle">Question Title:</label>
                  <input type="text" name="title" class="form-control" id="qtitle" value="{{isset($qs)?$qs->title:''}}">
                  <small id="qHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                </div>
                <div class="form-group">
                  <label for="my-input">Text</label>
                  <textarea name="qbody" id="editor" >{{isset($qs)? $qs->body:''}}</textarea>
                </div>

                <div class="form-group">
                  <label for="my-input">Answer Code:</label> <br />
                  <small> Write the right answer code bellow. </small>
                  <textarea class="d-none" id="ace-helper">{{isset($qs)? $qs->answer_code:''}}</textarea>
                  <div  id="code-editor" class="ace_editor" ></div>
                </div>

                <div class="form-group">
                  <label for="my-input">Type Input:</label> <br />
                  <small>Hints: If the above code takes input. Write all inputs one by one.</small> <br />
                  <textarea name="dummyInput" id="dummyInput" class="form-control" rows="6"   >{{isset($qs)? $qs->test_input:''}}</textarea>
                </div>
                
              <button id="run" class="btn btn-danger float-right">Run</button>
            </form>
          </div>
        </div><!-- card finished here -->
      </div>
    </div>
  </div>
  <!-- main page content finished here -->
@endsection


@push('scripts')
<script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>

  <script>
  

    </script>
  <script>
   /* ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
        */
        var editor = CKEDITOR.replace( 'editor' );
  </script>

   <!-- code editor text-->
   <script src="{{asset('js/ace-editor/ace.js')}}"></script>
   
   <script>
        var codeEditor = ace.edit("code-editor");
        codeEditor.session.setMode("ace/mode/python");
        codeEditor.resize(true);
        codeEditor.setValue($("#ace-helper").val());
    </script>

    <script>

        $(document).ready(function(){
         
          let dummyOutput = '';
          let dummyInput  = '';
          
          $("#run").click(function(){
            event.preventDefault();


            $('#run').html('running..');

            dummyInput = $("#dummyInput").val();
            
            if (dummyInput.length === 0) {
              dummyInput = "''";
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
                       
                        console.log(response);
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
                }});
                $("#codeOutputModal").modal("show");
            });


            $("#submit").click(function(){
              event.preventDefault();

              $.ajaxSetup({
               headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                       }
              });

              $.ajax({
                url: "{{ isset($qs) ? route('qs.update', $qs->id) : route('qs.store') }}",
                method: "{{isset($qs)? 'PUT': 'POST'}}",
                data: {
                      title        : $("#qtitle").val(),
                       body        : editor.getData(),
                       answer_code : codeEditor.getValue(),
                       dummyInput  : dummyInput,
                       dummyOutput : dummyOutput,
                       set_id      : $('#setID').val(),
                },
                success: function(response){
                    //------------------------
                       // console.log(response);
                        //let response = JSON.parse(response);
                        switch (response.status) {
                          case 1:
                                $.nok({
                                  message: "Sorry Limit exceed!!",
                                  type: "error",
                                  stay:4
                                });
                              break;
                          case 2:
                                $.nok({
                                    message: "New Question has been created successfully!",
                                    type: "success",
                                    stay:3
                                });
                                $.nok({
                                  message: "You have entered last question of this set!!",
                                  stay:5
                                });
                              break;
                            case 3:
                                $.nok({
                                      message: "Title, Body , Answer Code required !!",
                                      type: "error",
                                      stay:3
                                });
                                break;
                            case 4:
                                 $.nok({
                                    message: "Question update successfully !!",
                                    type: "success",
                                    stay:3
                                });
                                break;
                            default:
                                $.nok({
                                    message: "New Question has been created successfully!",
                                    type: "success",
                                    stay:3
                                });
                              break;
                        }
                        
                        //after successfully submission close the modal
                       @if(is_null($qs))                 
                          $("#qtitle").val('');  
                          editor.setData('');
                          $("#dummyInput").val('');
                          codeEditor.setValue('');
                       @endif

                        $("#codeOutputModal").modal("hide");

                        
                   },
                  error:function(response){
                      $("#codeOutputModal").modal("hide");
                          // success toast
                          $.nok({
                            message: "API Server or Network problem  is occured!!",
                            type: "error",
                            stay:4
                        });
                    }
                });
            });
          
        });


    </script>


@endpush