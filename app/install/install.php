<?php
	$con = mysqli_connect("localhost", "root", "") or die("Ошибка при подключении к локальному серверу!");
	//$query = mysqli_query($con, "CREATE DATABASE semester CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
	//if($query) echo "База данных успешно создана!";
	//else die("Ошибка при создании базы данных!");

	$con = mysqli_connect("localhost", "root", "", "semester") or die("Ошибка при подключении к БД!");
	/*$query = mysqli_query($con, "CREATE TABLE users (id int NOT NULL auto_increment PRIMARY KEY, login VARCHAR (20) NOT NULL, pass VARCHAR (32) NOT NULL)") or die("Не удалось создать таблицу users!");
	$pass = md5("admin");
	$query = mysqli_query($con, "INSERT INTO users (`id`, `login`, `pass`) VALUES (NULL, 'admin', '$pass')") or die("Не удалось добавить admin в users!");
	*/
	$query = mysqli_query($con, "CREATE TABLE users (id int NOT NULL auto_increment PRIMARY KEY, login VARCHAR (20) NOT NULL, pass VARCHAR (32) NOT NULL)") or die("Не удалось создать таблицу users!");
	ALTER TABLE `groups` ADD FOREIGN KEY (`g_curator`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;
?>