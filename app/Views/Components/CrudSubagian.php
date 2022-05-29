<?= $this->extend('Layout/template') ?>

<!-- Css -->
<?= $this->section('contentCss'); ?>
    <link rel="stylesheet" href="<?= base_url('css/texteditor/katex.min.css'); ?>">
	<link rel="stylesheet" href="<?= base_url('css/texteditor/quill.snow.css'); ?>">
	<link rel="stylesheet" href="<?= base_url('css/texteditor/monokai-sublime.min.css'); ?>">
    <style>
    </style>
<?= $this->endSection(); ?>

<!-- JS -->
<?= $this->section('jsComponent'); ?>
	<script src="<?= base_url('js/plugins/texteditor/katex.min.js'); ?>"></script>
	<script src="<?= base_url('js/plugins/texteditor/highlight.min.js'); ?>"></script>
	<script src="<?= base_url('js/plugins/texteditor/quill.min.js'); ?>"></script>
    <script>
        // Quil Initialization
        new Quill(`#editor_description_subag`, {
            modules: {
                formula: true,
                syntax: true,
                toolbar: `#toolbar_description_subag`
            },
            theme: 'snow'
        });

        // show popup
        function showCrudSubagian(title = null,subagId = null) {
            let dataStorage = JSON.parse(localStorage.getItem('data_bagian'));
            let option = "<option value=''>-- pilih id bagian --</option>";
                
            dataStorage.forEach(e => {
                option += `<option value="${e.id}">${e.name}</option>`;
            });

            $("#id_bagian").html(option);
            $('#crud_subagian .title_popup').html(title);

            $('#bg_crud_subagian').removeClass('-z-1 none');
            $('#bg_crud_subagian').addClass('z-50 flex');
            setTimeout(() => {
                $('#bg_crud_subagian').removeClass('opacity-0');
                $('#crud_subagian').removeClass('scale-75');
            }, 50);

            if (subagId != null) {
                getDetailSubag(subagId);
            }
        }

        // hide popup
        function hideCrudSubagian() {
            $('#crud_subagian').addClass('scale-75');
            $('#bg_crud_subagian').addClass('opacity-0');
            setTimeout(() => {
                $('#bg_crud_subagian').removeClass('z-50 flex');
                $('#bg_crud_subagian').addClass('-z-1 none');
            }, 500);
        }

        // btn close
        $("#close_popup_crudsubagian").on("click",() => {
            hideCrudSubagian();
            cleanFormSubagian();
        });

        // Get Detail Subagian
        async function getDetailSubag(subagId) {
            $('.label_fly').addClass('py-4 bg-zinc-400 animate-pulse');
            $('#description_subagian_wraper').addClass('min-h-72');
            $('.label_fly >* ').addClass('hidden');
            
            let httpResponse = await httpRequestGet(`${BASE_URL}/subagian/detail/${subagId}`);
            let data         = httpResponse.data.data;

            $('.label_fly').removeClass('py-4 bg-zinc-400 animate-pulse');
            $('#description_subagian_wraper').removeClass('min-h-72');
            $('.label_fly >* ').removeClass('hidden');

            $("#subagian_id").val(data.id);
            $("#name_subagian").val(data.name);
            $("#id_bagian").val(data.id_bagian);
            $("#editor_description_subag .ql-editor").html(data.description);
        }

        $('#crud_subagian').on('submit', async function(e) {
            e.preventDefault();
            
            if (validateCrudSubagian()) {
                // clear error message first
                $('.label_fly').addClass('border-zinc-400 focus-within:border-zinc-600');
                $('.label_fly').removeClass('border-red-500 focus-within:border-red-500');
                
                let httpResponse = "";
                let form = new FormData(e.target);
    
                form.append("description",$(`#editor_description_subag .ql-editor`).html());
                
                $("#btn_simpan_crudsubag #text").toggleClass("hidden inline");
                $("#btn_simpan_crudsubag #spinner").toggleClass("inline hidden");
    
                if (form.get("id") == "") {
                    httpResponse = await httpRequestPost(`${BASE_URL}/subagian/create/`,form);
                } 
                else {
                    httpResponse = await httpRequestPut(`${BASE_URL}/subagian/update/`,form);
                }
                    
                $("#btn_simpan_crudsubag #text").toggleClass("hidden inline");
                $("#btn_simpan_crudsubag #spinner").toggleClass("inline hidden");
    
                if (httpResponse.status === 201) {
                    if (form.get("id") == "") {
                        cleanFormSubagian();
                    }
                     
                    getDataSubagian(); // tugas_fungsi.js

                    showAlert({
                        message: `<strong>Success...</strong> subagian berhasil  ${form.get("id") == "" ? "ditambah" : "diubah"}!`,
                        autohide: true,
                        type:'success'
                    })
                }
                else if (httpResponse.status === 400) {
                    let msgList = ``;
                
                    for (const key in httpResponse.message) {
                        msgList += `<li>${httpResponse.message[key]}</li>`;
                        $(`#crud_subagian #${key}_wraper`).removeClass('border-zinc-400 focus-within:border-zinc-600');
                        $(`#crud_subagian #${key}_wraper`).addClass('border-red-500 focus-within:border-red-500');
                    }
                    
                    showAlert({
                        message: `<ul class="list-disc list-inside">${msgList}</ul>`,
                        autohide: true,
                        type:'warning'
                    })
                }
            }
        })

        function validateCrudSubagian() {
            let status = true;

            // clear error message first
            $('.label_fly').addClass('border-zinc-400 focus-within:border-zinc-600');
            $('.label_fly').removeClass('border-red-500 focus-within:border-red-500');

            if ($("#name_subagian").val() == "") {
                $("#name_subagian").parent().removeClass('border-zinc-400 focus-within:border-zinc-600');
                $("#name_subagian").parent().addClass('border-red-500 focus-within:border-red-500');
                status = false;
            }

            if ($("#id_bagian").val() == "") {
                $("#id_bagian").parent().removeClass('border-zinc-400 focus-within:border-zinc-600');
                $("#id_bagian").parent().addClass('border-red-500 focus-within:border-red-500');
                status = false;
            }

            let description = $(`#editor_description_subag .ql-editor`).html().replace(/(<([^>]+)>)/ig,"");

            if (description == "") {
                $("#description_subagian_wraper").removeClass('border-zinc-400 focus-within:border-zinc-600');
                $("#description_subagian_wraper").addClass('border-red-500 focus-within:border-red-500');
                status = false;
            }

            return status;
        }

        function cleanFormSubagian() {
            // clear error message first
            $('.label_fly').addClass('border-zinc-400 focus-within:border-zinc-600');
            $('.label_fly').removeClass('border-red-500 focus-within:border-red-500');

            $("#subagian_id").val("");
            $("#name_subagian").val("");
            $("#id_bagian").val("");
            $(`#editor_description_subag .ql-editor`).html("");
        }
    </script>
<?= $this->endSection(); ?>

<?= $this->section('contentHtml'); ?> 
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
<?= $this->endSection(); ?>