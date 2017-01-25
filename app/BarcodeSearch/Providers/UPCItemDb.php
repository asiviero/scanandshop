<?php

namespace PretrashBarcode\Providers;

use GuzzleHttp\Client;

class UPCItemDb extends AbstractProvider {

  public function search($upc) {
    $client = new Client();
    $res = $client->request('GET',
      sprintf(
        'https://api.upcitemdb.com/prod/trial/lookup?upc=%s',
        $upc
      ));
    $return = '';
    $body =  json_decode($res->getBody()->getContents(), true);
    if(count($body)) {
      $return = $body['items'][0]['title'];
    }
    return $return;
  }
}
