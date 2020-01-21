<!DOCTYPE html
  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>{{ $title }}</title>
  <link rel="stylesheet" href="{{asset('css/dashforge.profile.css')}}">
</head>

<body style="Font-family:Tahoma; font-size: 15px;">
  <h3>{{$heading}}</h3>
  <div style="float:left;width:80%;">A/C {{$responsavel}}</div>
  <div style="float:right;width:20%;right:0;">São José, {{$data}}</div>
  <p>Segue proposta de venda e instalação do sistema de gerenciamento de estacionamentos, localização de vagas livres e
    vigilância por CFTV denominado ParkEyes FULL.</p>

  <h4>Funcionalidades:</h4>
  <ul>
    <li> Sistema de Localização de vagas: Sim</li>
    <li>Vídeo Vigilância: Sim</li>
    <li>Vídeo Gravação 5 dias: Sim</li>
    <li>Localize seu carro: Sim</li>
    <li> Câmeras IP: Sim</li>
    <li> Alimentação de Câmeras e Painéis Internos com tecnologia POE: Sim</li>
  </ul>

  <h4>Topologia Central</h4>

  <p>
    A topologia Central permite que até quatro vagas sejam controladas por apenas um módulo gerenciamento, o que
    minimiza a necessidade de instalação infraestrutura e melhora a estética visual do sistema, uma vez que toda sua
    fixação se dará em apenas uma calha central.
  </p>

  <div align="center">

    <img width="450px" src="http://parkeyes.com/wp-content/uploads/2017/04/parkeyes-lighting-home.jpg" />

  </div>

  <div class='corpo' style='margin-top:40px; display:block; width:100%; overflow-x:auto;'>
    {{$content}}
  </div>
</body>
</body>

</html>