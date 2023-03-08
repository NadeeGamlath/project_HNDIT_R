<?php
require_once("./appointmentdao.php");
$method = $_SERVER['REQUEST_METHOD'];
if($method == 'POST') {


    $errors = "";
    $result = "";
    $defaultTime = "08:00:00";
    $appointmentARRAY1 = array();


    if (!isset($_POST['appointment'])) {
        $errors = "Appointment Not Available";
    } else {
        $appointmentOBJ = $_POST['appointment'];
        $appointment = json_decode($appointmentOBJ);
        $appointmentARRAY1["name"] = $appointment->name;
        $appointmentARRAY1["mobile"] = $appointment->mobile;
        $appointmentARRAY1["email"] = $appointment->email;
        $appointmentARRAY1["date"] = $appointment->date;
        $appointmentARRAY1["doctor"] = $appointment->doctor;

        if (!((isset($appointment->name)) && (isset($appointment->mobile)) && (isset($appointment->email)) && (isset($appointment->date)) && (isset($appointment->doctor)))) {
            $errors = "Appointment Data Is Missing..";
        } else {

            if (!preg_match("/^[a-zA-Z]+ [a-zA-Z]+$/", $appointment->name)) {
                $errors = $errors . "Name Invalid\n";
            }
            if (!preg_match("/^([0-9]{10})$/", $appointment->mobile)) {
                $errors = $errors . "Mobile Invalid\n";
            }
            if (!preg_match("/^[a-z0-9]+[@][a-z]+.[a-z]+$/", $appointment->email)) {
                $errors = $errors . "Email Invalid\n";
            }

            if ($appointment->doctor == null) {
                $errors = $errors . "Doctor Not Selected\n";
            }
        }
        $times = AppointmentDao::getTimeByDoctorAndDate($appointment->date, $appointment->doctor);
        $time = null;
        if (!$errors == "") {
            echo($errors);
        } else {

            if ($times['max(time)'] !== null) {
                if ($defaultTime == $times['max(time)']) {
                    $m = explode(":", $times['max(time)'])[1];
                    $h = explode(":", $times['max(time)'])[0];


                    if (8 <= $h && $h <= 17) {
                        $m = $m + 10;

                        if ($m >= 60) {
                            $h = $h + 1;
                            $m = $m - 60;

                        } else {
                            $time = $h . ":" . $m;

                            $appointmentARRAY1["time"] = $time;
                        }

                    } else {
                        $appointmentARRAY1["time"] = $defaultTime;

                    }

                } else {
                    $m = explode(":", $times['max(time)'])[1];
                    $h = explode(":", $times['max(time)'])[0];

                    if (8 <= $h && $h <= 17) {
                        $m = $m + 10;
                        if ($m >= 60) {
                            $h = $h + 1;
                            $m = $m - 60;

                            $time = $h . ":" . $m;
                            $appointmentARRAY1["time"] = $time;


                        } else {
                            $time = $h . ":" . $m;
                            $appointmentARRAY1["time"] = $time;
                        }

                    } else {
                        $appointmentARRAY1["time"] = $defaultTime;

                    }

                }
                $result = AppointmentDao::save($appointmentARRAY1);
                if ($result != 1) {
                    echo("DataBase Error!");
                }

            } else {
                $appointmentARRAY1["time"] = $defaultTime;
                $result = AppointmentDao::save($appointmentARRAY1);
                if ($result != 1) {
                    echo("DataBase Error!");
                }
            }
        }


    }
}elseif($method == 'GET'){

    $appointment = AppointmentDao::getById();
    $jsonData = json_encode($appointment);
    echo $jsonData;


}


