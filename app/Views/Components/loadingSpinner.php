<?= $this->extend('Layout/template') ?>

<!-- Css -->
<?= $this->section('contentCss'); ?>
    <style>
    </style>
<?= $this->endSection(); ?>

<!-- JS -->
<?= $this->section('jsComponent'); ?>
    <script>
        // show spinner
        function showLoadingSpinner() {
            $('#bg_loading').removeClass('-z-1 none');
            $('#bg_loading').addClass('z-60 flex');
            setTimeout(() => {
                $('#bg_loading').removeClass('opacity-0');
                $('#loading').removeClass('scale-75');
            }, 50);
        }

        // hide spinner
        function hideLoadingSpinner() {
            $('#loading').addClass('scale-75');
            $('#bg_loading').addClass('opacity-0');
            setTimeout(() => {
                $('#bg_loading').removeClass('z-60 flex');
                $('#bg_loading').addClass('-z-1 none');
            }, 500);
        }
    </script>
<?= $this->endSection(); ?>

<?= $this->section('contentHtml'); ?> 
    <div
      id="bg_loading"
      class="fixed -z-1 top-0 bottom-0 left-0 right-0 px-3 none flex-col justify-center items-center transition-opacity duration-500 opacity-0"
      style="background-color: rgba(0,0,0,0.2);">
      <div
        id="loading"
        class="bg-white px-5 py-4 flex justify-center items-center rounded-md shadow-2xl transition duration-500 scale-75">
          <div class="w-8 xs:w-12">
              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: rgba(0, 0, 0, 0) none repeat scroll 0% 0%; display: block; shape-rendering: auto;" width="100%" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                  <circle cx="50" cy="50" fill="none" stroke="#000000" stroke-width="10" r="35" stroke-dasharray="164.93361431346415 56.97787143782138">
                  <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" values="0 50 50;360 50 50" keyTimes="0;1"></animateTransform>
                  </circle>
              </svg>
          </div>
      </div>
    </div>
<?= $this->endSection(); ?>