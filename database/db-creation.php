<?php
include_once('database/db.php');

$posts = 'create table if not exists posts(
    id int not null auto_increment primary key,
    title varchar(255) not null,
    content text not null,
    created_at timestamp
)';

$pdo = db::connect();
$pdo->exec($posts);
$pdo = null;
?>