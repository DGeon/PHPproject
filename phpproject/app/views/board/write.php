<!DOCTYPE html>
<html lang="ko">
<?php include "../common/head.php"; ?>
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

<body>
  <?php include "../common/header.php"; ?>
  <h1>글쓰기</h1>
  <div class="main">
    <form action="../../models/board/insert.php" method="post">
      <table style="width : 600px">
        <tr>
          <td>글제목</td>
          <td><input type="text" name="title"></td>
        </tr>
        <tr>
          <td>작성자</td>
          <td><input type="text" name="writer" readonly value="<?= $_COOKIE['id'];?>"></td>
        </tr>
        <tr>
          <td>내 용</td>
          <td>
            <textarea name="content"></textarea>
          </td>
        </tr>
        <tr>
          <td colspan="2"><button type="submit" name="btn-board-submit">글 쓰기</button></td>
        </tr>
      </table>
    </form>
  </div>
  <?php include "../common/footer.php"; ?>
</body>

</html>