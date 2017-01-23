<?php

namespace PretrashBarcode\Providers;

abstract class AbstractProvider {
  abstract public function search($upc);
}
