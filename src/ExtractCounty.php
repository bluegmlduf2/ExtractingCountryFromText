<?php

namespace ExtractingCountryFromText;

require_once "Countries.php";

class ExtractCounty
{
    private string $searchWord; // The search keyword
    private string $searcItem; // The item to search for (e.g., name, alpha2, alpha3)
    private string $regPattern; // The regular expression pattern for searching the country list
    private string $language; // The language to use for searching (default is English)

    /**
     * Constructor
     * 
     * @param array $option An array of options for the search. The following keys are supported:
     *                      - "searchWord" (required): The search term to look for
     *                      - "searcItem": The item to search for (default is "name")
     *                      - "fullSearch": Determines whether to search for exact or partial matches (default is false)
     *                      - "language": The language to use for the search (default is "en")
     * @throws \Exception if searchWord is empty
     */
    public function __construct(array $option)
    {
        if (empty($option["searchWord"])) {
            throw new \Exception("searchWord is required");
        }

        $this->searchWord = $option["searchWord"];
        $this->searcItem = isset($option["searcItem"]) ? $option["searcItem"] : "name";
        $this->regPattern = $this->getRegPattern($option);
        $this->language = isset($option["language"]) ? $option["language"] : "en";
    }

    /**
     * Get country names that match your search results
     * 
     * @return array Matched country names array
     * @throws \Exception if no results are found
     */
    public function getCountryFullName(): array
    {
        return $this->getCountryData("name");
    }

    /**
     * Get country two letter codes that match your search results
     * 
     * @return array Matched country two letter codes array
     * @throws \Exception if no results are found
     */
    public function getCountryTwoLetter(): array
    {
        return $this->getCountryData("alpha2");
    }

    /**
     * Get country three letter codes that match your search results
     * 
     * @return array Matched country three letter codes array
     * @throws \Exception if no results are found
     */
    public function getCountryThreeLetter(): array
    {
        return $this->getCountryData("alpha3");
    }

    /**
     * Get data with matching country names
     * 
     * @param string $dataType Type of data to acquire
     * @return array Matched country data array
     * @throws \Exception if no results are found
     */
    private function getCountryData(string $dataType): array
    {
        // Filter the country list based on the search keyword and item to search for
        $filteredCountryList = array_filter(COUNTRY_LIST, function ($value) {
            return preg_match($this->regPattern, $value[$this->searcItem]['en']);
        });

        // Throw an exception if no results are found
        if (empty($filteredCountryList)) {
            throw new \Exception("No result");
        }

        // Return an array of the specified data type for the matched country data
        return array_column(array_map(function ($item) use ($dataType) {
            return $dataType === 'name' ? $item['name'][$this->language] : $item[$dataType];
        }, $filteredCountryList), null);
    }

    /**
     * Returns a regular expression pattern for searching the country list
     * 
     * @param bool $fullSearch Determines whether to search for exact or partial matches
     * @return string Regular expression pattern string
     */
    private function getRegPattern(array $option): string
    {
        $fullSearch = isset($option["fullSearch"]) ? $option["fullSearch"] : false;

        if ($fullSearch) {
            // search for exact matches
            return "/^\s*$this->searchWord$/i";
        } else {
            // search for partial matches
            return "/\s*$this->searchWord/i";
        }
    }
}
