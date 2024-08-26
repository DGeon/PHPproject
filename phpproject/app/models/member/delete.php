<?php
    $dbconn = mysqli_connect('localhost', 'root', '1234', 'dgeon');
    if (!$dbconn) {
        die("Connection failed : " . mysqli_connect_error());
    }
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $id = mysqli_escape_string($dbconn, trim($_POST['id']));
        $password = mysqli_escape_string($dbconn, $_POST['password']);

        $selectQuery = "select * from member where id = ?";
        $selectStmt = mysqli_prepare($dbconn, $selectQuery);
        if ($selectStmt) {
            mysqli_stmt_bind_param($selectStmt, "s", $id);
            mysqli_stmt_execute($selectStmt);
            $result = mysqli_stmt_get_result($selectStmt);
            if ($result && $row = mysqli_fetch_assoc($result)) {
                if (password_verify($password, $row['password'])) {
                    $deleteBoardQuery = "delete from board where writer = ?";
                    $deleteBoardStmt = mysqli_prepare($dbconn, $deleteBoardQuery);
                    if ($deleteBoardStmt) {
                        mysqli_stmt_bind_param($deleteBoardStmt, 's', $id);
                        mysqli_stmt_execute($deleteBoardStmt);
                        if (mysqli_stmt_affected_rows($deleteBoardStmt) >= 0) {
                            $deleteQuery = "delete from member where id = ?";
                            $deleteStmt = mysqli_prepare($dbconn, $deleteQuery);
                            if ($deleteStmt) {
                                mysqli_stmt_bind_param($deleteStmt, 's', $id);
                                mysqli_stmt_execute($deleteStmt);
                                if (mysqli_stmt_affected_rows($deleteStmt) > 0) {
                                    setcookie("id","null",time() - 3600,"/");
                                    $response['status'] = true;
                                    $response['msg'] = "성공적으로 탈퇴가 이루어졌습니다.";
                                }
                            } else {
                                $response['status'] = false;
                                $response['msg'] = "서버와 통신이 불가능 합니다";
                            }
                            mysqli_stmt_close($deleteStmt);
                        }
                        mysqli_stmt_close($deleteBoardStmt);
                    }
                } else {
                    $response['status'] = false;
                    $response['msg'] = "비밀번호가 다릅니다.";
                }
            } else {
                $response['status'] = false;
                $response['msg'] = "등록된 유저가 아닙니다.";
            }
        }
        header('Content-Type: application/json');
        echo json_encode($response);
        mysqli_stmt_close($selectStmt);
    }
    mysqli_close($dbconn);
?>