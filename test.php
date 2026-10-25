<?php
require 'koneksi.php';
$data = $pdo->query("SELECT * FROM ponsel")->fetchAll(PDO::FETCH_ASSOC);
echo "<pre>";
print_r($data);
echo "</pre>";