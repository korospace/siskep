<!DOCTYPE html>
<html lang="en">
<head>
  <title>instansi | <?= $title ?></title>

  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
  <!-- Render Css -->
  <?= $this->renderSection('contentCss'); ?>

  <style>
    *{
      padding: 0;
      margin: 0;
    }
    body{
      font-family: 'sans';
    }
    #body_container{
      width: 100% !important;
      max-width: 1200px;
      margin: auto;
    }
  </style>

</head>

<body>

<!-- // Render Html // -->
  <div id="body_container">
    <?= $this->renderSection('contentHtml'); ?>
  </div>
  
  <!-- Render Js -->
  <script src="<?= base_url('assets/js/plugins/jquery-2.1.0.min.js'); ?>"></script>
  <script src="<?= base_url('assets/js/plugins/popper.min.js'); ?>"></script>
  <script src="<?= base_url('assets/js/plugins/bootstrap.min.js'); ?>"></script>
  <script src="<?= base_url('assets/js/plugins/axios.min.js'); ?>"></script>
  <script src="<?= base_url('assets/js/plugins/sweetalert2.min.js'); ?>"></script>
  <script>
    const TOKEN    = "<?= (isset($token)) ? $token : null; ?>";
    const BASE_URL = "<?= base_url() ?>";
  </script>
  <?= $this->renderSection('jsComponent'); ?>
  <?= $this->renderSection('contentJs'); ?>

</body>

</html>