<?php
    $dbconn = mysqli_connect('localhost', 'root', '1234', 'dgeon');
    if (!$dbconn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = mysqli_real_escape_string($dbconn, trim($_POST["id"]));
        $query = "select id from member where id = ?";

        $stmt = mysqli_prepare($dbconn, $query);
        if($stmt){
            mysqli_stmt_bind_param($stmt, "s", $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if(mysqli_num_rows($result) > 0 ){
                $response['status'] = 1;
                $response['msg'] = "동일한 아이디가 존재 합니다.";
            }
            else{
                $response['status'] = 0;
                $response['msg'] = '사용 가능한 아이디 입니다.';
            }
            echo json_encode($response);
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($dbconn);
    
?>