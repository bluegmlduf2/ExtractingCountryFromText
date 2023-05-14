<?php
require 'ExtractCounty.php';

use ExtractingCountryFromText\ExtractCounty;

try {
    $country = new ExtractCounty('korea');

    var_dump($country->getCountryFullName());
    echo "<br>";
    var_dump($country->getCountryTwoLetter());
    echo "<br>";
    var_dump($country->getCountryThreeLetter());
} catch (\Throwable $th) {
    echo $th->getMessage();
}
