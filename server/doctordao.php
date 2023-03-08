<?php
require_once("db.php");
require_once("doctor.php");

class DoctorDao
{
    public static function getById($id)
    {
        $query = "SELECT * FROM doctor WHERE id = '$id';";
        $result = CommonDao::getResults($query);
        $row = $result->fetch_assoc();
        return DoctorDao::setData($row);
    }



    public static function setData($row)
    {
        $doctor = new Doctor();
        $doctor->setId($row['id']);
        $doctor->setName($row['name']);
        return $doctor;
    }

    public static function getAll()
    {
        $doctors = array();
        $query = "SELECT * FROM doctor";
        $result = CommonDao::getResults($query);
        while ($row = $result->fetch_assoc()) {
            $doctor = DoctorDao::setData($row);
            $doctors[] = $doctor;
        }
        return $doctors;
    }

}

