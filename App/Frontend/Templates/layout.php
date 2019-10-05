<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>
      <?= isset($title) ? $title : 'CryptoRanger' ?>
    </title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width:device-width, initial-scale=1">
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <!-- <base href="http://localhost/Web"> -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css"> 
  </head>
  
  <body>
      <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top pb-0 pt-0">
          <div class="container">
            <a class="navbar-brand p-0 m-0" href="https://twitter.com/TheChartRanger"><i class="fab fa-twitter fa-0.5x p-0 pr-3"></i><i class="fab fa-instagram p-0"></i></a>
            <button class="navbar-toggler mytoggle" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" id="toggle" onclick="add_class()">
              <span></span>
              <span></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav ml-auto"> <!-- changed type -->
                <li class="nav-item">
                  <a class="nav-link" href="/#home">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/news">News</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/#guides">Guides</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/#contact">Contact</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/#about">About me</a>
                </li>
                <?php if ($user->isAuthenticated()) { ?>
                <li class="nav-item">
                  <a class="nav-link" href="/admin/">Admin</a>
                </li>
                <?php } ?>
              </ul>
            </div>
          </div>
        </nav>
      </header>
  
      <?php if ($user->hasFlash()) echo '<p style="text-align: center;">', $user->getFlash(), '</p>'; ?>
          
      <?= $content ?>
     
      <footer>
        <section id="contform">
          <h2 class="mb-3" id="contact">SUBMIT FEEDBACK</h2>
          <?php if ($user->hasFeedback()): ?>
          <div class="alert alert-success text-center"><?php echo $user->getFlashFeedback(); ?></div>
          <?php endif ?>
          <form method="post" action="/feedback">
            <div class="form-row">
              <div class="form-group col-md-6">
                 <input type="email" class="form-control itemform <?php $user->hasFeed('mail') ? 'is-invalid' : '' ?>" placeholder="Email" name="mail" required maxlength="40">
                 <?php if ($error = $user->getFlashFeed('mail')): ?>
                 <div class="alert alert-danger text-center"><i class="fas fa-exclamation-triangle"></i><?= $error ?></div>
                 <?php endif ?>
              </div>
              <div class="form-group col-md-6">
               	 <input type="text" class="form-control itemform <?php $user->hasFeed('name') ? 'is-invalid' : '' ?>" placeholder="Name" name="name" required maxlength="20">
                 <?php if ($error = $user->getFlashFeed('name')): ?>
                 <div class="alert alert-danger text-center"><i class="fas fa-exclamation-triangle"></i><?= $error ?></div>
                 <?php endif ?>
              </div>
            </div>
            <div class="form-group">
              	<textarea class="form-control itemform <?php $user->hasFeed('feedback') ? 'is-invalid' : '' ?>"  placeholder="Message" rows="5" required name="feedback"></textarea>
                <?php if ($error = $user->getFlashFeed('feedback')): ?>
                <div class="alert alert-danger text-center"><i class="fas fa-exclamation-triangle"></i><?= $error ?></div>
                <?php endif ?>
            </div>
            <div class="form-group">
            	<input type="submit" name ="submit" class="btn btnSend form-control" value="Send">
            </div>
          </form>
        </section>
        <p class="copy text-center">CryptoRanger - All right reserved - © 2019</p>
      </footer>
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

       <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
        <script>
          AOS.init();
        </script>
      <script type="text/javascript">
        $(document).scroll(function(){
          $('.navbar').toggleClass('scrolled', $(this).scrollTop() > $('.navbar').height());
        });
      </script>

      <script type="text/javascript">
        function add_class(){
          var element = document.getElementById("toggle");
          element.classList.toggle("active")
        }
      </script>
  </body>
</html>