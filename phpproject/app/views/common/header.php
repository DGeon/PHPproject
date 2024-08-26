<style>
.headerBox {
  background-color: skyblue;
  display: flex;
  flex-direction: column; 
  align-items: center; 
  justify-content: center;
  height: 200px; 
  text-align: center; 
}

.header-ul {
  list-style: none; 
  padding: 0;
  margin: 50px 0px 50px 0px; 
}

.header-ul li {
  display: inline; 
  margin: 0 10px; 
}

.header-ul a {
  text-decoration: none; 
}
</style>

<div class="headerBox mb-3 d-flex">
  <h1 class="fw-bold my-auto d-block">PHP simple project</h1>
  <ul class="header-ul">
    <li><a href="/phpproject/public/index.php">홈</a></li>
    <li><a href="/phpproject/app/views/board/board.php">게시판</a></li>
    <li>
      <?php if (isset($_COOKIE["id"])) { ?>
      <a href="/phpproject/app/models/member/logout.php">로그아웃</a>
      <li><a href="/phpproject/app/views/member/mypage.php">마이페이지</a></li>
    <?php } else { ?>
      <a href="/phpproject/app/views/member/login.php">로그인</a>
    <?php } ?>
    </li>
  </ul>
</div>