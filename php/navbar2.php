<div id="preloader" class="loader">
    <div class="loader__container">
        <style>
            #outline {
                stroke-dasharray: 2, 2000;
                stroke-dashoffset: -20;
                animation: anim 1.6s linear infinite;
            }

            @keyframes anim {
                12.5% {
                    stroke-dasharray: 140, 860;
                    stroke-dashoffset: -110;
                }

                43.75% {
                    stroke-dasharray: 350, 650;
                    stroke-dashoffset: -350;
                }

                100% {
                    stroke-dasharray: 2, 1078;
                    stroke-dashoffset: -1074;
                }
            }
        </style>
        <div class="logo">
            AnimaL
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 387.6 189.77">
                <defs>
                    <style>
                        .cls-1,
                        .cls-2 {
                            fill: none;
                            stroke: #f5d049;
                            stroke-linecap: round;
                            stroke-linejoin: round;
                            stroke-width: 44px;
                        }

                        .cls-2 {
                            opacity: 0.2;
                            isolation: isolate;
                            stroke: #bebebe;
                        }
                    </style>
                </defs>
                <title>Recurso 4</title>
                <g id="Capa_2" data-name="Capa 2">
                    <g id="Capa_1-2" data-name="Capa 1">
                        <path id="outline-bg" class="cls-2"
                            d="M194.84,93.22c38.73,39.57,57.48,74.55,97.88,74.55A72.7,72.7,0,0,0,365.6,94.89c0-40.4-32.49-73.3-72.88-72.89s-55.4,30-92.05,71.22c-37.07,36.65-65.39,74.55-105.79,74.55A72.89,72.89,0,0,1,94.88,22C135.28,22,162.77,60.74,194.84,93.22Z" />
                        <path id="outline" class="cls-1"
                            d="M194.84,93.22c38.73,39.57,57.48,74.55,97.88,74.55A72.7,72.7,0,0,0,365.6,94.89c0-40.4-32.49-73.3-72.88-72.89s-55.4,30-92.05,71.22c-37.07,36.65-65.39,74.55-105.79,74.55A72.89,72.89,0,0,1,94.88,22C135.28,22,162.77,60.74,194.84,93.22Z" />
                    </g>
                </g>
            </svg>
            p
        </div>
    </div>
</div>
<!-- Back To Top Start -->
<a href="#main-wrapper" id="backto-top" class="back-to-top"><i class="fas fa-angle-up"></i></a>

<nav class="navbar navbar-expand-lg nav-2" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand mx-4" href="#">LOGO</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item my-3 my-lg-3 mx-4">
                    <a class="nav-link active" aria-current="page" href="/index.php">Inicio</a>
                </li>
                <li class="nav-item my-3 my-lg-3 mx-4">
                    <a class="nav-link" href="/anime-listing.php">Listado</a>
                </li>
                <li class="nav-item my-3 my-lg-3 mx-4 dropdown has-children">
                    <a class="nav-link dropdown-toggle" href="#" role="button">
                        Paginas
                    </a>
                    <ul class="dropdown-menu bg-light-black">
                        <li><a class="dropdown-item" href="/404.php">404</a></li>
                        <li><a class="dropdown-item" href="/coming-soon.php">Proximamente</a></li>
                        <li><a class="dropdown-item" href="/sign-up.php">Registrate</a></li>
                        <li><a class="dropdown-item" href="/login.php">Inicia Sesion</a></li>
                    </ul>
                </li>
            </ul>
            <form class="d-flex py-3" role="search" action="/anime-listing.php" method="GET">
                <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Search" name="search">
                <button class="btn btn-outline-primary" type="submit">Buscar</button>
            </form>

            <ul class="navbar-nav">
                <li class="nav-item my-3 my-lg-3 mx-4 dropdown has-children">
                    <a class="nav-link dropdown-toggle" href="#" role="button">
                        <img src="assets/media/author/profile.png" alt="">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end bg-light-black">
                        <li><a class="dropdown-item" href="/sign-up.php">Registrate</a></li>
                        <li><a class="dropdown-item" href="/login.php">Inicia Sesion</a></li>
                    </ul>
                </li>
            </ul>

        </div>
    </div>
</nav>