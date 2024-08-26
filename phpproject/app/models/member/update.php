<?php
    $dbconn = mysqli_connect('localhost','root','1234','dgeon');
    if(!$dbconn){
        die("Connection faild : " .mysqli_connect_error());
    }
    if($_SERVER["REQUEST_METHOD"] === "POST"){
        $id = mysqli_escape_string($dbconn, trim($_POST['id']));
        $password = mysqli_escape_string($dbconn, trim($_POST['password']));
        $name = mysqli_escape_string($dbconn, trim($_POST['name']));
        $email = mysqli_escape_string($dbconn, trim($_POST['email']));
        $phone = mysqli_escape_string($dbconn, trim($_POST['phone']));

        $query = "select * from member where id = ?";
        $stmt = mysqli_prepare($dbconn, $query);
        if($stmt){
            mysqli_stmt_bind_param($stmt, 's', $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if($result && $row = mysqli_fetch_assoc($result)){
                if(password_verify($password, $row['password'])){
                    $updateQuery = "update member set name =? , email =? , phone =? where id = ?";
                    $updateStmt = mysqli_prepare($dbconn, $updateQuery);
                    $response = [];
                    if($updateStmt){
                        mysqli_stmt_bind_param($updateStmt, "ssss", $name, $email, $phone, $id);
                        mysqli_stmt_execute($updateStmt);
                        if(mysqli_stmt_affected_rows($updateStmt) > 0){
                            $response['msg'] = "수정이 완료 되었습니다.";
                        } else {
                             $response['msg'] = "수정이 실패 되었습니다.";
                        }
                    }
                    mysqli_stmt_close($updateStmt);
                }else{
                    $response['msg'] = "비밀번호가 다릅니다.";
                }

            }else{
                $response['msg'] = "계정이 없거나 서버와 통신할 수 없습니다.";
            }
        }
        header('Content-Type: application/json');
        echo json_encode($response);
        mysqli_stmt_close($stmt);
    }
    mysqli_close($dbconn)
?>