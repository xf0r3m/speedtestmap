<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- leafleatjs -->
    <script src="leaflet.js"></script>
    <link rel="stylesheet" href="leaflet.css" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>SpeedTestMap</title>
    <style>
        #content {
            width: 80%;
            margin: auto;
        }
        #login {
            text-align: right;
        }
        #map {
            width: 100%;
            height: 60vh;
        }
    </style>
  </head>
  <body>
    <div id="content">
    <div id="login"><a href="admin/index.php">
    <?php
    if ( session_status() !== 2 ) { session_start(); }
    if ( ! empty($_SESSION['username']) ) {
      echo "Panel administracyjny";
    } else {
      echo "Zaloguj się";
    }
    ?>
    </a></div>
    <div id="map"></div>
    <div id="tabela">
    <?php

    include('db_conf.php');
    include('library.php');

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

     ?>
    </div>
    </div>
    <!-- mapa -->
    <script>
      // initialize Leaflet
      var map = L.map('map').setView({lon: 18.611111, lat: 53.022222}, 6);

      <?php 

        $tName = 'pins';
        $csh = "id,pinColor";
        
        $result2 = selectf($connection, $tName, $csh);
        if ( mysql_check_result($connection, $result2) ) {
          if ( mysqli_num_rows($result2) > 0 ) {

            while ( $row2 = mysqli_fetch_row($result2) ) {

              echo "var pin" . $row2[0] . " = L.icon({ iconUrl: 'https://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2%7C" . substr($row2[1], 1) . "&chf=a,s,ee00FFFF'});", PHP_EOL;
          
            }

          }
        }

      ?>

      //var plusIcon = L.icon({ iconUrl: 'https://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2%7C014011&chf=a,s,ee00FFFF'});
      // show a marker on the map
      //L.marker({lat: 53.022222, lon: 18.611111}).bindPopup('Urządzenie: Redmi Note 8 Pro<br />Ping: 33ms<br />Jitter: 2ms<br />Down: 26,8Mbp/s<br />Up: 33,1Mbp/s').addTo(map);


      <?php

        $tName = 'scans';
        $csh = "marker,dateof,typeof,lat,lon,down,up,ping";

        $result = selectf($connection, $tName, $csh);
        if ( mysql_check_result($connection, $result) ) {
          if ( mysqli_num_rows($result) > 0 ) {
            while ( $row = mysqli_fetch_row($result) ) {
              echo "L.marker([" . $row[3] . ", " . $row[4] . "], {icon: pin" . $row[0] . "}).bindPopup('Data: " . $row[1] . ",<br />Typ: " . $row[2] . ",<br />Down: " . $row[5] . ",<br />Up: " . $row[6] . ",<br />Ping: " . trim($row[7]) . "').addTo(map);", PHP_EOL;
            }
          }
        }

      ?>

      //L.marker([50.505, 30.57], {icon: plusIcon}).addTo(map);

                  // add the OpenStreetMap tiles
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap contributors</a>'
      }).addTo(map);

      // show the scale bar on the lower left corner
      L.control.scale().addTo(map);

    </script>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>