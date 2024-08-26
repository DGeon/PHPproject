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

    table tr:nth-child(2) td {
        display: none;
        text-align: right;
        color: red;
    }

    table tr:nth-child(5) td {
        display: none;
        text-align: right;
        color: red;
    }
</style>
<script>
    var idck = 0;
    var pwck = 0;

    function idCheck() {
        var id = $("input[name='id']").val();
        $.ajax({
            url: "../../models/member/idCheck.php",
            type: "post",
            dataType: "json",
            data: {
                id: id
            },
            success: function(response) {
                $("td[name=idcheckTr]").show();
                $("p[name=idsuccess]").text(response.msg);
                idck = 1;
            },
            error: function() {
                alert("서버와 통신 중 오류가 발생했습니다.");
            }
        });
    }
    $(document).ready(function() {
        $("input[name='passwordcheck']").blur(function() {
            $("td[name=pwcheckTr]").show();
            if ($("input[name='passwordcheck']").val() === $("input[name='password']").val()) {
                $("p[name=pwsuccess]").text("일치하는 비밀번호 입니다.");
                pwck = 1;
            } else {
                $("p[name=pwsuccess]").text("동일한 비밀번호를 입력해주세요.");
            }
        });
    });

    function signup() {
        if ($("input[name='passwordcheck']").val() === $("input[name='password']").val() && $("input[name='id']").val().length > 3 && $("input[name='password']").val().length > 3) {
            if ((idck && pwck) == 1) {
                return true;
            } 
        }else {
            alert("양식이 잘 못 되었습니다 확인 해주세요.");
            return false;
        }
    }
</script>

<body>
    <?php include "../common/header.php" ?>
    <form action="../../models/member/register.php" method="post" onsubmit="return signup()">
        <table>
            <tr>
                <td>아이디</td>
                <td><input type="type" placeholder="4~12글자 이내로 사용해주세요" name="id"></td>
                <td><button type="button" onclick="idCheck()">중복 확인</button></td>
            </tr>
            <tr>
                <td colspan="2" name="idcheckTr">
                    <p name="idsuccess"></p>
                </td>
            </tr>
            <tr>
                <td>비밀번호</td>
                <td><input type="password" placeholder="4~12글자 이내로 사용해주세요" name="password"></td>
            </tr>
            <tr>
                <td>비밀번호확인</td>
                <td><input type="password" placeholder="동일한 비밀번호를 입력해주세요" name="passwordcheck"></td>
            </tr>
            <tr>
                <td colspan="2" name="pwcheckTr">
                    <p name="pwsuccess"></p>
                </td>
            </tr>
            <tr>
                <td>이름</td>
                <td><input type="type" placeholder="2~6글자 이내로 사용해주세요" name="name"></td>
            </tr>
            <tr>
                <td>이메일</td>
                <td><input type="type" placeholder="php@gmail.com" name="email"></td>
            </tr>
            <tr>
                <td>연락처</td>
                <td><input type="type" placeholder="010-1234-5678" name="phone"></td>
            </tr>
            <tr>
                <td colspan="2"><button type="submit">가입하기</button></td>
            </tr>
        </table>
    </form>
    <?php include "../common/footer.php" ?>
</body>

</html>