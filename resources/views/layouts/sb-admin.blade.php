<html>
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>{{env('APP_NAME')}} - @yield('title')</title>

             <meta name="csrf-token" content="{{ csrf_token() }}">
            <!-- Custom fonts for this template-->
            <link href="{{asset('startbootstrap/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
            <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

            <!-- Custom styles for this template-->
            <link href="{{asset('startbootstrap/css/sb-admin-2.min.css')}}" rel="stylesheet">

            <!-- https://www.jqueryscript.net/other/Minimal-Notification-Plugin-jQuery-nok.html -->
            <link rel="stylesheet" href="{{asset('startbootstrap/css/jquery.nok.min.css')}}">
          
              <style>
                #loaded {
                  display: none;
                }
                .loader {
                    border: 5px solid #f3f3f3;
                    border-radius: 50%;
                    border-top: 5px solid #3498db;
                    width: 50px;
                    height: 50px;
                    -webkit-animation: spin 2s linear infinite; /* Safari */
                    animation: spin 2s linear infinite;
                  }

                  /* Safari */
                  @-webkit-keyframes spin {
                    0% { -webkit-transform: rotate(0deg); }
                    100% { -webkit-transform: rotate(360deg); }
                  }

                  @keyframes spin {
                    0% { transform: rotate(0deg); }
                    100% { transform: rotate(360deg); }
                  }
                  </style>
                
            @stack('styles')
    </head>
<body id="page-top">
       


    
<!-- Page Wrapper -->
  <div id="wrapper">
    @auth
      @if(Auth::user()->hasRole("admin"))
          @include('sidebar.admin')
      @elseif(Auth::user()->hasRole("student"))
          @include('sidebar.student')
      @endif
    @endauth
           <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

          <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Search -->
     

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
            
            </li>

            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
            </li>

            <!-- Nav Item - Messages -->
            <li class="nav-item dropdown no-arrow mx-1">
             
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span class="mr-2 d-none d-lg-inline text-gray-600 small">  {{  Auth::user()->name  }}  </span>
                <img class="img-profile rounded-circle" src="https://tse4.mm.bing.net/th?id=OIP.KfGJsGyjxCzwoYRnxI2amQHaHa&pid=Api">
              </a>
            
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                
                <a class="dropdown-item" target="_blank" href="{{url('password/reset')}}">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                </a>

                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->
        <div class="container mb-2">
            <div class="row">
              <div class="col-4">
                <a href="{{url()->previous()}}" class="btn btn-primary">Go Back</a>
              </div>
            </div>

            <div class="row justify-content-center">
              @if(session()->has("success"))
                 <p class="alert alert-success">{{session()->get("success")}}</p>
              @endif

              @if ($errors->any())
              <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
              @endif

            </div>

            <div class="row justify-content-center">
              <div class="loader" ></div>
            </div>
        </div>
      
        @yield('content')

        </div>
        
        <!-- end of content-->
           <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>Developed By @ MIU CSE Evening 1<sup>st</sup> Batch. Special Thanks To <a href="mailto:raihan.tusher@yahoo.com">Raihan Ahmed</a></span>
            </div>
            </div>
        </footer>
        <!-- End of Footer -->
        
    </div>
     <!-- end of content wrapper-->
  </div>
  <!-- End of Page Wrapper -->


   <!-- Scroll to Top Button-->
   <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>


  <!-- code output  modal -->
 
<div class="modal fade" id="codeOutputModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="errorMessage">Code Output</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" >
        <div id="emoji" class="text-center"></div>
        <hr/>
        <div id="res_message">
             
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="submit">Submit Question</button>
      </div>
    </div>
  </div>
</div>
<!-- code output modal has finished here --> 
  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
             <a class="btn btn-primary" href="{{ route('logout') }}"
                      onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                       {{ __('Logout') }}
              </a>
        </div>
        
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
      </form>
      </div>
    </div>
  </div>


 



        <!-- Bootstrap core JavaScript-->
        <script src="{{asset('startbootstrap/vendor/jquery/jquery.min.js')}}"></script>
        <script src="{{asset('startbootstrap/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

        <!-- Core plugin JavaScript-->
        <script src="{{asset('startbootstrap/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

        <!-- Custom scripts for all pages-->
        <script src="{{asset('startbootstrap/js/sb-admin-2.min.js')}}"></script>

        <!-- https://www.jqueryscript.net/other/Minimal-Notification-Plugin-jQuery-nok.html -->
        <script src="{{asset('startbootstrap/js/jquery.nok.min.js')}}"></script>
       
        <script>
          
          const success =[
                  "{{asset('assets/png/blushed-smiling.png')}}",
                  "{{asset('assets/png/wink.png')}}",
                  "{{asset('assets/png/upside-down.png')}}",
                  "{{asset('assets/png/cowboy.png')}}",
          ];

          const failure =[
                  "{{asset('assets/png/smile.png')}}",
                  "{{asset('assets/png/sick.png')}}",
                  "{{asset('assets/png/nerd.png')}}",
                  "{{asset('assets/png/cofounded.png')}}",
                  "{{asset('assets/png/hot.png')}}",
                  "{{asset('assets/png/drunk.png')}}"
          ];
          
          function emoji(state) {
            //https://stackoverflow.com/questions/4550505/getting-a-random-value-from-a-javascript-array
            const random = Math.floor(Math.random() * state.length);
             return state[random];
          }
        </script>
        @stack('scripts')

        <script>
          $(document).ready(function () {
            $('#loaded').hide();

              setTimeout(function(){
                          //$('#res_message').hide();
                          //$('#msg_div').hide();
                          $('.loader').hide();
                          $('#loaded').show();
              },2000);
          });
        </script>
    </body>

</html>
