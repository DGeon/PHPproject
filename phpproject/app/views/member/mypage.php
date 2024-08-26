<?php
$dbconn = mysqli_connect('localhost', 'root', '1234', 'dgeon');
if (!$dbconn) {
    die("Connetion failed : " . mysqli_connect_error());
}
$id = $_COOKIE['id'];
$query = "select * from member where id = ?";
$stmt = mysqli_prepare($dbconn, $query);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, 's', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($result);
}
mysqli_stmt_close($stmt);
mysqli_close($dbconn);
?>
<!DOCTYPE html>
<html lang="ko">
<?php include "../common/head.php" ?>
<style>
    table {
        margin: auto;
    }

    table tr:nth-last-child(1) td {
        text-align: right;
    }

    table tr:nth-child(3) td {
        display: none;
        text-align: right;
        color: red;
    }

    table tr:nth-child(7) td {
        text-align: right;
    }
</style>
<script>
    $(document).ready(function() {
        $("tr[name='memberDeleteTr']").hide();
        $("input[name='passwordConfirm']").attr("disabled", true);
    });

    function memberUpdate() {
        var id = "<?= $_COOKIE['id']; ?>";
        var password = $("input[name='passwordcheck']").val();
        var name = $("input[name='name']").val();
        var email = $("input[name='email']").val();
        var phone = $("input[name='phone']").val();
        $.ajax({
            url: "/phpproject/app/models/member/update.php",
            type: "post",
            dataType: "json",
            data: {
                id: id,
                password: password,
                name: name,
                email: email,
                phone: phone
            },
            success: function(response) {
                alert(response.msg);
            },
            error: function(xhr, status, error) {
                console.error("상태: " + status);
                console.error("에러: " + error);
                console.error("응답 텍스트: " + xhr.responseText);
                alert("서버와 통신 중 오류가 발생했습니다.");
            }
        });
    }

    function memberDelete() {
        $("tr[name='memberDeleteTr']").show();
        $("input[name='passwordConfirm']").attr("disabled", false);
    }

    function memberDeleteConfirm() {
        var id = "<?= $_COOKIE['id']; ?>";
        var password = $("input[name='passwordConfirm']").val();

        $.ajax({
            url: "/phpproject/app/models/member/delete.php",
            type: "post",
            dataType: "json",
            data: {
                id: id,
                password: password
            },
            success: function(response) {
                alert(response.msg);
                window.location.href = "/phpproject/public/index.php";
            },
            error: function(xhr, status, error) {
                console.error("상태: " + status);
                console.error("에러: " + error);
                console.error("응답 텍스트: " + xhr.responseText);
                alert("서버와 통신 중 오류가 발생했습니다.");
            }
        });
    }
</script>

<body>
    <?php include "../common/header.php" ?>
    <table>
        <tr>
            <td>아이디</td>
            <td><input type="type" placeholder="4~12글자 이내로 사용해주세요" name="id" value="<?= $row['id']; ?>" readonly></td>
        </tr>

        <tr>
            <td>비밀번호확인</td>
            <td><input type="password" placeholder="비밀번호를 입력해주세요" name="passwordcheck"></td>
        </tr>
        <tr>
            <td colspan="2" name="pwcheckTr">
                <p name="pwsuccess"></p>
            </td>
        </tr>
        <tr>
            <td>이름</td>
            <td><input type="type" placeholder="2~6글자 이내로 사용해주세요" name="name" value="<?= $row['name']; ?>"></td>
        </tr>
        <tr>
            <td>이메일</td>
            <td><input type="type" placeholder="php@gmail.com" name="email" value="<?= $row['email']; ?>"></td>
        </tr>
        <tr>
            <td>연락처</td>
            <td><input type="type" placeholder="010-1234-5678" name="phone" value="<?= $row['phone']; ?>"></td>
        </tr>
        <tr>
            <td colspan="2">
                <button type="button" onclick="memberDelete()">탈퇴하기</button>
                <button type="button" onclick="memberUpdate()">수정하기</button>
            </td>
        </tr>
        <tr name="memberDeleteTr">
            <td>
                <input type="password" placeholder="비밀번호를 입력하세요" name="passwordConfirm">
            </td>
            <td>
                <button type="button" onclick="memberDeleteConfirm()">탈퇴완료</button>
            </td>
        </tr>
    </table>
    </form>
    <?php include "../common/footer.php" ?>
</body>

</html>