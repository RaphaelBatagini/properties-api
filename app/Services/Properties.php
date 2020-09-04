<?php

namespace App\Services;

use GuzzleHttp\Client;
use App\Collections\PropertiesCollection;
use App\DTO\PropertyDTO;
use App\Iterators\ZapPropertyFilter;

class Properties 
{
    const PROPERTIES_FILE = __DIR__ . '/../../assets/properties.json';

    /*
     * Get properties from source
     * @return string
     */
    private static function getFromSource()
    {
        $client = new Client([
            'base_uri' => 'http://grupozap-code-challenge.s3-website-us-east-1.amazonaws.com/',
        ]);

        $response = $client->request('GET', 'sources/source-2.json');
        return $response->getBody()->getContents();
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
        
        $propertiesCollection = new PropertiesCollection($properties);

        if ($portal === 'zap') {
            $propertiesCollection = self::filterZap($propertiesCollection);
        }

        return $propertiesCollection->paginate($offset);
    }

    private static function filterZap(PropertiesCollection $propertiesCollection)
    {
        $properties = new ZapPropertyFilter(
            $propertiesCollection->getIterator()
        );

        $propertiesArray = [];
        foreach ($properties as $property) {
            array_push($propertiesArray, $property);
        }

        return new PropertiesCollection($propertiesArray);
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