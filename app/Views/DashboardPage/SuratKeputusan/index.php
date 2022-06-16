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
      
      async function getDataPegawai(showLoading = true) {
          if (showLoading) {
            showLoadingSpinner();
          }

          let httpResponse = await httpRequestGet(`${BASE_URL}/user/show?urutan=terbaru`);

          if (httpResponse.status === 200) {
              arrUser = httpResponse.data.data;
              arrUser.forEach(e => {
                  if (e.previlege == "nonasn") {
                    optionPegawai += `<option value="${e.id}">${e.nama_lengkap}</option>`;
                  }
              });
          }

          $(".select_pegawai").html(optionPegawai);
      }
      getDataPegawai();

      // get list of bagian
      let optionBagian = "<option value=''>-- pilih bagian --</option>";

      <?php if ($previlege == 'admin') { ?>
          async function getDataBagian() {
              let httpResponse = await httpRequestGet(`${BASE_URL}/bagian/show`);

              if (httpResponse.status === 200) {
                  let arrBagian = httpResponse.data.data;
                  arrBagian.forEach(e => {
                      optionBagian += `<option value="${e.id}">${e.name}</option>`;
                  });
              }

              $(".select_bagian").html(optionBagian);
          }
          getDataBagian();
      <?php } else if ($previlege == 'kabag') { ?>
        optionBagian += `<option value="<?= $idbagian ?>"><?= $bagian ?></option>`;
        $(".select_bagian").html(optionBagian);
      <?php } else if ($previlege == 'kasubag') { ?>
        optionBagian = `<option value="<?= $idbagian ?>"><?= $bagian ?></option>`;
        $(".select_bagian").html(optionBagian);
      <?php } ?>

      // get list of subagian
      let arrSubagian    = [];
      let optionSubagian = "<option value=''>-- pilih subagian --</option>";
      
      <?php if (in_array($previlege,["admin","kabag"])) { ?>
          async function getDataSubagian() {
              let httpResponse = await httpRequestGet(`${BASE_URL}/subagian/show`);

              if (httpResponse.status === 200) {
                arrSubagian = httpResponse.data.data;
              }
          }
          getDataSubagian();
      <?php } else if ($previlege == 'kasubag') { ?>
        optionSubagian = `<option value="<?= $idsubagian ?>"><?= $subagian ?></option>`;
        $(".select_subagian").html(optionSubagian);
      <?php } ?>

      // get list of kedudukan
      let optionKedudukan = "<option value=''>-- pilih kedudukan --</option>";
      
      async function getDataKedudukan() {
          let httpResponse = await httpRequestGet(`${BASE_URL}/kedudukan/show`);
          hideLoadingSpinner();

          if (httpResponse.status === 200) {
              let arrKedudukan = httpResponse.data.data;
              arrKedudukan.forEach(e => {
                  optionKedudukan += `<option value="${e.id}">${e.name}</option>`;
              });
          }

          $(".select_kedudukan").html(optionKedudukan);
      }
      getDataKedudukan();
    <?php } ?>
  </script>
  <script src="<?= base_url('js/surat_keputusan.js'); ?>"></script>
<?= $this->endSection(); ?>

<!-- Html -->
<?= $this->section('dashboardPage'); ?>
    <!-- form surat keputusan -->
    <?php if(in_array($previlege,["admin","kabag","kasubag"])) { ?>
    <form
      id="form_sk"
      class="h-max mt-8 flex flex-col rounded-xl shadow-lg">
        <div
          class="block bg-white px-8 pt-4 pb-4 border-b rounded-t-xl">
            <h1 id="bag_name" class="capitalize text-zinc-500 text-xl md:text-2xl font-semibold">
                form surat keputusan
            </h1>
        </div>
        <div
          class="bg-white px-8 pt-10 pb-4 text-zinc-500">
            <!-- input no_sk, title, tgl_sk, file_sk -->
            <div class="h-max w-full grid grid-cols-1 lg:grid-cols-2 grid-rows-4 lg:grid-rows-2 gap-x-4 gap-y-10 md:gap-y-12">
              <!-- No sk -->
              <div
                id="no_sk_wraper"
                class="label_fly w-full h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
                  <input
                    id="no_sk" type="text" name="no_sk" placeholder="no_sk" autocomplete="off" 
                    class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md" />
                  <label 
                    for="no_sk" 
                    class="py-2 absolute left-3 top-0 text-zinc-400 duration-300 origin-0 cursor-text">
                      Nomor SK
                  </label>
              </div>
              <!-- Title -->
              <div
                id="title_wraper"
                class="label_fly w-full h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
                  <input
                    id="title" type="text" name="title" placeholder="title" autocomplete="off" 
                    class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md" />
                  <label 
                    for="title" 
                    class="py-2 absolute left-3 top-0 text-zinc-400 duration-300 origin-0 cursor-text">
                      Judul SK
                  </label>
              </div>
              <!-- tgl_sk -->
              <div
              id="tgl_sk_wraper"
              class="label_fly w-full h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
                  <input
                  id="tgl_sk" type="date" name="tgl_sk" placeholder="tgl_sk" autocomplete="off" 
                  class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md"/>
                  <label 
                  for="tgl_sk" 
                  class="py-3 absolute top-0 left-5 text-zinc-400 duration-300 origin-0 cursor-text">
                      tanggal SK
                  </label>
              </div>
              <!-- file_sk -->
              <div
              id="file_sk_wraper"
              class="label_fly w-full h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
                  <input
                  id="file_sk" type="file" name="file_sk" placeholder="file_sk" autocomplete="off" 
                  class="validate text-sm block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md"/>
                  <label 
                  for="file_sk" 
                  class="py-3 absolute top-0 left-5 text-zinc-400 duration-300 origin-0 cursor-text">
                      file SK
                  </label>
              </div>
            </div>

            <!-- separator -->
            <div class="relative mt-8 flex items-center justify-center">
                <div class="absolute z-10 left-0 right-0 border-b border-slate-400"></div>
                <h1 class="z-20 px-3 bg-white text-slate-600">
                    pegawai
                </h1>
            </div>

            <!-- input pegawai -->
            <div id="table_input_pegawai_wraper" class="mt-8 h-max w-full overflow-x-auto overflow-y-hidden">
              <table id="input_pegawai" class="w-full text-center border-collapse border border-slate-400">
                <thead class="sticky top-0 bg-white">
                  <tr class="font-semibold text-sm">
                    <td class="text-gray-400 p-3 border border-slate-300">
                      #
                    </td>
                    <td class="text-gray-400 p-3 border border-slate-300">
                      nama lengkap
                    </td>
                    <td class="text-gray-400 p-3 border border-slate-300">
                      bagian
                    </td>
                    <td class="text-gray-400 p-3 border border-slate-300">
                      subagian
                    </td>
                    <td class="text-gray-400 p-3 border border-slate-300">
                      kedudukan
                    </td>
                    <td class="text-gray-400 p-3 border border-slate-300">
                      masa kerja
                    </td>
                    <td class="text-gray-400 p-3 border border-slate-300">
                      income
                    </td>
                  </tr>
                </thead>
                <tbody>
                  <tr id="special_tr">
                    <td colspan="6" class="text-gray-400 p-3 border border-slate-300">
                      Total Income
                    </td>
                    <td class="text-gray-400 p-3 border border-slate-300">
                      Rp. <span id="total_income">0</span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- tambah baris -->
            <div
             id="btn_simpan_crudu" 
             class="flex justify-center items-center mt-4 h-8 w-full px-10 bg-sky-400 hover:bg-sky-500 active:bg-sky-600 text-white rounded-md"
             onclick="tambahBaris();">
                <i class="fas fa-plus"></i>
            </div>
        </div>
        <div
          class="flex justify-end bg-white px-8 pt-4 pb-4 border-t rounded-b-xl">
            <button id="btn_simpan_crudu" class="flex justify-center items-center h-10 w-24 px-10 bg-emerald-400 hover:bg-emerald-500 active:bg-emerald-600 text-white rounded-md">
              simpan
            </button>
        </div>
    </form>
    <?php } ?>

    <!-- List of surat keputusan -->
    <div
      id="list_sk"
      class="min-h-96 mt-8 flex-1 bg-white overflow-auto rounded-xl shadow-lg">
          <div
            class="sticky top-0 z-20 bg-white block px-8 pt-4 pb-4 border-b border-gray-200">
              <h1 id="bag_name" class="capitalize text-zinc-500 text-2xl font-semibold">
                daftar surat keputusan
              </h1>
          </div>
          <div
            id="body_skeleton"
            class="px-8 pt-8 pb-4">
              <?php for ($i=0; $i < 5; $i++) { ?>
                <div class="mb-4 pb-4 border-b border-zinc-300">
                  <div class="w-20 py-2 rounded-xl bg-zinc-300 animate-pulse mb-4"></div>
                  <div class="py-2 rounded-xl bg-zinc-300 animate-pulse mb-4"></div>
                </div>
              <?php } ?>
          </div>
          <div
            id="body_main"
            class="hidden px-8 pt-8 pb-4">

          </div>
      </div>
<?= $this->endSection(); ?>