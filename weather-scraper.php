<?php
    if ($_POST) {
        
        $city = $_POST["city"];

        //Removes space between city names such as New York, to work with URL
        $cityUrl = str_replace(" ", "", $city);
        
        $forecastUrl = "https://www.weather-forecast.com/locations/" . $cityUrl . "/forecasts/latest";
            
        include("simple_html_dom.php");
            
        $urlHeaders = @get_headers($forecastUrl);

        if ($urlHeaders[0] == "HTTP/1.1 404 Not Found") {

            $error = "</br>Sorry, <strong>" . $city . " </strong>could not be found</br> ";
            
        } else {
            
            $html = file_get_html($forecastUrl);
                
            $weatherData = lcfirst($html->find(".phrase", 0)->plaintext);
    
            $weatherData = str_replace(". ", ".<br/>", $weatherData);
                
            $output = "<br/>The weather over the next 3 days in <strong>" . ucwords(strtolower($city)) . "</strong> is due to be " . $weatherData . "<br/> ";

        }

    } 
?>
<!DOCTYPE html>
<html>

    <head>

        <meta charset="UTF-8">   
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
        <title>Weather Scraper</title>
        <link rel="shortcut icon" href="images/tab-icon.png">
        
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <style type="text/css">
            
            body, html {
                height: 100%;
                margin: 0;
            }
                
            .bg {
                background-image: url("images/background.jpg");
                min-height: 100%;
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
            }
            
        </style>


    </head>

    <body>

        <div class="bg">

            <div class="container text-center p-5">

                <h1 class="pt-5">What's The Weather?</h1>

                <h6>Enter the name of a city</h6>

                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

                    <input name="city" type="text" class="form-control text-center text-primary font-weight-bold mx-auto mt-4 mb-4 w-50">

                    <input type="submit" value="Search" class="btn btn-primary rounded">

                </form>

            </div>

            <div class="<?php if ($output) {echo "bg-primary ";} if ($error) {echo "bg-danger ";} ?>text-white rounded col-md-6 mx-auto text-center">

                <?php
                
                    if ($output) {
                        
                        echo $output;

                    } else {
                        
                        echo $error;

                    }
                
                ?>

            </div>

        </div>

    </body>

</html>