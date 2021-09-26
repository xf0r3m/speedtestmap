<?php

echo "<form action=\"index.php?scans=1\" method=\"post\">
            <div class=\"form-group\">
                <label for=\"pinChoose\">Znacznik: </label>
                <select id=\"pinChoose\" class=\"form-control\" name=\"scans_marker\" aria-describedby=\"pinChooseHelp\">
                <option></option>";
                if ( mysql_check_result($connection, $result) ) {
                    if ( mysqli_num_rows($result) > 0 ) {
                        while ( $row = mysqli_fetch_row($result) ) {
                            echo "<option value=\"" . $row[0] . "\">" . $row[1] . "</option>";
                        }
                    }
                }
                    
echo "</select>
                <small id=\"pinChooseHelp\" class=\"form-text text-muted\">Wybierz znacznik dla tego testu</small>
            </div>
            <div class=\"form-group\">
                <label for=\"dateofInput\">Data testu:</label>
                <input id=\"dateofInput\" class=\"form-control\" type=\"text\" name=\"scans_dateof\" aria-describedby=\"dateofInputHelp\" />
                <small id=\"dateofInputHelp\" class=\"form-text text-muted\">Wprowadź datę i godzinę testu.</small>
            </div>
            <div class=\"form-group\">
                <label for=\"typeofSelect\">Typ połączenia:</label>
                <select id=\"typeofSelect\" class=\"form-control\" name=\"scans_typeof\" aria-describedby=\"typeOfSelectHelp\">
                    <option value=\"Wifi\">Wi-Fi</option>
                    <option value=\"Lte\">4G/LTE</option>
                    <option value=\"Hspap\">3G/HSUPA/HSDPA</option>
                    <option value=\"Edge\">2G/Edge/Gprs</option>
                </select>
                <small id=\"typeOfSelectHelp\" class=\"form-text text-muted\">Wybierz typ połączenia.</small>
            </div>
            <div class=\"form-group\">
                <label for=\"latInput\">Szerokość geograficzna:</label>
                <input id=\"latInput\" class=\"form-control\" type=\"text\" name=\"scans_lat\" aria-describedBy=\"latInputHelp\" />
                <small id=\"latInputHelp\" class=\"form-text text-muted\">Podaj szerokość geograficzną z wyników testu prędkości.</small>
            </div>
            <div class=\"form-group\">
                <label for=\"lonInput\">Długość geograficzna: </label>
                <input id=\"lonInput\" class=\"form-control\" type=\"text\" name=\"scans_lon\" aria-describedby=\"lonInputHelp\" />
                <small id=\"lonInputHelp\" class=\"form-text text-muted\">Podaj długość geograficzną z wyników testu prędkości.</small>
            </div>
            <div class=\"form-group\">
                <label for=\"downInput\">Prędkość pobierania: </label>
                <input id=\"downInput\" class=\"form-control\" type=\"text\" name=\"scans_down\" aria-describedby=\"downInputHelp\" />
                <small id=\"downInputHelp\" class=\"form-text text-muted\">Wpisz prędkość pobierania z wyników testu prędkości.</small>
            </div>
            <div class=\"form-group\">
                <label for=\"upInput\">Prędkość wysyłania: </label>
                <input id=\"upInput\" class=\"form-control\" type=\"text\" name=\"scans_up\" aria-describedby=\"upInputHelp\" />
                <small id=\"upInput=\" class=\"form-text text-muted\">Wpisz prędkosć wysyłania z wyników testu prędkości.</small>
            </div>
            <div class=\"form-group\">
                <label for=\"pingInput\">Wartość opóźnienia: </label>
                <input id=\"pingInput\" class=\"form-control\" type=\"text\" name=\"scans_ping\" aria_describedby=\"pingInputHelp\" />
                <small id=\"pingInput\" class=\"form-text text-muted\">Wpisz wartość opóźnienia z wyników testu prędkości.</small>
            </div>
            <button type=\"submit\" class=\"btn btn-success\">Dodaj test prędkości</button>
    </form>";

?>