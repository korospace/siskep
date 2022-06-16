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
        <!-- Table bagian -->
        <div
        class="min-h-96 flex flex-col mt-8 backdrop-blur-md overflow-hidden rounded-xl shadow-lg">
            
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

        <!-- Table subagian -->
        <div
        class="min-h-96 mt-8 flex flex-col backdrop-blur-md overflow-hidden rounded-xl shadow-lg">
            
            <div
            id="header_table_subagian"
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

        <!-- Table kedudukan -->
        <div
        class="min-h-96 mt-8 flex flex-col backdrop-blur-md overflow-hidden rounded-xl shadow-lg">
            
            <div
            id="header_table_kedudukan"
            class="block md:flex items-center justify-between px-8 pt-8 pb-4">
                <h1 
                class="capitalize text-zinc-500 text-2xl font-semibold">
                    kedudukan</h1>
                <div 
                class="w-full md:w-max flex justify-center items-center mt-5 md:mt-0 bg-indigo-900 active:bg-indigo-700 text-white rounded-lg px-4 py-2 cursor-pointer"
                onclick="showCrudKedudukan('tambah kedudukan')">
                        <i class="fas fa-plus"></i>
                </div>
            </div>

            <div
            id="table_kedudukan_wraper"
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
                        </tr>
                    <?php } ?>
                    </tbody>
                    <tbody id="body_main">

                    </tbody>
                </table>
            </div>
        </div>

        <!-- **** Crud bagian **** -->
        <div
        id="bg_crud_bagian"
        class="fixed -z-1 top-0 bottom-0 left-0 right-0 p-8 none flex-col justify-center items-center transition-opacity duration-500 opacity-0"
        style="background-color: rgba(0,0,0,0.2);">
            <form
                id="crud_bagian"
                class="bg-white w-full max-w-xl max-h-full flex flex-col justify-center items-center border border-zinc-400 rounded-lg shadow-md transition duration-500 scale-75">
                <div 
                    class="w-full flex justify-between items-center px-4 py-2 border-b border-gray-300">
                    <p class="title_popup text-gray-600">
                    </p>
                    <span
                        id="close_popup_crudbagian" 
                        class="text-gray-500 text-2xl cursor-pointer">
                        &times;
                    </span>
                </div>

                <div class="w-full flex-1 flex flex-col items-center px-8 pb-5 overflow-auto">
                    <input id="bagian_id" type="hidden" name="id">
                    <!-- Name -->
                    <div
                        id="name_wraper"
                        class="label_fly w-full h-max relative mt-8 border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
                        <input
                        id="name_bagian" type="text" name="name" placeholder="name" autocomplete="off" 
                        class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md" />
                        <label 
                        for="name_bagian" 
                        class="py-2 absolute left-3 top-0 text-zinc-400 duration-300 origin-0 cursor-text">
                            nama
                        </label>
                    </div>

                    <!-- Text editor -->
                    <div
                        id="description_wraper"
                        class="label_fly w-full relative mt-12 border-2 border-zinc-400 focus-within:border-zinc-600 rounded-xl">
                        <label 
                            for="description_bagian" 
                            class="py-2 absolute left-2 -top-10 z-0 text-zinc-600 cursor-text text-xl font-semibold opacity-90">
                            description
                        </label>
                        <div id="toolbar_description_bag">
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
                        <div class="h-60 overflow-auto">
                            <div id="editor_description_bag"></div>
                        </div>
                    </div>
                </div>

                <div
                class="w-full px-8 pb-8">
                    <button id="btn_simpan_crudbag" class="w-full px-10 py-2 bg-emerald-400 active:bg-emerald-600 text-white text-center rounded-md">
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

        <!-- **** Crud subagian **** -->
        <div
        id="bg_crud_subagian"
        class="fixed -z-1 top-0 bottom-0 left-0 right-0 p-8 none flex-col justify-center items-center transition-opacity duration-500 opacity-0"
        style="background-color: rgba(0,0,0,0.2);">
            <form
                id="crud_subagian"
                class="bg-white w-full max-w-xl max-h-full flex flex-col justify-center items-center border border-zinc-400 rounded-lg shadow-md transition duration-500 scale-75">
                <div 
                    class="w-full flex justify-between items-center px-4 py-2 border-b border-gray-300">
                    <p class="title_popup text-gray-600">
                    </p>
                    <span
                        id="close_popup_crudsubagian" 
                        class="text-gray-500 text-2xl cursor-pointer">
                        &times;
                    </span>
                </div>

                <div class="w-full flex-1 flex flex-col items-center px-8 pb-5 overflow-auto">
                    <input id="subagian_id" type="hidden" name="id">

                    <!-- Name -->
                    <div
                        id="name_wraper"
                        class="label_fly w-full h-max relative mt-8 border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
                        <input
                        id="name_subagian" type="text" name="name" placeholder="name" autocomplete="off" 
                        class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md" />
                        <label 
                        for="name_subagian" 
                        class="py-2 absolute left-3 top-0 text-zinc-400 duration-300 origin-0 cursor-text">
                            nama
                        </label>
                    </div>

                    <!-- id bagian -->
                    <div
                    id="id_bagian_wraper"
                    class="label_fly w-full h-max relative mt-12 border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
                        <select
                        id="id_bagian" name="id_bagian" placeholder="id_bagian" autocomplete="off" 
                        class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md" 
                        >
                            <option value="">-- pilih id bagian --</option>
                        </select>
                        <label 
                        for="id_bagian" 
                        class="py-2 absolute left-2 -top-8 z-0 text-zinc-600 cursor-text text-xs">
                            id bagian
                        </label>
                    </div>

                    <!-- Text editor -->
                    <div
                        id="description_subagian_wraper"
                        class="label_fly w-full relative mt-12 border-2 border-zinc-400 focus-within:border-zinc-600 rounded-xl">
                        <label 
                            for="description_subagian" 
                            class="py-2 absolute left-2 -top-10 z-0 text-zinc-600 cursor-text text-xl font-semibold opacity-90">
                            description
                        </label>
                        <div id="toolbar_description_subag">
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
                        <div class="h-60 overflow-auto">
                            <div id="editor_description_subag"></div>
                        </div>
                    </div>
                </div>

                <div
                class="w-full px-8 pb-8">
                    <button id="btn_simpan_crudsubag" class="w-full px-10 py-2 bg-emerald-400 active:bg-emerald-600 text-white text-center rounded-md">
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

        <!-- **** Crud kedudukan **** -->
        <div
        id="bg_crud_kedudukan"
        class="fixed -z-1 top-0 bottom-0 left-0 right-0 p-8 none flex-col justify-center items-center transition-opacity duration-500 opacity-0"
        style="background-color: rgba(0,0,0,0.2);">
            <form
                id="crud_kedudukan"
                class="bg-white w-full max-w-xl max-h-full flex flex-col justify-center items-center border border-zinc-400 rounded-lg shadow-md transition duration-500 scale-75">
                <div 
                    class="w-full flex justify-between items-center px-4 py-2 border-b border-gray-300">
                    <p class="title_popup text-gray-600">
                    </p>
                    <span
                        id="close_popup_crudkedudukan" 
                        class="text-gray-500 text-2xl cursor-pointer">
                        &times;
                    </span>
                </div>

                <div class="w-full flex-1 flex flex-col items-center px-8 pb-5 overflow-auto">
                    <input id="kedudukan_id" type="hidden" name="id">

                    <!-- Name -->
                    <div
                        id="name_wraper"
                        class="label_fly w-full h-max relative mt-8 border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
                        <input
                        id="name_kedudukan" type="text" name="name" placeholder="name" autocomplete="off" 
                        class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md" />
                        <label 
                        for="name_kedudukan" 
                        class="py-2 absolute left-3 top-0 text-zinc-400 duration-300 origin-0 cursor-text">
                            nama
                        </label>
                    </div>
                </div>

                <div
                class="w-full px-8 pb-8">
                    <button id="btn_simpan_crudkedudukan" class="w-full px-10 py-2 bg-emerald-400 active:bg-emerald-600 text-white text-center rounded-md">
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
    <?php } ?>

    <?php if(in_array($previlege,["kabag","kasubag","nonasn"])) { ?>
        <div
        class="min-h-96 mt-8 flex flex-col bg-white overflow-auto rounded-xl shadow-lg">
            <div
            id="header_tf_bagian"
            class="sticky top-0 z-20 bg-white block px-8 pt-4 pb-4 border-b border-gray-200">
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

    <?php if(in_array($previlege,["kasubag","nonasn"])) { ?>
        <div
        class="min-h-96 mt-8 flex flex-col bg-white overflow-auto rounded-xl shadow-lg">
            <div
            id="header_tf_subagian"
            class="sticky top-0 z-20 bg-white block px-8 pt-4 pb-4 border-b border-gray-200">
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