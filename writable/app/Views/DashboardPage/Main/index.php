<?= $this->extend('Dashboard/index') ?>

<!-- Css -->
<?= $this->section('dashboardCss'); ?>
    <style>
        .ql-align-right {
            text-align: right;
        }
        .ql-align-center {
            text-align: center;
        }
        .ql-align-left {
            text-align: left;
        }
    </style>
<?= $this->endSection(); ?>

<!-- JS -->
<?= $this->section('dashboardJs'); ?>
    <script>

        /**
         * Get Information
         */
        async function getDataInfo() {
            let httpResponse = await httpRequestGet(`${BASE_URL}/information/show`);

            if (httpResponse.status === 200) {
                let data = httpResponse.data.data;
        
                if (data.pengumuman.replace(/(<([^>]+)>)/ig,"") != "") {
                    $("#pengumuman_dash_wraper").removeClass("hidden");
                    $("#pengumuman").html(data.pengumuman);
                }
        
                $("#visi").html(data.visi);
                $("#misi").html(data.misi);
            }
        }

        getDataInfo();
    </script>
<?= $this->endSection(); ?>

<!-- Html -->
<?= $this->section('dashboardPage'); ?>
    <div class="flex flex-col items-center pt-12 px-5">
        <img
          id="logo_main_dashboard" alt="logo kemendagri"
          src="<?= base_url('images/logo-kemendagri.webp'); ?>" 
          class="w-14 md:w-20 lg:w-24">

        <h1
         id="title_app"
         class="mt-5 lg:mt-10 text-indigo-900 capitalize text-sm md:text-xl lg:text-2xl text-center font-bold">
            Sistem Kepegawaian Non ASN <br>
            Kementrian Dalam Negeri
        </h1>

        <div
        id="pengumuman_dash_wraper"
        class="hidden mt-8 lg:mt-10 p-3 w-full bg-emerald-300 text-green-700 rounded-xl">
            <p class="text-sm md:text-lg lg:text-xl font-bold uppercase text-center">
                pengumuman</p>
            <div id="pengumuman" class="mt-4 pt-4 border-t border-emerald-500">
                -
            </div>
        </div>

        <div
         class="mt-8 lg:mt-10 p-3 w-full bg-indigo-900 text-white rounded-xl">
            <p class="text-sm md:text-lg lg:text-xl font-bold uppercase text-center">
                visi</p>
            <div id="visi" class="mt-4 pt-4 border-t border-white">
                <?php for ($i=0; $i < 4; $i++) { ?>
                <div class="py-2 rounded-xl bg-zinc-300 animate-pulse mb-4"></div>
                <?php } ?>
            </div>
        </div>

        <div
        class="mt-8 lg:mt-10 p-3 w-full bg-white text-gray-500 rounded-xl">
            <p class="text-sm md:text-lg lg:text-xl font-bold uppercase text-center">
                misi</p>
            <div id="misi" class="mt-4 pt-4 border-t border-gray-300">
                <?php for ($i=0; $i < 4; $i++) { ?>
                <div class="py-2 rounded-xl bg-zinc-300 animate-pulse mb-4"></div>
                <?php } ?>
            </div>
        </div>
    </div>
<?= $this->endSection(); ?>