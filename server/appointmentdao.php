<?php
require_once("db.php");
require_once("appointment.php");
require_once("doctordao.php");

class AppointmentDao
{

    public static function setData($row)
    {
        $appointment = new Appointment();
        $appointment->setId($row['id']);
        $appointment->setName($row['name']);
        $appointment->setMobile($row['mobile']);
        $appointment->setEmail($row['email']);
        $appointment->setDate($row['date']);
        $doctor = DoctorDao::getById($row['doctor_id']);
        $appointment->setDoctor($doctor);
        $appointment->setTime($row['time']);
        return $appointment;
    }


    public static function getById()
    {
        $appointments = array();
        $query = "select * from appointment where id = (SELECT max(id) FROM appointment  order by id DESC);";
        $result = CommonDao::getResults($query);
        while ($row = $result->fetch_assoc()) {
            $appointment = AppointmentDao::setData($row);
            $appointments[] = $appointment;
        }
        return $appointments;
    }


    public static function getTimeByDoctorAndDate($date, $doctor)
    {
        $query = "SELECT max(time) FROM appointment where date ='" . $date . "' and doctor_id =" . $doctor->id." order by time DESC";

        $result = CommonDao::getResults($query);
        $row = $result->fetch_assoc();

        return $row;
    }

    public static function save($data)
    {
        $query = "INSERT INTO appointment (name, mobile,email, date,time,doctor_id) VALUES ('" . $data['name'] . "','" . $data['mobile'] . "','" . $data['email'] . "','" . $data['date'] . "','" . $data['time'] . "'," . $data ['doctor']->id . ")";
        return CommonDao::getResults($query);
    }

}
