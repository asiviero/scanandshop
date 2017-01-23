(function($){
    $(document).ready(function() {
      this.addEventListener("keydown", function (e) {
        var tag = e.target.tagName.toLowerCase();
        if (tag != 'input' && tag != 'textarea') {
          if((e.key == 's' || e.key == 'S') && !$('#scan-camera').is(':visible')) {
            $('#scan-camera').modal('toggle')
          }
        }
      });
      $('form#addProduct').submit(function(e) {
        e.preventDefault()
        product = $(this).find('input[name=product]').val()
        $.post('/list/add', $(this).serialize())
          .done(function() {
            location.reload()
          })
          .fail(function() {
            $('#newProduct input[name=barcode]').val(product)
            $('#newProduct').modal('toggle')
          })
      });
      $('button#newList').click(function(e) {
        $.post('/list')
          .done(function() {
            location.reload()
          })
      });
      $('#barcode-icon').click(function(e) {
        $('#scan-camera').modal('toggle')
      });
      // Barcode related code
      $('#scan-camera').on('show.bs.modal', function() {
        initMedia()
      })
      $('#scan-camera').on('hide.bs.modal', function() {
        stopMedia()
      })

      var video = document.querySelector('video');
      var canvas = $('canvas')[0];
      var ctx = canvas.getContext('2d');
      var localMediaStream = null;
      var worker = new Worker('assets/js/zbar-processor.js');
      var interval = null

      worker.onmessage = function(event) {
          if (event.data.length == 0) return;
          $('#product-barcode').val(event.data[0][2])
          $('#scan-camera').modal('hide')
      };

      function snapshot() {
          if (localMediaStream === null) return;
          var k = (320 + 240) / (video.videoWidth + video.videoHeight);
          canvas.width = Math.ceil(video.videoWidth * k);
          canvas.height = Math.ceil(video.videoHeight * k);
          var ctx = canvas.getContext('2d');
          ctx.drawImage(video, 0, 0, video.videoWidth, video.videoHeight,
                        0, 0, canvas.width, canvas.height);
          if(canvas.width && canvas.height) {
            var data = ctx.getImageData(0, 0, canvas.width, canvas.height);
            worker.postMessage(data);
          }
      }
      navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;
      window.URL = window.URL || window.webkitURL || window.mozURL || window.msURL;

    function initMedia() {
      interval = setInterval(snapshot, 200);
      if (navigator.getUserMedia) {
        navigator.getUserMedia({video: true},
          function(stream) { // success callback
            if (video.mozSrcObject !== undefined) {
              video.mozSrcObject = stream;
            } else {
              video.src = (window.URL && window.URL.createObjectURL(stream)) || stream;
              video.stream = stream
           }
           localMediaStream = true;
         },
         function(error) {
             console.error(error);
         });
      }
    }

    function stopMedia() {
      video.stream.getTracks()[0].stop()
      clearInterval(interval)
    }

  });
})(jQuery);
