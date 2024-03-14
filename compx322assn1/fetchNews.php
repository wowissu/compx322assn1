<?php

require 'http.php';

function main () {
  header("Content-Type", "application/json");
  
  $request = Request::json();
  
  // var_dump($request);die();

  if (!isset($request['locale'])) {
    return Response::toJson(null, Response::ERROR);  
  }

  $data = fetchTheNewsApi($request['locale']);

  return Response::toJson($data);
}

main();

function fetchTheNewsApi($locale) {
  try {
    $params = array(
      // fixed language
      "language" => "en",
      // selected locale
      "locale" => $locale,
      // 
      "api_token" => "SuU2Gmc4j23OvBVoIGtbm5faaJPwMBbQiG2hOyaH"
    );

    $url = "https://api.thenewsapi.com/v1/news/headlines?" . http_build_query($params);
    $ch = curl_init();
  
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Accept: application/json"
    ));
    curl_setopt($ch, CURLOPT_HTTPGET, TRUE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  
    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    echo json_encode([
      "url" => $url,
      "httpCode" => $httpCode,
      "result" => json_decode($result, true)
    ]);
    die();

    return json_decode($result, true);

  } finally {
    curl_close($ch);
  }
}