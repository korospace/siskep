<!DOCTYPE html>
<html lang="en">
<head>
  <title>SISKEP | <?= $title ?></title>

  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="shortcut icon" href="<?= base_url('images/logo-kemendagri.webp') ?>" type="image/x-icon">

  <!-- Render Css -->
  <?= $this->renderSection('contentCss'); ?>
  <link rel="stylesheet" href="<?= base_url('css/dist/tailwind/tailwind.css') ?>">

  <style>
    body{
      font-family: 'sans';
    }
  </style>

</head>

<body  
  style="background-image: url('<?= base_url('images/bg.webp'); ?>');"
  class="bg-cover bg-no-repeat">

    <!-- // Render Html // -->
    <?= $this->renderSection('contentHtml'); ?>
    
    <!-- Render Js -->
    <script src="<?= base_url('js/plugins/jquery-2.1.0.min.js'); ?>"></script>
    <script src="<?= base_url('js/plugins/axios.min.js'); ?>"></script>
    <script src="<?= base_url('js/plugins/sweetalert2.min.js'); ?>"></script>
    <script src="<?= base_url('js/plugins/font-awesome.min.js'); ?>"></script>
    <script>
      const TOKEN    = "<?= (isset($token)) ? $token : null; ?>";
      const PASSWORD = "<?= (isset($password)) ? $password : null; ?>";
      const BASE_URL = "<?= base_url() ?>";
      const LASTURL  = "<?= (isset($lasturl)) ? $lasturl : null; ?>"; //login controller
    </script>
    <script src="<?= base_url('js/parent.js'); ?>"></script>
    <?= $this->renderSection('jsComponent'); ?>
    <?= $this->renderSection('contentJs'); ?>

</body>

</html>