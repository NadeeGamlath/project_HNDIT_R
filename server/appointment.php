<?php
//data encapsulation
    class Appointment{
    
        public $id;
        public $name;
        public $email;
        public $mobile;
        public $date;
        public $time;
        public $doctor;

        function __construct(){}

        public function getId(){return $this->id;}

        public function setId($id){$this->id = $id;}

        public function getName(){return $this->name;}

        public function setName($name){$this->name = $name;}

        public function getEmail(){return $this->email;}

        public function setEmail($email){$this->email = $email;}

        public function getDate(){return $this->date;}

        public function setDate($date){$this->date = $date;}

        public function getTime(){return $this->time;}

        public function setTime($time){$this->time = $time;}

        public function getMobile(){return $this->mobile;}

        public function setMobile($mobile): void{$this->mobile = $mobile;}

        public function getDoctor(){return $this->doctor;}

        public function setDoctor($doctor): void{$this->doctor = $doctor;}




    }



?>