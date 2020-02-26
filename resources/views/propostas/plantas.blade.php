@extends('layouts.app', ["current"=>"propostas"])


@section('vendor')
<!-- vendor css -->
<link href="{{asset('lib/typicons.font/typicons.css')}}" rel="stylesheet">
<link href="{{asset('lib/prismjs/themes/prism-vs.css')}}" rel="stylesheet">
<link href="{{asset('lib/@fortawesome/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
<link href="{{asset('lib/datatables.net-dt/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{asset('lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css')}}" rel="stylesheet">

@endsection

@section('css')
<!-- DashForge CSS -->
<link rel="stylesheet" href="{{asset('css/dashforge.demo.css')}}">
<style>
    .divider-text {
        font-size: 15px;
        font-weight: 900;
    }
</style>
@endsection

@section('header')
x
@endsection
@section('body')
<div class="content content-fixed">
    <div class="container">
        <ol class="breadcrumb df-breadcrumbs mg-b-10">
            <li class="breadcrumb-item"><a href="/dashboard">Painel de Controle</a></li>
            <li class="breadcrumb-item"><a href="/propostas">Propostas</a></li>
            <li class="breadcrumb-item active" aria-current="page">Envio de Planta</li>
        </ol>


        @if(session('classe'))
        <div class="alert {{session('classe')}} alert-dismissible fade show" role="alert">
            {{ session('mensagem') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        @endif

        <form action="/propostas/plantas/{{$idProposta}}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="proposta_id" value="{{$idProposta}}" />
            @foreach ($proposta as $key=>$val)
            <div>


                <div class="row row-sm">
                    <div class="col-md">
                        <h5>{{$val->nomeParque}}</h5>
                        @if($val->imagem!='')
                        <figure class="pos-relative mg-b-0 wd-lg-50p">
                            <img src="/files/{{$val->imagem}}" class="img-thumbnail" width="278" height="183">
                            <figcaption class="pos-absolute b-0 l-0 wd-100p pd-20 d-flex justify-content-center">
                                <div class="btn-group">
                                    <a href="" class="btn btn-dark btn-icon"><i data-feather="trash-2"></i></a>
                                </div>
                            </figcaption>
                        </figure>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="patio[{{$val->idEstrutura}}]"
                                id="customFile">
                            <label class="custom-file-label" for="customFile">Enviar Arquivo</label>
                        </div>
                        @else
                        <figure class="pos-relative mg-b-0 wd-lg-50p">
                            <img src="/img/parque-dafault.png" class="img-thumbnail" width="278" height="183">
                            <figcaption class="pos-absolute b-0 l-0 wd-100p pd-20 d-flex justify-content-center">
                                <div class="btn-group">
                                    <a href="" class="btn btn-dark btn-icon"><i data-feather="trash-2"></i></a>
                                </div>
                            </figcaption>
                        </figure>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="patio[{{$val->idEstrutura}}]"
                                id="customFile">
                            <label class="custom-file-label" for="customFile">Enviar Arquivo</label>
                        </div>
                        @endif
                    </div><!-- col -->

                    @if($val->parqueCentralizado)
                        <div class="divider-text"><-- {{$val->distanciaCentralizado}} m --></div>
                        <div class="col-md mg-t-10 mg-md-t-0 mg-l-60">
                            <figure class="img-caption pos-relative mg-b-0">
                                <img src="/img/central-comando.jpeg" class="img-thumbnail" width="248" height="153">

                            </figure>
                        </div><!-- col -->
                        
                    @else

                        <div class="col-md mg-t-10 mg-md-t-0">&nbsp;</div>

                    @endif
                </div><!-- row -->


            

            @if($key+1 != $proposta->count())
                <div class="row row-sm">
                    <div class="col-md-6"></div>
                    <div class="divider-text divider-vertical" data-text="">{{$val->distanciaEntreParques}} m</div>
                    <div class="col-md mg-t-6 mg-md-t-0">
                        <br><br>
                        <br>
                        <br>
                        <br>
                    </div><!-- col -->
                </div>
            @endif
            </div>
            @endforeach
            <button type="submit" class="btn btn-primary">{{ __('Carregar Imagens') }}</button>
        </form>
    </div>
</div>
@endsection

@section('js')

<script src="{{asset('lib/feather-icons/feather.min.js')}}"></script>
<script src="{{asset('lib/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('js/dashforge.js')}}"></script>

<!-- append theme customizer -->
<script src="{{asset('lib/js-cookie/js.cookie.js')}}"></script>
<script src="{{asset('lib/jquery.maskMoney/jquery.maskMoney.js')}}" type="text/javascript"></script>
<script>

</script>

@endsection