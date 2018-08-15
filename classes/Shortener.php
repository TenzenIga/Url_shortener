<?php
   /**
    *
    */
   class Shortener
   {
     private $conn;
     private $table = 'links';

     public function __construct($db)
      {
       $this->conn = $db;
      }

     public function getUrl($code)
      {
       $query = "SELECT url FROM $this->table WHERE code= ?";
       $stmt = $this->conn->prepare($query);

       $stmt->execute([$code]);
       return $stmt->fetch()['url'];
      }


      // Take url, create code , check if code uniqie and add to Database
     public function makeCode($url)
      {
       $url = trim($url);
       if (!filter_var($url, FILTER_VALIDATE_URL)) {
         return '';
       }

       //if it's already exists, return code
       $query = "SELECT code FROM $this->table WHERE url= ?";
       $stmt = $this->conn->prepare($query);

       // Execute query
       $stmt->execute([$url]);

       if ($stmt->rowCount()) {
           return $stmt->fetch()['code'];
       }else {
        $code = $this->generateCode();
        $query = "INSERT INTO $this->table(url, code, created) VALUES(:url, :code, NOW())";
        $stmt = $this->conn->prepare($query);

        $stmt->execute([
          ':url'=> $url,
          ':code'=>$code
        ]);
        return $code;
      }
     }

     protected function checkCode($code)
     {
       $query = "SELECT code FROM $this->table";
       $stmt = $this->conn->prepare($query);
       $stmt->execute();

       while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
         if ($row['code'] == $code) {
           return true;
        }
       }
       return false;
     }

     protected function generateCode()
     {
       $str = "abcdefghijklmnopqrstuvwxyz1234567890";
       $randStr = substr(str_shuffle($str), 0, 8);

       while($this->checkCode($randStr) == true){
          $randStr = substr(str_shuffle($str), 0, 8);
       }
       return $randStr;
     }
   }


 ?>
