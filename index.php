<?php
if(!isset($_GET['page'])){
    header('location:?page=welcome');
}else{
    $page = $_GET['page'];
}
if(!$page || empty($page)) $page = 'welcome';
?>
<!DOCTYPE html>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="icon" href="icon.svg" type="image/svg+xml">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="background.css">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
  </head>
  <body class="worklet-canvas">
    <input type="checkbox" id="check">
    <label for="check">
      <i style="position: fixed; z-index: 999;" class="fas fa-bars" id="btn"></i>
      <i style="position: fixed; z-index: 999;" class="fas fa-times" id="cancel"></i>
    </label>
    <div class="sidebar">
      <header><a href="?page=welcome">Normunds</a></header>
      <a class="a" href="?page=temperature">Temperature</a>
			<a class="a" href="?page=student">Student</a>
		  <a class="a" href="?page=nordpool">Nordpool</a>
			<a class="a" href="?page=datalogger">Climate</a>
      <a class="a" href="?page=map">Map</a>
      <a class="a" href="?page=weather">Weather table</a>
      <a class="a" href="#">....</a>
      <a class="a" href="#">....</a>
      <a class="a" href="#">....</a>
      <a class="a" href="#">....</a>
      <a class="a" href="#">....</a>
      <a class="a" href="#">....</a>
      <a class="a" href="#">....</a>
      <a class="a" href="#">....</a>
      <a class="a" href="#">....</a>
      <a class="a" href="#">....</a>
      <a class="a" href="#">....</a>
      <a class="a" href="#">....</a>
      <a class="a" href="#">....</a>
      <a class="a" href="#">....</a>
      <a class="a" href="#">....</a>
    </div>
    <?php include('pages/' . $page . '.php'); ?> 
    <script>
      CSS.paintWorklet.addModule('background.js');
      document.documentElement.style.setProperty('--pattern-seed', Math.random() * 10000);
    </script>
    <script type="text/javascript">
      $(document).keydown(function(e) {
        if (e.which == '39') { //right arrow key
          // $(".sidebar").finish().animate({
          //     left: "+=240"
          // });
          document.getElementById("check").checked = true;
        }
      });

      $(document).keydown(function(e) {
        if (e.which == '37') { //left arrow key
          // $(".sidebar").finish().animate({
          //     left: "-=240"
          // });

          document.getElementById("check").checked = false;
        }
      });


      function appHeight() {
        const doc = document.documentElement
        doc.style.setProperty('--vh', (window.innerHeight*.01) + 'px');
      }

      window.addEventListener('resize', appHeight);
      appHeight();
    </script>
</body>
</html>