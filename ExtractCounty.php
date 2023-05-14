<?php

namespace ExtractingCountryFromText;

require_once 'Countries.php';

// TODO 언어별지원 
// TODO stefangabos/world_countries 컴포저추가
class ExtractCounty
{
    private string $searchWord;
    private string $pattern;

    /**
     * initialization
     * 
     * @param string $searchWord Country name to search for
     * @param bool $patternType If true, search for results that match the country name completely; if false, search for results that match partially
     */
    public function __construct(string $searchWord, bool $patternType = false)
    {
        $this->searchWord = $searchWord;
        $this->pattern = $this->getPattren($patternType ? 'perfect' : 'partial');
    }

    /**
     * Get country names that match your search results
     */
    public function getCountryFullName()
    {
        return $this->getCountryData('name');
    }

    /**
     * Get country Two Letter that match your search results
     */
    public function getCountryTwoLetter()
    {
        return $this->getCountryData('alpha2');
    }

    /**
     * Get country Three Letter that match your search results
     */
    public function getCountryThreeLetter()
    {
        return $this->getCountryData('alpha3');
    }

    /**
     * Get data with matching country names
     * 
     * @param string $dataType Types of data to acquire
     * @return null|array Matched Country Data array
     * 
     * @throws Exception If their is no return data
     */
    private function getCountryData(string $dataType): null|array
    {
        $filteredCountryList = array_filter(COUNTRY_LIST, function ($value) use ($dataType) {
            if (preg_match($this->pattern, $value['name'])) {
                return $value[$dataType];
            }
        });

        if (empty($filteredCountryList)) {
            throw new \Exception("No result");
        }

        return array_column($filteredCountryList, $dataType);
    }

    /**
     * Returns a regular expression pattern
     * 
     * @param string $pattrenType Type of data to find
     * @return string regular expression pattern string
     */
    private function getPattren(string $patternType)
    {
        switch ($patternType) {
            case 'perfect':
                return "/^\s*$this->searchWord$/i";
                break;
            case 'partial':
                return "/\s*$this->searchWord/i";
                break;
        }
    }
}
