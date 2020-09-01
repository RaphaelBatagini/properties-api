<?php

namespace App\Services;

use GuzzleHttp\Client;

class Properties 
{
    const PROPERTIES_FILE = __DIR__ . '/../../assets/properties.json';

    private static function getFromSource()
    {
        $client = new Client([
            'base_uri' => 'http://grupozap-code-challenge.s3-website-us-east-1.amazonaws.com/',
        ]);

        $response = $client->request('GET', 'sources/source-2.json');
        return $response->getBody()->getContents();
    }

    public static function list()
    {
        if (
            file_exists(self::PROPERTIES_FILE)
            && filesize(self::PROPERTIES_FILE)
        ) {
            return json_decode(file_get_contents(self::PROPERTIES_FILE));
        }

        $properties_json = self::getFromSource();
        $properties_file = fopen(self::PROPERTIES_FILE, 'w')
            or die("Unable to open file!");
        fwrite($properties_file, $properties_json);
        fclose($properties_file);
        
        return self::list();
    }
}