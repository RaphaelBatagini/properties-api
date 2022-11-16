<?php

namespace App\Services;

use App\Collections\PropertiesCollection;
use App\Collections\CompanyOnePropertiesCollection;
use App\Collections\CompanyTwoPropertiesCollection;
use App\DTO\PropertyDTO;

class Properties 
{
    const REMOTE_FILE_DOMAIN = 'http://grupocompanytwo-code-challenge.s3-website-us-east-1.amazonaws.com/';
    const PROPERTIES_FILE = __DIR__ . '/../../assets/properties.json';
    const TYPE_RENTAL = 'RENTAL';
    const TYPE_SALE = 'SALE';

    /*
     * Get properties from source
     * @return string
     */
    private static function getFromSource()
    {
        return file_get_contents(
            self::REMOTE_FILE_DOMAIN . 'sources/source-2.json'
        );
    }

    /*
     * Get properties paginated
     * @return PropertiesCollection
     */
    public static function list($offset = 0, $portal = null)
    {
        $properties = self::getProperties();

        foreach ($properties as &$property) {
            $property = new PropertyDTO($property);
        }

        $properties = self::getPropertiesCollection($properties, $portal);

        return [
            'pageNumber' => ++$offset,
            'pageSize' => $properties::PAGE_LENGTH,
            'totalCount' => $properties->count(),
            'listings' => $properties->paginate($offset)
        ];
    }

    /*
     * Apply properties filters based on portal
     * @return PropertiesCollection
     */
    private static function getPropertiesCollection($properties, $portal) {
        $portals = [
            'companytwo' => CompanyTwoPropertiesCollection::class,
            'companyone' => CompanyOnePropertiesCollection::class,
        ];

        if (!key_exists($portal, $portals)) {
            return new PropertiesCollection($properties);
        }

        return new $portals[$portal]($properties);
    }

    /*
     * Get properties from internal file
     * @return array
     */
    private static function getProperties()
    {
        if (!self::propertiesFileExists()) {
            self::generatePropertiesFile();
        }

        return json_decode(file_get_contents(self::PROPERTIES_FILE));
    }

    /*
     * Generate file with properties
     * @return void
     */
    private static function generatePropertiesFile()
    {
        $properties_json = self::getFromSource();
        $properties_file = fopen(self::PROPERTIES_FILE, 'w')
            or die("Unable to open file!");
        fwrite($properties_file, $properties_json);
        fclose($properties_file);
    }

    /*
     * Check if properties file exists
     * @return boolean
     */
    private static function propertiesFileExists()
    {
        return file_exists(self::PROPERTIES_FILE)
            && filesize(self::PROPERTIES_FILE);
    }
}