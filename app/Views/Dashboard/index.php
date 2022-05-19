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
        <!-- **** Loading Spinner ****  -->
        <?= $this->include('Components/loadingSpinner'); ?>
        
        <div
         id="wraper"
         class="w-full flex">
          <!-- side bar -->
            <div
              id="aside_wraper"
              class="relative z-50 w-0 sm:w-72 h-screen transition-all duration-500 overflow-visible">
                <aside
                  class="w-max absolute z-10 top-5 bottom-5 left-5 px-5 py-5 backdrop-blur-md bg-white/30 rounded-xl shadow-lg transform -translate-x-80 sm:translate-x-0 transition-all duration-500 overflow-auto">
                    <div
                      class="w-max flex items-center mb-14">
                        <img
                          src="<?= base_url('images/logo-kemendagri.webp'); ?>" 
                          alt="logo kemendagri"
                          class="w-8 mr-3">
                        <span
                          class="text-md text-indigo-900 text-extrabold opacity-90">
                            SISTEM KEPEGAWAIAN</span>
                    </div>
                    <a
                      href=""
                      class="<?= ($title=='dashboard') ? 'bg-white shadow-sm' : ''?> mt-5 p-3 flex items-center rounded-xl">
                        <div
                          class="bg-indigo-900 w-8 h-8 flex justify-center items-center mr-3 rounded-md">
                            <i class="fas fa-home text-white text-md"></i>
                        </div>
                        <span class="text-indigo-900">Dashboard</span>
                    </a>
                    <a
                      href=""
                      class="<?= ($title=='tugas & fungsi') ? 'bg-white shadow-sm' : ''?> mt-5 p-3 flex items-center rounded-xl">
                        <div
                          class="bg-indigo-900 w-8 h-8 flex justify-center items-center mr-3 rounded-md">
                            <i class="fas fa-clipboard-check text-white text-md"></i>
                        </div>
                        <span class="text-indigo-900">Tugas & Fungsi</span>
                    </a>
                    <a
                      href=""
                      class="<?= ($title=='pembuatan sk') ? 'bg-white shadow-sm' : ''?> mt-5 p-3 flex items-center rounded-xl">
                        <div
                          class="bg-indigo-900 w-8 h-8 flex justify-center items-center mr-3 rounded-md">
                            <i class="fas fa-file-alt text-white text-md"></i>
                        </div>
                        <span class="text-indigo-900">Pembuatan SK</span>
                    </a>
                    <a
                      href=""
                      class="<?= ($title=='pegawai') ? 'bg-white shadow-sm' : ''?> mt-5 p-3 flex items-center rounded-xl">
                        <div
                          class="bg-indigo-900 w-8 h-8 flex justify-center items-center mr-3 rounded-md">
                            <i class="fas fa-user-friends text-white text-md"></i>
                        </div>
                        <span class="text-indigo-900">Pegawai</span>
                    </a>
                    <a
                      href=""
                      class="<?= ($title=='laporan') ? 'bg-white shadow-sm' : ''?> mt-5 p-3 flex items-center rounded-xl">
                        <div
                          class="bg-indigo-900 w-8 h-8 flex justify-center items-center mr-3 rounded-md">
                            <i class="fas fa-paste text-white text-md"></i>
                        </div>
                        <span class="text-indigo-900">Laporan</span>
                    </a>
                    <a
                      href=""
                      class="mt-5 p-3 flex items-center rounded-xl">
                        <div
                          class="bg-indigo-900 w-8 h-8 flex justify-center items-center mr-3 rounded-md">
                            <i class="fas fa-user text-white text-md"></i>
                        </div>
                        <span class="text-indigo-900">Profile</span>
                    </a>
                    <hr class="mt-5 border border-indigo-900">
                    <a
                      id="btn_logout"
                      href=""
                      class="mt-5 p-3 flex items-center rounded-xl">
                        <div
                          class="bg-indigo-900 w-8 h-8 flex justify-center items-center mr-3 rounded-md">
                            <i class="fas fa-power-off text-white text-md"></i>
                        </div>
                        <span class="text-indigo-900">Logout</span>
                    </a>
                </aside>
              </div>

            <main
              class="flex-1 max-h-screen overflow-auto pl-4 sm:pl-6 pr-4 py-5">
                <div
                  class="w-full px-7 py-3 backdrop-blur-md bg-white/30 flex justify-between items-center text-indigo-900 rounded-xl shadow-lg">
                    <div>
                      <span class="opacity-80 text-xs">Pages / dashboard</span>
                      <p class="text-sm text-bold">Dashboard</p>
                    </div>
                    <div
                      id="toggle_nav" 
                      class="sm:hidden opacity-80 active:opacity-100 transition transform active:scale-90 cursor-pointer">
                        <p class="bg-indigo-900 w-7 h-1 mb-1"></p>
                        <p class="bg-indigo-900 w-7 h-1 mb-1"></p>
                        <p class="bg-indigo-900 w-7 h-1 mb-1"></p>
                    </div>
                </div>
            </main>
        </div>
    </div>
	
<?= $this->endSection(); ?>