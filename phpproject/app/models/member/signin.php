<?php
    $dbconn = mysqli_connect('localhost','root','1234','dgeon');
    if(!$dbconn){
        die("Connection failed : ". mysqli_connect_error() );
    }
    if($_SERVER["REQUEST_METHOD"]==="POST"){

        
        $id = mysqli_real_escape_string($dbconn, trim($_POST["id"]));
        $password =  mysqli_real_escape_string($dbconn, trim($_POST["password"]));

        $query = "select * from member where id = ?";

        $stmt = mysqli_prepare($dbconn, $query);
        if($stmt){
            mysqli_stmt_bind_param($stmt, "s", $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($result && $row = mysqli_fetch_assoc($result)) {
                if (password_verify($password, $row['password'])) {
                    $response['id'] = $row['id'];
                    $response['msg'] = "로그인에 성공하셨습니다.";
                    setcookie('id', $row['id'], time()+3600, "/");
                } else {
                    $response['msg'] = "비밀번호가 잘못되었습니다.";
                }
            } else {
                $response['msg'] = "아이디가 존재하지 않습니다.";
            }
            echo json_encode($response);
        }
        
        mysqli_stmt_close($stmt);
    }
    mysqli_close($dbconn);
?>