<?php
include_once("database/db.php");

if (isset($_POST['title']) && isset($_POST['content'])) {
    try {
        $pdo = db::connect();
        $ps = $pdo->prepare("insert into posts(title, content) values(:title, :content)");
        $ps->execute($_POST);
        $ps = null;
        $pdo = null;
        header("Location: index.php?status=1");
        die();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
}
header("Location: index.php");
die();
?>