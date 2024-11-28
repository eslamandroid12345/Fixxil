@extends('layouts.app')
@section('style')
    <link
      rel="shortcut icon"
      href="https://goSellJSLib.b-cdn.net/v1.6.0/imgs/tap-favicon.ico"
    />

    <link
      href="https://goSellJSLib.b-cdn.net/v1.6.0/css/gosell.css"
      rel="stylesheet"
    />

    <script
      type="text/javascript"
      src="https://goSellJSLib.b-cdn.net/v1.6.0/js/gosell.js"
    ></script>

@endsection
@section('content')

    <div>
        {{ isset($message) ? $message:"رابط خطأ" }}
    </div>
    <div id="root"></div>


@endsection

@section('script')
    <script>
       goSell.showResult({

           callback: response => {

           console.log("callback", response);

         }

      });
    </script>

    <script>
        window.setTimeout(function(){
            // Move to a new location or you can do something else
            window.location.href = "{{url('/')}}";
        }, 10000);

    </script>

@endsection
