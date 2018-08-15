<?php
require_once 'classes/Shortener.php';
require_once 'config/DB.php';
  if ($_GET['code']) {
    $code = $_GET['code'];
    $database = new Database();
    $db = $database->connect();
    $s = new Shortener($db);
    header('Location: '.$s->getUrl($code));
  }

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <link rel="stylesheet" href="main.css">
    <meta charset="utf-8">
    <title>URL shortener</title>
  </head>
  <body>
    <header>
      <h1>URL shortener</h1>
    </header>

    <form class="" action="shorten.php" method="post">

      <input type="url" name="url" placeholder="url">
      <button  id="submit" type="submit" name="submit" class="btn btn-primary">Генерировать ссылку</button>
    </form>
    <div id="result" role="alert">
    </div>

    <script type="text/javascript">
      $(document).ready(function(){
        function urlParam(name){
        	var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        	return results[1] || 0;
        }

        $("form").submit(function(e){
          e.preventDefault();
          var data = $("form").serialize();
          $.ajax({
              type:"POST",
              url: "shorten.php",
              data: data,
              cache:false,
              success: function(result){
              result = JSON.parse(result);
                  if (result.success === true) {
                    $('#result').attr('class','result').html('<h4>Ваша ссылка</h4><p>http://localhost/' +result['message'] +'</p>');
                  }else {
                    $('#result').attr('class','error').html(result['message']);
                  }
              }
            })

        });
    });

    </script>
  </body>
</html>
