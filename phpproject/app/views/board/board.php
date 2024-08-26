<!DOCTYPE html>
<html lang="ko">
<?php include "../common/head.php"; ?>
<head>
    <style>
        .board-div-header {
            text-align: right;
            padding: 0px 30px 0px 0px;
        }

        .board-btn-write {
            text-align: center;
            display: inline-block;
            margin: auto;
        }

        table {
            text-align: center;
        }

        a {
            text-decoration: none;
        }
    </style>
    <script>

    </script>
</head>

<body>
    <?php
    
    include "../common/header.php";
    include "../../models/board/list.php";
    
    ?>
    <h1>게시판</h1>
    <div class="board-div-header">
        <?php if(!empty($_COOKIE['id'])) : ?>
        <button class="btn-write" type="button" onclick="location.href='../board/write.php'">글 쓰기</button>
        <?php endif;?>
    </div>
    <div class="board-list">
        <table style="width: 100%;">
            <tr>
                <th>글번호</th>
                <th>작성자</th>
                <th>제목</th>
                <th>작성일자</th>
            </tr>
            <?php if(!empty($rows)):?>
            <?php foreach ($rows as $row): ?>
                
                <tr>
                    <td><?= $row['bno']; ?></td>
                    <td><?= $row['writer']; ?></td>
                    <td><a href="../board/detail.php?bno=<?= $row["bno"]; ?>"><?= $row['title']; ?></a></td>
                    <td><?= $row['regdate']; ?></td>
                </tr>
            <?php endforeach; ?>
            <?php else :?>
                    <tr>
                        <td colspan="4">
                            검색 결과가 없습니다.
                        </td>
                    </tr>
            <?php endif ;?>
            
            <tr>
                <td colspan="4">
                <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center my-5">
                        <?php
                        if($pageNum >1){
                            echo '<li class="page-item">
                                    <a class="page-link" href="board.php?pageNum=' .($pageNum-1).'&searchMenu='.$searchMenu.'&keyword='.$keyword.'" aria-label="Previous">
                                        <span aria-hidden="true">prev</span>
                                    </a>
                                </li>';
                        }
                        for($printPage = $s_pageNum; $printPage <= $e_pageNum; $printPage++) {
                            echo '
                              <li class="page-item '.(($pageNum == $printPage) ? "active" : "").'">
                                <a class="page-link" href="board.php?pageNum='.$printPage.'&searchMenu='.$searchMenu.'&keyword='.$keyword.'">'.$printPage.'</a>
                              </li>
                            ';
                          }
                          if($pageNum < $totalPage) {
                            echo '
                              <li class="page-item">
                                <a class="page-link" href="board.php?pageNum='.($pageNum+1).'&searchMenu='.$searchMenu.'&keyword='.$keyword.'" aria-label="Next">
                                  <span aria-hidden="true">next</span>
                                </a>
                              </li>
                            ';
                          }
                        ?>
                    </ul>
                </nav>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <form action="/phpproject/app/views/board/board.php" method="GET">
                        <select name="searchMenu">
                            <option value="title" <?= $searchMenu == 'title' ? 'selected' : '' ?>>제목</option>
                            <option value="content" <?= $searchMenu == 'content' ? 'selected' : '' ?>>내용</option>
                            <option value="writer" <?= $searchMenu == 'writer' ? 'selected' : '' ?>>작성자</option>
                        </select>
                        <input type="text" name="keyword" id="keyword">
                        <button type="submit">검색</button>
                    </form>
                </td>
            </tr>
        </table>
        <?php include "../common/footer.php"; ?>
</body>

</html>