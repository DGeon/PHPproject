<?php
    setcookie("id","null",time() - 3600,"/");
    header("Location: /phpproject/public/index.php");
?>