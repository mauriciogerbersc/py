<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Meta -->
    <meta name="description" content="">
    <meta name="author" content="gerber">


    <title>{{ config('app.name', 'Acesso ao Sistema ') }}</title>

    @hasSection('vendor')
    <!-- vendor css -->
    <link href="{{asset('lib/@fortawesome/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
    <link href="{{asset('lib/ionicons/css/ionicons.min.css')}}" rel="stylesheet">

    @yield('vendor')
    @endif

    <!-- DashForge CSS -->
    <link rel="stylesheet" href="{{asset('css/dashforge.css')}}">
    @hasSection('css')
    @yield('css')
    @endif
</head>

<body>
    @hasSection('header')
    <header class="navbar navbar-header navbar-header-fixed">
        <a href="" id="mainMenuOpen" class="burger-menu"><i data-feather="menu"></i></a>
        <div class="navbar-brand">
            <a href="#" class="df-logo">sb<span>trade</span></a>
        </div><!-- navbar-brand -->
        <div id="navbarMenu" class="navbar-menu-wrapper">
            <div class="navbar-menu-header">
                <a href="dashboard" class="df-logo">sb<span>trade</span></a>
                <a id="mainMenuClose" href=""><i data-feather="x"></i></a>
            </div><!-- navbar-menu-header -->
            <ul class="nav navbar-menu">
                <li class="nav-label pd-l-20 pd-lg-l-25 d-lg-none">navegação</li>
                <li class="nav-item active">
                    <a href="" class="nav-link"><i data-feather="pie-chart"></i> Painel de Controle</a>
                </li>

                <li class="nav-item with-sub">
                    <a href="" class="nav-link"><i data-feather="package"></i> Administrativo</a>
                    <div class="navbar-menu-sub">
                        <div class="d-lg-flex">
                            <ul>
                                <li class="nav-sub-item">
                                    <a href="/clientes" class="nav-sub-link"><i data-feather="users"></i>Gerenciar Clientes</a>
                                </li>
                                <li class="nav-sub-item">
                                    <a href="#" class="nav-sub-link"><i data-feather="user"></i>Gerenciar Usuários</a>
                                </li>
                            </ul>

                        </div>
                    </div>

                </li>
                <li class="nav-item with-sub ">
                    <a href="" class="nav-link"><i data-feather="layers"></i> Variáveis</a>
                    <div class="navbar-menu-sub">
                        <div class="d-lg-flex">
                            <ul>
                                <li class="nav-sub-item">
                                    <a href="/variaveis" class="nav-sub-link"><i data-feather="file"></i> Gerenciador Varíaveis</a>
                                </li>

                                <li class="nav-sub-item">
                                    <a href="/variaveis/categorias" class="nav-sub-link"><i data-feather="file"></i> Gerenciador Categoria de Variáveis</a>
                                </li>


                                <li class="nav-sub-item">
                                    <a href="/vagas/subcategorias" class="nav-sub-link"><i data-feather="file"></i> Gerenciador Valores por Vaga</a>
                                </li>
                            </ul>

                        </div>
                    </div><!-- nav-sub -->
                </li>
                <li class="nav-item with-sub ">
                    <a href="" class="nav-link"><i data-feather="layers"></i> Propostas</a>
                    <div class="navbar-menu-sub">
                        <div class="d-lg-flex">
                            <ul>
                                <li class="nav-sub-item">
                                    <a href="/propostas" class="nav-sub-link">
                                        <i data-feather="file-text"></i>
                                         Propostas
                                    </a>
                                </li>
                              
                                <li class="nav-sub-item">
                                    <a href="#" class="nav-sub-link">
                                        <i data-feather="file-text"></i>
                                        Contratos Gerados</a>
                                </li>
                               
                            </ul>

                        </div>
                    </div><!-- nav-sub -->
                </li>
            </ul>
        </div><!-- navbar-menu-wrapper -->
        <div class="navbar-right">
            <a id="navbarSearch" href="" class="search-link"><i data-feather="search"></i></a>


            <div class="dropdown dropdown-profile">
                <a href="" class="dropdown-link" data-toggle="dropdown" data-display="static">
                    <div class="avatar avatar-sm"><img src="https://via.placeholder.com/500" class="rounded-circle" alt=""></div>
                </a><!-- dropdown-link -->
                <div class="dropdown-menu dropdown-menu-right tx-13">
                    <div class="avatar avatar-lg mg-b-15">
                        <img src="https://via.placeholder.com/500" class="rounded-circle" alt="">
                    </div>
                    <h6 class="tx-semibold mg-b-5">{{ Auth::user()->name }} </h6>
                    <p class="mg-b-25 tx-12 tx-color-03">Administrador</p>

                    <a href="" class="dropdown-item"><i data-feather="edit-3"></i> Editar Perfil</a>
                    <a href="#" class="dropdown-item"><i data-feather="user"></i> Visualizar Perfil</a>

                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i data-feather="log-out"></i>Sair
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div><!-- dropdown-menu -->
            </div><!-- dropdown -->
        </div><!-- navbar-right -->
        <div class="navbar-search">
            <div class="navbar-search-header">
                <input type="search" class="form-control" placeholder="Digite o que você deseja achar...">
                <button class="btn"><i data-feather="search"></i></button>
                <a id="navbarSearchClose" href="" class="link-03 mg-l-5 mg-lg-l-10"><i data-feather="x"></i></a>
            </div><!-- navbar-search-header -->
            <div class="navbar-search-body">

                <label class="tx-10 tx-medium tx-uppercase tx-spacing-1 tx-color-03 mg-b-10 d-flex align-items-center">Sugestões
                    de Busca</label>

                <ul class="list-unstyled">
                    <li><a href="#">Clientes</a></li>
                    <li><a href="#">Propostas</a></li>
                    <li><a href="#">Gerenciador de Preços</a></li>

                </ul>
            </div><!-- navbar-search-body -->
        </div><!-- navbar-search -->
    </header><!-- navbar -->
    @endif

    <main>
        @hasSection('body')
        @yield('body')
        @endif
    </main>

    <footer class="footer">
        <div>
            <span>&copy; 2019 ParkEyes v1.0.0. </span>
            <span><a href="https://sbtrade.com.br/">SBtrade</a></span>
        </div>
    </footer>

    <script src="{{asset('lib/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('lib/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    @hasSection('js')
    @yield('js')
    @endif
</body>

</html>