<?php
include 'config.php';

@$d->query("CREATE TABLE user(name char, fullname char)");
@$d->query("CREATE TABLE repo(name char, fork int)");
@$d->query("CREATE TABLE branch(repo char, branch char)");
@$d->query("CREATE TABLE lang(repo char, lang char)");
?>
