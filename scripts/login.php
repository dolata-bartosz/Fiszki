<?php

if(isset($_POST['button'])&& !empty($_POST['login']) && !empty($_POST['password'])){

    $login=$_POST['login'];
    $password=$_POST['password'];
    require_once("./connect.php");
    $stmt = $connect->prepare("SELECT * FROM `uzytkownik` WHERE `login`=?");
    $stmt->bind_param('s', $login);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $pswd = $row['haslo'];
      $function = $row['funkcja_id'];
      $status = $row['status_id'];
      $class = $row['klasa_id'];
    }

        if(password_verify($password,$pswd)){
            session_start();
            setcookie("session_id",session_id(),time()+60*60);
            $_SESSION['login']=$login;
            $_SESSION['function']=$function;
            $_SESSION['status']=$status;
            $_SESSION['class']=$class;
            $_SESSION['id']=session_id();
           header("location: ../podstrony/sets.php");
        } else {
            header("location: ../index.php");
        }
    } else {
      header("location: ../index.php");
    }

} else {
    header("location: ../index.php");
}




?>
