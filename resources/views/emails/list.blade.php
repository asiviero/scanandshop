@foreach ($list->getProducts() as $product)
  - {{ $product->getName() }} <br />
@endforeach
