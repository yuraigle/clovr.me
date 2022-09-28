<?php

$mysqli = mysqli_connect(null, "root", "FpA200g8OtukFVi", "finance");
$res1 = $mysqli->query("select * from `assets` where `is_active` = 1");
$row1 = $res1->fetch_assoc();
$res1->close();

if ($row1['upd_type'] === 'json') {
    $s = file_get_contents($row1['upd_url']);
    $json = json_decode($s, true);
    print_r($json);

    
}
