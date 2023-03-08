<?php
// interact with DBMS (db.php)
class CommonDao
{

//    php walin function ekak hadala thiyanawa getResult kiyala
// php variable hadanne $.....
    public static function getResults($query)
    {
        $servername = "localhost";
        $username = "root";
        $password = "1234";
        $database = "appointment_db";

        // Create connection
        //mysqli kiyanne php wala function ekk connection ek hadaganna one nam api ekata thama danne
        //meken return krnne true false
        $dbconn = new mysqli($servername, $username, $password, $database);

        // Check connection
        //! mehem dala thiyenne connection eka true une nathnam kiyana eka
        //php wala concatination wenne . eken
        if (!$dbconn) {
                                       //arrow function ekk...  connection eke  error eka pennawa hethuwa
            die("Connection failed: " . $dbconn->connect_error);
        }
        return $dbconn->query($query);
    }
}
    