<!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE HTML>
<html>
<head>
    <title>PERAST Recolección de datos</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>

    {!! Html::Style('/css/app.css') !!}


    <link href="{{ asset('/index/css/style.css') }}" rel="stylesheet" type="text/css" media="all" />
    <link href="{{ asset('/index/css/slimmenu.css') }}" rel="stylesheet" media="screen">
    <link rel="stylesheet" type="text/css" href="{{ asset('/index/css/magnific-popup.css')}}">
    <script src="{{ asset('/index/js/jquery.min.js')}}"></script>
</head>
<body>
<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav">
        <!--<li><a href="{{ url('/') }}">Inicio</a></li>-->
    </ul>

    <ul class="nav navbar-nav navbar-right">
        @if (Auth::guest())
            <li><a href="{{ url('/auth/login') }}">Ingresar</a></li>
            <!-- <li><a href="{{ url('/auth/register') }}">Register</a></li>-->
        @else
            <li class="dropdown">
                <a href="{{ url('/auth/logout') }}" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Salir</a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="{{ url('/auth/logout') }}">Logout</a></li>
                </ul>
            </li>
        @endif
    </ul>
</div>
<div class="content" id="home">
    <div class="header">
        <div class="wrap">

            <header id="topnav">
                <nav>
                    <ul>
                        <li class="active"><a href="#home" class="scroll">Inicio</a></li>
                        <li><a href="#team" class="scroll">PERAST</a></li>
                        <li><a href="#ourstory" class="scroll">Servicios</a></li>
                        <li><a href="#blog" class="scroll">Planes</a></li>
                        <li><a href="#contact" class="scroll">Contacto</a></li>

                        <div class="clear"> </div>
                    </ul>
                </nav>
                <h1><a href="index.html">PERAST</a></h1>
                <a href="#" id="navbtn">Nav Menu</a>
                <div class="clear"> </div>

            </header>
        </div>
    </div>
    <!-----script------------->
    <script type="text/javascript"  src="{{ asset('/index/js/menu.js') }}"></script>

    <div class="slider" id="home">
        <div class="wrap">
            <!---start-da-slider----->
            <div id="da-slider" class="da-slider">
                <div class="da-slide">
                    <h2>El sistema móvil de recolección de datos más fácil y flexible </h2>
                    <p>Capacidades para capturar, editar y analizar información rapido y eficientemente.</p>
                    <a href="#blog" class="da-link">Solicitar Ahora</a>
                </div>
                <div class="da-slide">
                    <h2>Totalmente adaptable a sus necesidades de conteo</h2>
                    <p>Extremadamente flexible, facilmente configurable a los requerimientos de su empresa.</p>
                    <a href="#blog" class="da-link">Solicitar Ahora</a>
                </div>
                <div class="da-slide">
                    <h2>Ahorre 30% en sus procesos de recolección de datos</h2>
                    <p>Elimine los procesos basados en papel y optimice la productividad de sus empresa.</p>
                    <a href="#blog" class="da-link">Solicitar Ahora</a>

                </div>
                <div class="da-slide">
                    <h2>Optimice la confiabilidad en la recolección de datos en campo</h2>
                    <p>Reduzca errores en la toma y análisis de datos y ahorrar tiempo al eliminar problemas en procesos intermedios como transcripción de datos, soporte y costos de expansion.</p>
                    <a href="#blog" class="da-link">Solicitar Ahora</a>

                </div>
            </div>

            <script type="text/javascript" src="{{ asset('/index/js/jquery.cslider.js')}}"></script>
            <!---strat-slider---->
            <link rel="stylesheet" type="text/css" href="{{ asset('/index/css/slider.css') }}" />
            <script type="text/javascript" src="{{ asset('/index/js/modernizr.custom.28468.js') }}"></script>
            <script type="text/javascript">
                $(function() {

                    $('#da-slider').cslider({
                        autoplay	: true,
                        bgincrement	: 450
                    });

                });
            </script>
            <!---//End-da-slider----->

        </div>
    </div>
</div>
<!---start-team----->
<div  class="team" id="team">
    <div class="wrap">
        <div class="section group">
            <div class="col_1_of_1 span_1_of_1">
                <h3>Empiece a recolectar datos de forma eficiente y segura</h3>
                <p>PERAST, es un Servicio de Software Movil para Recolección de Datos, que le permite capturar, editar y analizar informacion rapida y eficientemente. Ofrece un conjunto de herramientas estadísticas que facilitan el análisis de la información recolectada por las terminales móviles, así como la configuración de las diferentes variables del sistema de recolección según las necesidades de su empresa.</p>
            </div>
            <hr>
            <div class="panel-body text-center">
                <a href="colector.apk" class="btn btn-warning btn-lg">DESCARGAR</a>
            </div>
            <hr>
            <div class="pen">
                <img src="{{ asset('/index/images/perast.gif') }}" width="427" height="679"><img src="{{ asset('/index/images/pen.png') }}">
            </div>

        </div>



    </div>
</div>
<!---//end-team----->





<!---start-our story----->
<div  class="ourstory" id="ourstory">
    <div class="our-story">
        <h3>Descargue la aplicación en cualquier dispositivo android</h3>
        <p>Configure desde el panel de administrador sus necesidades de conteo y permita que sus empleados alimenten la información desde dispositivos móviles y disponga en tiempo real de los datos para el análisis.</p>
    </div>
    <div class="group_2" id="Portfolio">
        <div class="group_2_items">
            <div class="wrap">
                <div id="owl-demo1" class="owl-carousel">

                    <div class="item">
                        <div class="carousel">
                            <div class="group_2_img1">
                                <img src="{{ asset('/index/images/slider2.jpg') }}" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="carousel">
                            <div class="group_2_img1">
                                <img src="{{ asset('/index/images/slider3.jpg') }}" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="carousel">
                            <div class="group_2_img1">
                                <img src="{{ asset('/index/images/slider1.jpg') }}" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="carousel">
                            <div class="group_2_img1">
                                <img src="{{ asset('/index/images/slider4.jpg') }}" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="carousel">
                            <div class="group_2_img1">
                                <img src="{{ asset('/index/images/slider5.jpg') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Owl Carousel Assets -->
<link href="{{ asset('/index/css/owl.carousel.css')}}" rel="stylesheet">
<!-- Owl Carousel Assets -->
<!-- Prettify -->
<script src="{{ asset('/index/js/owl.carousel.js') }}"></script>
<script>
    $(document).ready(function() {

        $("#owl-demo").owlCarousel({
            items : 1,
            lazyLoad : true,
            autoPlay : true,
            navigation : true,
            navigationText : ["",""],
            rewindNav :true,
            scrollPerPage :true,
            pagination : true,
            paginationNumbers: false,
        });

    });
    $(document).ready(function() {

        $("#owl-demo1").owlCarousel({
            items : 1,
            lazyLoad : true,
            autoPlay : true,
            navigation : true,
            navigationText : ["",""],
            rewindNav : true,
            scrollPerPage :true,
            pagination : false,
            paginationNumbers: false,
        });

    });

    $(document).ready(function() {

        $('#select-precio').change(function(){
            var moneda=$(this).val();

            if(moneda=="usd"){
                $('#precio-basico').empty();
                $('#precio-basico').html('$300 USD/mes');

                $('#precio-profesional').empty();
                $('#precio-profesional').html('$1400 USD/mes');

            }
            if(moneda=="clp"){
                $('#precio-basico').empty();
                $('#precio-basico').html('$200.000 CLP/mes');

                $('#precio-profesional').empty();
                $('#precio-profesional').html('$900.000 CLP/mes');

            }

            if(moneda=="cop"){
                $('#precio-basico').empty();
                $('#precio-basico').html('$600.000 COP/mes');

                $('#precio-profesional').empty();
                $('#precio-profesional').html('$3.000.000 COP/mes');

            }


        });

    });

</script>
<!----start-pricingplans---->
<div  class="blog" id="blog">
    <div class="wrap">
        <div class="pricing-plans">
            <h5>Planes Flexibles que se ajustan a sus necesidades</h5>
            <p>Seleccione su plan y empiece a recolectar datos inmediatamente.</p>
            <P><LAVEL>MONEDA:</LAVEL> <select id="select-precio">
                <option value="clp">CLP</option>
                <option value="cop">COP</option>
                <option value="usd">USD</option>
            </select></P>
            <div class="pricing-grids">
                <div class="pricing-grid black">
                    <h3><a href="#">Básico</a></h3>
                    <div class="price-value">
                        <a href="#" id="precio-basico">$200.000 CLP/mes</a>
                    </div>
                    <ul>
                        <li><a href="#">1GB/mes</a></li>
                        <li><a href="#">2 Usuarios</a></li>
                        <li><a href="#">Registros limitados</a></li>
                    </ul>
                    <div class="cart">
                        <a class="popup-with-zoom-anim" href="#contact">Solicitar Ahora</a>
                    </div>
                </div>
                <div class="pricing-grid green">
                    <h3><a href="#">Profesional<h4>Más Popular </h4></a></h3>

                    <div class="price-value">
                        <a href="#" id="precio-profesional">$900.000 CLP/mes</a>
                    </div>
                    <ul>
                        <li><a href="#">5GB/mes</a></li>
                        <li><a href="#">10 Usuarios</a></li>
                        <li><a href="#">Registros ilimitados</a></li>
                    </ul>
                    <div class="cart">
                        <a class="popup-with-zoom-anim" href="#contact">Solicitar Ahora</a>
                    </div>
                </div>
                <div class="pricing-grid blue">
                    <h3><a href="#">Empresarial</a></h3>
                    <div class="price-value">
                        <a href="#contact">Solicitar Cotización</a>
                    </div>
                    <ul>
                        <li><a href="#">Más de 5GB/mes</a></li>
                        <li><a href="#">Más de 10 Usuarios </a></li>
                        <li><a href="#">Necesidades especiales adicionales</a></li>
                    </ul>
                    <div class="cart">
                        <a class="popup-with-zoom-anim" href="#contact">Solicitar Ahora</a>
                    </div>
                </div>
                <div class="clear"> </div>
                <!-----pop-up-grid---->
                <div id="small-dialog" class="mfp-hide">
                    <div class="pop_up">
                        <div class="payment-online-form-left">
                            <form>
                                <h4><span class="shipping"> </span>Información de Contacto</h4>
                                <ul>
                                    <li><input class="text-box-dark" type="text" value="Nombre" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Frist Name';}"></li>
                                    <li><input class="text-box-dark" type="text" value="Apellido" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Last Name';}"></li>
                                </ul>
                                <ul>
                                    <li><input class="text-box-dark" type="text" value="Email" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Email';}"></li>
                                    <li><input class="text-box-dark" type="text" value="Empresa" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Company Name';}"></li>
                                </ul>
                                <ul>
                                    <li><input class="text-box-dark" type="text" value="Telefono" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Phone';}"></li>
                                    <li><input class="text-box-dark" type="text" value="Dirección" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Address';}"></li>
                                    <div class="clear"> </div>
                                </ul>
                                <div class="clear"> </div>
                                <ul class="payment-type">
                                    <h4><span class="payment"> </span> Tipos de pago</h4>
                                    <li><span class="col_checkbox">
													<input id="3" class="css-checkbox1" type="checkbox">
													<label for="3" name="demo_lbl_1" class="css-label1"> </label>
													<a class="visa" href="#"> </a>
													</span>

                                    </li>
                                    <li>
													<span class="col_checkbox">
														<input id="4" class="css-checkbox2" type="checkbox">
														<label for="4" name="demo_lbl_2" class="css-label2"> </label>
														<a class="paypal" href="#"> </a>
													</span>
                                    </li>
                                    <div class="clear"> </div>
                                </ul>
                                <ul>
                                    <li><input class="text-box-dark" type="text" value="Numero de Tarjeta" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Card Number';}"></li>
                                    <li><input class="text-box-dark" type="text" value="Nombre en la tarjeta" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Name on card';}"></li>
                                    <div class="clear"> </div>
                                </ul>
                                <ul>
                                    <li><input class="text-box-light hasDatepicker" type="text" id="datepicker" value="Fecha de expiración" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Expiration Date';}"><em class="pay-date"> </em></li>
                                    <li><input class="text-box-dark" type="text" value="Código de seguridad" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Security Code';}"></li>
                                    <div class="clear"> </div>
                                </ul>
                                <ul class="payment-sendbtns">
                                    <li><input type="reset" value="Cancelar"></li>
                                    <li><input type="submit" value="Procesar la orden"></li>
                                </ul>
                                <div class="clear"> </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-----pop-up-grid---->
            </div>
            <div class="clear"> </div>
            <h6>Si tiene alguna inquietud acerca del precio por favor póngase en contacto con nosotros usando el formulario que se encuentra al final de esta página.</h6>
        </div>
    </div>
</div>
<!-- Add fancyBox light-box -->
<script src="{{ asset('/index/js/jquery.magnific-popup.js') }}" type="text/javascript"></script>

<script>
    $(document).ready(function() {
        $('.popup-with-zoom-anim').magnificPopup({
            type: 'inline',
            fixedContentPos: false,
            fixedBgPos: true,
            overflowY: 'auto',
            closeBtnInside: true,
            preloader: false,
            midClick: true,
            removalDelay: 300,
            mainClass: 'my-mfp-zoom-in'
        });
    });
</script>
<!----End-pricingplans---->
<!----start-contact---->
<div  class="contact" id="contact">
    <div class="contact">
        <h3>Manténgase en contacto</h3>
        <p>¿Tiene Preguntas? Siéntase libre en contactarnos, Nos encantaría escuchar de usted.</p>
        <div class="wrap">
           @include('index.partials.contac')
            <div class="clear"> </div>
            <div class="social_icon">
                <ul>

                    <li class="twitter"><a href="#"><span> </span></a></li>
                    <li class="facebook"><a href="#"><span> </span></a></li>
                    <li class="google"><a href="#"><span> </span></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!----//End-contact---->
<div class="footer">
    <div class="wrap">
        <div class="footer-con">

            <div class="footer-right">
                <ul>
                    <li class="active"><a href="#home" class="scroll">Inicio</a></li>
                    <li><a href="#team" class="scroll">PERAST</a></li>
                    <li><a href="#ourstory" class="scroll">Servicios</a></li>
                    <li><a href="#blog" class="scroll">Planes</a></li>
                    <li><a href="#contact" class="scroll">Contacto</a></li>
                    <div class="clear"> </div>
                </ul>
            </div>
            <div class="footer-left">
                <p> 2015 &#169; Template by <a href="#">W3layouts</a></p>

            </div>
            <div class="clear"> </div>
        </div>

    </div>

</div>
<!-- scroll_top_btn -->
<script type="text/javascript" src="{{ asset('/index/js/move-top.js') }}"></script>
<script type="text/javascript" src="{{ asset('/index/js/easing.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {

        var defaults = {
            containerID: 'toTop', // fading element id
            containerHoverID: 'toTopHover', // fading element hover id
            scrollSpeed: 1200,
            easingType: 'linear'
        };


        $().UItoTop({ easingType: 'easeOutQuart' });

    });
</script>

<!---smoth-scrlling---->
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $(".scroll").click(function(event){
            event.preventDefault();
            $('html,body').animate({scrollTop:$(this.hash).offset().top},1200);
        });
    });
</script>

<a href="#" id="toTop" style="display: block;"><span id="toTopHover" style="opacity: 1;"></span></a>

</body>
</html>
