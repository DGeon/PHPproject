<?php
    $dbconn = mysqli_connect('localhost','root','1234','dgeon');
    if(!$dbconn){
        die("Connection failed : ".mysqli_connect_error());
    }
    if($_SERVER["REQUEST_METHOD"] === "POST"){
        $search = mysqli_escape_string($dbconn, $_POST['searchInput']);
        if($_POST['searchMenu'] === "title"){
            $query = "select * from board where title = ?";
        }else if($_POST['searchMenu'] === "content"){
            $query = "select * from board where content = ?";
        }else if($_POST['searchMenu'] === "writer"){
            $query = "select * from board where writer = ?";
        }

        $stmt = mysqli_prepare($dbconn, $query);
        if($stmt){
            mysqli_stmt_bind_param($stmt, 's', $search);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if($result){
                while($row = mysqli_fetch_assoc($result)){
                    $row[] = $row;
                }

            }
        }
    }

    mysqli_close($dbconn);
?>
