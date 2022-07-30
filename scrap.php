<?php

require_once __DIR__ . '/config.php';

if (php_sapi_name() != "cli") {
    throw new Exception("This script only executes in CLI.");
}

do {
    $url = sprintf('%s?api_key=%s&%s', $_ENV['API_URL'], $_ENV['API_KEY'], urlencode('page[size]') . '=100');
    $response =  makeRequest($url);

    foreach ($response['data'] as $row) {
        $property_type = $row['property_type'];

        $exists = $db->has(TBL_PROPERTY_TYPES, [
            'id' => $property_type['id']
        ]);
        if (!$exists) {
            $db->insert(TBL_PROPERTY_TYPES, [
                'id' => $property_type['id'],
                'title' => $property_type['title'],
                'description' => $property_type['description'],
                'created_at' => $property_type['created_at'],
                'updated_at' => $property_type['updated_at'],
            ]);
            echo sprintf('Property type %s inserted %s', $property_type['title'], PHP_EOL);
        }

        $exists = $db->has(TBL_PROPERTIES, [
            'uuid' => $row['uuid']
        ]);
        if (!$exists) {
            $db->insert(TBL_PROPERTIES, [
                'uuid' => $row['uuid'],
                'property_type_id' => $property_type['id'],
                'county' => $row['county'],
                'country' => $row['country'],
                'town' => $row['town'],
                'description' => $row['description'],
                'address' => $row['address'],
                'img' => $row['image_full'],
                'thumbnail' => $row['image_thumbnail'],
                'lat' => $row['latitude'],
                'lon' => $row['longitude'],
                'beds' => $row['num_bedrooms'],
                'baths' => $row['num_bathrooms'],
                'price' => $row['price'],
                'type' => $row['type']
                
            ]);
            echo sprintf('Property %s inserted %s', $row['uuid'], PHP_EOL);
        }
    }

    $url = $response['next_page_url'];
} while ($response['next_page_url'] != null);

?>