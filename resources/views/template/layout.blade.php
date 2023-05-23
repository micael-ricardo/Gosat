<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-3.6.4.js"></script>
    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    {{-- InputMask --}}
    <script src="https://cdn.jsdelivr.net/npm/inputmask@5.0.8/dist/jquery.inputmask.min.js"></script>
    {{-- Incone --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    {{-- Chart --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{-- Estilo do sistema --}}
    <link rel="stylesheet" href="css/geral.css">

</head>

<body>
    @include('template.header')
    @include('template.sidebar')

    <div id="conteudo" class="col py-3">
        @yield('conteudo')
    </div>
</body>

</html>
