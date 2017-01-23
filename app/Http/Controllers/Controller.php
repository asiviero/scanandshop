<?php

namespace App\Http\Controllers;

use PretrashBarcode\BarcodeSearch;
use PretrashBarcode\BarcodeSearch\Providers\AbstractProvider;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Http\Request;
use Mail;

use Entity\ProductList;
use Entity\Product;
use EntityManager;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    public function show()
    {
      $repository = app('em');
      $repository = $repository->getRepository(ProductList::class);
      $list = $repository->findOneBy([], ['id' => 'desc']);
      return view('list', ['list' => $list]);
    }

    public function add(Request $request)
    {
      $repository = app('em');
      $repository = $repository->getRepository(ProductList::class);
      $list = $repository->findOneBy(['id' => $request->input('list')], ['id' => 'desc']);
      $prod = app('em')->getRepository(Product::class)->findOneBy(['barcode' => $request->input('product')], ['id' => 'desc']);
      if(!$prod) {
        $search = new BarcodeSearch();
        if($name = $search->search($request->input('product'))) {
          $prod = new Product($request->input('product'), $name);
          app('em')->persist($prod);
          app('em')->flush();
        } else {
          return response()->json(['Product not found'], 500);
        }
      }
      $list->addProduct($prod);
      app('em')->flush();
      if($request->server('HTTP_REFERER')) {
        return redirect($request->server('HTTP_REFERER'));
      }
      return '';
    }

    public function newList(Request $request)
    {
      $list = new ProductList();
      app('em')->persist($list);
      app('em')->flush();
    }

    public function send(Request $request)
    {
      $repository = app('em');
      $repository = $repository->getRepository(ProductList::class);
      $list = $repository->findOneBy(['id' => $request->input('list')], ['id' => 'desc']);
      $mail = $request->input('mail');
      Mail::send('emails.list', ['list' => $list], function ($m) use ($mail) {
           $m->from('altsiviero@gmail.com', 'Andre Siviero');
           $m->to($mail, '')->subject('Shop List');
       });
       if($request->server('HTTP_REFERER')) {
         return redirect($request->server('HTTP_REFERER'));
       }
    }
}
