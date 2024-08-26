<?php
    
    $dbconn = mysqli_connect('localhost','root','1234','dgeon');
    if(!$dbconn){
        die("Connetion faild: " . mysqli_connect_error());
    }
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $id = mysqli_real_escape_string($dbconn, trim($_POST["id"]));
        $password = password_hash(mysqli_real_escape_string($dbconn, trim($_POST["password"])), PASSWORD_DEFAULT);
        $name = mysqli_real_escape_string($dbconn, trim($_POST["name"]));
        $email = mysqli_real_escape_string($dbconn, trim($_POST["email"]));
        $phone = mysqli_real_escape_string($dbconn, $_POST["phone"]);

        $query = "insert into member(id, password, name, email, phone) values('$id','$password','$name','$email','$phone')";

        if(mysqli_query($dbconn, $query)){
            header("Location: ../../views/member/login.php");
        }
        
    }

    mysqli_close($dbconn);
?>
