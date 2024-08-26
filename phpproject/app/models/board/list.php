<?php
$dbconn = mysqli_connect('localhost', 'root', '1234', 'dgeon');
if (!$dbconn) {
    die("Connection failed : " . mysqli_connect_error());
}
$keyword = isset($_GET['keyword']) ? mysqli_real_escape_string($dbconn, $_GET['keyword']) : '';
$searchMenu = isset($_GET['searchMenu']) ? mysqli_real_escape_string($dbconn, $_GET['searchMenu']) : 'title';


$amount = 5; //한 페이지당 보여줄 게시물 수
$pageNum = isset($_GET["pageNum"]) ?  $_GET["pageNum"] : 1; //현재페이지를 가져오거나 없다면 1을 기본값으로
$pageNation =3; //페이지 출력갯수

$query = "select * from board where $searchMenu like  ? order by bno desc";
$stmt = mysqli_prepare($dbconn, $query);
if ($stmt) {
    $strKeyword = "%$keyword%";
    mysqli_stmt_bind_param($stmt, 's', $strKeyword);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $total = mysqli_num_rows($result);
    $totalPage = ceil($total / $amount);
    $start =($pageNum -1) * $amount;
    $totalBlock = ceil($totalPage / $pageNation);
    $nowBlock = ceil($pageNum / $pageNation);
    $s_pageNum = ($nowBlock -1) * $pageNation +1;
    if($s_pageNum <=0){
        $s_pageNum = 1;
    }
    $e_pageNum = $nowBlock * $pageNation;
    if($e_pageNum > $totalPage){
        $e_pageNum = $totalPage;
    }
    $serachQuery = "select * from board where $searchMenu like  ? order by bno desc limit $start, $amount";
    $stmt = mysqli_prepare($dbconn, $serachQuery);
    $strKeyword = "%$keyword%";
    mysqli_stmt_bind_param($stmt, 's', $strKeyword);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
    }
}

mysqli_stmt_close($stmt);
mysqli_close($dbconn);


?>