<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Assignment 1</title>
  </head>
  <body>
    <?php

    $distances = array(
        "Berlin" => array(
        "Berlin" => 0,
        "Moscow" => 1607.99,
        "Paris" => 876.96,
        "Prague" => 280.34,
        "Rome" => 1181.67
        ),
        "Moscow" => array(
        "Berlin" => 1607.99,
        "Moscow" => 0,
        "Paris" => 2484.92,
        "Prague" => 1664.04,
        "Rome" => 2374.26
        ),
        "Paris" => array(
        "Berlin" => 876.96,
        "Moscow" => 641.31,
        "Paris" => 0,
        "Prague" => 885.38,
        "Rome" => 1105.76
        ),
        "Prague" => array(
        "Berlin" => 280.34,
        "Moscow" => 1664.04,
        "Paris" => 885.38,
        "Prague" => 0,
        "Rome" => 922
        ),
        "Rome" => array(
        "Berlin" => 1181.67,
        "Moscow" => 2374.26,
        "Paris" => 1105.76,
        "Prague" => 922,
        "Rome" => 0
        )
    );

    $startIndex = "Berlin";
    $endIndex = "Berlin";
    $kmToMiles = 0.62;

    if (isset($_POST['submit']))
      {
      	$startIndex = stripslashes($_POST['Start']);
            $endIndex = stripslashes($_POST['End']);
            if (isset($distances[$startIndex][$endIndex]))
            {
                	echo "<p>The distance from " . $startIndex . " to " .
                  $endIndex . " is " . $distances[$startIndex][$endIndex]
                  . " kilometers, or " . round(($kmToMiles * $distances[$startIndex][$endIndex]), 2) . " miles.</p>\n";
            } else
            {
                	echo "<p>The distance from " . $startIndex . " to " .
                  $endIndex . " is not in the array.</p>\n";
            }
      }
    ?>

    <form action="assignment1.php" method="post">
      <p>Starting City:
      <select name="Start">
        <?php
        foreach ($distances as $city => $otherCities)
        {
          echo "<option value='$city'";
          if (strcmp($startIndex,$city)==0)
          {
            echo " selected";
          }
          echo ">$city</option>\n";
        }
        ?>
      </select></p>
      <p>Ending City:
      <select name="End">
      </select></p>
      <p><input type="submit" name="submit"
          value="Calculate Distance"/></p>
    </form>
  </body>
</html>
