<?php

use Database\MySQLWrapper;

$mysqli = new MySQLWrapper();

$directories = __DIR__ . "/Examples/";

$arrays = ["user", "post", "comment", "alter_user",  "comment-like", "post-like", "category", "user-setting", "tag", "post-tag", "alter_post",];

for ($i = 0; $i < count($arrays); $i++) {

    $code = $directories . $arrays[$i] .  ".sql";

    $sql = file_get_contents($code);
    // echo $sql . PHP_EOL;
    $result = $mysqli->query($sql);
    if ($result === false) throw new Exception('Could not execute query.');
    else print("Successfully run " . $arrays[$i] . " SQL setup queries." . PHP_EOL);
}

// user.sqlファイルの内容を読み込み、実行する
// $userSqlFile = $directories . "user.sql";
// $userSql = file_get_contents($userSqlFile);
// $userResult = $mysqli->query($userSql);
// if ($userResult === false) throw new Exception('Could not execute user.sql query.');
// else print("Successfully run user.sql query." . PHP_EOL);

// $alterResult = $mysqli->query($alterSql);
// if ($alterResult === false) throw new Exception('Could not execute ALTER TABLE query.');
// else print("Successfully run ALTER TABLE query." . PHP_EOL);

// user
// $user = $directories . "user.sql";
// $sql = file_get_contents($user);
// $result = $mysqli->query($sql);


// // post
// $post = $directories . "post.sql";
// $sql = file_get_contents($post);
// $result = $mysqli->query($sql);

// if ($result === false) throw new Exception('Could not execute query.');
// else print("Successfully ran POST SQL setup queries." . PHP_EOL);

// // coment
// $comment = $directories . "comment.sql";
// $sql = file_get_contents($comment);
// $result = $mysqli->query($sql);

// if ($result === false) throw new Exception('Could not execute query.');
// else print("Successfully ran COMMENT SQL setup queries." . PHP_EOL);


// // comment-like
// $comment_like = $directories . "comment-like.sql";
// $sql = file_get_contents($comment_like);
// $result = $mysqli->query($sql);

// if ($result === false) throw new Exception('Could not execute query.');
// else print("Successfully ran SQL COMMENT_LIKE setup queries." . PHP_EOL);

// // post-like
// $post_like = $directories . "post-like.sql";
// $sql = file_get_contents($post_like);
// $result = $mysqli->query($sql);

// if ($result === false) throw new Exception('Could not execute query.');
// else print("Successfully ran SQL POST_LIKE setup queries." . PHP_EOL);
