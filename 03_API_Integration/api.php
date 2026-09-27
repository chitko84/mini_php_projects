<?php
function getJson(string $url): array
{
    $ch = curl_init();

    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_USERAGENT => "PHP Phase 11 Student Project"
    ]);

    $response = curl_exec($ch);

    if ($response === false) {
        $error = curl_error($ch);
        curl_close($ch);
        throw new Exception("API request failed: " . $error);
    }

    $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($statusCode < 200 || $statusCode >= 300) {
        throw new Exception("API returned HTTP status " . $statusCode);
    }

    $data = json_decode($response, true);

    if (!is_array($data)) {
        throw new Exception("Invalid JSON response.");
    }

    return $data;
}

function getWeatherByCity(string $city): array
{
    $encodedCity = urlencode($city);

    $geoUrl = "https://geocoding-api.open-meteo.com/v1/search"
        . "?name={$encodedCity}&count=1&language=en&format=json";

    $geo = getJson($geoUrl);

    if (empty($geo["results"][0])) {
        throw new Exception("City not found.");
    }

    $place = $geo["results"][0];
    $latitude = $place["latitude"];
    $longitude = $place["longitude"];

    $weatherUrl = "https://api.open-meteo.com/v1/forecast"
        . "?latitude={$latitude}"
        . "&longitude={$longitude}"
        . "&current=temperature_2m,apparent_temperature,wind_speed_10m"
        . "&timezone=auto";

    $weather = getJson($weatherUrl);

    if (empty($weather["current"])) {
        throw new Exception("Weather data is unavailable.");
    }

    return [
        "name" => $place["name"] ?? $city,
        "country" => $place["country"] ?? "",
        "latitude" => $latitude,
        "longitude" => $longitude,
        "temperature" => $weather["current"]["temperature_2m"] ?? null,
        "feels_like" => $weather["current"]["apparent_temperature"] ?? null,
        "wind_speed" => $weather["current"]["wind_speed_10m"] ?? null,
        "temperature_unit" => $weather["current_units"]["temperature_2m"] ?? "°C",
        "wind_unit" => $weather["current_units"]["wind_speed_10m"] ?? "km/h"
    ];
}
?>
