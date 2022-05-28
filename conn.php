<?php
    $host = '127.0.0.1';
    $db   = 'pdo_var0';
    $user = 'root';
    $pass = '';

    
    $dsn = "mysql:host=$host;dbname=$db";
    $pdo = new PDO($dsn, $user, $pass);
