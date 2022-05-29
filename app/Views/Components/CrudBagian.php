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
        new Quill(`#editor_description_bag`, {
            modules: {
                formula: true,
                syntax: true,
                toolbar: `#toolbar_description_bag`
            },
            theme: 'snow'
        });

        // show popup
        function showCrudBagian(title = null,bagId = null) {
            $('#crud_bagian .title_popup').html(title);

            $('#bg_crud_bagian').removeClass('-z-1 none');
            $('#bg_crud_bagian').addClass('z-50 flex');
            setTimeout(() => {
                $('#bg_crud_bagian').removeClass('opacity-0');
                $('#crud_bagian').removeClass('scale-75');
            }, 50);

            if (bagId != null) {
                getDetailBag(bagId);
            }
        }

        // hide popup
        function hideCrudBagian() {
            $('#crud_bagian').addClass('scale-75');
            $('#bg_crud_bagian').addClass('opacity-0');
            setTimeout(() => {
                $('#bg_crud_bagian').removeClass('z-50 flex');
                $('#bg_crud_bagian').addClass('-z-1 none');
            }, 500);
        }

        // btn close
        $("#close_popup_crudbagian").on("click",() => {
            hideCrudBagian();
            cleanFormBagian();
        });

        // Get Detail Bagian
        async function getDetailBag(bagId) {
            $('.label_fly').addClass('py-4 bg-zinc-400 animate-pulse');
            $('#description_wraper').addClass('min-h-72');
            $('.label_fly >* ').addClass('hidden');
            
            let httpResponse = await httpRequestGet(`${BASE_URL}/bagian/detail/${bagId}`);
            let data         = httpResponse.data.data;

            $('.label_fly').removeClass('py-4 bg-zinc-400 animate-pulse');
            $('#description_wraper').removeClass('min-h-72');
            $('.label_fly >* ').removeClass('hidden');

            $("#bagian_id").val(data.id);
            $("#name_bagian").val(data.name);
            $("#editor_description_bag .ql-editor").html(data.description);
        }

        $('#crud_bagian').on('submit', async function(e) {
            e.preventDefault();
            
            if (validateCrudBagian()) {
                // clear error message first
                $('.label_fly').addClass('border-zinc-400 focus-within:border-zinc-600');
                $('.label_fly').removeClass('border-red-500 focus-within:border-red-500');
                
                let httpResponse = "";
                let form = new FormData(e.target);
    
                form.append("description",$(`#editor_description_bag .ql-editor`).html());
                
                $("#btn_simpan_crudbag #text").toggleClass("hidden inline");
                $("#btn_simpan_crudbag #spinner").toggleClass("inline hidden");
    
                if (form.get("id") == "") {
                    httpResponse = await httpRequestPost(`${BASE_URL}/bagian/create/`,form);
                } 
                else {
                    httpResponse = await httpRequestPut(`${BASE_URL}/bagian/update/`,form);
                }
                    
                $("#btn_simpan_crudbag #text").toggleClass("hidden inline");
                $("#btn_simpan_crudbag #spinner").toggleClass("inline hidden");
    
                if (httpResponse.status === 201) {
                    if (form.get("id") == "") {
                        cleanFormBagian();
                    }
                     
                    localStorage.removeItem("data_bagian");
                    getDataBagian(); // tugas_fungsi.js

                    showAlert({
                        message: `<strong>Success...</strong> bagian berhasil ${form.get("id") == "" ? "ditambah" : "diubah"}!`,
                        autohide: true,
                        type:'success'
                    })
                }
                else if (httpResponse.status === 400) {
                    let msgList = ``;
                
                    for (const key in httpResponse.message) {
                        msgList += `<li>${httpResponse.message[key]}</li>`;
                        $(`#crud_bagian #${key}_wraper`).removeClass('border-zinc-400 focus-within:border-zinc-600');
                        $(`#crud_bagian #${key}_wraper`).addClass('border-red-500 focus-within:border-red-500');
                    }
                    
                    showAlert({
                        message: `<ul class="list-disc list-inside">${msgList}</ul>`,
                        autohide: true,
                        type:'warning'
                    })
                }
            }
        })

        function validateCrudBagian() {
            let status = true;

            // clear error message first
            $('.label_fly').addClass('border-zinc-400 focus-within:border-zinc-600');
            $('.label_fly').removeClass('border-red-500 focus-within:border-red-500');

            if ($("#name_bagian").val() == "") {
                $("#name_bagian").parent().removeClass('border-zinc-400 focus-within:border-zinc-600');
                $("#name_bagian").parent().addClass('border-red-500 focus-within:border-red-500');
                status = false;
            }

            let description = $(`#editor_description_bag .ql-editor`).html().replace(/(<([^>]+)>)/ig,"");

            if (description == "") {
                $("#description_wraper").removeClass('border-zinc-400 focus-within:border-zinc-600');
                $("#description_wraper").addClass('border-red-500 focus-within:border-red-500');
                status = false;
            }

            return status;
        }

        function cleanFormBagian() {
            // clear error message first
            $('.label_fly').addClass('border-zinc-400 focus-within:border-zinc-600');
            $('.label_fly').removeClass('border-red-500 focus-within:border-red-500');

            $("#bagian_id").val("");
            $("#name_bagian").val("");
            $(`#editor_description_bag .ql-editor`).html("");
        }
    </script>
<?= $this->endSection(); ?>

<?= $this->section('contentHtml'); ?> 
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
<?= $this->endSection(); ?>