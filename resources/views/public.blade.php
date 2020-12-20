<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta property="og:title" content="Click to WhatsApp." />
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>{{ config('app.name') }} - WhatsApp Link Generator</title>


        <!-- Styles -->
        <style>
            .card:hover{
                background-color:whitesmoke !important;
                color:black !important;
                border:1px solid black !important
            }


        </style>
    </head>
    <body class="bg-custom">
        <div class="container mt-5 mb-5">
            <h1 class="text-center text-secondary">Click To WhatsApp.</h1>
            @for($i=0;$i<count($decodePretext);$i++)
            <div class="row justify-content-center my-4">
            <a href='/{{$grouplinkid[$i]}}/{{$shortURL}}' class="text-decoration-none text-dark col-md-6 col-10 p-0 m-0">
                    <div class="card p-3 bg-dark text-white border-white" style="white-space: pre-line">{{$decodePretext[$i]}}</div>
                </a>
            </div>
            @endfor
        </div>
        <script>
            
        //if (location.protocol != 'https:')
        //{
         //location.href = 'https:' + window.location.href.substring(window.location//.protocol.length);
        //}
        </script>
    </body>
</html>
