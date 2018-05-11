<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>COMPROMISO EMPRESARIAL</title>

        <!-- Styles -->
        <link href="{{ asset('template/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('template/css/fancybox/jquery.fancybox.css') }}" rel="stylesheet">
        <link href="{{ asset('template/css/flexslider.css') }}" rel="stylesheet">
        <link href="{{ asset('template/css/style.css') }}" rel="stylesheet">

    </head>
    <body>
        <div id="wrapper" class="home-page">
            
            <!-- start header -->
            <header>
                <div class="navbar navbar-default navbar-static-top">
                    <div class="container">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="{{ url('/') }}" ><img src="{{ asset('template/img/logo.png') }}" alt="logo"/></a>
                        </div>
                        <div class="navbar-collapse collapse ">
                            <ul class="nav navbar-nav">

                                @if (Route::has('login'))
                                    @if (Auth::check())
                                        <li><a href="{{ url('/home') }}">Inicio</a></li>
                                    @else
                                        <li><a href="{{ url('/login') }}">Login</a></li>
                                        <li><a href="{{ url('/generador') }}">Registrar Generador</a></li>
                                        <li><a href="{{ url('/transportista') }}">Registrar Transportista</a></li>
                                        
                                    @endif
                                @endif

                            </ul>
                        </div>
                    </div>
                </div>
            </header>
            <!-- end header -->

            <section id="banner">
             
                <!-- Slider -->
                    <div id="main-slider" class="flexslider">
                        <ul class="slides">
                          <li>
                            <img src="{{ asset('template/img/slides/slide01.jpg') }}" alt="" />
                            <div class="flex-caption container">
                                <h3>Compromiso Empresarial</h3> 
                                <p>
                                    Somos una empresa que brinda  soluciones logísticas innovadoras <br>
                                    en la cadena de abastecimiento par las cargas de nuestros clientes <br>
                                    viajen de forma segura, rápida y puntual.
                                </p> 
                            </div>
                          </li>
                        </ul>
                    </div>
                <!-- end slider -->
            </section>

            <section class="txt-area">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="aligncenter"><h1 class="aligncenter">¿Por qué elegirnos?</h1></div>
                            
                        </div>
                    </div>
                </div>
            </section>
            
            <section id="content">
                <div class="container">
                    <div class="row">
                            <div class="features">
                                <div class="col-md-6 col-sm-6 wow fadeInUp animated" data-wow-duration="300ms" data-wow-delay="0ms" style="visibility: visible; -webkit-animation-duration: 300ms; -webkit-animation-delay: 0ms;">
                                    <div class="media service-box">
                                        <div class="pull-left">
                                            <i class="fa fa-bullseye"></i>
                                        </div>
                                        <div class="media-body">
                                            <h4 class="media-heading">Compromiso</h4>
                                            <p>
                                                Brindamos servicios de transporte de carga, soluciones de logística, distribución de cargas y alquiler de maquinaria, enfocada en satisfacer las necesidades de nuestros clientes.
                                            </p>
                                        </div>
                                    </div>
                                </div><!--/.col-md-4-->

                                <div class="col-md-6 col-sm-6 wow fadeInUp animated" data-wow-duration="300ms" data-wow-delay="100ms" style="visibility: visible; -webkit-animation-duration: 300ms; -webkit-animation-delay: 100ms;">
                                    <div class="media service-box">
                                        <div class="pull-left">
                                            <i class="fa fa-bullseye"></i>
                                        </div>
                                        <div class="media-body">
                                            <h4 class="media-heading">Seguridad y Cumplimiento</h4>
                                            <p>
                                                La seguridad de su carga es una de nuestras principales prioridades. Cada paquete es manejado con la mayor atención por nuestro personal capacitado y altamente calificado.
                                            </p>
                                        </div>
                                    </div>
                                </div><!--/.col-md-4-->

                                <div class="col-md-6 col-sm-6 wow fadeInUp animated" data-wow-duration="300ms" data-wow-delay="200ms" style="visibility: visible; -webkit-animation-duration: 300ms; -webkit-animation-delay: 200ms;">
                                    <div class="media service-box">
                                        <div class="pull-left">
                                            <i class="fa fa-bullseye"></i>
                                        </div>
                                        <div class="media-body">
                                            <h4 class="media-heading">Profesionalismo</h4>
                                            <p>
                                                Contamos con un equipo humano calificado y de vasta experiencia por líneas de negocio. <br>
                                                Contamos con la tecnologia necesaria para brindar un servicio optimo y de garantía a todos nuestros clientes.
                                            </p>
                                        </div>
                                    </div>
                                </div><!--/.col-md-4-->
                            
                                <div class="col-md-6 col-sm-6 wow fadeInUp animated" data-wow-duration="300ms" data-wow-delay="300ms" style="visibility: visible; -webkit-animation-duration: 300ms; -webkit-animation-delay: 300ms;">
                                    <div class="media service-box">
                                        <div class="pull-left">
                                            <i class="fa fa-bullseye"></i>
                                        </div>
                                        <div class="media-body">
                                            <h4 class="media-heading">Flota de unidades</h4>
                                            <p>
                                                Tenemos disponibilidad de unidades a nivel nacional. <br>
                                                Contamos con seguros de Carga para todos nuestros servicios.
                                            </p>
                                        </div>
                                    </div>
                                </div><!--/.col-md-4-->
                            </div>
                        </div>   
                </div>
            </section>
            
            <section class="aboutUs">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="aligncenter"><h2 class="aligncenter">Nuestros Servicios</h2></div>
                            <br/>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            <h4>TRANSPORTE DE CARGA POR CARRETERA</h4>
                            <ul class="list-unstyled">
                                <li><i class="fa fa-arrow-circle-right pr-10 colored"></i> Transporte de mineral </li>
                                <li><i class="fa fa-arrow-circle-right pr-10 colored"></i> Transporte de envases o insumos </li>
                                <li><i class="fa fa-arrow-circle-right pr-10 colored"></i> Transporte de perecibles </li>
                                <li><i class="fa fa-arrow-circle-right pr-10 colored"></i> Transporte de postes </li>
                                <li><i class="fa fa-arrow-circle-right pr-10 colored"></i> Transporte de de harina de pescado </li> 
                            </ul>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <h4>ALQUILER DE MAQUINARIA</h4>
                            <p>
                                Esta opción permite una mayor eficiencia en el proceso de la obra. Por ello contamos con un amplio catalogo de maquinaria gracias al cual ofrecemos un servicio tanto a empresas privadas como al sector público.
                            </p>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <h4>OPERACIONES LOGÍSTICAS</h4>
                            <p>
                                Coordinamos la ejecución del transporte y distritubución de la mercaderia por carretera así mismo realizamos el seguimiento de las unidades transportadoras.
                            </p>
                        </div>
                        <!-- <div class="col-md-6">
                            <p>Lorem ipsum dolor sit amet, cadipisicing  sit amet, consectetur adipisicing elit. Atque sed, quidem quis praesentium, ut unde fuga error commodi architecto, oribus omnis minus temporibus perferendis nesciunt quam repellendus nulla nemo ipsum odit corrupti consequuntur possimus, vero mollitia velit ad consectetur. Alias, laborum excepturi nihil autem nemo numquam, ipsa architecto non, magni consequuntlaudantium culpa tenetur at id, beatae pet.</p>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. adipisicing  sit amet, consectetur adipisicing elit. Atque sed, quidem quis praesentium,m deserunt.</p>
                            <ul class="list-unstyled">
                                <li><i class="fa fa-arrow-circle-right pr-10 colored"></i> Lorem ipsum enimdolor sit amet</li>
                                <li><i class="fa fa-arrow-circle-right pr-10 colored"></i> Explicabo deleniti neque aliquid</li>
                                <li><i class="fa fa-arrow-circle-right pr-10 colored"></i> Consectetur adipisicing elit</li>
                                <li><i class="fa fa-arrow-circle-right pr-10 colored"></i> Lorem ipsum dolor sit amet</li>
                                <li><i class="fa fa-arrow-circle-right pr-10 colored"></i> Quo issimos molest quibusdam temporibus</li>
                            </ul>
                        </div> -->
                     </div>
                
                </div>
            </section>

            <section id="clients">
                <div class="container">
                        <div class="row">
                    <div class="col-md-12">
                        <div class="aligncenter"><h2 class="aligncenter">Nuestros Clientes</h2></div>
                        <br/>
                    </div>
                </div>
                    <div class="row">
                        <div class="col-md-2 col-sm-4 client">
                            <div class="img client1"></div>
                        </div>
                        <div class="col-md-2 col-sm-4 client">
                            <div class="img client2"></div>
                        </div>
                        <div class="col-md-2 col-sm-4 client">
                            <div class="img client3"></div>
                        </div>
                        <div class="col-md-2 col-sm-4 client">
                            <div class="img client4"></div>
                        </div>
                        <div class="col-md-2 col-sm-4 client">
                            <div class="img client5"></div>
                        </div>
                        <div class="col-md-2 col-sm-4 client">
                            <div class="img client6"></div>
                        </div>
                    </div>
                </div>
            </section> 
            
            <footer>
                <div id="sub-footer">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="copyright">
                                    <p>
                                        <span>&copy; 2018 COEMPPERU S.A.C. </span>- Todos los Derechos Reservados | MKT y Diseño: <a href="https://www.edesce.com/" rel="nofollow" target="_blank">EDESCE E.I.R.L.</a> </a>
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <ul class="social-network">
                                    <li><a href="https://www.facebook.com/compromisoempresarialsac" data-placement="top" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="#" data-placement="top" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="https://www.linkedin.com/in/compromiso-empresarial-sac-919882150/" data-placement="top" title="Linkedin"><i class="fa fa-linkedin"></i></a></li>
                                    <li><a href="#" data-placement="top" title="Google plus"><i class="fa fa-google-plus"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>

        <script src="{{ asset('template/js/jquery.js') }}"></script>
        <script src="{{ asset('template/js/jquery.easing.1.3.js') }}"></script>
        <script src="{{ asset('template/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('template/js/jquery.fancybox.pack.js') }}"></script>
        <script src="{{ asset('template/js/jquery.fancybox-media.js') }}"></script> 
        <script src="{{ asset('template/js/portfolio/jquery.quicksand.js') }}"></script>
        <script src="{{ asset('template/js/portfolio/setting.js') }}"></script>
        <script src="{{ asset('template/js/jquery.flexslider.js') }}"></script>
        <script src="{{ asset('template/js/animate.js') }}"></script>
        <script src="{{ asset('template/js/custom.js') }}"></script>

    </body>
</html>
