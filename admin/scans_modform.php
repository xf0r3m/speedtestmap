<?php

echo "<form action=\"index.php?modscan=1\" method=\"post\">
        <input type=\"hidden\" name=\"scans_id\" value=\"" . $row[0] . "\" />
        <div class=\"form-group\">
                <label for=\"pinChoose\">Znacznik: </label>
                <select id=\"pinChoose\" class=\"form-control\" name=\"scans_marker\" aria-describedby=\"pinChooseHelp\">";
                if ( mysql_check_result($connection, $result2) ) {
                    if ( mysqli_num_rows($result2) > 0 ) {
                        while ( $row1 = mysqli_fetch_row($result2) ) {
                            if ( $row[1] === $row1[0] ) {
                                echo "<option value=\"" . $row1[0] . "\">" . $row1[1] . "</option>";
                            }
                        }
                        mysqli_data_seek($result2,0);
                        while ( $row1 = mysqli_fetch_row($result2) ) {
                            if ( $row[1] === $row1[0] ) { continue; }
                            else {
                                echo "<option value=\"" . $row1[0] . "\">" . $row1[1] . "</option>";
                            }
                        }
                    }
                }
                    
echo "</select>
                <small id=\"pinChooseHelp\" class=\"form-text text-muted\">Wybierz znacznik dla tego testu</small>
            </div>
            <div class=\"form-group\">
                <label for=\"dateofInput\">Data testu:</label>
                <input id=\"dateofInput\" class=\"form-control\" type=\"text\" name=\"scans_dateof\" value=\"" . $row[2] . "\" aria-describedby=\"dateofInputHelp\" />
                <small id=\"dateofInputHelp\" class=\"form-text text-muted\">Wprowadź datę i godzinę testu.</small>
            </div>
            <div class=\"form-group\">
                <label for=\"typeofSelect\">Typ połączenia:</label>
                <select id=\"typeofSelect\" class=\"form-control\" name=\"scans_typeof\" aria-describedby=\"typeOfSelectHelp\">";
                    
                    $values0 = ["Wifi", "Lte", "Hspap", "Edge"];
                    $labels0 = ["Wi-Fi", "4G/LTE", "3G/HSUPA/HSDPA", "2G/Edge/Gprs"];

                    for ($i=0; $i < count($values0); $i++) {
                        if ( $row[3] === $values0[$i] ) {
                            echo "<option value=\"" . $row[3] . "\">" . $labels0[$i] . "</option>";
                        }
                    }

                    for ($i=0; $i < count($values0); $i++) {
                        if ( $row[3] === $values0[$i] ) { continue; }
                        else {
                            echo "<option value=\"" . $values[$i] . "\">" . $labels0[$i] . "</option>"; 
                        }
                    }

                    
                echo "</select>
                <small id=\"typeOfSelectHelp\" class=\"form-text text-muted\">Wybierz typ połączenia.</small>
            </div>
            <div class=\"form-group\">
                <label for=\"latInput\">Szerokość geograficzna:</label>
                <input id=\"latInput\" class=\"form-control\" type=\"text\" name=\"scans_lat\" value=\"" . $row[4] . "\" aria-describedBy=\"latInputHelp\" />
                <small id=\"latInputHelp\" class=\"form-text text-muted\">Podaj szerokość geograficzną z wyników testu prędkości.</small>
            </div>
            <div class=\"form-group\">
                <label for=\"lonInput\">Długość geograficzna: </label>
                <input id=\"lonInput\" class=\"form-control\" type=\"text\" name=\"scans_lon\" value=\"" . $row[5] . "\" aria-describedby=\"lonInputHelp\" />
                <small id=\"lonInputHelp\" class=\"form-text text-muted\">Podaj długość geograficzną z wyników testu prędkości.</small>
            </div>
            <div class=\"form-group\">
                <label for=\"downInput\">Prędkość pobierania: </label>
                <input id=\"downInput\" class=\"form-control\" type=\"text\" name=\"scans_down\" value=\"" . $row[6] . "\" aria-describedby=\"downInputHelp\" />
                <small id=\"downInputHelp\" class=\"form-text text-muted\">Wpisz prędkość pobierania z wyników testu prędkości.</small>
            </div>
            <div class=\"form-group\">
                <label for=\"upInput\">Prędkość wysyłania: </label>
                <input id=\"upInput\" class=\"form-control\" type=\"text\" name=\"scans_up\" value=\"" . $row[7] . "\" aria-describedby=\"upInputHelp\" />
                <small id=\"upInput=\" class=\"form-text text-muted\">Wpisz prędkosć wysyłania z wyników testu prędkości.</small>
            </div>
            <div class=\"form-group\">
                <label for=\"pingInput\">Wartość opóźnienia: </label>
                <input id=\"pingInput\" class=\"form-control\" type=\"text\" name=\"scans_ping\" value=\"" . $row[8] . "\" aria_describedby=\"pingInputHelp\" />
                <small id=\"pingInput\" class=\"form-text text-muted\">Wpisz wartość opóźnienia z wyników testu prędkości.</small>
            </div>
            <button type=\"submit\" class=\"btn btn-warning\">Modyfikuj test prędkości</button>&nbsp;<a href=\"index.php\"><button type=\"button\" class=\"btn btn-secondary\">Wróć</button></a>
    </form>
    
    <br />";

?>