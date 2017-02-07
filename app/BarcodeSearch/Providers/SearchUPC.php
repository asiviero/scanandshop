<?php

namespace PretrashBarcode\Providers;

use GuzzleHttp\Client;

class SearchUPC extends AbstractProvider {
  private $key;

  public function __construct($key) {
    $this->key = $key;
  }

  public function search($upc) {
    $client = new Client();
    $res = $client->request('GET',
      sprintf(
        'http://www.searchupc.com/handlers/upcsearch.ashx?request_type=3&access_token=%s&upc=%s',
        $this->key,
        $upc
      ));
    $return = null;
    $body =  json_decode($res->getBody()->getContents(), true);
    if(count($body)) {
      $return = isset($body[0]['productname']) ? trim($body[0]['productname']) : null;
    }
    return $return;
  }
}
