<?= $this->extend('Dashboard/index') ?>

<!-- Css -->
<?= $this->section('dashboardCss'); ?>

<?= $this->endSection(); ?>

<!-- JS -->
<?= $this->section('dashboardJs'); ?>
  <script>
    <?php if ($previlege != 'nonasn') { ?>
      // get list of pegawai
      let arrUser = [];
      let optionPegawai = "<option value=''>-- pilih pegawai --</option>";
      
      async function getDataPegawai() {
          optionPegawai = "<option value=''>-- pilih pegawai --</option>";

          let httpResponse = await httpRequestGet(`${BASE_URL}/user/show?urutan=terbaru`);

          if (httpResponse.status === 200) {
              arrUser = httpResponse.data.data;
              arrUser.forEach(e => {
                  if (e.previlege == "nonasn") {
                    optionPegawai += `<option value="${e.id}">${e.nama_lengkap}</option>`;
                  }
              });
          }

          $("#user_id_tugas").html(optionPegawai);
      }
      getDataPegawai();
    <?php } ?>
  </script>

  <script src="<?= base_url('js/tugas.js'); ?>"></script>
<?= $this->endSection(); ?>

<!-- Html -->
<?= $this->section('dashboardPage'); ?>

    <!-- List of tugas -->
    <div
      id="list_tugas"
      class="min-h-96 mt-8 flex-1 bg-white overflow-auto rounded-xl shadow-lg">
          <div
            class="sticky top-0 z-20 bg-white pb-8 px-8 pt-8 border-b border-gray-300">
              <div class="block md:flex justify-between ">
                <div
                  class="flex text-gray-600 overflow-hidden">
                    <h1 id="bag_name" class="capitalize text-zinc-500 text-2xl font-semibold">
                      daftar tugas
                    </h1>
                </div>
                <div 
                  class="w-full md:w-max flex justify-center items-center mt-5 md:mt-0 bg-indigo-900 hover:bg-indigo-700 active:bg-indigo-500 text-white rounded-lg px-4 py-2 cursor-pointer"
                  onclick="showCrudTugas('tambah tugas')">
                    <i class="fas fa-plus"></i>
                </div>
              </div>
              <?php if ($previlege != "nonasn") { ?>
              <div
                class="mt-4 pt-4 md:pt-0 border-t md:border-none border-zinc-300">
                  <div class="flex items-center">
                    <div id="btn_filter" class="w-max mr-3 px-1.5 pt-1.5 pb-1 bg-white shadow-md rounded-sm cursor-pointer transition transform active:scale-90" onclick="showFilterUser();">
                        <div class="h-0.5 w-4 mb-0.5 bg-gray-500 rounded-md"></div>
                        <div class="h-0.5 w-4 mb-0.5 bg-gray-500 rounded-md"></div>
                        <div class="h-0.5 w-4 mb-0.5 bg-gray-500 rounded-md"></div>
                    </div>
                    <span id="status_filter" class="text-gray-500 text-sm">
                      terbaru - semua pegawai
                    </span>
                  </div>
              </div>
              <?php } ?>
          </div>
          <div
            id="body_skeleton"
            class="mt-4 px-8 pb-4">
              <?php for ($i=0; $i < 4; $i++) { ?>
                <div class="mb-4 pb-4 border-b border-zinc-300">
                  <div class="w-20 py-2 rounded-xl bg-zinc-300 animate-pulse mb-4"></div>
                  <div class="py-2 rounded-xl bg-zinc-300 animate-pulse mb-4"></div>
                </div>
              <?php } ?>
          </div>
          <div
            id="body_main"
            class="hidden mt-4 px-8 pb-4">

          </div>
    </div>

    <!-- Crud tugas -->
    <div
      id="bg_crud_tugas"
      class="fixed -z-1 top-0 bottom-0 left-0 right-0 p-8 none flex-col justify-center items-center transition-opacity duration-500 opacity-0"
      style="background-color: rgba(0,0,0,0.2);">
        <form
          id="crud_tugas"
          class="bg-white w-full max-w-xl max-h-full flex flex-col justify-center items-center border border-zinc-400 rounded-lg shadow-md transition duration-500 scale-75">
            <div 
              class="w-full flex justify-between items-center px-4 py-2 border-b border-gray-300">
                <div class="flex items-center">
                  <p class="title_popup text-gray-600">
                  </p>
                  <p id="header_status">
                  </p>
                </div>
                <span
                    id="close_popup_crudtugas" 
                    class="text-gray-500 text-2xl cursor-pointer">
                    &times;
                </span>
            </div>

            <div class="w-full flex-1 px-8 pb-5 overflow-auto">
                <input id="tugas_id" type="hidden" name="id">
                
                <!-- title -->
                <div
                  id="title_wraper"
                  class="label_fly w-full h-max relative mt-8 border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
                    <input
                      id="title_tugas" type="text" name="title" placeholder="title" autocomplete="off" 
                      class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md" />
                    <label 
                      for="title_tugas" 
                      class="py-2 absolute left-3 top-0 text-zinc-400 duration-300 origin-0 cursor-text">
                        title
                    </label>
                </div>

                <?php if($previlege != "nonasn") { ?>
                <!-- User id -->
                <div
                  id="user_id_wraper"
                  class="label_fly w-full h-max relative mt-8 border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
                    <select
                      id="user_id_tugas" name="user_id" placeholder="jenis akun" autocomplete="off" 
                      class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md">
                    </select>
                    <label 
                      for="user_id_tugas" 
                      class="py-2 absolute left-2 -top-8 z-0 text-zinc-600 cursor-text text-xs">
                        pegawai
                    </label>
                </div>
                <!-- Status -->
                <div
                  id="status_wraper"
                  class="label_fly w-full h-max relative mt-8 border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
                    <select
                      id="status_tugas" name="status" placeholder="jenis akun" autocomplete="off" 
                      class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md">
                        <option value=''>-- pilih status --</option>
                        <option value='pengecekan'>pengecekan</option>
                        <option value='diterima'>diterima</option>
                        <option value='revisi'>revisi</option>
                    </select>
                    <label 
                      for="status_tugas" 
                      class="py-2 absolute left-2 -top-8 z-0 text-zinc-600 cursor-text text-xs">
                        status tugas
                    </label>
                </div>
                <?php } ?>

                <!-- komentar -->
                <div
                  id="komentar_wraper"
                  class="label_fly w-full none relative mt-8 border-2 border-zinc-400 focus-within:border-zinc-600 rounded-xl">
                    <label 
                      class="py-2 absolute left-2 -top-8 z-0 text-zinc-600 cursor-text text-xs">
                        komentar
                    </label>
                    <?php if($previlege != "nonasn") { ?>
                    <div id="toolbar_komentar">
                        <span class="ql-formats">
                            <select class="ql-font"></select>
                            <select class="ql-size"></select>
                        </span>
                        <span class="ql-formats">
                            <button class="ql-bold"></button>
                            <button class="ql-italic"></button>
                            <button class="ql-underline"></button>
                            <button class="ql-strike"></button>
                            <select class="ql-color"></select>
                            <select class="ql-background"></select>
                            <button class="ql-blockquote"></button>
                        </span>
                        <span class="ql-formats">
                            <button class="ql-list" value="ordered"></button>
                            <button class="ql-list" value="bullet"></button>
                            <select class="ql-align"></select>
                        </span>
                        <span class="ql-formats">
                            <button class="ql-link"></button>
                        </span>
                    </div>
                    <?php } ?>
                    <div class="h-44 overflow-auto">
                        <div id="editor_komentar"></div>
                    </div>
                </div>

                <!-- separator -->
                <div class="relative w-full mt-6 flex items-center justify-center">
                    <div class="absolute z-10 left-0 right-0 border-b border-slate-400"></div>
                    <h1 class="z-20 px-3 bg-white text-slate-600">
                        upload file
                    </h1>
                </div>

                <!-- input file -->
                <div id="input_file_wraper" class="mt-3 max-h-40 w-full overflow-y-auto overflow-x-hidden">
                  <div id="special_div" class="none"></div>
                </div>

                <!-- tambah input file -->
                <div
                  class="label_fly flex justify-center items-center mt-4 h-8 w-full px-10 bg-sky-400 hover:bg-sky-500 active:bg-sky-600 text-white rounded-md cursor-pointer"
                  onclick="tambahInputFile();">
                    <div><i class="fas fa-plus"></i></div>
                </div>

                <!-- File Wraper -->
                <div id="parent_file_wraper" class="mb-6">
                  <!-- separator -->
                  <div class="relative w-full mt-6 flex items-center justify-center">
                      <div class="absolute z-10 left-0 right-0 border-b border-slate-400"></div>
                      <h1 class="z-20 px-3 bg-white text-slate-600">
                          file tersimpan
                      </h1>
                  </div>
                  <div id="file_wraper" class="mt-3 px-8 max-h-40 overflow-y-auto overflow-x-hidden">

                  </div>
                </div>
            </div>

            <div
            class="w-full px-8 pt-4 pb-4 flex justify-end border-t border-gray-300">
              <button id="btn_simpan_crudtugas" class="w-max px-4 py-2 bg-emerald-400 active:bg-emerald-600 text-white text-center rounded-md">
                <span id="text" class="inline">simpan</span>
                <span id="spinner" class="hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: rgba(0, 0, 0, 0) none repeat scroll 0% 0%; display: block; shape-rendering: auto;" width="18px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                      <circle cx="50" cy="50" fill="none" stroke="#ffffff" stroke-width="10" r="35" stroke-dasharray="164.93361431346415 56.97787143782138">
                      <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" values="0 50 50;360 50 50" keyTimes="0;1"></animateTransform>
                      </circle>
                    </svg>
                </span>
              </button>
            </div>
        </form>
    </div>
<?= $this->endSection(); ?>