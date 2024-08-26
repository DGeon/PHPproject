<?php
    $dbconn = mysqli_connect('localhost','root','1234','dgeon');
    if(!$dbconn){
        die("Connection failed: " . mysqli_connect_error());
    }
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $title = $_POST["title"];
        $writer = $_POST["writer"];
        $content = $_POST["content"];
    }else{
        echo "없음";
    }
    $query = "insert into board (title,writer,content) values('$title','$writer','$content');";
    $result = mysqli_query($dbconn, $query);
    
    if($result){
        echo '<script type="text/javascript">'; 
        echo 'alert("게시물 작성이 성공했습니다. 게시판 목록으로 돌아갑니다.")';
        echo '</script>';
        header("Location: ../../views/board/board.php");
    }else{
        echo '<script type="text/javascript">'; 
        echo 'alert("게시물 작성이 실패했습니다. 게시판 글작성으로 돌아갑니다.")';
        echo '</script>';
        header("Location: ../../views/board/write.php");
    }
    mysqli_close($dbconn);
?>