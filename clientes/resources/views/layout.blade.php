<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Festival de Música 2025')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
        }
        
        body {
            display: flex;
            flex-direction: column;
        }
        
        main {
            flex: 1;
            margin-top: 56px;
        }
        
        footer {
            margin-top: auto !important;
        }
    </style>
    @stack('head')
</head>
<body>
    {{-- Navbar (fixa no topo) --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}"><i class="fas fa-music me-2"></i>MusicFest 2025</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                {{-- Menu âncora para a página pública (opcionalmente esconda em telas internas) --}}
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/#inicio') }}">Início</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/#programacao') }}">Programação</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/#ingressos') }}">Ingressos</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/#galeria') }}">Galeria</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/#contato') }}">Contato</a></li>

                    {{-- Área Administrativa (link condicional) --}}
                    <li class="nav-item">
                        @if(session()->has('admin_user_id'))
                            <a class="nav-link" href="{{ route('admin.clientes') }}">
                                <i class="fa-solid fa-shield-halved me-1"></i>Área Administrativa
                            </a>
                        @else
                            <a class="nav-link" href="{{ route('admin.login.form') }}">
                                <i class="fa-solid fa-shield-halved me-1"></i>Área Administrativa
                            </a>
                        @endif
                    </li>

                    @if(session()->has('admin_user_id'))
                        <li class="nav-item">
                            <form method="POST" action="{{ route('admin.logout') }}" class="d-inline">
                                @csrf
                                <button class="btn btn-link nav-link p-0">
                                    Sair ({{ session('admin_user_name') }})
                                </button>
                            </form>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    {{-- Conteúdo das páginas --}}
    <main style="margin-top: 56px;">
        @yield('content')
    </main>



    {{-- Footer padrão (pode ser sobrescrito) --}}
    @hasSection('footer')
        @yield('footer')
    @else
        <footer id="contato" class="bg-dark text-white py-4 mt-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Contato</h5>
                        <p><i class="fas fa-envelope me-2"></i>contato@musicfest2025.com</p>
                        <p><i class="fas fa-phone me-2"></i>(81) 9999-8888</p>
                        <p><i class="fas fa-map-marker-alt me-2"></i>Parque da Jaqueira, Recife - PE</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <h5>Siga-nos</h5>
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook fa-2x"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-instagram fa-2x"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-twitter fa-2x"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-youtube fa-2x"></i></a>
                    </div>
                </div>
                <hr>
                <div class="text-center">
                    <p>&copy; 2025 MusicFest. Todos os direitos reservados.</p>
                </div>
            </div>
        </footer>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>