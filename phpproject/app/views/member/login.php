<!DOCTYPE html>
<html lang="ko">
<?php include "../common/head.php"; ?>

<head>
    <style>
        table {
            margin: auto;
        }

        table tr:nth-child(3) td:nth-child(1) {
            text-align: left;
        }

        table tr:nth-child(3) td:nth-child(2) {
            text-align: right;
        }
    </style>
    <script>
        function register() {
            window.location.href = "../member/signup.php";
        }

        function login() {
            var id = $("input[name='id']").val();
            var password = $("input[name='password']").val();
            $.ajax({
                url: "../../models/member/signin.php",
                type: "post",
                dataType: "json",
                data: {
                    id: id,
                    password: password
                },
                success: function(response) {
                    window.location.href = "/phpproject/public/index.php";
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("AJAX call failed: " + textStatus + ", " + errorThrown);
                }
            });
        }
    </script>
</head>

<body>
    <?php include "../common/header.php"; ?>
    <h1>로그인</h1>
    <table>
        <tr>
            <td colspan="2"><input type="text" placeholder="아이디" name="id"></td>
        </tr>
        <tr>
            <td colspan="2"><input type="password" placeholder="비밀번호" name="password"></td>
        </tr>
        <tr>
            <td><button type="button" onclick="register()">회원가입</button></td>
            <td><button type="button" onclick="login()">로그인</button></td>
        </tr>
        <tr>

        </tr>
    </table>
    <?php include "../common/footer.php"; ?>
</body>

</html>