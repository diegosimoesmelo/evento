<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Login e Cadastro')</title>


    <!-- CDN do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJjRZtWtrddS4INk4F6cxkNj4Z5pRwnh0U5yJee0VJdM+GnbP8JQyybmjX5Z" crossorigin="anonymous">
    <style>
        /* Cores personalizadas em tons de vermelho */
        body {
            background-color: #f8d7da;
        }


        .form-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            border-radius: 10px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }


        .btn-custom {
            background-color: #dc3545;
            color: white;
        }


        .btn-custom:hover {
            background-color: #c82333;
        }


        .alert-custom {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        @yield('content')
    </div>


    <!-- CDN do Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-wfS3aWROuP0df5rM1yduYzQhkb3zoTSwaQ1X5u59n1k6V3gXzgyfPVoPjUBeYH8U" crossorigin="anonymous"></script>
</body>
</html>
