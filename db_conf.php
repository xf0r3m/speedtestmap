<?php

    $db_host="localhost";
    $db_user="speedtestmap";
    $db_pass="6I20I801hE";
    $db="speedtestmap";

    $connection = mysqli_connect($db_host, $db_user, $db_pass, $db);

    if ( ! $connection ) {
    
        echo "<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
        Błąd połączenia z bazą danych.
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
            <span aria-hidden=\"true\">&times;</span>
        </button>
        </div>";
        exit;
    }

?>