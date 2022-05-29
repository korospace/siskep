<?= $this->extend('Dashboard/index') ?>

<!-- Css -->
<?= $this->section('dashboardCss'); ?>

<?= $this->endSection(); ?>

<!-- JS -->
<?= $this->section('dashboardJs'); ?>
    <script src="<?= base_url('js/tugas_fungsi.js'); ?>"></script>
<?= $this->endSection(); ?>

<!-- Html -->
<?= $this->section('dashboardPage'); ?>

    <?php if ($previlege == "admin") { ?>
    <div
    class="min-h-96 flex flex-col mt-8 backdrop-blur-md overflow-hidden rounded-xl shadow-lg">
        
        <!-- Table bagian -->
        <div
        id="header_table_bagian"
        class="block md:flex items-center justify-between px-8 pt-8 pb-4">
            <h1 
            class="capitalize text-zinc-500 text-2xl font-semibold">
                bagian</h1>
            <div 
            class="w-full md:w-max flex justify-center items-center mt-5 md:mt-0 bg-indigo-900 active:bg-indigo-700 text-white rounded-lg px-4 py-2 cursor-pointer"
            onclick="showCrudBagian('tambah bagian')">
                    <i class="fas fa-plus"></i>
            </div>
        </div>

        <div
        id="table_bagian_wraper"
        class="relative flex-1 bg-white overflow-auto">
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
                            Action
                        </td>
                    </tr>
                </thead>
                <tbody id="body_skeleton">
                <?php for ($i=0; $i < 5; $i++) { ?>
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
                    </tr>
                <?php } ?>
                </tbody>
                <tbody id="body_main" class="hidden">

                </tbody>
            </table>
        </div>
    </div>

    <div
    class="min-h-96 mt-8 flex flex-col backdrop-blur-md overflow-hidden rounded-xl shadow-lg">
        
        <!-- Table subagian -->
        <div
        id="header_table_bagian"
        class="block md:flex items-center justify-between px-8 pt-8 pb-4">
            <h1 
            class="capitalize text-zinc-500 text-2xl font-semibold">
                subagian</h1>
            <div 
            class="w-full md:w-max flex justify-center items-center mt-5 md:mt-0 bg-indigo-900 active:bg-indigo-700 text-white rounded-lg px-4 py-2 cursor-pointer"
            onclick="showCrudSubagian('tambah subagian')">
                    <i class="fas fa-plus"></i>
            </div>
        </div>

        <div
        id="table_subagian_wraper"
        class="relative flex-1 bg-white overflow-auto">
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
                            Bagian
                        </td>
                        <td class="text-gray-400 p-3">
                            Action
                        </td>
                    </tr>
                </thead>
                <tbody id="body_skeleton" class="hidden">
                <?php for ($i=0; $i < 5; $i++) { ?>
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
                    </tr>
                <?php } ?>
                </tbody>
                <tbody id="body_main">

                </tbody>
            </table>
        </div>
    </div>
    <?php } ?>

    <?php if(in_array($previlege,["kabag","kasubag","pegawai"])) { ?>
    <div
    class="min-h-96 mt-8 flex flex-col bg-white overflow-hidden rounded-xl shadow-lg">
        <div
        id="header_tf_bagian"
        class="block px-8 pt-4 pb-4 border-b border-gray-200">
            <div class="text-sm text-zinc-400 italic mb-2">bagian</div>
            <h1 id="bag_name" class="capitalize text-zinc-500 text-2xl font-semibold">
                <div class="py-3 max-w-10 rounded-lg bg-zinc-300 animate-pulse"></div>
            </h1>
        </div>
        <div
        id="body_tf_bagian"
        class="px-8 pt-8 pb-4 text-zinc-500">
            <?php for ($i=0; $i < 5; $i++) { ?>
            <div class="py-2 rounded-xl bg-zinc-300 animate-pulse mb-4"></div>
            <?php } ?>
        </div>
    </div>
    <?php } ?>

    <?php if(in_array($previlege,["kasubag","pegawai"])) { ?>
    <div
    class="min-h-96 mt-8 flex flex-col bg-white overflow-hidden rounded-xl shadow-lg">
        <div
        id="header_tf_subagian"
        class="block px-8 pt-4 pb-4 border-b border-gray-200">
            <div class="text-sm text-zinc-400 italic mb-2">subagian</div>
            <h1 id="subag_name" class="capitalize text-zinc-500 text-2xl font-semibold">
                <div class="py-3 max-w-10 rounded-lg bg-zinc-300 animate-pulse"></div>
            </h1>
        </div>
        <div
        id="body_tf_subagian"
        class="px-8 pt-4 pb-4 text-zinc-500">
            <?php for ($i=0; $i < 5; $i++) { ?>
            <div class="py-2 rounded-xl bg-zinc-300 animate-pulse mb-4"></div>
            <?php } ?>
        </div>
    </div>
    <?php } ?>

<?= $this->endSection(); ?>