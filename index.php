<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Nigeria Meteorological Agency</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href="https://opensource.keycdn.com/fontawesome/4.6.3/font-awesome.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
    <script src="js/app.js"></script>
</head>

<?php
    require_once('src/CityWeather.php');
    require_once('src/CityPrevision.php');
    if(!isset($_POST['city'])){
        $city = $_POST['city'] = "Abuja";//Nantes default city              
    }
    else{
        $city = ucfirst($_POST['city']);
    }

    // day weather
    $dw = curl_init("http://api.openweathermap.org/data/2.5/weather?q=".$city."&APPID=6725751c808eb207c32ed7a52ee67d61");
    if($dw){
        curl_setopt($dw, CURLOPT_RETURNTRANSFER, true); //to get data in variable instead of show it in html page 
        $dataWeather = curl_exec($dw);
        curl_close($dw);

        $weather = json_decode($dataWeather);//to get php object
        $cityWeather = new CityWeather($weather);
        $iconId =  $cityWeather->getIconId();
        $measureDate = $cityWeather->getMeasureDate();
        $sunrise = $cityWeather->getSunriseHour();
        $sunset = $cityWeather->getSunsetHour();
        $humidity = $cityWeather->getHumidity();
        $pressure = $cityWeather->getPressure();
        $wind = $cityWeather->getWindSpeed();
        $temp = $cityWeather->getTempC();
        $iconId = $cityWeather->getIconId();
        $lat = $cityWeather->getLat();
        $lon = $cityWeather->getLon();
    } 


    // forecast weather
    $fw = curl_init("http://api.openweathermap.org/data/2.5/forecast/daily?q=".$city."&cnt=6&APPID=6725751c808eb207c32ed7a52ee67d61");
    if($fw){
        curl_setopt($fw, CURLOPT_RETURNTRANSFER, true); //to get data in variable instead of show it in html page
        $dataForecast = curl_exec($fw);
        curl_close($fw);

        $forecast = json_decode($dataForecast);   
        $cityPrevision = new CityPrevision($forecast);
        $listDays = $cityPrevision->getList(); 
    }
?>


<body>
    <div id="station">
        <h1>WEATHER CHANNEL</h1>
        <div id="search">
            <h3>Search Weather for a City</h3>
            <form method="POST" id="cityForm" class= "cityForm">
                <input type="text" id="city" class= "cityForm" name="city" placeholder="ex: Lagos">
                <input id="submit" class= "cityForm" type="submit" value="Get Weather Details"/>
            </form>
        </div>
        <h3 id="title">Weather forecast of <?= $cityWeather->getDate()?> for <?= $city ?></h3>
        <span id="cityWeather">
            <span id="map">
                <img src="https://maps.googleapis.com/maps/api/staticmap?center=<?=$lat?>,<?=$lon?>&zoom=12&size=250x250&key=AIzaSyBMPVNGjluoxeo6mZaDfTjAUTOb0yzQbuw">
            </span>

            <span id="info">
                <ul>
                    <li>Measurement time : <?= $measureDate ?></li>
                    <li>Sunrise: <?= $sunrise ?></li>
                    <li>Sunset: <?= $sunset ?></li>
                    <li>Humidity : <?= $humidity ?></li>
                    <li>Pressure : <?= $pressure ?></li>
                    <li>Wind : <?= $wind ?></li>
                </ul>
            </span>
            <span id="icon"><img class="iconImg" src="img/<?=$iconId?>.png"/></span>
            <span id="temp"><?= $temp ?></span>
        </span>
        <span id="btn_forecast"><i id="arrowPrev" class="fa fa-arrow-circle-down fa-2x pointer"></i><legend id="prev">
</legend></span>

        <span id="forecast">
            <?php
                for ($ii = 1; $ii < count($listDays); $ii++) {
                    $icon = $cityPrevision->getIconDay($ii);
                    $temp = $cityPrevision->getTempC($ii);
                    $day = $cityPrevision->getDay($ii);
            ?>
            <span><img class="iconImg" src="img/<?=$icon?>.png"/><p><?=$temp?></br><?=$day?></p></span>

            <?php
                }
            ?>    
        </span>
    </div>
</body>
</html>