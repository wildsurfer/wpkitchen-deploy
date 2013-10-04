<?php

require('wp-config.php');

$filename = 'dump.sql';
$mysql_host = DB_HOST;
$mysql_username = DB_USER;
$mysql_password = DB_PASSWORD;
$mysql_database = DB_NAME;

mysql_connect($mysql_host, $mysql_username, $mysql_password) or die('Error connecting to MySQL server: ' . mysql_error());
mysql_select_db($mysql_database) or die('Error selecting MySQL database: ' . mysql_error());

$templine = '';
$lines = file($filename);
foreach ($lines as $line)
{
    if (substr($line, 0, 2) == '--' || $line == '')
        continue;
    $templine .= $line;
    if (substr(trim($line), -1, 1) == ';')
    {
        mysql_query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
        $templine = '';
    }
}

unlink('dump.sql');
unlink('undump.php');
