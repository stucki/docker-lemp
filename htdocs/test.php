<?php

$db = mysqli_connect('db', 'root', 'secret', 'mysql')
	or die('Error: ' . mysqli_error());

$query = 'SHOW DATABASES;';
$res = mysqli_query($db, $query);

if ($res) {
	echo '<pre>' . PHP_EOL;

	while ($row = mysqli_fetch_assoc($res)) {
		var_dump($row);
	}

	echo '</pre>' . PHP_EOL;
}

echo 'Success! ' . time();
