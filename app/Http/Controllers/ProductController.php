<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Entity\Product;
use Entity\ProductList;

class ProductController extends Controller
{
    public function create(Request $request) {
      $prod = new Product(
        $request->input('barcode'),
        $request->input('name')
      );
      app('em')->persist($prod);
      app('em')->flush();
      if($request->input('includeList') && $request->input('list')) {
        $list = app('em')->getRepository(ProductList::class)->findOneBy(['id' => $request->input('list')]);
        if($list) {
          $list->addProduct($prod);
          app('em')->flush();
        }
      }
      if($request->server('HTTP_REFERER')) {
        return redirect($request->server('HTTP_REFERER'));
      }
      return '';
    }
}
