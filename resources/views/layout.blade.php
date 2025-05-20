<!DOCTYPE html>
<html lang="es" >
  <head>
      <script src="/js/jquery-3.2.1.slim.min.js"></script>
      <script type="text/javascript">
      var jQuery_3_2_1 = $.noConflict(true);
      </script>

     <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
      <script type="text/javascript">
      var jQuery_3_3_1 = $.noConflict(true);
      </script>




    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="google-site-verification" content="LxHKqj-7LHr4nr1F8SSnd7J2_vI1H0lgTg2s1hb-t7A" />
    <link rel="icon" type="image/png" href="/img/logo_ari_CRM.png">
    <title>{{ config('app.name', 'Duomo') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

        
        {{-- ✅ Livewire Styles --}}
        @livewireStyles
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <!-- fonts online -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">    
    <link rel="stylesheet" href="/css/dashboard.css?id=<?php echo rand(1,1000);?>">


    {{-- drag and drop --}}

    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    


  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>


    <style>
      fieldset.scheduler-border {
    border: 1px groove #ddd !important;
    padding: 0 1.4em 1.4em 1.4em !important;
    margin: 0 0 1.5em 0 !important;
    -webkit-box-shadow:  0px 0px 0px 0px #000;
            box-shadow:  0px 0px 0px 0px #000;
}

legend.scheduler-border {
    font-size: 1.2em !important;
    font-weight: bold !important;
    text-align: left !important;
}

    </style>
  </head>
  <body class="bg-gray-150 text-gray-800">
    <div id="main-navigation">
        @include('layouts.navigation')
    </div>
  
    <main class="pt-10 mx-auto px-3">
        @yield('content')
        @include('layouts.footer')
    </main>
  
    
  
      


        {{-- ✅ Livewire Scripts --}}
        @livewireScripts
  <script src="/js/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    <!-- Bootstrap core JavaScript
  
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/js/popper.min.js"></script>
    {{-- <script src="/js/popper.min.js"></script> --}}

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="/js/ie10-viewport-bug-workaround.js"></script>
    {{-- <script src="/js/ie10-viewport-bug-workaround.js"></script> --}}

  {{--   <script scr="/js/fontawesome.js"></script> --}}
    @yield('footer_scripts')
    <script src="/js/scripts.js?id=<?php echo rand(1,10000) ?>"></script> 
    <script src="/js/addInput.js?id=<?php echo rand(1,10000) ?>"></script> 
  </body>
</html>
