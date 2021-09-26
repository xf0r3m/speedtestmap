
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <style>

        body {
            width: 80%;
            margin: auto;
            margin-top: 1.5%;
        }

    </style>

    <title>SpeedTestMap - panel administracyjny</title>
  </head>
  <body>

<?php

include('../db_conf.php');
include('../library.php');

//var_dump($_GET);
//var_dump($_POST);

if ( ! empty($_POST) ) {

    if ( ! empty($_GET['modscan']) ) {

        $mod_id = $_POST['scans_id'];

        $tName = 'scans';
        $csh = 'marker,dateof,typeof,lat,lon,down,up,ping';
        $pKL = generatePKL($tName, $csh);
        $whereValue = "id=" . $mod_id;

        if ( strlen($_POST['scans_lat']) <= 7 ) {
            $_POST['scans_lat'] .= rand(210, 900);
        }

        if ( strlen($_POST['scans_lon']) <= 7 ) {
            $_POST['scans_lon'] .= rand(210, 900);
        }

        $result = updatef($connection, $tName, $csh, $pKL, $whereValue);
        mysql_check_result($connection, $result);
        header("Location: index.php");

    } else if ( ! empty($_GET['modpins']) ) {

        $mod_id = $_POST['pinId'];

        $tName = 'pins';
        $csh = 'pinName,pinColor';
        $pKL = generatePKL($tName, $csh);
        $whereValue = "id=" . $mod_id;

        $result = updatef($connection, $tName, $csh, $pKL, $whereValue);
        mysql_check_result($connection, $result);
        header("Location: index.php");

    } else if ( ! empty($_GET['scans']) ) {

        $tName = 'scans';
        $csh = 'marker,dateof,typeof,lat,lon,down,up,ping';
        $pKL = generatePKL($tName, $csh);

        if ( strlen($_POST['scans_lat']) <= 7 ) {
            $_POST['scans_lat'] .= rand(210, 900);
        }
        
        if ( strlen($_POST['scans_lon']) <= 7 ) {
            $_POST['scans_lon'] .= rand(210, 900);
        }
        
        $result = insertf($connection, $tName, $csh, $pKL);
        mysql_check_result($connection, $result);
        header("Location: index.php");

    } else if ( ! empty($_GET['pins']) ) {

        $tName = 'pins';
        $csh = 'pinName,pinColor';
        $pKL = generatePKL($tName, $csh);

        $result = insertf($connection, $tName, $csh, $pKL);
        mysql_check_result($connection, $result);
        header("Location: index.php");

    } else if ( ! empty($_GET['register']) ) {

        $_POST['users_hash']=password_hash($_POST['password'], PASSWORD_DEFAULT);

        $tName = 'users';
        $csh = 'uname,hash';
        $pKL = generatePKL($tName, $csh);

        $result = insertf($connection, $tName, $csh, $pKL);
        if ( mysql_check_result($connection, $result) ) {
            session_start();
            $_SESSION['username'] = $_POST['users_uname'];
            header("Location: index.php");
        }

    } else {

        $tName = 'users';
        $csh = 'hash';
        $whereValue="uname='" . $_POST['users_uname'] . "'";

        $result = selectf($connection, $tName, $csh, $whereValue);
        if ( mysql_check_result($connection, $result) ) {
            if ( mysqli_num_rows($result) > 0 ) {
                
                $row = mysqli_fetch_row($result);
                if ( password_verify($_POST['password'], $row[0]) ) {
                    session_start();
                    $_SESSION['username'] = $_POST['users_uname'];
                    header("Location: index.php");
                } else {
                    echo "<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                        Nie poprawna nazwa użytkownia lub hasło.
                    <span aria-hidden=\"true\">&times;</span>
                    </button>
                    </div>";
                }
            } else {
                echo "<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                        Nie znaleziono uzytkownika.
                    <span aria-hidden=\"true\">&times;</span>
                    </button>
                    </div>";
            }
        }
    }

}

if ( session_status() !== 2 ) { session_start(); }
if ( ! empty($_SESSION['username']) ) {

    if ( ! empty($_GET['scansloadfile']) ) {

        if ( $_FILES['csvLoad']['error'] === 0 ) {
    
            if ( move_uploaded_file($_FILES['csvLoad']['tmp_name'], 'result.csv') ) {
    
                $f = fopen('result.csv', 'r');
                
                while ( ( $csvLine = fgets($f)) !== FALSE ) {
                    
                    $csvLineArray = explode(',', $csvLine);
                    
                    $tName = 'scans';
                    $csh = 'marker,dateof,typeof,lat,lon,down,up,ping';
                    $pKL = generatePKL($tName, $csh);
    
                    $_POST['scans_marker'] = $csvLineArray[0];
                    $_POST['scans_dateof'] = $csvLineArray[1];
                    $_POST['scans_typeof'] = $csvLineArray[2];
                    $_POST['scans_lat'] = $csvLineArray[3];
                    $_POST['scans_lon'] = $csvLineArray[4];

                    if ( strlen($_POST['scans_lat']) <= 7 ) {
                        $_POST['scans_lat'] .= rand(210, 900);
                    }
                    
                    if ( strlen($_POST['scans_lon']) <= 7 ) {
                        $_POST['scans_lon'] .= rand(210, 900);
                    }

                    $_POST['scans_down'] = $csvLineArray[5];
                    $_POST['scans_up'] = $csvLineArray[6];
                    $_POST['scans_ping'] = $csvLineArray[7];
    
                    $result = insertf($connection, $tName, $csh, $pKL);
                    mysql_check_result($connection, $result);

                    unlink('result.csv');
                }
            }
        } else {
            echo "<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
        Wystąpił problem z załadowanie pliku, pilk może przekraczać 2 MB.
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
            <span aria-hidden=\"true\">&times;</span>
        </button>
        </div>";
        }
    }

//Znaczniki
echo "<div style=\"text-align: right;\"><a href=\"../index.php\">Powrót do mapy</a></div>";
echo "<p><h3>Znaczniki </h3></p>
<hr />";

if ( ! empty($_GET['modpins']) ) {

    $mod_id=$_GET['id'];

    $tName = 'pins';
    $csh = '*';
    $whereValue = "id=" . $mod_id;

    $result = selectf($connection, $tName, $csh, $whereValue);
    if ( mysql_check_result($connection, $result) ) {
        if ( mysqli_num_rows($result) > 0 ) {
            $row = mysqli_fetch_row($result);

            echo "<form action=\"index.php?modpins=1\" method=\"post\">
                    <input type=\"hidden\" name=\"pinId\" value=\"" . $row[0] . "\" />
                    <div class=\"form-group\">
                        <label for=\"pinName\">Nazwa znacznika</label>
                        <input id=\"pinName\" class=\"form-control\" type=\"text\" name=\"pins_pinName\" value=\"" . $row[1] . "\" aria-describedby=\"pinNameHelp\" />
                        <small id=\"pinNameHelp\" class=\"form-text text-muted\">Podaj nazwę identyfikacyjną znacznika.</small>
                    </div>
                    <div class=\"form-group\">
                        <label for=\"pinColor\">Kolor znacznika</label>
                        <input id=\"pinColor\" class=\"form-control\" type=\"color\" name=\"pins_pinColor\" value=\"" . $row[2] . "\" aria-describedby=\"pinColorHelp\" />
                        <small id=\"pinColorHelp\" class=\"form-text text-muted\">Wybierz kolor dla zanacznika</small>
                    </div>
                    <button type=\"submit\" class=\"btn btn-success\">Modyfikuj znaczninik</button>&nbsp;
                    <a href=\"index.php\"><button class=\"btn btn-secondary\">Wróć</button></a>
                </form>
                <br />";
        }
    }

} else if ( ! empty($_GET['delpins']) ) {

    $del_id = $_GET['id'];

    $tName = 'pins';
    $whereValue = 'id=' . $del_id;

    $result = deletef($connection, $tName, $whereValue);
    mysql_check_result($connection, $result);

} else {

    echo "
        <form action=\"index.php?pins=1\" method=\"post\">
            <div class=\"form-group\">
                <label for=\"pinName\">Nazwa znacznika</label>
                <input id=\"pinName\" class=\"form-control\" name=\"pins_pinName\" type=\"text\" aria-describedby=\"pinNameHelp\" />
                <small id=\"pinNameHelp\" class=\"form-text text-muted\">Podaj nazwę identyfikacyjną znacznika.</small>
            </div>
            <div class=\"form-group\">
                <label for=\"pinColor\">Kolor znacznika</label>
                <input id=\"pinColor\" class=\"form-control\" name=\"pins_pinColor\" type=\"color\" aria-describedby=\"pinColorHelp\" />
                <small id=\"pinColorHelp\" class=\"form-text text-muted\">Wybierz kolor dla zanacznika</small>
            </div>
            <button type=\"submit\" class=\"btn btn-success\">Dodaj znaczninik</button>
        </form>
        <br />  
    ";

}

echo "<p><u>Zdefiniowane znaczniki: </u></p>  ";

$tName = 'pins';
$csh = 'id,pinName,pinColor';

$result = selectf($connection, $tName, $csh);
if ( mysql_check_result($connection, $result) ) {
    if ( mysqli_num_rows($result) > 0) {
        echo "<table class=\"table\">
                <thead>
                    <tr>
                        <th scope=\"col\">#</th>
                        <th scope=\"col\"></th>
                        <th scope=\"col\">Nazwa znacznika</th>
                        <th scope=\"col\">Kolor znacznika</th>
                        <th colspan=\"2\" scope=\"col\"></th>
                    </tr>
                </thead>
                <tbody>";

                while ( $row = mysqli_fetch_row($result) ) {

                    echo "<tr>
                        <th scope=\"row\">" . $row[0] . "</th>
                        <td><img src=\"https://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2%7C" . substr($row[2], 1) . "&chf=a,s,ee00FFFF\" /></td>
                        <td>" . $row[1] . "</td>
                        <td><input type=\"color\" readonly=\"readonly\" value=\"" . $row[2] . "\" /></td>
                        <td><a href=\"index.php?modpins=1&id=" . $row[0] . "\">
                                <button class=\"btn btn-warning\">Modyfikuj</button></a></td>
                        <td><a href=\"index.php?delpins=1&id=" . $row[0] . "\">
                                <button class=\"btn btn-danger\">Usuń</button></a></td>
                        </tr>";

                }
                    
                echo "</tbody>
            </table>";
    } else {
        echo "
        <div class=\"alert alert-primary\" role=\"alert\">
            Nie znaleziono żadnych znaczników.
        </div>
        ";
    }
}

//Koniec znaczników

echo "<p>&nbsp;</p>
<p><h3>Skany</h3></p>
<hr />";

if ( ! empty($_GET['modscan']) ) {

    $mod_id = $_GET['id'];

    $tName = 'scans';
    $csh = "*";

    $result = selectf($connection, $tName, $csh);

    if ( mysql_check_result($connection, $result) ) {
        if ( mysqli_num_rows($result) > 0 ) {

            $row = mysqli_fetch_row($result);

            $tName = 'pins';
            $csh = 'id,pinName';

            $result2 = selectf($connection, $tName, $csh);

            include('scans_modform.php');

        }
    }
    
} else if ( ! empty($_GET['delscan']) ) {

    $del_id = $_GET['id'];

    $tName = 'scans';
    $whereValue = "id=" . $del_id;

    $result = deletef($connection, $tName, $whereValue);
    mysql_check_result($connection, $result);
    header("Location: index.php");  

} else {

    echo "<p><strong>Dodaj automatycznie: </strong></p>";
    echo "<form action=\"index.php?scansloadfile=1\" method=\"post\" enctype=\"multipart/form-data\">
        <div class=\"form-group\">
            <label for=\"fileUpload\">Załaduj plik:</label>
            <input id=\"fileUpload\" type=\"file\" name=\"csvLoad\" class=\"form-control\" aria-describedby=\"fileUpload\" />
            <small id=\"fileUploadHelp\" class=\"form-text text-muted\">Załaduj plik .csv z wynikami ze SpeedTest</small>
        </div>
        <button type=\"submit\" class=\"btn btn-success\">Wyślij plik</button>
    </form>";
    echo "<br />
    <p><strong>Dodaj ręcznie: </strong></p>";

    $tName = 'pins';
    $csh = 'id,pinName';

    $result = selectf($connection, $tName, $csh);

    include('scans_form.php');
    
}

echo "<br />
    <p><u>Testy prędkości: </u></p>";

$tName = 'scans';
$csh = '*';

$result = selectf($connection, $tName, $csh);
if ( mysql_check_result($connection, $result) ) {
    if ( mysqli_num_rows($result) > 0) {
        echo "<table class=\"table\">
                <thead>
                    <tr>
                        <th scope=\"col\">#</th>
                        <th scope=\"col\">Znacznik</th>
                        <th scope=\"col\">Data</th>
                        <th scope=\"col\">Typ połączenia</th>
                        <th scope=\"col\">Szerokosć geograficza</th>
                        <th scope=\"col\">Długość geograficzna</th>
                        <th scope=\"col\">Prędkosc pobierania</th>
                        <th scope=\"col\">Prędkość wysyłania</th>
                        <th scope=\"col\">Wartość opóżnienia</th>
                        <th colspan=\"2\" scope=\"col\"></th>
                    </tr>
                </thead>
                <tbody>";

                while ( $row = mysqli_fetch_row($result) ) {

                    $tName = 'pins';
                    $csh = 'pinColor';
                    $whereValue = 'id=' . $row[1];

                    $result2 = selectf($connection, $tName, $csh, $whereValue);
                    if ( mysql_check_result($connection, $result2) ) { 
                        if ( mysqli_num_rows($result2) > 0 ) {
                            $row2 = mysqli_fetch_row($result2);
                        }
                    }

                    echo "<tr>
                        <th scope=\"row\">" . $row[0] . "</th>
                        <td><img src=\"https://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2%7C" . substr($row2[0], 1) . "&chf=a,s,ee00FFFF\" /></td>
                        <td>" . $row[2] . "</td>
                        <td>" . $row[3] . "</td>
                        <td>" . $row[4] . "</td>
                        <td>" . $row[5] . "</td>
                        <td>" . $row[6] . "</td>
                        <td>" . $row[7] . "</td>
                        <td>" . $row[8] . "</td>
                        <td><a href=\"index.php?modscan=1&id=" . $row[0] . "\">
                                <button class=\"btn btn-warning\">Modyfikuj</button></a></td>
                        <td><a href=\"index.php?delscan=1&id=" . $row[0] . "\">
                                <button class=\"btn btn-danger\">Usuń</button></a></td>
                        </tr>";

                }
                    
                echo "</tbody>
            </table>";
    } else {
        echo "
        <div class=\"alert alert-primary\" role=\"alert\">
            Nie znaleziono żadnych testów.
        </div>
        ";
    }
}

} else {

    $tName = 'users';
    $csh = "*";
    $result = selectf($connection, $tName, $csh);
    
    if ( mysql_check_result($connection, $result) ) {
        
        if ( mysqli_num_rows($result) > 0 ) {
            echo "<p><h3>Logowanie</h3></p>
            <hr />
            <form action=\"index.php?login=1\" method=\"post\">";
        } else {
            echo "<p><h3>Rejestracja</h3></p>
            <hr />
            <form action=\"index.php?register=1\" method=\"post\">";
        }
    
        echo "<div class=\"form-group\">
                    <label for=\"username\">Nazwa użytkownika:</label>
                    <input id=\"username\" class=\"form-control\" type=\"text\" name=\"users_uname\" aria-describedby=\"usernameHelp\" />
                    <small id=\"usernameHelp\" class=\"form-text text-muted\">Podaj login.</small>
                </div>
                <div class=\"form-group\">
                    <label for=\"password\">Hasło:</label>
                    <input id=\"password\" class=\"form-control\" type=\"password\" name=\"password\" aria-describedby=\"passwordHelp\" />
                    <small id=\"passwordHelp\" class=\"form-text text-muted\">Podaj hasło.</small>
                </div>
                <button type=\"submit\" class=\"btn btn-success\">Zaloguj się</button>
            </form>";
    
    }

}

?>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>