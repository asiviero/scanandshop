<?php

namespace PretrashBarcode\Providers;
use PretrashBarcode\Providers\AbstractProvider;

use PhpXmlRpc\Value;
use PhpXmlRpc\Request;
use PhpXmlRpc\Client;
use PhpXmlRpc\Encoder;

class UPCDatabase extends AbstractProvider {

  private $rpcKey;

  public function __construct($rpcKey) {
    $this->rpcKey = $rpcKey;
  }

  public function search($upc) {
    $encoder = new Encoder();
    $params = [new Value(
        array(
            "rpc_key" => new Value($this->rpcKey),
            "upc" => new Value($upc),
        ),
        "struct"
    )];
    $host = 'https://www.upcdatabase.com/xmlrpc/';
    $client = new Client($host);
    $req = new Request('lookup',$params);
    $response = $client->send(new Request('lookup', $encoder->encode($params)));
    $value = $encoder->decode($response->value());
    return isset($value['description']) ? $value['description'] : null;
  }
}
