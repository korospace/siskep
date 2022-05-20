<?= $this->extend('Layout/template') ?>

<!-- Css -->
<?= $this->section('contentCss'); ?>

<?= $this->endSection(); ?>

<!-- JS -->
<?= $this->section('contentJs'); ?>
<?= $this->endSection(); ?>

<!-- Html -->
<?= $this->section('contentHtml'); ?>

    <div
      id="container" 
      style="background-image: url('<?= base_url('images/bg.webp'); ?>');"
      class="h-screen bg-cover bg-no-repeat"
      >
        <!-- **** Alert info **** -->
        <?= $this->include('Components/alertInfo'); ?>
        <!-- **** Loading Spinner **** -->
        <?= $this->include('Components/loadingSpinner'); ?>
        <!-- **** Edit Profile Admin **** -->
        <?php if ($previlege == 'admin') { ?>
          <?= $this->include('Components/EditProfileAdmin'); ?>
        <?php } ?>
        
        <div
         id="wraper"
         class="w-full flex">
            <!-- side bar -->
            <?= $this->include('Components/SideBar'); ?>

            <main
              class="flex-1 max-h-screen overflow-auto pl-4 sm:pl-6 pr-4 py-5">
                <!-- nav bar -->
                <?= $this->include('Components/Navbar'); ?>
            </main>
        </div>
    </div>
	
<?= $this->endSection(); ?>