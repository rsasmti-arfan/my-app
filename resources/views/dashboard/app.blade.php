<!doctype html>
<html lang="en">

<head>
    @include('dashboard.head')

    <!-- <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DBEST | @yield('title', 'Home')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/colvis/1.1.2/css/dataTables.colVis.min.css" /> -->

    <!-- <style>
        .bb {
            /* color: red; */
            position: relative;
            text-decoration: none;
        }

        .bb::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 1px;
            border-radius: 4px;
            background-color: red;
            bottom: 0;
            left: 0;
            transform-origin: right;
            transform: scaleX(0);
            transition: transform .3s ease-in-out;
        }

        .bb:hover::before {
            transform-origin: left;
            transform: scaleX(1);
        }



        .aa {
            color: inherit;
            text-decoration: none;
        }

        .aa {
            background:
                linear-gradient(to right,
                    rgba(100, 200, 200, 1),
                    rgba(100, 200, 200, 1)),
                linear-gradient(to right,
                    rgba(255, 0, 0, 1),
                    rgba(255, 0, 180, 1),
                    rgba(0, 100, 200, 1));
            background-size: 100% 1px, 0 1px;
            background-position: 100% 100%, 0 100%;
            background-repeat: no-repeat;
            transition: background-size 400ms;
        }

        .aa:hover {
            background-size: 0 2px, 100% 2px;
        }
    </style> -->
    @stack('css')
</head>

<body>
    @include('dashboard.navbar')

    <div class="wrapper">

        @yield('content')

    </div>
    <!-- jquery -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> -->
    <!-- datatables -->
    <!-- <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/4.1.0/js/dataTables.fixedColumns.min.js"></script>
    <script src="https://cdn.datatables.net/colvis/1.1.2/js/dataTables.colVis.min.js"></script> -->
    <!-- bootstrap5 -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script> -->
    @include('dashboard.script')
    <!-- include('sweetalert::alert') -->
</body>
@stack('js')

</html>
