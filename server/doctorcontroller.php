<?php
require_once("doctordao.php");
$doctors = DoctorDao::getAll();
$jsonData = json_encode($doctors);
echo $jsonData;

?>