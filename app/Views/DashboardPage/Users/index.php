<?= $this->extend('Dashboard/index') ?>

<!-- Css -->
<?= $this->section('dashboardCss'); ?>

<?= $this->endSection(); ?>

<!-- JS -->
<?= $this->section('dashboardJs'); ?>
    <script src="<?= base_url('js/users.js'); ?>"></script>
<?= $this->endSection(); ?>

<!-- Html -->
<?= $this->section('dashboardPage'); ?>

    <div
      id="list_users_wraper"
      class="flex-1 flex flex-col mt-8 backdrop-blur-md rounded-xl shadow-lg overflow-auto">
        <div
          id="header_1"
          class="block md:flex justify-between px-8 pt-8">
            <div
              class="flex border border-gray-600 focus-within:border-gray-800 rounded-lg bg-white text-gray-600 overflow-hidden">
                <div class="border-r border-gray-600 pt-2 pb-1 px-3">
                    <i class="fas fa-search opacity-80"></i>
                </div>
                <input id="search-user" type="text" class="px-4 py-2 outline-none" placeholder="nik/nama">
            </div>
            <div 
              class="w-full md:w-max flex justify-center items-center mt-5 md:mt-0 bg-indigo-900 active:bg-indigo-700 text-white rounded-lg px-4 py-2 cursor-pointer"
              onclick="showCrudUsers('buat akun')">
                <i class="fas fa-plus"></i>
            </div>
        </div>

        <div
          id="header_1"
          class="mt-4 px-8 pt-4 md:pt-0 border-t md:border-none border-zinc-300">
          <div class="flex items-center mb-4">
              <div id="btn_filter" class="w-max mr-3 px-1.5 pt-1.5 pb-1 bg-white shadow-md rounded-sm cursor-pointer transition transform active:scale-90" onclick="showFilterUser();">
                  <div class="h-0.5 w-4 mb-0.5 bg-gray-500 rounded-md"></div>
                  <div class="h-0.5 w-4 mb-0.5 bg-gray-500 rounded-md"></div>
                  <div class="h-0.5 w-4 mb-0.5 bg-gray-500 rounded-md"></div>
              </div>
              <span id="status_filter" class="text-gray-500 text-sm">
                terbaru - semua bagian
              </span>
            </div>
            <div id="total" class="text-gray-500">
              0 akun
            </div>
        </div>

        <div
          id="table_wraper"
          class="relative flex-1 bg-white mt-6 overflow-auto">
            <table class="w-full text-center">
              <thead class="sticky top-0 bg-white">
                <tr class="font-semibold text-sm">
                  <td class="text-gray-400 p-3">
                    No
                  </td>
                  <td class="text-gray-400 p-3">
                    Nama
                  </td>
                  <td class="text-gray-400 p-3">
                    NIK
                  </td>
                  <td class="text-gray-400 p-3">
                    jabatan
                  </td>
                  <td class="text-gray-400 p-3">
                    Penempatan
                  </td>
                  <td class="text-gray-400 p-3">
                    Action
                  </td>
                </tr>
              </thead>
              <tbody id="body_skeleton" class="hidden">
                <?php for ($i=0; $i < 10; $i++) { ?>
                  <tr>
                    <td class="p-4">
                      <span class="block w-full h-5 rounded-md bg-gray-400 animate-pulse"></span>
                    </td>
                    <td class="p-4">
                      <span class="block w-full h-5 rounded-md bg-gray-400 animate-pulse"></span>
                    </td>
                    <td class="p-4">
                      <span class="block w-full h-5 rounded-md bg-gray-400 animate-pulse"></span>
                    </td>
                    <td class="p-4">
                      <span class="block w-full h-5 rounded-md bg-gray-400 animate-pulse"></span>
                    </td>
                    <td class="p-4">
                      <span class="block w-full h-5 rounded-md bg-gray-400 animate-pulse"></span>
                    </td>
                    <td class="p-4">
                      <span class="block w-full h-5 rounded-md bg-gray-400 animate-pulse"></span>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
              <tbody id="body_main">

              </tbody>
            </table>
        </div>
    </div>
	
<?= $this->endSection(); ?>