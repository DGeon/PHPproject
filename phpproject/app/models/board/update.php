<?php
    $dbconn = mysqli_connect('localhost','root','1234','dgeon');
    if(!$dbconn){
        die("Connection failed : ".mysqli_connect_error());
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
    
        $bno = isset($_POST['bno']) ? intval(trim($_POST['bno'])) : null;
        $writer = mysqli_real_escape_string($dbconn, trim($_POST['writer']));
        $title = mysqli_real_escape_string($dbconn, trim($_POST['title']));
        $content = mysqli_real_escape_string($dbconn, trim($_POST['content']));
        $query = "update board set title = ?, content = ? where  bno = ? and writer = ?";
        $stmt = mysqli_prepare($dbconn, $query);
        $response = [];
        if($stmt){
            mysqli_stmt_bind_param($stmt, "ssis", $title, $content, $bno, $writer);
            mysqli_stmt_execute($stmt);
            if(mysqli_stmt_affected_rows($stmt) > 0){

                $response['msg'] = "수정이 완료 되었습니다.";
            } else {
                 $response['msg'] = "수정이 실패 되었습니다.";
            }
        }
        header('Content-Type: application/json');
        echo json_encode($response);
        mysqli_stmt_close($stmt);
    }
    mysqli_close($dbconn);
?>