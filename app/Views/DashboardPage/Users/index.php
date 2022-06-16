<?= $this->extend('Dashboard/index') ?>

<!-- Css -->
<?= $this->section('dashboardCss'); ?>

<?= $this->endSection(); ?>

<!-- JS -->
<?= $this->section('dashboardJs'); ?>
  <script>
    /**
     * CRUD User
     */
    // get list of previlege
    async function getDataPrevilege() {
        let httpResponse = await httpRequestGet(`${BASE_URL}/user/previlege`);

        if (httpResponse.status === 200) {
            let option = "<option value=''>-- pilih jenis akun --</option>";
            let data   = httpResponse.data.data;
            
            data.forEach(e => {
                option += `<option value="${e.id}">${e.type}</option>`;
            });

            $("#id_previlege_crudu").html(option);
        }
    }
    getDataPrevilege();

    // get list of bagian
    <?php if ($previlege == 'admin') { ?>
        async function getDataBagian() {
            let data = [];
            let httpResponse = await httpRequestGet(`${BASE_URL}/bagian/show`);

            if (httpResponse.status === 200) {
                data = httpResponse.data.data;
            }

            let option = "<option value=''>-- pilih bagian --</option>";
            
            data.forEach(e => {
                option += `<option value="${e.id}">${e.name}</option>`;
            });

            $("#id_bagian_crudu").html(option);
            $("#bagian_filus").html(option);
        }
        getDataBagian();
    <?php } ?>

    // get list of subagian
    let arrSubag = [];
    <?php if ($previlege != 'kasubag') { ?>
        async function getDataSubagian() {
            let httpResponse = await httpRequestGet(`${BASE_URL}/subagian/show`);

            if (httpResponse.status === 200) {
                arrSubag = httpResponse.data.data;
            }
        }
        getDataSubagian();
    <?php } ?>

    // get list of kedudukan
    async function getDataKedudukan() {
        let data = [];
        let httpResponse = await httpRequestGet(`${BASE_URL}/kedudukan/show`);

        if (httpResponse.status === 200) {
            data = httpResponse.data.data;
        }

        let option = "<option value=''>-- pilih kedudukan --</option>";
            
        data.forEach(e => {
            option += `<option value="${e.id}">${e.name}</option>`;
        });

        $("#id_kedudukan_crudu").html(option);
    }
    getDataKedudukan();

    function previlegeOnChange(){
        let e    = document.getElementById("id_previlege_crudu");
        // let value=e.options[e.selectedIndex].value;
        let text =e.options[e.selectedIndex].text;

        $("#data_optional_line").addClass('hidden');
        $(".data_nonasn").addClass('hidden');

        if (text == "kabag") {
            $("#id_subagian_wraper_crudu").addClass('hidden');
        }
        else {
            $("#id_subagian_wraper_crudu").removeClass('hidden');
            $("#id_bagian_crudu").val("")
            $("#id_subagian_crudu").val("")

            if (text == "nonasn") {
                $("#data_optional_line").removeClass('hidden');
                $(".data_nonasn").removeClass('hidden');

                if ($('#title_popup').html() == "buat akun") {
                    $("#status_wraper_crudu").addClass("hidden");
                }
            } 
        }

    }

    function bagianOnChange1(bagId = null){
        let e     = document.getElementById("id_bagian_crudu");
        let value = bagId ? bagId : e.options[e.selectedIndex].value;
                
        let option = "<option value=''>-- pilih subagian --</option>";

        arrSubag.forEach(e => {
            if (e.id_bagian == value) {
                option += `<option value="${e.id}">${e.name}</option>`;
            }
        });

        $("#id_subagian_crudu").html(option);
    }

    // show popup
    function showCrudUsers(title = null,userId = null) {
        $('#title_popup').html(title);
                
        <?php if ($previlege == 'kabag') { ?>
            $("#id_bagian_crudu").html(`
                <option value="<?= $idbagian ?>">
                    <?= $bagian ?>
                </option>
            `);

            bagianOnChange1('<?= $idbagian ?>');
        <?php } else if ($previlege == 'kasubag') {?>
            $("#id_bagian_crudu").html(`
                <option value="<?= $idbagian ?>">
                    <?= $bagian ?>
                </option>
            `);
            $("#id_subagian_crudu").html(`<option value="<?= $idsubagian ?>">
                <?= $subagian ?>
            </option>`);
        <?php } ?>

        if (title == "buat akun") {
            $("#id_crudu").val("");
            $("#new_password_wraper_crudu").addClass("hidden");
            $("#status_wraper_crudu").addClass("hidden");
        }
        else {
            $("#new_password_wraper_crudu").removeClass("hidden");
            $("#status_wraper_crudu").removeClass("hidden");
            getDetailUser(userId);
        }

        $('#bg_crud_users').removeClass('-z-1 none');
        $('#bg_crud_users').addClass('z-50 flex');
        setTimeout(() => {
            $('#bg_crud_users').removeClass('opacity-0');
            $('#crud_users').removeClass('scale-75');
        }, 50);
    }

    // hide popup
    function hideCrudUsers() {
        $('#crud_users').addClass('scale-75');
        $('#bg_crud_users').addClass('opacity-0');
        setTimeout(() => {
            $('#bg_crud_users').removeClass('z-50 flex');
            $('#bg_crud_users').addClass('-z-1 flex');
        }, 500);
    }

    // Button Close
    $("#close_popup_crudusers").on("click",() => {
        $("#data_optional_line").addClass('hidden');
        $(".data_nonasn").addClass('hidden');
        hideCrudUsers();
        cleanForm();
    });

    // Get Detail User
    async function getDetailUser(userId) {
        $("#data_optional_line").removeClass('hidden');
        $(".data_nonasn").removeClass('hidden');
        $('.label_fly').addClass('py-3 bg-zinc-400 animate-pulse');
        $('.label_fly >* ').addClass('hidden');
        
        let httpResponse = await httpRequestGet(`${BASE_URL}/user/show?id=${userId}`);
        let data         = httpResponse.data.data;

        $('.label_fly').removeClass('py-3 bg-zinc-400 animate-pulse');
        $('.label_fly >* ').removeClass('hidden');

        if (data.subagian == null) {
            $("#id_subagian_wraper_crudu").addClass('hidden');
        }
        else {
            <?php if ($previlege != 'kasubag') {?>
                bagianOnChange1(data.id_bagian);
            <?php } ?>
            $("#id_subagian_wraper_crudu").removeClass('hidden');
        }

        if (data.previlege != "nonasn") {
            $("#data_optional_line").addClass('hidden');
            $(".data_nonasn").addClass('hidden');
        }

        for (const key in data) {
            if (key=="tgl_lahir") {
                if (data[key] != null) {
                    let tglLahir = data[key].split('-');
                    $(`#crud_users #${key}_crudu`).val(`${tglLahir[2]}-${tglLahir[1]}-${tglLahir[0]}`);
                }
            }
            else{
                $(`#crud_users #${key}_crudu`).val(data[key]);
            }
        }
    }

    $('#crud_users').on('submit', async function(e) {
        e.preventDefault();

        // clear error message first
        $('.label_fly').addClass('border-zinc-400 focus-within:border-zinc-600');
        $('.label_fly').removeClass('border-red-500 focus-within:border-red-500');

        let form = new FormData(e.target);

        $(".data_nonasn .validate").each(function() {
            if ($(this).parent().hasClass("hidden")) {
                form.delete($(this).attr("name"));
            }
        })

        $(".validate").each(function() {
            if ($(this).val() == "") {
                form.delete($(this).attr("name"));
            }
        })

        let userId  = form.get('id');
        let newPass = form.get('new_password');

        if (form.get('tgl_lahir')) {
            let newTgl  = form.get('tgl_lahir').split('-');
            form.set('tgl_lahir',`${newTgl[2]}-${newTgl[1]}-${newTgl[0]}`);
        }
        
        $("#btn_simpan_crudu #text").toggleClass("hidden inline");
        $("#btn_simpan_crudu #spinner").toggleClass("inline hidden");

        let httpResponse = "";

        if (userId == "") {
            httpResponse = await httpRequestPost(`${BASE_URL}/user/create`,form);
        } 
        else {
            if (newPass == "") {
                form.delete("new_password");
            }
            httpResponse = await httpRequestPut(`${BASE_URL}/user/update/`+userId,form);
        }
        
        $("#btn_simpan_crudu #text").toggleClass("hidden inline");
        $("#btn_simpan_crudu #spinner").toggleClass("inline hidden");

        if (httpResponse.status === 201) {
            showAlert({
                message: `<strong>Success...</strong> akun berhasil ${userId == "" ? "dibuat" : "diupdate"}!`,
                autohide: true,
                type:'success'
            })

            getUsers();

            if (userId == "") {
                cleanForm();
            }
            else {
                $(".data_nonasn .validate").each(function() {
                    if ($(this).parent().hasClass("hidden")) {
                        $(this).val("");
                    }
                })
            }
        }
        else if (httpResponse.status === 400) {
            let msgList = ``;
    
            for (const key in httpResponse.message) {
                msgList += `<li>${httpResponse.message[key]}</li>`;
                $(`#crud_users #${key}_wraper_crudu`).removeClass('border-zinc-400 focus-within:border-zinc-600');
                $(`#crud_users #${key}_wraper_crudu`).addClass('border-red-500 focus-within:border-red-500');
            }
            
            showAlert({
                message: `<ul class="list-disc list-inside">${msgList}</ul>`,
                autohide: true,
                type:'warning'
            })
        }
    })

    function validateCrudUser() {
        let status = true;

        // clear error message first
        $('.label_fly').addClass('border-zinc-400 focus-within:border-zinc-600');
        $('.label_fly').removeClass('border-red-500 focus-within:border-red-500');

        $('#crud_users .validate').each(function() {
            let isEmpty   = $(this).val() == "";
            let isNotHide = $(this).parent().hasClass("hidden") == false;
            let notUserId  = $(this).attr("name") != "id";
            let notNewPass = $(this).attr("name") != "new_password";

            if (isEmpty && isNotHide && notUserId && notNewPass) {
                $(this).parent().removeClass('border-zinc-400 focus-within:border-zinc-600');
                $(this).parent().addClass('border-red-500 focus-within:border-red-500');
                status = false;
            }
        })

        return status;
    }

    function cleanForm() {
        $("#id_subagian_wraper_crudu").removeClass('hidden');
        $("#id_subagian_crudu").html(`<option value="">-- pilih subagian --</option>`);

        // clear error message first
        $('.label_fly').addClass('border-zinc-400 focus-within:border-zinc-600');
        $('.label_fly').removeClass('border-red-500 focus-within:border-red-500');

        $('#crud_users .validate').each(function() {
            $(this).val("");
        })
    }

    /**
     * Filter User
     */
    function bagianOnChange(bagName = null){
        let e    = document.getElementById("bagian_filus");
        let text = bagName ? bagName : e.options[e.selectedIndex].text;
                
        let option = "<option value=''>-- pilih subagian --</option>";
        arrSubag.forEach(e => {
            if (e.bagian == text) {
                option += `<option value="${e.name}">${e.name}</option>`;
            }
        });

        $("#subagian_filus").html(option);
    }

    // show popup
    function showFilterUser() {
        <?php if ($previlege == 'kabag') { ?>
            $("#bagian_filus").html(`<option value="<?= $bagian ?>">
                <?= $bagian ?>
            </option>`);

            bagianOnChange('<?= $bagian ?>');
        <?php } else if ($previlege == 'kasubag') {?>
            $("#bagian_filus").html(`<option value="<?= $bagian ?>">
                <?= $bagian ?>
            </option>`);
            $("#subagian_filus").html(`<option value="<?= $subagian ?>">
                <?= $subagian ?>
            </option>`);
        <?php } ?>

        $('#bg_filter_users').removeClass('-z-1 none');
        $('#bg_filter_users').addClass('z-50 flex');
        setTimeout(() => {
            $('#bg_filter_users').removeClass('opacity-0');
            $('#filter_users').removeClass('scale-75');
        }, 50);
    }

    // hide popup
    function hideFilterUser() {
        $('#filter_users').addClass('scale-75');
        $('#bg_filter_users').addClass('opacity-0');
        setTimeout(() => {
            $('#bg_filter_users').removeClass('z-50 flex');
            $('#bg_filter_users').addClass('-z-1 none');
        }, 500);
    }

    $("#close_popup_filus").on("click",() => {
        hideFilterUser();
    });

    $('#filter_users').on('submit', async function(e) {
        e.preventDefault();
        
        if (validateFilterUsers()) {
            let queries = "";
            let status  = "";
            let form    = new FormData(e.target);
            let pairTotal = 0;

            for (var pair of form.entries()) {
                ++pairTotal;
                status  += `${pair[1]} - `;
                queries += `${pair[0]}=${pair[1]}&`;
            }

            status  = pairTotal == 1 ? status+" semua bagian" : "";
            queries = queries.replace(/.$/,"");

            $("#status_filter").html(status); // Views/DashboardPage/Users/index.php
            getUsers(queries);                // in file users.js
        }
    })

    function validateFilterUsers() {
        let status = true;

        // clear error message first
        $('.label_fly').addClass('border-zinc-400 focus-within:border-zinc-600');
        $('.label_fly').removeClass('border-red-500 focus-within:border-red-500');

        $('#filter_users .validate').each(function() {
            let isEmpty   = $(this).val() == "";
            let isNotHide = $(this).parent().hasClass("hidden") == false;

            if (isEmpty && isNotHide) {
                $(this).parent().removeClass('border-zinc-400 focus-within:border-zinc-600');
                $(this).parent().addClass('border-red-500 focus-within:border-red-500');
                status = false;
            }
        })

        return status;
    }
  </script>
  <script src="<?= base_url('js/users.js'); ?>"></script>
<?= $this->endSection(); ?>

<!-- Html -->
<?= $this->section('dashboardPage'); ?>
    <!-- table users -->
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
                    username
                  </td>
                  <td class="text-gray-400 p-3">
                    Nama
                  </td>
                  <td class="text-gray-400 p-3">
                    NIK
                  </td>
                  <td class="text-gray-400 p-3">
                    jenis akun
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
	
    <!-- Form CRUD Users -->
    <div
      id="bg_crud_users"
      class="fixed -z-1 top-0 bottom-0 left-0 right-0 p-8 none justify-center items-center transition-opacity duration-500 opacity-0"
      style="background-color: rgba(0,0,0,0.2);">
        <form
            id="crud_users"
            class="bg-white w-full max-h-full flex flex-col justify-center items-center border border-zinc-400 rounded-lg shadow-md transition duration-500 scale-75">
            <div 
                class="w-full flex justify-between items-center px-4 py-2 border-b border-gray-300">
                <p id="title_popup" class="text-gray-600">
                    
                </p>
                <span
                    id="close_popup_crudusers" 
                    class="text-gray-500 text-2xl cursor-pointer">
                    &times;
                </span>
            </div>

            <div class="w-full flex-1 overflow-auto">
                <!-- User id -->
                <input id="id_crudu" type="hidden" name="id" class="">

                <div class="relative mt-8 flex items-center justify-center">
                    <div class="absolute z-10 left-8 right-8 border-b border-zinc-400"></div>
                    <h1 class="z-20 px-3 bg-white text-zinc-600">
                        wajib diisi
                    </h1>
                </div>

                <div id="data_mandatory_wraper" class="h-max w-full px-8 pt-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 grid-rows-11 md:grid-rows-6 lg:grid-rows-3 gap-x-4 gap-y-10 md:gap-y-12">
                    <!-- Username -->
                    <div
                    id="username_wraper_crudu"
                    class="label_fly w-full h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
                        <input
                        id="username_crudu" type="text" name="username" placeholder="username" autocomplete="off" 
                        class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md" />
                        <label 
                        for="username_crudu" 
                        class="py-2 absolute left-3 top-0 text-zinc-400 duration-300 origin-0 cursor-text">
                            username
                        </label>
                    </div>
    
                    <!-- password baru -->
                    <div
                    id="new_password_wraper_crudu"
                    class="label_fly w-full h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
                        <input
                        id="new_password_crudu" type="password" name="new_password" placeholder="password" autocomplete="off" 
                        class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md" />
                        <label 
                        for="new_password_crudu" 
                        class="py-2 absolute left-3 top-0 text-zinc-400 duration-300 origin-0 cursor-text">
                            password baru
                            <small class="w-max text-gray-400 italic">
                                (opsional)
                            </small>
                        </label>
                    </div>

                    <!-- id_previlege -->
                    <div
                    id="id_previlege_wraper_crudu"
                    class="label_fly w-full h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
                        <select
                        id="id_previlege_crudu" name="id_previlege" placeholder="jenis akun" autocomplete="off" 
                        class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md"  
                        onchange="previlegeOnChange()">
                            <option value="">-- pilih jenis akun --</option>
                        </select>
                        <label 
                        for="id_previlege_crudu" 
                        class="py-2 absolute left-2 -top-8 z-0 text-zinc-600 cursor-text text-xs">
                            jenis akun
                        </label>
                    </div>

                    <!-- bagian -->
                    <div
                    id="id_bagian_wraper_crudu"
                    class="label_fly w-full h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
                        <select
                        id="id_bagian_crudu" name="id_bagian" placeholder="bagian" autocomplete="off" 
                        class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md" 
                        onchange="bagianOnChange1();"
                        >
                            <option value="">-- pilih bagian --</option>
                        </select>
                        <label 
                        for="id_bagian_crudu" 
                        class="py-2 absolute left-2 -top-8 z-0 text-zinc-600 cursor-text text-xs">
                            bagian
                        </label>
                    </div>

                    <!-- subagian -->
                    <div
                    id="id_subagian_wraper_crudu"
                    class="label_fly w-full h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
                        <select
                        id="id_subagian_crudu" name="id_subagian" placeholder="subagian" autocomplete="off" 
                        class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md" >
                            <option value="">-- pilih subagian --</option>
                        </select>
                        <label 
                        for="id_subagian_crudu" 
                        class="py-2 absolute left-2 -top-8 z-0 text-zinc-600 cursor-text text-xs">
                            subagian
                            <small class="w-max text-gray-400 italic">
                                (pilih bagian terlebih dahulu)
                            </small>
                        </label>
                    </div>
    
                    <!-- nik -->
                    <div
                    id="nik_wraper_crudu"
                    class="label_fly data_nonasn hidden w-full h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
                        <input
                        id="nik_crudu" type="text" name="nik" placeholder="nik" autocomplete="off" 
                        class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md" />
                        <label 
                        for="nik_crudu" 
                        class="py-2 absolute left-3 top-0 text-zinc-400 duration-300 origin-0 cursor-text">
                            nik
                        </label>
                    </div>
    
                    <!-- npwp -->
                    <div
                    id="npwp_wraper_crudu"
                    class="label_fly data_nonasn hidden w-full h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
                        <input
                        id="npwp_crudu" type="text" name="npwp" placeholder="npwp" autocomplete="off" 
                        class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md" />
                        <label 
                        for="npwp_crudu" 
                        class="py-2 absolute left-3 top-0 text-zinc-400 duration-300 origin-0 cursor-text">
                            npwp
                        </label>
                    </div>

                    <!-- email -->
                    <div
                    id="email_wraper_crudu"
                    class="label_fly data_nonasn hidden w-full h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
                        <input
                        id="email_crudu" type="email" name="email" placeholder="email" autocomplete="off" 
                        class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md" />
                        <label 
                        for="email_crudu" 
                        class="py-2 absolute left-3 top-0 text-zinc-400 duration-300 origin-0 cursor-text">
                            email
                        </label>
                    </div>

                    <!-- notelp -->
                    <div
                    id="notelp_wraper_crudu"
                    class="label_fly data_nonasn hidden w-full h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
                        <input
                        id="notelp_crudu" type="text" name="notelp" placeholder="notelp" autocomplete="off" 
                        class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md" />
                        <label 
                        for="notelp_crudu" 
                        class="py-2 absolute left-3 top-0 text-zinc-400 duration-300 origin-0 cursor-text">
                            nomor telepon
                        </label>
                    </div>

                    <!-- kedudukan -->
                    <div
                    id="id_kedudukan_wraper_crudu"
                    class="label_fly data_nonasn hidden w-full h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
                        <select
                        id="id_kedudukan_crudu" name="id_kedudukan" placeholder="kedudukan" autocomplete="off" 
                        class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md" >
                            <option value="">-- pilih kedudukan --</option>
                        </select>
                        <label 
                        for="id_kedudukan_crudu" 
                        class="py-2 absolute left-2 -top-8 z-0 text-zinc-600 cursor-text text-xs">
                            kedudukan
                        </label>
                    </div>

                    <!-- masa_kerja -->
                    <div
                    id="masa_kerja_wraper_crudu"
                    class="label_fly data_nonasn hidden w-full h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
                        <input
                        id="masa_kerja_crudu" type="number" name="masa_kerja" placeholder="masa kerja" autocomplete="off" 
                        class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md" />
                        <label 
                        for="masa_kerja_crudu" 
                        class="py-2 absolute left-3 top-0 text-zinc-400 duration-300 origin-0 cursor-text">
                            masa kerja
                        </label>
                    </div>

                    <!-- income -->
                    <div
                    id="income_wraper_crudu"
                    class="label_fly data_nonasn hidden w-full h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
                        <input
                        id="income_crudu" type="number" name="income" placeholder="masa kerja" autocomplete="off" 
                        class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md" />
                        <label 
                        for="income_crudu" 
                        class="py-2 absolute left-3 top-0 text-zinc-400 duration-300 origin-0 cursor-text">
                            income
                        </label>
                    </div>
                </div>

                <div id="data_optional_line" class="hidden relative mt-8 flex items-center justify-center">
                    <div class="absolute z-10 left-8 right-8 border-b border-zinc-400"></div>
                    <h1 class="z-20 px-3 bg-white text-zinc-600">
                        tidak wajib diisi
                    </h1>
                </div>

                <div id="data_optional_wraper" class="h-max w-full px-8 pt-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 grid-rows-11 md:grid-rows-6 lg:grid-rows-3 gap-x-4 gap-y-10 md:gap-y-12">
    
                    <!-- nama_lengkap -->
                    <div
                    id="nama_lengkap_wraper_crudu"
                    class="label_fly data_nonasn hidden w-full h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
                        <input
                        id="nama_lengkap_crudu" type="text" name="nama_lengkap" placeholder="nama_lengkap" autocomplete="off" 
                        class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md" />
                        <label 
                        for="nama_lengkap_crudu" 
                        class="py-2 absolute left-3 top-0 text-zinc-400 duration-300 origin-0 cursor-text">
                            nama lengkap
                        </label>
                    </div>
    
                    <!-- alamat -->
                    <div
                    id="alamat_wraper_crudu"
                    class="label_fly data_nonasn hidden w-full h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
                        <input
                        id="alamat_crudu" type="text" name="alamat" placeholder="alamat" autocomplete="off" 
                        class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md" />
                        <label 
                        for="alamat_crudu" 
                        class="py-2 absolute left-3 top-0 text-zinc-400 duration-300 origin-0 cursor-text">
                            alamat
                        </label>
                    </div>
                    
                    <!-- agama -->
                    <div
                    id="agama_wraper_crudu"
                    class="label_fly data_nonasn hidden w-full h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
                        <select
                        id="agama_crudu" name="agama" placeholder="agama" autocomplete="off" 
                        class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md" >
                            <option value="">-- pilih agama --</option>
                            <option value="islam">islam</option>
                            <option value="protestan">protestan</option>
                            <option value="katolik">katolik</option>
                            <option value="budha">budha</option>
                            <option value="hindu">hindu</option>
                            <option value="khonghucu">khonghucu</option>
    
                        </select>
                        <label 
                        for="agama_crudu" 
                        class="py-2 absolute left-2 -top-8 z-0 text-zinc-600 cursor-text text-xs">
                            agama
                        </label>
                    </div>
    
                    <!-- pendidikan -->
                    <div
                    id="pendidikan_wraper_crudu"
                    class="label_fly data_nonasn hidden w-full h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
                        <input
                        id="pendidikan_crudu" type="text" name="pendidikan" placeholder="pendidikan" autocomplete="off" 
                        class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md" />
                        <label 
                        for="pendidikan_crudu" 
                        class="py-2 absolute left-3 top-0 text-zinc-400 duration-300 origin-0 cursor-text">
                            pendidikan
                        </label>
                    </div>
    
                    <!-- kelamin -->
                    <div
                    id="kelamin_wraper_crudu"
                    class="label_fly data_nonasn hidden w-full h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
                        <select
                        id="kelamin_crudu" name="kelamin" placeholder="kelamin" autocomplete="off" 
                        class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md" >
                            <option value="">-- pilih kelamin --</option>
                            <option value="laki-laki">laki-laki</option>
                            <option value="perempuan">perempuan</option>
    
                        </select>
                        <label 
                        for="kelamin_crudu" 
                        class="py-2 absolute left-2 -top-8 z-0 text-zinc-600 cursor-text text-xs">
                            kelamin
                        </label>
                    </div>
    
                    <!-- tgl_lahir -->
                    <div
                    id="tgl_lahir_wraper_crudu"
                    class="label_fly data_nonasn hidden w-full h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
                        <input
                        id="tgl_lahir_crudu" type="date" name="tgl_lahir" placeholder="tgl_lahir" autocomplete="off" 
                        class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md"/>
                        <label 
                        for="tgl_lahir_crudu" 
                        class="py-3 absolute top-0 left-5 text-zinc-400 duration-300 origin-0 cursor-text">
                            tanggal lahir
                        </label>
                    </div>
                                    
                    <!-- status -->
                    <div
                    id="status_wraper_crudu"
                    class="label_fly data_nonasn hidden w-full h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
                        <select
                        id="status_crudu" name="status" placeholder="status" autocomplete="off" 
                        class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md" >
                            <option value="">-- pilih status --</option>
                            <option value="active">active</option>
                            <option value="nonactive">nonactive</option>
                        </select>
                        <label 
                        for="status_crudu" 
                        class="py-2 absolute left-2 -top-8 z-0 text-zinc-600 cursor-text text-xs">
                            status
                        </label>
                    </div>
                </div>
            </div>

            <div
              class="w-full px-8 pb-8">
                <button id="btn_simpan_crudu" class="w-full px-10 py-2 bg-emerald-400 hover:bg-emerald-500 active:bg-emerald-600 text-white text-center rounded-md">
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

    <!-- Form Filter User -->
    <div
      id="bg_filter_users"
      class="fixed -z-1 top-0 bottom-0 left-0 right-0 px-3 none flex-col justify-center items-center transition-opacity duration-500 opacity-0"
      style="background-color: rgba(0,0,0,0.2);">
        <form
            id="filter_users"
            class="bg-white w-full v-340:w-72 flex flex-col justify-center items-center border border-zinc-400 rounded-lg shadow-md transition duration-500 scale-75">
            <div 
                class="w-full flex justify-between items-center px-4 py-2 border-b border-gray-300">
                <p class="text-gray-600">
                    Filter Akun
                </p>
                <span
                    id="close_popup_filus" 
                    class="text-gray-500 text-2xl cursor-pointer">
                    &times;
                </span>
            </div>

            <div class="w-full flex flex-col items-center px-8 pb-5">
                
                <!-- urutan -->
                <div
                id="urutan_wraper_filus"
                class="label_fly w-full h-max mt-10 relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
                    <select
                    id="urutan_filus" type="text" name="urutan" placeholder="urutan" autocomplete="off" 
                    class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md" >
                        <option value="">-- pilih urutan --</option>
                        <option value="terbaru">terbaru</option>
                        <option value="terlama">terlama</option>
                    </select>
                    <label 
                    for="urutan" 
                    class="py-2 absolute left-2 -top-8 z-0 text-zinc-600 cursor-text text-xs">
                        urutan
                    </label>
                </div>

                <!-- bagian -->
                <div
                id="bagian_wraper_filus"
                class="label_fly w-full h-max mt-8 relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
                    <select
                    id="bagian_filus" name="bagian" placeholder="bagian" autocomplete="off" 
                    class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md" 
                    onchange="bagianOnChange();"
                    >
                        <option value="">-- pilih bagian --</option>
                    </select>
                    <label 
                    for="bagian_filus" 
                    class="py-2 absolute left-2 -top-8 z-0 text-zinc-600 cursor-text text-xs">
                        bagian
                    </label>
                </div>

                <!-- subagian -->
                <div
                id="subagian_wraper_filus"
                class="label_fly w-full h-max mt-8 relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
                    <select
                    id="subagian_filus" name="subagian" placeholder="subagian" autocomplete="off" 
                    class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md" >
                        <option value="">-- pilih subagian --</option>
                    </select>
                    <label 
                    for="subagian_filus" 
                    class="py-2 absolute left-2 -top-8 z-0 text-zinc-600 cursor-text text-xs">
                        subagian
                        <small class="w-max text-gray-400 italic">
                            (pilih bagian terlebih dahulu)
                        </small>
                    </label>
                </div>

                <button
                  class="w-full mt-7 px-10 py-2 bg-emerald-400 active:bg-emerald-600 text-white text-center rounded-md">
                    ok
                </button>
            </div>
        </form>
    </div>
<?= $this->endSection(); ?>