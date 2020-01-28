@extends('layouts.app', ["current" => "propostas"])

@section('vendor')
<!-- vendor css -->
<link href="{{asset('lib/typicons.font/typicons.css')}}" rel="stylesheet">
<link href="{{asset('lib/prismjs/themes/prism-vs.css')}}" rel="stylesheet">
<link href="{{asset('lib/@fortawesome/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
<link href="https://kendo.cdn.telerik.com/2017.2.621/styles/kendo.common-material.min.css" rel="stylesheet">
<link href="https://kendo.cdn.telerik.com/2017.2.621/styles/kendo.material.min.css" rel="stylesheet">
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('css/dashforge.profile.css')}}">

<script src="https://kendo.cdn.telerik.com/2017.2.621/js/jquery.min.js"></script> // dependency for Kendo UI API
<script src="https://kendo.cdn.telerik.com/2017.2.621/js/jszip.min.js"></script>
<script src="https://kendo.cdn.telerik.com/2017.2.621/js/kendo.all.min.js"></script>


<style>
    .page-template>* {
        position: absolute;
        left: 20px;
        right: 20px;
        font-size: 90%;
        font-family: 'Montserrat-Regular', sans-serif;
        font-weight: 400;
    }

    .page-template .header {
        top: 20px;
        border-bottom: 0px solid #000;
    }

    .page-template .footer {
        bottom: 20px;
        border-top: 0px solid #000;
    }

    .page-template .watermark {
        font-weight: bold;
        font-size: 400%;
        text-align: right;
        margin-top: 70%;
        color: #aaaaaa;
        opacity: 0.4;
    }
</style>
@endsection

@section('header')
x
@endsection

@section('body')

<script type="x/kendo-template" id="page-template">
    <div class="page-template">
           <div class="header">
                <div style="display:block;float:left">
                     <img src="{{asset('img/logo-proposta.png')}}"> 
                </div>
                <div style="display:block;float:right">
                    <img src="{{asset('img/logo-sb-proposta.png')}}"> 
               </div>
           </div>
           <div class="footer" style="text-align: center; margin:0 auto; font-size: 80%">
                <div style="display:block; float:left">
                    <strong>#:pageNum#</strong> de <strong>#:totalPages#</strong>
                </div>
                <div style="width:300px; margin:0 auto; font-size:9px;"">
                    Rua Sebastião Furtado Pereira, 60 - Sala 1109<br>
                    (48) 3372-7030 / (48) 99815-0052 -contato@sbtrade.com.br
                </div>
           </div>
     </div>
</script>

<div class="content tx-13"  id="canvas">
    {!! $base64_decode !!}
</div>

@endsection

@section('js')

<script src="{{asset('lib/feather-icons/feather.min.js')}}"></script>
<script src="{{asset('lib/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('js/dashforge.js')}}"></script>

<!-- append theme customizer -->
<script src="{{asset('lib/js-cookie/js.cookie.js')}}"></script>
<script src="{{asset('lib/jquery.maskMoney/jquery.maskMoney.js')}}" type="text/javascript"></script>
<script src="{{asset('js/jspdf.js')}}"></script>

<script>
    // Import DejaVu Sans font for embedding

    // NOTE: Only required if the Kendo UI stylesheets are loaded
    // from a different origin, e.g. cdn.kendostatic.com
    kendo.pdf.defineFont({
        "DejaVu Sans"             : "https://kendo.cdn.telerik.com/2016.2.607/styles/fonts/DejaVu/DejaVuSans.ttf",
        "DejaVu Sans|Bold"        : "https://kendo.cdn.telerik.com/2016.2.607/styles/fonts/DejaVu/DejaVuSans-Bold.ttf",
        "DejaVu Sans|Bold|Italic" : "https://kendo.cdn.telerik.com/2016.2.607/styles/fonts/DejaVu/DejaVuSans-Oblique.ttf",
        "DejaVu Sans|Italic"      : "https://kendo.cdn.telerik.com/2016.2.607/styles/fonts/DejaVu/DejaVuSans-Oblique.ttf",
        "WebComponentsIcons"      : "https://kendo.cdn.telerik.com/2017.1.223/styles/fonts/glyphs/WebComponentsIcons.ttf"
    });


    $(document).ready(function() {
       ExportPdf();

       function ExportPdf(){ 
            kendo.drawing.drawDOM("#canvas", 
                { 
                    forcePageBreak: ".page-break", // add this class to each element where you want manual page break
                    paperSize: "A4",
                    margin: { top: "1cm", bottom: "1cm"},
                    scale: 0.7,
                    height: 400, 
                    template: $("#page-template").html(),
                    keepTogether: ".prevent-split"
                })
                .then(function(group){
                    kendo.drawing.pdf.saveAs(group, "Exported.pdf", "", function(){
                        $(location).attr('href', '/propostas')
                    });
                });          
        }
    });
</script>
@endsection


