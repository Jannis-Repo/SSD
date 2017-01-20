<?php

/**
 * Created by PhpStorm.
 * User: Jannis
 * Date: 1/13/2017
 * Time: 10:56 AM
 */


$databaseName = 'jannis_whitestone';
$DBConnection = mysqli_connect('localhost', 'jannis', 'gL!.2zcR', $databaseName);

if (!$DBConnection)
{
    echo '<p>There is a problem with the Database Connection.</p>';
    echo '<p>' . mysqli_connect_error($DBConnection) . '</p>';
    die();
}