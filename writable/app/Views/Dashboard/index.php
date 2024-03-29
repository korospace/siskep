<?= $this->extend('Layout/template') ?>

<!-- Css -->
<?= $this->section('layoutCss'); ?>
    <link rel="stylesheet" href="<?= base_url('css/texteditor/katex.min.css'); ?>">
	<link rel="stylesheet" href="<?= base_url('css/texteditor/quill.snow.css'); ?>">
	<link rel="stylesheet" href="<?= base_url('css/texteditor/monokai-sublime.min.css'); ?>">
    <?= $this->renderSection('dashboardCss'); ?>
<?= $this->endSection(); ?>

<!-- JS -->
<?= $this->section('layoutJs'); ?>
	<script src="<?= base_url('js/plugins/texteditor/katex.min.js'); ?>"></script>
	<script src="<?= base_url('js/plugins/texteditor/highlight.min.js'); ?>"></script>
	<script src="<?= base_url('js/plugins/texteditor/quill.min.js'); ?>"></script>
    <?= $this->renderSection('dashboardJs'); ?>

    <?php if ($previlege == 'admin') { ?>
    <script>
        /**
         * Popup Edit Information
         */
        // Quil Initialization
        ["visi","misi","pengumuman"].forEach(e => {
            new Quill(`#editor-${e}`, {
                modules: {
                    formula: true,
                    syntax: true,
                    toolbar: `#toolbar-${e}`
                },
                theme: 'snow'
            });
        })

        // show popup
        async function showEditInformation() {
            $('#bg_edit_info').removeClass('-z-1 none');
            $('#bg_edit_info').addClass('z-50 flex');
            setTimeout(() => {
                $('#bg_edit_info').removeClass('opacity-0');
                $('#edit_info').removeClass('scale-75');
            }, 50);

            showLoadingSpinner();
            let httpResponse = await httpRequestGet(`${BASE_URL}/information/show`);
            hideLoadingSpinner();

            if (httpResponse.status === 200) {
                let data = httpResponse.data.data;

                $("#id_info").val(data.id);
                $("#logo_info_preview").attr("src",data.logo);
                ["visi","misi","pengumuman"].forEach(e => {
                    $(`#editor-${e} .ql-editor`).html(data[e]);
                })
            }

        }

        // hide popup
        function hideEditInformation() {
            $('#edit_info').addClass('scale-75');
            $('#bg_edit_info').addClass('opacity-0');
            setTimeout(() => {
                $('#bg_edit_info').removeClass('z-50 flex');
                $('#bg_edit_info').addClass('-z-1 none');
            }, 500);
        }

        // btn close
        $("#close_popup_editinfo").on("click",() => {
            hideEditInformation();
        });

        $('#edit_info').on('submit', async function(e) {
            e.preventDefault();
            
            if (validateEditInfo()) {
                // clear error message first
                $('.label_fly').addClass('border-zinc-400 focus-within:border-zinc-600');
                $('.label_fly').removeClass('border-red-500 focus-within:border-red-500');
                
                let form = new FormData(e.target);

                if (filePreview !== '') { // filePreview in parent.js
                    form.set('new_logo', filePreview, filePreview.name);
                }
                ["visi","misi","pengumuman"].forEach(e => {
                    form.append(e,$(`#editor-${e} .ql-editor`).html());
                })
                
                $("#btn_simpan_info #text").toggleClass("hidden inline");
                $("#btn_simpan_info #spinner").toggleClass("inline hidden");

                let httpResponse = await httpRequestPut(`${BASE_URL}/information/update/`,form);
                    
                $("#btn_simpan_info #text").toggleClass("hidden inline");
                $("#btn_simpan_info #spinner").toggleClass("inline hidden");

                if (httpResponse.status === 201) {
                    filePreview = "";
                    showAlert({
                        message: `<strong>Success...</strong> infomation berhasil diupdate!`,
                        autohide: true,
                        type:'success'
                    })

                    let newDataInfo = {
                        id:form.get("id"),
                        logo:BASE_URL+"/images/logo-kemendagri.webp",
                        title:form.get("title"),
                        visi:form.get("visi"),
                        misi:form.get("misi"),
                        pengumuman:form.get("pengumuman"),
                    }

                    localStorage.setItem("data_info",JSON.stringify(newDataInfo));
                }
                else if (httpResponse.status === 400) {
                    let msgList = ``;
                
                    for (const key in httpResponse.message) {
                        msgList += `<li>${httpResponse.message[key]}</li>`;
                        $(`#edit_info #${key}_wraper`).removeClass('border-zinc-400 focus-within:border-zinc-600');
                        $(`#edit_info #${key}_wraper`).addClass('border-red-500 focus-within:border-red-500');
                    }
                    
                    showAlert({
                        message: `<ul class="list-disc list-inside">${msgList}</ul>`,
                        autohide: true,
                        type:'warning'
                    })
                }
            }
        })

        function validateEditInfo() {
            let status = true;

            // clear error message first
            $('.label_fly').addClass('border-zinc-400 focus-within:border-zinc-600');
            $('.label_fly').removeClass('border-red-500 focus-within:border-red-500');

            let visi = $(`#editor-visi .ql-editor`).html().replace(/(<([^>]+)>)/ig,"");
            let misi = $(`#editor-misi .ql-editor`).html().replace(/(<([^>]+)>)/ig,"");

            if (visi == "") {
                $("#visi_wraper").removeClass('border-zinc-400 focus-within:border-zinc-600');
                $("#visi_wraper").addClass('border-red-500 focus-within:border-red-500');
                status = false;
            }
            if (misi == "") {
                $("#misi_wraper").removeClass('border-zinc-400 focus-within:border-zinc-600');
                $("#misi_wraper").addClass('border-red-500 focus-within:border-red-500');
                status = false;
            }

            return status;
        }
    </script>
    <?php } ?>

    <?php if ($previlege != 'nonasn') { ?>
    <script>
        /**
         * Get Profile
         */
        async function getDataProfile() {
            let httpResponse = await httpRequestGet(`${BASE_URL}/user/profile`);
        
            if (httpResponse.status === 200) {
                let data = httpResponse.data.data;

                PASSWORD = data.password;
                
                $("#edit_prof_admin #penempatan_epa").val((data.bagian != null) ? (data.subagian) ? data.bagian+" | "+data.subagian : data.bagian : '-');
                $("#edit_prof_admin #username_epa").val(data.username);
                $("#edit_prof_admin #new_password_epa").val(PASSWORD);
            }
        }

        getDataProfile();

        // show popup
        function showEditProfAdmin(el=null,event=null) {
            event.preventDefault();

            $('#bg_edit_prof_admin').removeClass('-z-1 none');
            $('#bg_edit_prof_admin').addClass('z-50 flex');
            setTimeout(() => {
                $('#bg_edit_prof_admin').removeClass('opacity-0');
                $('#edit_prof_admin').removeClass('scale-75');
            }, 50);
        }

        // hide popup
        function hideEditProfAdmin() {
            $('#edit_prof_admin').addClass('scale-75');
            $('#bg_edit_prof_admin').addClass('opacity-0');
            setTimeout(() => {
                $('#bg_edit_prof_admin').removeClass('z-50 flex');
                $('#bg_edit_prof_admin').addClass('-z-1 none');
            }, 500);
        }

        $("#close_popup_editprofadmin").on("click",() => {
            hideEditProfAdmin();
        });

        $('#edit_prof_admin ').on('submit', async function(e) {
            e.preventDefault();

            if (validateEditProfAdmin()) {
                let form = new FormData(e.target);
                
                showLoadingSpinner();
                let httpResponse = await httpRequestPut(`${BASE_URL}/user/update_profile`,form);
                hideLoadingSpinner();

                if (httpResponse.status === 201) {
                    showAlert({
                        message: `<strong>Success...</strong> edit profile berhasil!`,
                        autohide: true,
                        type:'success'
                    })

                    if (form.get("new_password") !== PASSWORD) {
                        setTimeout(() => {
                            Swal.fire({
                                icon  : 'info',
                                title : '<strong>INFO</strong>',
                                html  : 'Password telah diubah, silahkan login ulang',
                                showCancelButton: false,
                                confirmButtonText: 'ok',
                            })
                            .then(() => {
                                doLogout();
                            })
                        }, 2000);
                    }
                }
                else if (httpResponse.status === 400) {
                    if (httpResponse.message.username) {
                        showAlert({
                            message: `<strong>Gagal...</strong> ${httpResponse.message.username}!`,
                            autohide: true,
                            type:'warning'
                        })
                        $('#edit_prof_admin #username_wraper').removeClass('border-zinc-400');
                        $('#edit_prof_admin #username_wraper').addClass('border-red-500');
                    }
                    else if (httpResponse.message.new_password) {
                        showAlert({
                            message: `<strong>Gagal...</strong> ${httpResponse.message.new_password}!`,
                            autohide: true,
                            type:'warning'
                        })
                        $('#edit_prof_admin #new_password_wraper').removeClass('border-zinc-400');
                        $('#edit_prof_admin #new_password_wraper').addClass('border-red-500');
                    }
                }
            }
        })

        function validateEditProfAdmin() {
            let status = true;

            // clear error message first
            $('.label_fly').addClass('border-zinc-400');
            $('.label_fly').removeClass('border-red-500');

            // email validation
            if ($('#edit_prof_admin #username_epa').val() == '') {
                $('#edit_prof_admin #username_wraper').removeClass('border-zinc-400');
                $('#edit_prof_admin #username_wraper').addClass('border-red-500');
                status = false;
            }
            // password validation
            if ($('#edit_prof_admin #new_password_epa').val() == '') {
                $('#edit_prof_admin #new_password_wraper').removeClass('border-zinc-400');
                $('#edit_prof_admin #new_password_wraper').addClass('border-red-500');
                status = false;
            }

            return status;
        }
    </script>
    <?php } ?>
<?= $this->endSection(); ?>

<!-- Html -->
<?= $this->section('layoutHtml'); ?>

    <div
      id="container" 
      class="h-screen max-w-w-2xl m-auto"
      >
        <!-- **** Alert info **** -->
        <?= $this->include('Components/alertInfo'); ?>
        
        <!-- **** Loading Spinner **** -->
        <?= $this->include('Components/loadingSpinner'); ?>
        
        <div
         id="wraper"
         class="w-full flex">
            <!-- side bar -->
            <?= $this->include('Components/SideBar'); ?>

            <main
              class="flex-1 max-h-screen flex flex-col overflow-auto pl-4 sm:pl-6 pr-4 py-5">
                <!-- nav bar -->
                <?= $this->include('Components/Navbar'); ?>

                <!-- // Render Dashboard Page // -->
                <?= $this->renderSection('dashboardPage'); ?>
            </main>
        </div>
    </div>

    <?php if ($previlege == 'admin') { ?>
    <!-- Popup Edit Information -->
    <div
      id="bg_edit_info"
      class="fixed -z-1 top-0 bottom-0 left-0 right-0 p-8 none flex-col justify-center items-center transition-opacity duration-500 opacity-0"
      style="background-color: rgba(0,0,0,0.2);">
        <form
            id="edit_info"
            class="bg-white w-full max-h-full flex flex-col justify-center items-center border border-zinc-400 rounded-lg shadow-md transition duration-500 scale-75">
            <div 
                class="w-full flex justify-between items-center px-4 py-2 border-b border-gray-300">
                <p class="text-gray-600">
                    Edit Information
                </p>
                <span
                    id="close_popup_editinfo" 
                    class="text-gray-500 text-2xl cursor-pointer">
                    &times;
                </span>
            </div>

            <div class="w-full flex-1 flex flex-col items-center px-8 pb-5 overflow-auto">
                <input id="id_info" type="hidden" name="id">
                
                <!-- logo -->
                <div class="mt-8 w-24 min-h-24 p-2 border border-zinc-400 rounded-sm overflow-hidden shadow-md">
                    <img id="logo_info_preview" class="w-full h-full" src="<?= base_url('images/logo-kemendagri.webp'); ?>" alt="logo kemendagri">
                </div>
                <div
                    id="new_logo_wraper"
                    class="label_fly w-auto h-max relative mt-4 border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
                    <input
                    id="" type="file" name="" autocomplete="off" 
                    class="block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md" 
                    onchange="changePreview(this,'#logo_info_preview');"/>
                </div>

                <!-- Text editor -->
                <?php foreach (["visi","misi","pengumuman"] as $value) {?>
                <div
                    id="<?= $value ?>_wraper"
                    class="label_fly w-full relative mt-12 border-2 border-zinc-400 focus-within:border-zinc-600 rounded-xl">
                    <label 
                        for="<?= $value ?>_info" 
                        class="py-2 absolute left-2 -top-10 z-0 text-zinc-600 cursor-text text-xl font-semibold opacity-90">
                        <?= ($value == "pengumuman") ? $value." <small class='text-xs italic font-light'>(kosongkan jika tidak ingin ditampilkan)</small>" : $value ?>
                    </label>
                    <div id="toolbar-<?= $value ?>">
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
                        <div id="editor-<?= $value ?>"></div>
                    </div>
                </div>
                <?php } ?>
            </div>

            <div
              class="w-full px-8 pb-8">
                <button id="btn_simpan_info" class="w-full px-10 py-2 bg-emerald-400 active:bg-emerald-600 text-white text-center rounded-md">
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

    <?php if ($previlege != 'nonasn') { ?>
    <!-- Popup Edit Profile NonAsn -->
    <div
      id="bg_edit_prof_admin"
      class="fixed -z-1 top-0 bottom-0 left-0 right-0 px-3 none flex-col justify-center items-center transition-opacity duration-500 opacity-0"
      style="background-color: rgba(0,0,0,0.2);">
        <form
            id="edit_prof_admin"
            class="bg-white w-full v-340:w-max flex flex-col justify-center items-center border border-zinc-400 rounded-lg shadow-md transition duration-500 scale-75">
            <div 
                class="w-full flex justify-between items-center px-4 py-2 border-b border-gray-300">
                <p class="text-gray-600">
                    Edit Profile
                </p>
                <span
                    id="close_popup_editprofadmin" 
                    class="text-gray-500 text-2xl cursor-pointer">
                    &times;
                </span>
            </div>

            <div class="flex flex-col items-center px-8 pb-5">
                <?php if ($previlege != "admin") { ?>
                <div
                    id="penempatan_wraper"
                    class="label_fly w-full v-340:w-64 relative mt-8 bg-zinc-200 border-2 border-zinc-400 focus-within:border-zinc-600 rounded-xl">
                    <input
                        id="penempatan_epa" type="text" placeholder="penempatan" autocomplete="off" 
                        class="block px-5 py-3 w-full appearance-none focus:outline-none transition-all text-zinc-600 rounded-xl cursor-not-allowed" disabled />
                    <label 
                        for="penempatan_epa" 
                        class="py-3 absolute top-0 left-5 text-zinc-400 duration-300 origin-0 cursor-not-allowed">
                        penempatan
                    </label>
                </div>
                <?php } ?>

                <div
                    id="username_wraper"
                    class="label_fly w-full v-340:w-64 relative mt-8 border-2 border-zinc-400 focus-within:border-zinc-600 rounded-xl">
                    <input
                        id="username_epa" type="text" name="username" placeholder="username" autocomplete="off" 
                        class="block px-5 py-3 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-xl" />
                    <label 
                        for="username_epa" 
                        class="py-3 absolute top-0 left-5 text-zinc-400 duration-300 origin-0 cursor-text">
                        username
                    </label>
                </div>

                <div
                    id="new_password_wraper"
                    class="label_fly w-full v-340:w-64 relative mt-8 border-2 border-zinc-400 focus-within:border-zinc-600 rounded-xl">
                    <input
                        id="new_password_epa" type="password" name="new_password" placeholder="password" autocomplete="off" 
                        class="block px-5 py-3 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-xl" />
                    <label 
                        for="new_password_epa" 
                        class="py-3 absolute top-0 left-5 text-zinc-400 duration-300 origin-0 cursor-text">
                        password 
                    </label>
                </div>

                <button
                  class="w-full mt-7 px-10 py-2 bg-emerald-400 active:bg-emerald-600 text-white text-center rounded-md">
                    simpan
                </button>
            </div>
        </form>
    </div>
    <?php } ?>
	
<?= $this->endSection(); ?>