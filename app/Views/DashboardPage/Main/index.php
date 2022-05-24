<?= $this->extend('Dashboard/index') ?>

<!-- Css -->
<?= $this->section('dashboardCss'); ?>

<?= $this->endSection(); ?>

<!-- JS -->
<?= $this->section('dashboardJs'); ?>
    <script>
        let data = JSON.parse(localStorage.getItem('data_info'));

        $("#logo_main_dashboard").attr("src",data.logo);
        $("#title_app").html(data.title);
        $("#pengumuman").html(data.pengumuman);
        $("#visi").html(data.visi);
        $("#misi").html(data.misi);
    </script>
<?= $this->endSection(); ?>

<!-- Html -->
<?= $this->section('dashboardPage'); ?>
    <div class="flex flex-col items-center pt-12 px-5">
        <img
          id="logo_main_dashboard" src="" alt="logo kemendagri"
          class="w-14 md:w-20 lg:w-24">

        <h1
         id="title_app"
         class="mt-5 lg:mt-10 text-indigo-900 capitalize text-sm md:text-xl lg:text-2xl text-center font-bold">
        </h1>

        <div
        class="mt-8 lg:mt-10 p-3 w-full bg-emerald-300 text-green-700 rounded-xl">
            <p class="text-sm md:text-lg lg:text-xl font-bold uppercase text-center">
                pengumuman</p>
            <div id="pengumuman" class="mt-4 pt-4 border-t border-emerald-500"></div>
        </div>

        <div
         class="mt-8 lg:mt-10 p-3 w-full bg-indigo-900 text-white text-center rounded-xl">
            <p class="text-sm md:text-lg lg:text-xl font-bold uppercase">
                visi</p>
            <div id="visi" class="mt-4 pt-4 border-t border-white"></div>
        </div>

        <div
        class="mt-8 lg:mt-10 p-3 w-full bg-white text-gray-500 rounded-xl">
            <p class="text-sm md:text-lg lg:text-xl font-bold uppercase text-center">
                misi</p>
            <div id="misi" class="mt-4 pt-4 border-t border-gray-300"></div>
        </div>
    </div>
<?= $this->endSection(); ?>