<?php
require 'ExtractCounty.php';

use ExtractingCountryFromText\ExtractCounty;

try {

    $country = new ExtractCounty([
        "searchWord" => "korea",
        "searcItem" => "name",
        "fullSearch" => false,
        "language" => "ko",
    ]);

    var_dump($country->getCountryFullName());
    echo "<br>";
    var_dump($country->getCountryTwoLetter());
    echo "<br>";
    var_dump($country->getCountryThreeLetter());
} catch (\Throwable $th) {
    echo $th->getMessage();
}
