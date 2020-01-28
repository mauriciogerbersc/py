<header class="navbar navbar-header navbar-header-fixed">
    <a href="" id="mainMenuOpen" class="burger-menu"><i data-feather="menu"></i></a>
    <div class="navbar-brand">
        <a href="/admin" class="df-logo">sb<span>trade</span></a>
    </div><!-- navbar-brand -->
    <div id="navbarMenu" class="navbar-menu-wrapper">
        <div class="navbar-menu-header">
            <a href="dashboard" class="df-logo">sb<span>trade</span></a>
            <a id="mainMenuClose" href=""><i data-feather="x"></i></a>
        </div><!-- navbar-menu-header -->
        <ul class="nav navbar-menu">
            <li class="nav-label pd-l-20 pd-lg-l-25 d-lg-none">navegação</li>

            <li @if($current=="administrativo" ) class="nav-item with-sub active" @else class="nav-item with-sub"
                @endif>
                <a href="" class="nav-link"><i data-feather="package"></i> Administrativo</a>

                <div class="navbar-menu-sub">
                    <div class="d-lg-flex">

                        <ul>
                            <li class="nav-label">Clientes</li>

                            <li class="nav-sub-item">
                                <a href="/clientes" class="nav-sub-link"><i data-feather="users"></i>Gerenciar
                                    Clientes</a>
                            </li>

                            <li class="nav-sub-item">
                                <a href="/clientes/cadastro" class="nav-sub-link"><i data-feather="users"></i>Novo
                                    Cliente</a>
                            </li>

                        </ul>


                        <ul>
                            <li class="nav-label">Proposta</li>

                            <li class="nav-sub-item">
                                <a href="/variaveis/listar" class="nav-sub-link"><i data-feather="file"></i> Estrutura de
                                    Proposta</a>
                            </li>

                            <li class="nav-sub-item">
                                <a href="/variaveis/categorias" class="nav-sub-link"><i data-feather="file"></i>
                                    Categoria</a>
                            </li>

                        </ul>

                    </div>
                </div>

            </li>




            <li @if($current=="propostas" ) class="nav-item with-sub active" @else class="nav-item with-sub" @endif>
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


            <li @if($current=="tabela_precos" ) class="nav-item with-sub active" @else class="nav-item with-sub" @endif>
                <a href="" class="nav-link"><i data-feather="layers"></i> Tabelas de Preços</a>
                <div class="navbar-menu-sub">
                    <div class="d-lg-flex">
                        <ul>
                            <li class="nav-label">Preços</li>
                            <!-- <li><a href="/vagas/subcategorias" class="nav-sub-link"><i data-feather="file"></i>
                                    Gerenciar Tabela de Preços</a>
                            </li> -->
                            <li class="nav-sub-item">
                                <a href="/variaveis/subcategorias" class="nav-sub-link"><i data-feather="file"></i>
                                    Criar Tabela de Preços</a>
                            </li>
                        </ul>


                    </div>
                </div><!-- nav-sub -->
            </li>


            <li class="nav-item with-sub ">
                <a href="" class="nav-link"><i data-feather="layers"></i> Provisão de Pagamento</a>
                <div class="navbar-menu-sub">

                    <div class="d-lg-flex">
                        <ul>
                            <li class="nav-label">Produtos</li>
                            <li class="nav-sub-item">
                                <a href="/provisao/produtos" class="nav-sub-link"><i data-feather="file"></i>
                                    Adicionar Produtos</a>
                            </li>

                        </ul>


                    </div>
                </div>
            </li>


           <!-- <li @if($current=="configuracao" ) class="nav-item with-sub active" @else class="nav-item with-sub" @endif>
                <a href="" class="nav-link"><i data-feather="package"></i> Configuração</a>

                <div class="navbar-menu-sub">
                    <div class="d-lg-flex">
                        <ul>
                            <li class="nav-label">Perguntas </li>
                            <li class="nav-sub-item">
                                <a href="/configuracao" class="nav-sub-link"><i data-feather="file"></i>
                                    Perguntas Questionário</a>
                            </li>
                            <li class="nav-sub-item">
                                <a href="/configuracao/nova" class="nav-sub-link"><i data-feather="file"></i>
                                    Cadastrar Pergunta</a>
                            </li>

                        </ul>

                        <ul>
                            <li>Regras</li>
                            <li class="nav-sub-item">
                                <a href="/configuracao/regras" class="nav-sub-link"><i data-feather="file"></i>
                                    Questionário x Variáveis</a>
                            </li>
                            <li class="nav-sub-item">
                                <a href="/configuracao/regras/criar" class="nav-sub-link"><i data-feather="file"></i>
                                    Criar Regra </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </li> -->


        </ul>
    </div><!-- navbar-menu-wrapper -->
    <div class="navbar-right">
        <a id="navbarSearch" href="" class="search-link"><i data-feather="search"></i></a>


        <div class="dropdown dropdown-profile">
            <a href="" class="dropdown-link" data-toggle="dropdown" data-display="static">
                <div class="avatar avatar-sm"><img src="https://via.placeholder.com/500" class="rounded-circle" alt="">
                </div>
            </a><!-- dropdown-link -->
            <div class="dropdown-menu dropdown-menu-right tx-13">
                <div class="avatar avatar-lg mg-b-15">
                    <img src="https://via.placeholder.com/500" class="rounded-circle" alt="">
                </div>

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

            <label
                class="tx-10 tx-medium tx-uppercase tx-spacing-1 tx-color-03 mg-b-10 d-flex align-items-center">Sugestões
                de Busca</label>

            <ul class="list-unstyled">
                <li><a href="#">Clientes</a></li>
                <li><a href="#">Propostas</a></li>
                <li><a href="#">Gerenciador de Preços</a></li>

            </ul>
        </div><!-- navbar-search-body -->
    </div><!-- navbar-search -->
</header><!-- navbar -->