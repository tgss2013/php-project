<?php
/*
 * File : FB_ReqHandler.php
 * Description : Class to perform the request from the facebook.
 * File version : 0.01
 * Revision Date : 5-10-13
 */
require ('config.php');

class FB_ReqHandler {
    function parse_signed_request($signed_request, $secret) {
        list($encoded_sig, $payload) = explode('.', $signed_request, 2);

        // decode the data
        $sig = $this -> base64_url_decode($encoded_sig);
        $data = json_decode($this -> base64_url_decode($payload), true);

        if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') {
            error_log('Unknown algorithm. Expected HMAC-SHA256');
            return null;
        }

        // check sig
        $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
        if ($sig !== $expected_sig) {
            error_log('Bad Signed JSON signature!');
            return null;
        }

        return $data;
    }

    function base64_url_decode($input) {
        return base64_decode(strtr($input, '-_', '+/'));
    }

    public function parse_json_places_request($city_id) {
        $json_url = "https://graph.facebook.com/$city_id";
        $fetched_json_content = file_get_contents($json_url);
        $decoded_content = json_decode($fetched_json_content, true);

        return $decoded_content;
    }

    public function objectToArrays($parsed_url) {
        if (is_object($parsed_url)) {
            $parsed_url = get_object_vars($parsed_url);
        }

        if (is_array($parsed_url)) {
            return array_map(__FUNCTION__, $parsed_url);
        } else {
            return $parsed_url;
        }
    }

    public function redirectUrl($url) {
        echo '<script> window.location.href="' . $url . '"</script>';
    }

}
