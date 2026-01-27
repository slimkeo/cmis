<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Processing Payment</title>

  <!-- jQuery (required for AJAX) -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <style>
    .gif-wrapper {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      width: 100%;
      background: #111;
      overflow: hidden;
    }

    #temp-gif {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: opacity 400ms ease;
      opacity: 1;
    }

    #temp-gif.hide {
      opacity: 0;
      pointer-events: none;
    }

    #placeholder {
      display: none;
      color: #eee;
      font-family: Arial, sans-serif;
      text-align: center;
      font-size: 24px;
    }

    #placeholder.visible { display: block; }
  </style>
</head>
<body>

  <div class="gif-wrapper">
    <img id="temp-gif" src="<?= base_url('uploads/loading.gif') ?>" alt="Loading..." />

    <div id="placeholder">
      <h2>Payment Complete</h2>
      <p>Please wait for confirmation...</p>
    </div>
  </div>

<script>
(function () {

  const GIF_TIME_MS = 15000;  // 15 seconds
  const FADE_MS = 400;        // fade duration

  const gif = document.getElementById('temp-gif');
  const placeholder = document.getElementById('placeholder');

  setTimeout(() => {

    gif.classList.add('hide');

    setTimeout(() => {

      if (gif.parentNode) gif.parentNode.removeChild(gif);

      placeholder.classList.add('visible');

      // 🔥 AJAX call to update status in DB
      $.ajax({
        url: "<?php echo base_url()?>index.php?burial/update_with_momo",
        type: "POST",
        data: {
          attendeeid: "<?= $param2 ?>"
        },
        success: function (response) {
          console.log("Server: " + response);

          // 🔄 Reload the page after 1 second
          setTimeout(function () {
            location.reload();
          }, 1000);

        }
      });

    }, FADE_MS);

  }, GIF_TIME_MS);

})();
</script>

</body>
</html>
