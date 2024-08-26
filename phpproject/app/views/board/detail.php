<?php
$dbconn = mysqli_connect('localhost', 'root', '1234', 'dgeon');
if (!$dbconn) {
    die("Connection failed: " . mysqli_connect_error());
}
$bno = isset($_GET['bno']) ?  intval($_GET['bno']) : 1;
//isset null인지 검사 하고 값이 없을 경우 기본값으로 설정한 1이 사용된다, intval 문자열, 부동소수점, 숫자관련 값을 정수형으로 리턴한다
$query = "select * from board where bno = ?";
//보안적인 측면을 위해서 stmt를 사용
$stmt = mysqli_prepare($dbconn, $query);
//SQL 쿼리를 실행했을때 객체를 반환하거나 false를 반환
mysqli_stmt_bind_param($stmt, 'i', $bno);
//파라미터를 바인딩 하는 것으로 $bno 정수일때 i, 부동소수수점 일때 d, 문자열 일때 s를 사용
mysqli_stmt_execute($stmt);
//쿼리 실행 성공 여부를 반환 ture/false 반환
$result = mysqli_stmt_get_result($stmt);
//결과 반환
$row = mysqli_fetch_assoc($result);
//해당 행을 가져옴
mysqli_stmt_close($stmt);
mysqli_close($dbconn);
?>
<!DOCTYPE html>
<html lang="ko">
<?php include "../common/head.php" ?>

<head>
    <style>
        table {
            margin: auto;
        }

        table tr {
            height: 100px;
        }

        table tr:nth-child(4) td {
            text-align: right;
            padding-right: 10px;
        }

        input,
        textarea {
            width: 100%;
        }
    </style>
    <script>
        $(document).ready(function() {
            var writer = <?= json_encode($row['writer']); ?>;
            var id = <?= json_encode($_COOKIE['id']); ?>;
            $("button[name='btn-board-delete']").hide();
            if (writer === id) {
                $("button[name='btn-board-update']").show();
            } else {
                $("button[name='btn-board-update']").hide();
            }
        });

        function boardList() {
            window.location.href = "/phpproject/app/views/board/board.php";
        }

        function boardUpdate() {
            var writer = <?= json_encode($row['writer']); ?>;
            var id = <?= json_encode($_COOKIE['id']); ?>;
            if (writer === id) {
                $("button[name='btn-board-delete']").show();
            } else {
                $("button[name='btn-board-delete']").hide();
            }
            if (!$("input[name='title']").prop("disabled")) {
                var bno = <?= $row['bno']; ?>;
                var writer = <?= json_encode($row['writer']); ?>;
                var title = $("input[name='title']").val();
                var content = $("textarea[name='content']").val();
                $.ajax({
                    url: "/phpproject/app/models/board/update.php",
                    type: "POST",
                    dataType: "json",
                    data: {
                        bno: bno,
                        writer: writer,
                        title: title,
                        content: content,
                    },
                    success: function(response) {
                        alert(response.msg);
                        $("input[name='title']").attr("disabled", true);
                        $("textarea[name='content']").attr("disabled", true);
                        $("button[name='btn-board-delete']").hide();
                    },
                    error: function(xhr, status, error) {
                        console.error("상태: " + status);
                        console.error("에러: " + error);
                        console.error("응답 텍스트: " + xhr.responseText);

                        alert("서버와 통신 중 오류가 발생했습니다.");
                    }
                });
            }
            $("input[name='title']").attr("disabled", false);
            $("textarea[name='content']").attr("disabled", false);

        }

        function boardDelete() {
            var writer = <?= json_encode($row['writer']); ?>;
            var id = <?= json_encode($_COOKIE['id']); ?>;
            var bno = <?= json_encode($row['bno']); ?>;
            if (writer === id) {
                $.ajax({
                    url: "/phpproject/app/models/board/delete.php",
                    type: "POST",
                    dataType: "json",
                    data: {
                        writer : writer,
                        bno : bno 
                    },
                    success: function(response){
                        alert(response.msg);
                        window.location.href = "/phpproject/app/views/board/board.php";
                    },
                    error: function(xhr, status, error){
                        console.error("상태: " + status);
                        console.error("에러: " + error);
                        console.error("응답 텍스트: " + xhr.responseText);

                        alert("서버와 통신 중 오류가 발생했습니다. 콘솔에서 오류를 확인하세요.");
                    }

                });
            }else{
                alert("회원정보와 다릅니다.");
            }
        }
    </script>
</head>

<body>
    <?php include "../common/header.php" ?>
    <table style="width : 600px">
        <tr>
            <td>글제목</td>
            <td><input type="text" name="title" value="<?= $row['title']; ?>" disabled></input></td>
        </tr>
        <tr>
            <td>작성자</td>
            <td><input type="text" name="writer" value="<?= $row['writer']; ?>" disabled></td>
        </tr>
        <tr>
            <td>내 용</td>
            <td>
                <textarea name="content" disabled><?= $row['content']; ?></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <button type="button" name="btn-board-delete" onclick="boardDelete()">삭제하기</button>
                <button type="button" name="btn-board-submit" onclick="boardList()">목록으로</button>
                <button type="button" name="btn-board-update" onclick="boardUpdate()">수정하기</button>
            </td>
        </tr>
    </table>
    <?php include "../common/footer.php" ?>
</body>

</html>