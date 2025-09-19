<?php

$conn = new mysqli("localhost", "root","", "reforest", 3306);
if ($conn->connect_error) {
  die("Error de conexión: " . $conn->connect_error);
}


$sql = "SELECT especie, edad, cuidados, estado, fotoUrl, altura, diametroTronco, ST_AsText(coordenadas) as coordenadas,qrUrl FROM arboles";
$result = $conn->query($sql);


$arboles = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $arboles[] = $row;
  }
}
$conn->close();
?>
<!DOCTYPE html>
<html class="h-100" lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no" />
  <meta name="description" content="A growing collection of ready to use components for the CSS framework Bootstrap 5" />
  <link rel="apple-touch-icon" sizes="180x180" href="img/apple-touch-icon.png" />
  <link rel="icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png" />
  <link rel="icon" type="image/png" sizes="16x16" href="img/favicon-16x16.png" />
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />

  <link rel="icon" type="image/png" sizes="96x96" href=".t/img/favicon.png" />
  <meta name="author" content="Holger Koenemann" />
  <meta name="generator" content="Eleventy v2.0.0" />
  <meta name="HandheldFriendly" content="true" />

  <link rel="stylesheet" href="css/theme.min.css" />
  <script src="https://api.mapbox.com/mapbox-gl-js/v2.4.1/mapbox-gl.js"></script>
  <link href="https://api.mapbox.com/mapbox-gl-js/v2.4.1/mapbox-gl.css" rel="stylesheet" />
  <!-- Agrega tu clave de acceso de Mapbox -->
  <script>
    mapboxgl.accessToken =
      "pk.eyJ1IjoiYWxlc3NpcyIsImEiOiJjbGcxbHBtbHQwdDU5M2RubDFodjY3a2x0In0.NXe43GdM4PJBj7ow0Dnkpw";
  </script>
  <!-- Agrega tus estilos CSS personalizados -->
  <style>
    #skygreen-bot {
      position: fixed;
      bottom: 20px;
      right: 20px;
      width: 320px;
      background: rgb(255, 255, 255);
      border: 2px solidrgb(41, 43, 42);
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
      font-family: Arial, sans-serif;
      z-index: 9999;
    }

    #skygreen-header {
      background-color: #333940;
      color: white;
      padding: 10px;
      font-weight: bold;
      border-top-left-radius: 10px;
      border-top-right-radius: 10px;
    }

    #skygreen-body {
      padding: 10px;
    }

    #skygreen-question {
      width: 100%;
      padding: 8px;
      margin-bottom: 8px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    #skygreen-body button {
      background-color: #333940;
      color: white;
      padding: 8px 12px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }

    #skygreen-response {
      margin-top: 10px;
      font-size: 14px;
    }

    #skygreen-image iframe {
      width: 100%;
      height: 200px;
      border: none;
      margin-top: 10px;
    }

    /* inter-300 - latin */
    @font-face {
      font-family: "Inter";
      font-style: normal;
      font-weight: 300;
      font-display: swap;
      src: local(""), url("./fonts/inter-v12-latin-300.woff2") format("woff2"),
        /* Chrome 26+, Opera 23+, Firefox 39+ */
        url("./fonts/inter-v12-latin-300.woff") format("woff");
      /* Chrome 6+, Firefox 3.6+, IE 9+, Safari 5.1+ */
    }

    @font-face {
      font-family: "Inter";
      font-style: normal;
      font-weight: 500;
      font-display: swap;
      src: local(""), url("./fonts/inter-v12-latin-500.woff2") format("woff2"),
        /* Chrome 26+, Opera 23+, Firefox 39+ */
        url("./fonts/inter-v12-latin-500.woff") format("woff");
      /* Chrome 6+, Firefox 3.6+, IE 9+, Safari 5.1+ */
    }

    @font-face {
      font-family: "Inter";
      font-style: normal;
      font-weight: 700;
      font-display: swap;
      src: local(""), url("./fonts/inter-v12-latin-700.woff2") format("woff2"),
        /* Chrome 26+, Opera 23+, Firefox 39+ */
        url("./fonts/inter-v12-latin-700.woff") format("woff");
      /* Chrome 6+, Firefox 3.6+, IE 9+, Safari 5.1+ */
    }

    /* Estilos generales para el carrusel y los formularios */
    .carousel-container {
      width: 550px;
      overflow: hidden;
      margin: 0 auto;
    }

    .carousel {
      display: flex;
      transition: transform 0.5s;
    }

    .slide {
      flex: 0 0 100%;
      width: 500px;
      padding: 20px;

      background-color: #f9f9f9;
      box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
      display: none;
    }

    .titulo-pagina {
      font-size: 80px;
      font-weight: bold;

      /* Cambia el color según tu preferencia */
      text-align: left;
      /* Otros estilos adicionales según tus necesidades */
    }

    #modal {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: 1000;
      /* Ajusta este valor según sea necesario */
    }

    .modal-contenido {
      background-color: white;
      margin: 5% auto;
      /* Ajusta el margen superior según sea necesario */
      padding: 20px;
      border: 1px solid #888;
      max-width: 100%;
      /* Ajusta el ancho máximo del modal según sea necesario */
      border-radius: 30px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
      position: relative;
      z-index: 1001;
      /* Asegura que el contenido del modal esté por encima del fondo del modal */
    }

    .cerrar {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
      cursor: pointer;
      z-index: 1002;
      /* Asegura que el botón de cerrar esté por encima del contenido del modal */
    }

    .cerrar:hover,
    .cerrar:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
    }

    /* Estilos personalizados para el mapa */
    #map {
      width: 100%;
    }

    .tree-marker {
      border-radius: 50%;

      background-color: cover;
    }

    .map-legend {
      position: absolute;
      top: 10px;
      left: 10px;
      background-color: rgba(255, 255, 255, 0.8);
      /* Fondo semitransparente */
      padding: 10px;
      border-radius: 5px;
      font-family: Arial, sans-serif;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
      /* Sombra para resaltar la leyenda */
      z-index: 1000;
      /* Z-index alto para asegurar que esté sobre el mapa */
    }

    .map-legend h4 {
      margin: 0 0 10px;
      font-size: 14px;
    }

    .legend-icon {
      display: inline-block;
      width: 12px;
      height: 12px;
      margin-right: 8px;
      border-radius: 2px;
    }

    .legend-icon.protected {
      background-color: #ff0000;
      /* Color rojo para Árboles Protegidos */
    }

    .legend-icon.native {
      background-color: #00ff00;
      /* Color verde para Árboles Nativos */
    }

    .legend-icon.dangerous {
      background-color: #ffcc00;
      /* Color amarillo para Árboles Peligrosos */
    }

    .container-mapa {
      max-width: 1000px;
      /* Cambia este valor según el ancho que prefieras */
      margin: 0 auto;
      /* Centra el contenedor horizontalmente */

      /* Opcional: añade espacio alrededor del mapa */
    }

    #map {
      width: 100%;
      height: 90vh;
    }

    /* Estilos del popup */
    .mapboxgl-popup {
      max-width: 250px;
      font-family: Arial, sans-serif;
      opacity: 0;
      transform: scale(0.8);
      transition: opacity 0.3s ease, transform 0.3s ease;
    }

    .mapboxgl-popup-content {
      border-radius: 10px;
      padding: 10px;
      text-align: center;
      background-color: rgba(255, 255, 255, 0.9);
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
      position: relative;
    }

    .mapboxgl-popup-content h3 {
      margin: 0;
      font-size: 16px;
      color: #2a6d2a;
    }

    .mapboxgl-popup-content img {
      width: 100%;
      border-radius: 5px;
      margin: 5px 0;
    }

    /* Botón de cierre */
    .close-popup {
      position: absolute;
      top: 5px;
      right: 8px;
      background: red;
      color: white;
      border: none;
      font-size: 14px;
      width: 20px;
      height: 20px;
      line-height: 20px;
      text-align: center;
      cursor: pointer;
      border-radius: 50%;
    }
  </style>
  <script>
    function mostrarModal() {
      var modal = document.getElementById("modal");
      modal.style.display = "block";
    }

    function cerrarModal() {
      var modal = document.getElementById("modal");
      modal.style.display = "none";
    }
  </script>
</head>

<body data-bs-spy="scroll" data-bs-target="#navScroll">
  <nav id="navScroll" class="navbar navbar-expand-lg navbar-light fixed-top" tabindex="0" style="background-color: #f9f9f9e0">
    <div class="container">
      <a class="navbar-brand pe-4 fs-4" href="#top">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-layers-half" viewbox="0 0 16 16"></svg>

        <span class="ms-1 fw-bolde">SkyGreen<i class="bx bxs-tree-alt"></i></span>
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="#aboutus"> ¿Que hacemos? </a>
          </li>
          <!--<li class="nav-item">
              <a class="nav-link" href="#numbers"></a>
            </li>-->
          <li class="nav-item">
            <a class="nav-link" href="#map"> Árboles Registrados </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#workwithus"> Muro de Honor </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="info-legal.html"> Más Información </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="administrador.php"> Panel </a>
          </li>
          <li class="nav-item">
            <a class="nav-link btn btn-dark shadow rounded-0" style="color: white" href="#!" onclick="mostrarModal()">
              Login
            </a>
          </li>

        </ul>
      </div>
    </div>
  </nav>

  <div id="modal" class="modal">
    <div class="modal-contenido">
      <span class="cerrar" onclick="cerrarModal()">&times;</span>
      <h2 style="color: black">Login</h2>
      <div id="error-message" style="color: red; text-align: center; display: none;">Usuario o contraseña incorrectos</div>
      <form id="login-form" method="POST" action="login.php" onsubmit="return validarFormulario()">
        <label for="usuario" style="color: black">Usuario:</label>
        <input type="text" class="form-control" name="usuario" required /><br /><br />
        <label for="contrasena" style="color: black">Contraseña:</label>
        <input type="password" class="form-control" name="contrasena" required /><br /><br />
        <input type="submit" class="btn btn-primary" name="submit" value="Iniciar sesión" />
      </form>
    </div>
  </div>


  <div class="w-100 overflow-hidden bg-gray-100" id="top">
    <div class="container position-relative">
      <div class="col-12 col-lg-8 mt-0 h-100 position-absolute top-0 end-0 bg-cover" data-aos="fade-left" style="background-image: url(img/pla.jpg)"></div>
      <div class="row">
        <div class="col-lg-7 py-vh-6 position-relative" data-aos="fade-right">
          <h1 class="display-1 fw-bold mt-5">
            Bienvenido a SkyGreen
          </h1>
          <p class="lead">
            Transformamos Cochabamba. <br>
            Nuestra misión es construir un futuro más verde y sostenible.
            Nos complace presentar la Plataforma Web Ambiental, una innovadora iniciativa en colaboración con la Empresa Municipal de Áreas Verdes. Aquí, la comunidad y la naturaleza se unen.
            ¡Explora y participa en la transformación verde!
          </p>
          <a href="#aboutus" class="btn btn-dark btn-xl shadow me-3 rounded-0 my-5">Conoce mas sobre nosotros</a>
        </div>
      </div>
    </div>
  </div>

  <div class="py-vh-4 bg-gray-100 w-100 overflow-hidden" id="aboutus">
    <div class="container">
      <div class="row d-flex justify-content-between align-items-center">
        <div class="col-lg-6">
          <div class="row gx-5 d-flex">
            <div class="col-md-11">
              <div class="shadow ratio ratio-16x9 rounded bg-cover bp-center align-self-end" data-aos="fade-right" style="
                      background-image: url(img/mace.jpg);
                      --bs-aspect-ratio: 50%;
                    "></div>
            </div>
            <div class="col-md-5 offset-md-1">
              <div class="shadow ratio ratio-1x1 rounded bg-cover mt-5 bp-center float-end" data-aos="fade-up" style="background-image: url(img/mace2.jpg)"></div>
            </div>
            <div class="col-md-6">
              <div class="col-12 shadow ratio rounded bg-cover mt-5 bp-center" data-aos="fade-left" style="
                      background-image: url(img/mac4.webp);
                      --bs-aspect-ratio: 150%;
                    "></div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <h3 class="py-5 border-top border-dark" data-aos="fade-left">
            ¿Qué Hacemos?
          </h3>
          <p data-aos="fade-left" data-aos-delay="200">
            Mapa Interactivo: Descubre cada rincón verde de la Zona Norte, identificando árboles, parques y áreas verdes. Explora un mapa detallado que clasifica los árboles según su estado: protegidos, nativos y peligrosos.
            <br>
            Información Detallada: Aprende sobre las especies de árboles, su historia y los cuidados necesarios para su florecimiento. Accede a datos específicos como la edad de los árboles y consejos para su mantenimiento.
            <br>
            Eventos y Talleres: Únete a nuestras actividades comunitarias, aprende sobre jardinería sostenible y participa en la siembra de árboles. Promovemos la reforestación y te invitamos a registrar tus plantaciones en nuestra plataforma web.
          </p>
        </div>
      </div>
    </div>
  </div>
  <div class="small py-vh-3 w-100 overflow-hidden">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-lg-4 border-end" data-aos="fade-up">
          <div class="d-flex">
            <div class="col-md-3 flex-fill pt-3 pe-3 pe-md-0">
              <svg xmlns="http://www.w3.org/2000/svg" width="42" height="42" fill="currentColor" class="bi bi-box-seam" viewbox="0 0 16 16">
                <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z" />
              </svg>
            </div>
            <div class="col-md-9 flex-fill">
              <h3 class="h5 my-2">Registro de Árboles:</h3>
              <p>
                Registra tu árbol y conviértete en un guardián del verde en tu vecindario.
              </p>
              <h3 class="h5 my-2">Guía del arbolado urbano en Cochabamba</h3>
              <p>
                <a href="https://www.lostiempos.com/sites/default/files/ayma2021guiadeselecciondeespeciesparaelarboladourbanodecochabambaparacompartir_1_0.pdf" target="_blank">Informate aquí....</a>
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-4 border-end" data-aos="fade-up" data-aos-delay="200">
          <div class="d-flex">
            <div class="col-md-3 flex-fill pt-3 pt-3 pe-3 pe-md-0">
              <svg xmlns="http://www.w3.org/2000/svg" width="42" height="42" fill="currentColor" class="bi bi-card-checklist" viewbox="0 0 16 16">
                <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z" />
                <path d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0zM7 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0z" />
              </svg>
            </div>
            <div class="col-md-9 flex-fill">
              <h3 class="h5 my-2">Especies de Árboles Legales y Recomendadas para Plantar en Cochabamba</h3>
              <p>
                <a href="https://es.wikipedia.org/wiki/Polylepis" target="_blank">Kewiña (Polylepis spp.)</a>
                <br>
                <a href="https://es.wikipedia.org/wiki/Alnus_acuminata" target="_blank">Aliso (Alnus acuminata)</a>
                <br>
                <a href="https://www.minsal.cl/portal/url/item/7d99ff5a580fdbd7e04001011f016dc3.pdf" target="_blank">Molle (Schinus molle)</a>
                <br>
                <a href="https://es.wikipedia.org/wiki/Cinchona_officinalis" target="_blank">Quina (Cinchona officinalis)</a>
                <br>
                <a href="https://ciudadesverdes.com/arboles/jacaranda-mimosifolia/" target="_blank">Tarco (Jacaranda mimosifolia)</a>
                <br>
                <a href="https://es.wikipedia.org/wiki/Buddleja_coriacea" target="_blank">Kari Kari (Buddleja coriacea)</a>
                <br>
                <a href="https://sib.gob.ar/especies/tipuana-tipu" target="_blank">Tipa (Tipuana tipu)</a>
              </p>
            </div>

          </div>
        </div>

        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="400">
          <div class="d-flex">
            <div class="col-md-3 flex-fill pt-3 pt-3 pe-3 pe-md-0">
              <svg xmlns="http://www.w3.org/2000/svg" width="42" height="42" fill="currentColor" class="bi bi-window-sidebar" viewbox="0 0 16 16">
                <path d="M2.5 4a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1zm2-.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm1 .5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
                <path d="M2 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H2zm12 1a1 1 0 0 1 1 1v2H1V3a1 1 0 0 1 1-1h12zM1 13V6h4v8H2a1 1 0 0 1-1-1zm5 1V6h9v7a1 1 0 0 1-1 1H6z" />
              </svg>
            </div>
            <div class="col-md-9 flex-fill">
              <h3 class="h5 my-2">Seguimiento y Transparencia</h3>
              <p>
                Ofrecemos un sistema transparente donde pueden hacer un seguimiento del progreso de las
                plantaciones, proporcionando actualizaciones periódicas y
                datos detallados sobre las plantaciones realizadas.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="py-vh-5 w-100 overflow-hidden" id="numbers">
    <div class="container">
      <div class="row d-flex justify-content-between align-items-center">
        <div class="col-lg-5">
          <h3 class="py-5 border-top border-dark" data-aos="fade-right">
            Información Educativa
          </h3>
        </div>
        <div class="col-lg-6">
          <div class="row">
            <div class="col-12">
              <h2 class="display-6 mb-5" data-aos="fade-down">
                Importancia de la Reforestación
              </h2>
            </div>
            <div class="col-lg-6" data-aos="fade-up">
              <div class="display-1 fw-bold py-4">80%</div>
              <p class="text-black-50">
                Los bosques albergan al menos el 80% de la biodiversidad
                terrestre, proporcionando hogar y refugio para innumerables
                especies de plantas y animales.
              </p>
            </div>
            <div class="col-lg-6" data-aos="fade-up">
              <div class="display-1 fw-bold py-4">26,000 millas</div>
              <p class="text-black-50">
                Un acre de árboles puede absorber el dióxido de carbono
                producido por un automóvil que recorre 26,000 millas.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container-mapa">
    <div class="position-relative overflow-hidden bg-light" id="map" style="height: 550px; width: 100%;">
      <div class="map-legend">
        <h4>Categorías</h4>
        <div><span class="legend-icon protected"></span> Árboles Peligrosos</div>
        <div><span class="legend-icon native"></span> Árboles Nativos</div>
        <div><span class="legend-icon dangerous"></span> Árboles Protegidos</div>
      </div>
    </div>
  </div>
  
  <!-- 
  <div id="skygreen-bot">
    
    <div id="skygreen-header">IA SkyGreen</div>
    
    <div id="skygreen-body">
      
      <input type="text" id="skygreen-question" placeholder="Pregúntame sobre un árbol...">
      <button onclick="askSkyGreen()">Preguntar</button>
      <div id="skygreen-response"></div>
      <div id="skygreen-image"></div>
    </div>
  </div>
  -->

  <div class="container py-vh-4 w-100 overflow-hidden" id="workwithus">
    <div class="row d-flex justify-content-center align-items-center">
      <div class="col-lg-5">
        <h3 class="py-5 border-top border-dark" data-aos="fade-right">
          🌳 Muro de Honor: Héroes de la Reforestación 🌳
        </h3>
        <p>
          Estos son los héroes que están ayudando a restaurar nuestro ecosistema.
          ¡Gracias por formar parte de SkyGreen!
        </p>
      </div>
    </div>

    <div class="row">
      <!-- Tarjeta de Persona 1 -->
      <div class="col-md-4 mb-4" data-aos="fade-up">
        <div class="card text-center" style="background-color: #333940; color: #e0e0e0; border-radius: 12px;">
          <div class="card-body">
            <img src="img/person1.jpg" class="rounded-circle mb-3" alt="Persona 1" width="80" height="80">
            <h5 class="card-title">Alejandro Pérez</h5>
            <p class="card-text">🌿 Ha adoptado un <b>Pino</b></p>
          </div>
        </div>
      </div>

      <!-- Tarjeta de Persona 2 -->
      <div class="col-md-4 mb-4" data-aos="fade-up">
        <div class="card text-center" style="background-color: #333940; color: #e0e0e0; border-radius: 12px;">
          <div class="card-body">
            <img src="img/person2.jpg" class="rounded-circle mb-3" alt="Persona 2" width="80" height="80">
            <h5 class="card-title">María Gómez</h5>
            <p class="card-text">🌿 Ha adoptado un <b>Roble</b></p>
          </div>
        </div>
      </div>

      <!-- Tarjeta de Persona 3 -->
      <div class="col-md-4 mb-4" data-aos="fade-up">
        <div class="card text-center" style="background-color: #333940; color: #e0e0e0; border-radius: 12px;">
          <div class="card-body">
            <img src="img/person3.jpg" class="rounded-circle mb-3" alt="Persona 3" width="80" height="80">
            <h5 class="card-title">Carlos Rodríguez</h5>
            <p class="card-text">🌿 Ha adoptado un <b>Ciprés</b></p>
          </div>
        </div>
      </div>

      <!-- Tarjeta de Persona 4 -->
      <div class="col-md-4 mb-4" data-aos="fade-up">
        <div class="card text-center" style="background-color: #333940; color: #e0e0e0; border-radius: 12px;">
          <div class="card-body">
            <img src="img/person4.jpg" class="rounded-circle mb-3" alt="Persona 4" width="80" height="80">
            <h5 class="card-title">Laura Méndez</h5>
            <p class="card-text">🌿 Ha adoptado un <b>Olivo</b></p>
          </div>
        </div>
      </div>

      <!-- Tarjeta de Persona 5 -->
      <div class="col-md-4 mb-4" data-aos="fade-up">
        <div class="card text-center" style="background-color: #333940; color: #e0e0e0; border-radius: 12px;">
          <div class="card-body">
            <img src="img/person5.jpg" class="rounded-circle mb-3" alt="Persona 5" width="80" height="80">
            <h5 class="card-title">Fernando Ruiz</h5>
            <p class="card-text">🌿 Ha adoptado un <b>Almendro</b></p>
          </div>
        </div>
      </div>

      <!-- Tarjeta de Persona 6 -->
      <div class="col-md-4 mb-4" data-aos="fade-up">
        <div class="card text-center" style="background-color: #333940; color: #e0e0e0; border-radius: 12px;">
          <div class="card-body">
            <img src="img/person6.jpg" class="rounded-circle mb-3" alt="Persona 6" width="80" height="80">
            <h5 class="card-title">Ana López</h5>
            <p class="card-text">🌿 Ha adoptado un <b>Cerezo</b></p>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div id="formAdopcionModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); z-index: 9999; justify-content: center; align-items: center;">
    <div style="background: white; padding: 20px; border-radius: 12px; width: 350px; position: relative; display: flex; flex-direction: column;">
      <button id="cerrarFormularioBtn" style="position: absolute; top: 8px; right: 10px; background: none; border: none; font-size: 20px; cursor: pointer;">&times;</button>
      <h2 style="margin-bottom: 10px; color: #16a34a;">Formulario de Adopción</h2>
      <form id="formAdopcion">
        <input type="hidden" name="arbol_id" id="arbolIdInput">

        <label for="nombre">Nombre completo:</label>
        <input type="text" id="nombre" name="nombre" required style="width: 100%; padding: 6px; margin-bottom: 8px;">

        <label for="correo">Correo electrónico:</label>
        <input type="email" id="correo" name="correo" required style="width: 100%; padding: 6px; margin-bottom: 8px;">

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" style="width: 100%; padding: 6px; margin-bottom: 8px;">

        <label for="mensaje">¿Por qué deseas adoptar este árbol?</label>
        <textarea id="mensaje" name="mensaje" rows="3" style="width: 100%; padding: 6px; margin-bottom: 10px;"></textarea>

        <button type="submit" style="padding: 8px 12px; background-color: #16a34a; color: white; border: none; border-radius: 6px; cursor: pointer;">Enviar solicitud</button>
      </form>
    </div>
  </div>

  <div class="container py-vh-3 border-top" data-aos="fade" data-aos-delay="200" id="testimonials">
    <div class="row d-flex justify-content-center">
      <div class="col-12 col-lg-8 text-center">
        <h3 class="fs-2 fw-light">
          Ingresa tu<span class="fw-bold"> correo electrónico</span> para
          proporcionarte más información
        </h3>
      </div>
      <div class="col-12 col-lg-8 text-center">
        <div class="row">
          <div class="grouped-inputs border bg-light p-2">
            <div class="row">
              <div class="col">
                <form action="interesados.php" method="post" class="form-floating">
                  <input type="email" name="email" class="form-control p-3" id="email" placeholder="name@example.com" required />
                  <div class="col-auto">
                    <br />
                    <button type="submit" class="btn btn-dark py-3 px-5">
                      Enviar
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <footer>
    <div class="container small border-top">
      <div class="row py-2 d-flex justify-content-between">
        <div class="text-secondary mt-3 col-12 col-lg-6 col-xl-3 border-end p-5">
          <strong class="h6 mb-3">SkyGreen<i class="bx bxs-tree-alt"></i></strong><br />

          <address class="text-secondary mt-3">
            "Cambiando la vida del mundo"
          </address>
          <ul class="nav flex-column"></ul>
        </div>
        <div class="text-secondary mt-3 col-12 col-lg-6 col-xl-3 border-end p-5">
          <h3 class="h6 mb-3">Facebook</h3>
          <address class="text-secondary mt-3">Siguenos en facebook:</address>
          <ul class="nav flex-column"></ul>
        </div>
        <div class="text-secondary mt-3 col-12 col-lg-6 col-xl-3 border-end p-5">
          <h3 class="h6 mb-3">Instagram</h3>
          <address class="text-secondary mt-3">
            Siguenos en instagram:
          </address>
          <ul class="nav flex-column"></ul>
        </div>
        <div class="text-secondary mt-3 col-12 col-lg-6 col-xl-3 p-5">
          <h3 class="h6 mb-3">Whatsapp</h3>
          <address class="text-secondary mt-3">Siguenos en WhatsApp:</address>
          <ul class="nav flex-column"></ul>
        </div>
      </div>
    </div>

    <div class="container text-center py-3 small">
      By
      <a href="https://github.com/Aless030" class="link-fancy" target="_blank">SkyGreen.com</a>
    </div>
  </footer>

  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/aos.js"></script>
  <script>
    mapboxgl.accessToken = 'pk.eyJ1IjoiYWxlc3NpcyIsImEiOiJjbGcxbHBtbHQwdDU5M2RubDFodjY3a2x0In0.NXe43GdM4PJBj7ow0Dnkpw';

    const map = new mapboxgl.Map({
      container: 'map',
      style: 'mapbox://styles/mapbox/outdoors-v11',
      center: [-66.158468, -17.374908],
      zoom: 17,
      pitch: 50,
      bearing: -17.6
    });

    // 
    const arboles = <?php echo json_encode($arboles); ?>;

    arboles.forEach(arbol => {
      const coordinates = arbol.coordenadas.replace('POINT(', '').replace(')', '').split(' ');
      const lng = parseFloat(coordinates[0]);
      const lat = parseFloat(coordinates[1]);

      if (isNaN(lng) || isNaN(lat)) {
        console.error("Coordenadas inválidas:", arbol);
        return;
      }

      // 
      const el = document.createElement('div');
      el.className = 'tree-marker';
      el.style.backgroundImage = 'url("https://cdn2.iconfinder.com/data/icons/miscellaneous-iii-glyph-style/150/tree-512.png")';
      el.style.width = '30px';
      el.style.height = '30px';
      el.style.backgroundSize = 'cover';
      el.style.cursor = 'pointer';

      // Asignar borde según estado del árbol
      switch (arbol.estado.toLowerCase()) {
        case 'peligrosos':
          el.style.border = '3px solid red';
          break;
        case 'protegido':
          el.style.border = '3px solid yellow';
          break;
        case 'nativo':
          el.style.border = '3px solid green';
          break;
        default:
          el.style.border = '3px solid gray';
      }

      //  popup 
      const popupContent = `
      <style="max-width: 200px; padding: 4px; font-size: 12px;">
      <button class="close-popup" style="
          position: absolute;
          top: 3px;
          right: 5px;
          background: #ff4d4f;
          color: #fff;
          border: none;
          font-size: 12px;
          width: 16px;
          height: 16px;
          line-height: 16px;
          text-align: center;
          cursor: pointer;
          border-radius: 50%;
          transition: background 0.2s;
      ">&times;</button>
      
      <h3 style="font-size: 14px; margin-bottom: 5px;">${arbol.especie}</h3>

      <a href="360.html"> <!-- Cambia esto al nombre del HTML al que quieres ir -->
         <img src="${arbol.fotoUrl}" alt="Foto del árbol" style="
         width: 80%; 
         height: 90px; 
         border-radius: 5px; 
         margin-bottom: 5px;
        "/>
      </a>
      
      <p style="margin: 3px 0; font-size: 12px; line-height: 1.2;">
          <strong>Edad:</strong> ${arbol.edad} años
      </p>
      
      <p style="margin: 3px 0; font-size: 12px; line-height: 1.2;">
          <strong>Altura:</strong> ${arbol.altura} m
      </p>
      
      <p style="margin: 3px 0; font-size: 12px; line-height: 1.2;">
          <strong>Diámetro:</strong> ${arbol.diametroTronco} cm
      </p>
      
      <p style="margin: 3px 0; font-size: 12px; line-height: 1.2;">
          <strong>Cuidados:</strong> ${arbol.cuidados}
      </p>
      
      <p style="margin: 3px 0; font-size: 12px; line-height: 1.2;">
          <strong>Estado:</strong> ${arbol.estado}
      </p>
      
      <img src="${arbol.qrUrl}" alt="QR" style="
          width: 60px; 
          height: 60px; 
          border-radius: 5px;
      "/>
      <br>
      <button class="abrir-form-adopcion" data-id="${arbol.id}" data-especie="${arbol.especie}" style="
      margin-top: 6px;
      padding: 5px 10px;
      background-color: #16a34a;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 12px;
    ">Adoptar árbol</button>
  
  </div>
`;




      const popup = new mapboxgl.Popup({
          offset: [20, -70], 
          closeButton: false,
          closeOnClick: true
        })
        .setHTML(popupContent);

      
      const marker = new mapboxgl.Marker(el)
        .setLngLat([lng, lat])
        .setPopup(popup)
        .addTo(map);

     
      el.addEventListener('click', () => {
        map.flyTo({
          center: [lng, lat],
          zoom: 18,
          essential: true
        });

        setTimeout(() => {
          popup.addTo(map);

         
          const popupElement = document.querySelector('.mapboxgl-popup');
          if (popupElement) {
            popupElement.style.opacity = '1';
            popupElement.style.transform = 'translateX(20px) translateY(-10px) scale(1.1)'; // Desplazamiento hacia la derecha y hacia arriba
            popupElement.style.transition = 'transform 0.2s ease, opacity 0.2s ease';
          }

        
          setTimeout(() => {
            const closeBtn = document.querySelector(".close-popup");
            if (closeBtn) {
              closeBtn.addEventListener("click", () => {
                popup.remove();
              });
            }
          }, 100);
        }, 300);
      });




      document.addEventListener('click', function(event) {
        if (event.target && event.target.classList.contains('abrir-form-adopcion')) {
          const arbolId = event.target.getAttribute('data-id');
          document.getElementById('arbolIdInput').value = arbolId;
          document.getElementById('formAdopcionModal').style.display = 'flex';
        }
      });

  
      document.getElementById('cerrarFormularioBtn').addEventListener('click', function() {
        document.getElementById('formAdopcionModal').style.display = 'none';
      });

      
      window.addEventListener('click', function(event) {
        const modal = document.getElementById('formAdopcionModal');
        if (event.target === modal) {
          modal.style.display = 'none';
        }
      });

     
      document.getElementById('formAdopcion').addEventListener('submit', function(e) {
        e.preventDefault();
        alert("¡Gracias por adoptar un árbol! 🌱");
        document.getElementById('formAdopcionModal').style.display = 'none';
        this.reset();
      });




    });

    /*async function askSkyGreen() {
      const pregunta = document.getElementById("skygreen-question").value;
      const especie = corregirNombreEspecie(extractSpecies(pregunta));

      document.getElementById("skygreen-response").innerHTML = "🔍 Buscando información...";
      document.getElementById("skygreen-image").innerHTML = "";

      try {
        // ✅ Info de Wikipedia
        const wikiRes = await fetch(`https://es.wikipedia.org/api/rest_v1/page/summary/${encodeURIComponent(especie)}`);
        const wikiData = await wikiRes.json();

        const resumen = wikiData.extract || "🌱 No se encontró información sobre esa especie.";
        document.getElementById("skygreen-response").innerHTML = `<p><strong>${especie}:</strong> ${resumen}</p>`;

        // ✅ Imagen de Wikipedia si existe
        if (wikiData.thumbnail && wikiData.thumbnail.source) {
          const imageURL = wikiData.thumbnail.source;
          document.getElementById("skygreen-image").innerHTML = `
          <p><strong>Imagen del árbol:</strong></p>
          <img src="${imageURL}" alt="Imagen de ${especie}" style="width:100%; border-radius: 8px;" />
        `;
        } else {
          document.getElementById("skygreen-image").innerHTML = "<p>❌ No se encontró imagen para esta especie.</p>";
        }

      } catch (error) {
        document.getElementById("skygreen-response").innerHTML = `<p>❌ Error al buscar información.</p>`;
        console.error(error);
      }
    }

    function extractSpecies(texto) {
      let cleaned = texto.toLowerCase();
      const stopWords = ['qué', 'es', 'el', 'la', 'un', 'una', 'árbol', 'sobre', 'quiero', 'saber', 'del', 'de', 'en', 'bolivia', 'háblame', 'como', 'cómo'];
      stopWords.forEach(w => cleaned = cleaned.replace(w, ''));
      return cleaned.trim().replace(/\s+/g, ' ');
    }

    function corregirNombreEspecie(nombre) {
      const mapa = {
        "lluvia dorada": "Cassia fistula",
        "tajibo": "Handroanthus impetiginosus",
        "algarrobo": "Prosopis alba",
        "copaibo": "Copaifera langsdorffii",
        "toborochi": "Ceiba speciosa",
        "palo santo": "Bursera graveolens"
      };
      return mapa[nombre] || nombre;
    }*/
  </script>



  <script>
    AOS.init({
      duration: 800, // values from 0 to 3000, with step 50ms
    });

    const formCount = 3;
    let currentForm = 1;

    // EventListeners para el botón "Siguiente" y "Anterior"
    document.getElementById("next").addEventListener("click", function() {
      if (validarFormularioActual()) {
        if (currentForm < formCount) {
          document.getElementById("slide" + currentForm).style.display =
            "none";
          currentForm++;
          document.getElementById("slide" + currentForm).style.display =
            "block";

          document.getElementById("prev").style.display = "block";
          if (currentForm === formCount) {
            document.getElementById("next").style.display = "none";
            document.querySelector(
              'form button[type="submit"]'
            ).style.display = "block";
          }
        }
      }
    });

    document.getElementById("prev").addEventListener("click", function() {
      if (currentForm > 1) {
        document.getElementById("slide" + currentForm).style.display = "none";
        currentForm--;
        document.getElementById("slide" + currentForm).style.display =
          "block";

        document.getElementById("next").style.display = "block";
        if (currentForm === 1) {
          document.getElementById("prev").style.display = "none";
        }
      }
    });

    function validarFormularioActual() {
      const currentSlide = document.getElementById("slide" + currentForm);
      const requiredFields = currentSlide.querySelectorAll("[required]");
      let isValid = true;

      requiredFields.forEach((field) => {
        if (field.value.trim() === "") {
          isValid = false;
          field.classList.add("campo-invalido");
        } else {
          field.classList.remove("campo-invalido");
        }
      });

      if (!isValid) {
        alert("Por favor, complete todos los campos requeridos.");
      }

      return isValid;
    }
  </script>
  
  <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</body>

</html>