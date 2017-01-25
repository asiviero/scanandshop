<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Scan & Shop</title>
        <!-- <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet"> -->
        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="assets/js/zbar-processor.js"></script>
        <script src="assets/js/app.js"></script>
        <link href="css/app.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="container">
          <div class="row">
            <div class="col-xs-12">
              <h1>Scan & Shop</h1>
              <p>Press "s" to open barcode scan dialog</p>
              <form method="post" action="/list/add" id="addProduct" class="text-right">
                {{ csrf_field() }}
                <input type="hidden" name="list" value="{{ $list->getId() }}" />
                <div class="form-group">
                  <label class="sr-only" for="product-barcode">Barcode: </label>
                  <div class="input-group">
                    <input class="form-control" type="text" name="product" id="product-barcode" placeholder="Barcode, e.g.: 064100108264" aria-describedby="barcode-icon" />
                    <span class="input-group-addon" id="barcode-icon"><span class="glyphicon glyphicon-barcode" aria-hidden="true"></span></span>
                  </div>
                  <!-- <input class="form-control" type="text" name="product" id="product-barcode" placeholder="Barcode, e.g.: 064100108264" /> -->
                </div>
                <button id="addProduct" class="btn btn-primary btn-lg text-right">Search and Add</button>
              </form>
            </div>
            <div class="col-xs-12">
              <div class="row">
                  <div class="col-xs-9">
                    <h2>Current List </h2>
                  </div>
                  <div class="col-xs-3 text-right">
                    <button class="btn btn-danger" id="newList">Reset List</button>
                  </div>
                </div>
              @forelse ($list->getProducts() as $product)
                <p>{{ $product->getName() }}</p>
              @empty
                <p>No products in list</p>
              @endforelse
            </div>
            <div class="col-xs-12">
                  <form action="/list/send" method="post" id="sendList">
                    {{ csrf_field() }}
                    <div class="row">
                      <div class="col-xs-12">
                        <div class="form-group">
                          <label for="send-mail">Send list to:</label>
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" name="default-mail" checked> Send to user mail
                            </label>
                          </div>
                          <input type="text" name="mail" id="send-mail" class="form-control" placeholder="youremail@mail.com" disabled />
                          <input type="hidden" name="list" value="{{ $list ->getId()}}" />
                        </div>

                      </div>
                      <div class="col-xs-3 col-xs-offset-9 text-right">
                        <button class="btn btn-lg">Send</button>
                      </div>
                  </form>
                </div>
            </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="newProduct">
          <div class="modal-dialog" role="document">
            <form action="/product/" method="post" class="form-horizontal">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Product not found</h4>
                </div>
                <div class="modal-body">
                  {{ csrf_field() }}
                  <div class="form-group">
                    <div class="col-xs-12">
                      <p>Would you like to add a name for this product?</p>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-xs-3" for="new-barcode">Barcode:</label>
                    <div class="col-xs-9"><input class="form-control" type="text" name="barcode" id="new-barcode"/></div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-xs-3" for="new-name">Product Name:</label>
                    <div class="col-xs-9"><input class="form-control" type="text" name="name" id="new-name"/></div>
                  </div>
                  <div class="form-group">
                    <div class="col-xs-9 col-xs-offset-3">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" name="includeList" value="1" id="new-include-list" checked />Include in list
                        </label>
                      </div>
                    </div>
                  </div>
                    <input type="hidden" name="list" value="{{ $list ->getId()}}" />
                    </div>
                <div class="modal-footer">
                  <button class="btn btn-primary">Save</button>
                </div>
              </div><!-- /.modal-content -->
            </form>
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="modal fade" tabindex="-1" role="dialog" id="scan-camera">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Scan barcode</h4>
              </div>
              <div class="modal-body">
                <div id="barcode-scanner-wrapper">
                  <video id="video" autoplay="true" src=""></video>
                  <div id="inner"></div>
                  <div id="redline">
                  </div>
                  <canvas id="canvas" style="display:none;" width="320" height="240"></canvas>
                </div>
              </div><!-- /.modal-content -->
            <div class="modal-footer">
              <button type="button" class="btn btn-default">Cancel</button>
            </div>
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    </body>
</html>
