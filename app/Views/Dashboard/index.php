<?= $this->extend('Layout/template') ?>

<!-- Css -->
<?= $this->section('contentCss'); ?>
  <?= $this->renderSection('dashboardCss'); ?>
<?= $this->endSection(); ?>

<!-- JS -->
<?= $this->section('contentJs'); ?>
  <?= $this->renderSection('dashboardJs'); ?>
<?= $this->endSection(); ?>

<!-- Html -->
<?= $this->section('contentHtml'); ?>

    <div
      id="container" 
      class="h-screen max-w-w-2xl m-auto"
      >
        <!-- **** Alert info **** -->
        <?= $this->include('Components/alertInfo'); ?>
        
        <!-- **** Loading Spinner **** -->
        <?= $this->include('Components/loadingSpinner'); ?>
        
        <?php if ($previlege != 'pegawai' && $title == 'pegawai') { ?>
          <!-- **** PopUp Crud Users **** -->
          <?= $this->include('Components/CrudUsers'); ?>

          <!-- **** PopUp Filter Users **** -->
          <?= $this->include('Components/FilterUsers'); ?>
        <?php } ?>

        <?php if ($previlege == 'admin') { ?>
          <!-- **** Edit Information **** -->
          <?= $this->include('Components/EditInformation'); ?>

          <!-- **** Edit Profile Admin **** -->
          <?= $this->include('Components/EditProfileAdmin'); ?>
        <?php } ?>
        
        <div
         id="wraper"
         class="w-full flex">
            <!-- side bar -->
            <?= $this->include('Components/SideBar'); ?>

            <main
              class="flex-1 max-h-screen flex flex-col overflow-auto pl-4 sm:pl-6 pr-4 py-5">
                <!-- nav bar -->
                <?= $this->include('Components/Navbar'); ?>

                <!-- // Render Dashboard Page // -->
                <?= $this->renderSection('dashboardPage'); ?>
            </main>
        </div>
    </div>
	
<?= $this->endSection(); ?>