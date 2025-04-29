
<?php
// index.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <base href="">
  <meta charset="UTF-8">
  <meta name="referrer" content="no-referrer">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reproductor de Video con HLS</title>
  <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
  <script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2"></script>
  <style>
    /* --- Estilos mejorados --- */
    :root {
      --primary-color: #6c5ce7;
      --secondary-color: #a29bfe;
      --accent-color: #fd79a8;
      --background: #f9f9f9;
      --text-color: #2d3436;
    }
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0; padding: 20px;
      background: linear-gradient(135deg, #a8e6cf 0%, #dcedc1 100%);
      min-height: 100vh;
    }
    .container {
      max-width: 1200px;
      margin: auto;
      padding: 30px;
      background: rgba(255,255,255,0.95);
      border-radius: 20px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      backdrop-filter: blur(10px);
    }
    .titulo {
      font-size: 42px;
      text-align: center;
      font-weight: bold;
      color: var(--primary-color);
      margin-bottom: 20px;
      position: relative;
      padding-bottom: 15px;
    }
    .titulo::after {
      content: '';
      width: 100px; height: 4px;
      background: linear-gradient(to right, var(--primary-color), var(--accent-color));
      position: absolute; bottom: 0; left: 50%;
      transform: translateX(-50%);
      border-radius: 2px;
    }
    .subtitulo {
      font-size: 28px;
      margin-top: 30px;
      margin-bottom: 15px;
      text-align: center;
      color: var(--text-color);
    }
    video.reproductor {
      width: 100%;
      height: 500px;
      border-radius: 15px;
      background: black;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      transition: transform 0.3s, box-shadow 0.3s;
    }
    video.reproductor:hover {
      transform: scale(1.01);
      box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    ul.lista-reproduccion {
      list-style: none;
      padding: 0;
      margin-top: 20px;
      background: white;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    .lista-reproduccion li {
      padding: 15px 20px;
      cursor: pointer;
      border-bottom: 1px solid rgba(0,0,0,0.05);
      transition: all 0.3s;
      display: flex;
      align-items: center;
    }
    .lista-reproduccion li:hover {
      background: rgba(108, 92, 231, 0.05);
      padding-left: 25px;
    }
    .lista-reproduccion li::before {
      content: '▶';
      margin-right: 10px;
      opacity: 0;
      transform: translateX(-10px);
      transition: all 0.3s;
      color: var(--primary-color);
    }
    .lista-reproduccion li:hover::before {
      opacity: 1;
      transform: translateX(0);
    }
    .lista-reproduccion .seleccionado {
      background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
      color: white;
      font-weight: bold;
    }
    .footer {
      margin-top: 30px;
      text-align: center;
      font-size: 14px;
      color: var(--text-color);
      opacity: 0.8;
      border-top: 1px solid rgba(0,0,0,0.1);
      padding: 20px;
    }
    @media(max-width:768px){
      video.reproductor { height: 250px; }
      .titulo { font-size: 32px; }
      .subtitulo { font-size: 24px; }
    }
  </style>
</head>

<body>
  <div class="container">
    <h1 class="titulo">Deportes en Vivo</h1>
    <video id="video-player" class="reproductor" controls autoplay muted></video>
    <h2 class="subtitulo">Lista de Reproducción</h2>
    <ul class="lista-reproduccion">
      <li data-url-hls="168.231.71.30:8080/hls/0/stream.m3u8?">Canal 1</li>
      <li data-url-hls="#">Canal 2</li>
      <li data-url-hls="#">Canal 3</li>
    </ul>

    <div class="footer">
      Derechos reservados a sus respectivos creadores.
    </div>
  </div>

<script>
const videoPlayer = document.getElementById('video-player');
const listaReproduccion = document.querySelector('.lista-reproduccion');
let hls;
let canalSeleccionado = null;

listaReproduccion.addEventListener('click', (e) => {
  if (e.target.tagName === 'LI') {
    const urlHls = e.target.getAttribute('data-url-hls');
    if (urlHls) {
      if (canalSeleccionado) canalSeleccionado.classList.remove('seleccionado');
      e.target.classList.add('seleccionado');
      canalSeleccionado = e.target;

      if (hls) hls.destroy();
      hls = new Hls();
      hls.loadSource(urlHls);
      hls.attachMedia(videoPlayer);
      hls.on(Hls.Events.MANIFEST_PARSED, () => videoPlayer.play());
    }
  }
});
</script>

</body>
</html>
