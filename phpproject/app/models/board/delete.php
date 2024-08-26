<?php
$dbconn = mysqli_connect('localhost', 'root', '1234', 'dgeon');
if (!$dbconn) {
    die("Conntection failed : " . mysqli_connect_error());
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bno = isset($_POST['bno']) ? intval(trim($_POST['bno'])) : null;
    $writer = mysqli_real_escape_string($dbconn, trim($_POST['writer']));

    $query = "delete from board where bno = ? and writer = ?";
    $stmt = mysqli_prepare($dbconn, $query);
    $response = [];
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'is', $bno, $writer);
        mysqli_stmt_execute($stmt);
        if (mysqli_stmt_affected_rows($stmt) > 0) {
            $response['msg'] = "게시글이 삭제가 완료되었습니다.";
        } else {
            $response['msg'] = "삭제할 항목이 없습니다.";
        }
    }
    header('Content-Type: application/json');
    echo json_encode($response);
    mysqli_stmt_close($stmt);
}
mysqli_close($dbconn);
?>