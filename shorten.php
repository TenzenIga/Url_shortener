<?php
    session_start();
    require_once 'classes/Shortener.php';
    require_once 'config/DB.php';
    $database = new Database();
    $db = $database->connect();

    $s = new Shortener($db);
    if (isset($_POST['url'])) {
       $url = $_POST['url'];

       if ($code = $s->makeCode($url)) {
         echo json_encode(array('success' => true, 'message'=>$code), JSON_UNESCAPED_UNICODE);
       }else {
         echo json_encode(array('success' => false, 'message'=>'Что-то пошло не так'), JSON_UNESCAPED_UNICODE);
       }
    }
?>
