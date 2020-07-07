<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/src/common-utils.php';


  class Api {
    private static function make_api_url($url) {
      return get_secret('api_server') . "/{$url}";
    }

    private static function create_auth_token() {
      return ['Authorization' => 'Bearer ' . get_secret('api_key')];
    }

    static private function make_request($verb, $url, $data, $auth) {
      $headers = [];
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);

      // Set JSON content heading if we're sending it
      if ($data !== null) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $headers = array_merge($headers, [
          'Content-Type: application/json',
          'Content-Length: ' . strlen($data)
        ]);
      }

      // Send an API key if we need to
      if ($auth) {
        $headers = array_merge($headers, self::create_auth_token());
      }

      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $verb);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLINFO_HEADER_OUT, true);
      $response = curl_exec($ch);
      $http_status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      curl_close($ch);

      // Return the response info
      $data = new stdClass();
      $data->code = $http_status_code;
      $data->response = $response;
      $data->ok = ($http_status_code >= 200 && $http_status_code < 300);
      return $data;
    }

    static function make_url($endpoint, $query=[]) {
      $url = self::make_api_url($endpoint) . '/';

      // If we have query string data, add it to the URL
      if (!empty($query)) {
        $qs = http_build_query($query);
        return $url . '?' . $qs;
      }
      return $url;
    }

    static function get($url, $data=null, $auth=false) {
      return self::make_request('GET', $url, $data, $auth);
    }
    static function post($url, $data=null, $auth=false) {
      return self::make_request('POST', $url, $data, $auth);
    }
    static function put($url, $data=null, $auth=false) {
      return self::make_request('PUT', $url, $data, $auth);
    }
    static function delete($url, $data=null, $auth=false) {
      return self::make_request('DELETE', $url, $data, $auth);
    }
  }
