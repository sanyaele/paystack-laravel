<?php
namespace App\customClasses\customCurl;

class curl_get {
    function __construct ($url){ 
        $curl = curl_init();
    
        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "authorization: Bearer ".liveKey, 
            "cache-control: no-cache"
        ],
        ));
    
        $response = curl_exec($curl);
    
        $tranx = json_decode($response, true);
    
        // Close cURL session handle
        curl_close($curl);
    
        return $tranx;
    }
    
}


class curl_post {
    function __construct ($url, $data){
        $payload = json_encode($data);
        // Prepare new cURL resource
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        
        // Set HTTP Header for POST request 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "authorization: Bearer ".liveKey, 
            "cache-control: no-cache"
        ));

        $tranx = json_decode(curl_exec($ch), true);
        
        // Close cURL session handle
        curl_close($ch);
        
        return $tranx;
    }
}
