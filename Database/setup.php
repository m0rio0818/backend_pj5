<?php

use Database\MySQLWrapper;

$mysqli = new MySQLWrapper();

$directories = __DIR__ . "/Examples/";


// user
$user = $directories . "user.sql";
$sql = file_get_contents($user);
$result = $mysqli->query($sql);

if ($result === false) throw new Exception('Could not execute query.');
else print("Successfully ran USER SQL setup queries." . PHP_EOL);

// post
$post = $directories . "post.sql";
$sql = file_get_contents($post);
$result = $mysqli->query($sql);

if ($result === false) throw new Exception('Could not execute query.');
else print("Successfully ran POST SQL setup queries." . PHP_EOL);

// coment
$comment = $directories . "comment.sql";
$sql = file_get_contents($comment);
$result = $mysqli->query($sql);

if ($result === false) throw new Exception('Could not execute query.');
else print("Successfully ran COMMENT SQL setup queries." . PHP_EOL);


// comment-like
$comment_like = $directories . "comment-like.sql";
$sql = file_get_contents($comment_like);
$result = $mysqli->query($sql);

if ($result === false) throw new Exception('Could not execute query.');
else print("Successfully ran SQL COMMENT_LIKE setup queries." . PHP_EOL);

// post-like
$post_like = $directories . "post-like.sql";
$sql = file_get_contents($post_like);
$result = $mysqli->query($sql);

if ($result === false) throw new Exception('Could not execute query.');
else print("Successfully ran SQL POST_LIKE setup queries." . PHP_EOL);

