<?php
    // Set the content type header to JSON
    header('Content-Type: application/json');

    // Get the Channels DVR IP from an environment variable, with a fallback
    $channels_dvr_ip = getenv('CHANNELS_DVR_IP') ?: 'host.docker.internal'; // Default to host.docker.internal
    $api_url = "http://$channels_dvr_ip:8089/dvr/guide/stations";

    // Fetch the content from the API
    $response = @file_get_contents($api_url);

    // Check if the fetch was successful
    if ($response === FALSE) {
        // Log the error (optional, for debugging)
        error_log("Failed to fetch from Channels DVR API: " . error_get_last()['message']);
        // Return an error message to the client
        echo json_encode(['error' => 'Could not connect to Channels DVR server. Please ensure it is running at ' . $api_url]);
        http_response_code(500); // Internal Server Error
    } else {
        // Echo the JSON response directly
        echo $response;
    }
?>