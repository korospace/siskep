<!DOCTYPE html>
<html lang="en">
<head>
  <title>instansi | <?= $title ?></title>

  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
  <!-- Render Css -->
  <?= $this->renderSection('contentCss'); ?>
  <link rel="stylesheet" href="<?= base_url('css/dist/tailwind/tailwind.css') ?>">

  <style>
    body{
      font-family: 'sans';
    }
  </style>

</head>

<body>

  <!-- // Render Html // -->
  <?= $this->renderSection('contentHtml'); ?>
  
  <!-- Render Js -->
  <script src="<?= base_url('js/plugins/jquery-2.1.0.min.js'); ?>"></script>
  <script src="<?= base_url('js/plugins/axios.min.js'); ?>"></script>
  <script src="<?= base_url('js/plugins/sweetalert2.min.js'); ?>"></script>
  <script src="<?= base_url('js/plugins/font-awesome.min.js'); ?>"></script>
  <!-- <script src="https://kit.fontawesome.com/8b503c378c.js" crossorigin="anonymous"></script> -->
  <script>
    const TOKEN    = "<?= (isset($token)) ? $token : null; ?>";
    const BASE_URL = "<?= base_url() ?>";
  </script>
  <script src="<?= base_url('js/parent.js'); ?>"></script>
  <?= $this->renderSection('jsComponent'); ?>
  <?= $this->renderSection('contentJs'); ?>

</body>

</html>