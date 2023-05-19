# ExtractingCountryFromText

Applications that extract country names from strings

## Installation

After installing the composer, execute the following commands

`composer require countrytext/extracting-country-from-text`

## Usage

```php
$country = new ExtractCounty([
    "searchWord" => "korea", // required
    "searcItem" => "name", // optional
    "fullSearch" => false, // optional
    "language" => "ko", // optional
]);

$country->getCountryFullName(); // Array ( [0] => Korea (Democratic People's Republic of) [1] => Korea, Republic of )
$country->getCountryTwoLetter(); // Array ( [0] => kp [1] => kr )
$country->getCountryThreeLetter(); // Array ( [0] => prk [1] => kor )
```

## Reference

I made it by referring to this [repository](https://github.com/stefangabos/world_countries)
