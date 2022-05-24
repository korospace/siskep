<?= $this->extend('Layout/template') ?>

<!-- Css -->
<?= $this->section('contentCss'); ?>
    <style>
    </style>
<?= $this->endSection(); ?>

<!-- JS -->
<?= $this->section('jsComponent'); ?>
    <script>
        // get list of bagian
        <?php if ($previlege == 'admin') { ?>
            async function getDataBagian() {
                let dataStorage = JSON.parse(localStorage.getItem('data_bagian'));

                if (dataStorage == null) {
                    let httpResponse = await httpRequestGet(`${BASE_URL}/bagian/show`);

                    if (httpResponse.status === 200) {
                        dataStorage = httpResponse.data.data;
                    }
                    else {
                        dataStorage = [];
                    }
        
                    localStorage.setItem("data_bagian",JSON.stringify(dataStorage));
                }

                let option = "<option value=''>-- pilih bagian --</option>";
                
                dataStorage.forEach(e => {
                    option += `<option value="${e.name}">${e.name}</option>`;
                });

                $("#bagian_filus").html(option);
            }
            getDataBagian();
        <?php } ?>

        // get list of subagian
        let arrSubag2 = [];
        <?php if ($previlege != 'kasubag') { ?>
            async function getDataSubagian() {
                let httpResponse = await httpRequestGet(`${BASE_URL}/subagian/show`);

                if (httpResponse.status === 200) {
                    arrSubag2 = httpResponse.data.data;
                }
            }
            getDataSubagian();
        <?php } ?>

        function bagianOnChange(bagName = null){
            let e    = document.getElementById("bagian_filus");
            let text = bagName ? bagName : e.options[e.selectedIndex].text;
                    
            let option = "<option value=''>-- pilih subagian --</option>";
            arrSubag2.forEach(e => {
                if (e.bagian == text) {
                    option += `<option value="${e.name}">${e.name}</option>`;
                }
            });

            $("#subagian_filus").html(option);
        }

        // show popup
        function showFilterUser() {
            <?php if ($previlege == 'kabag') { ?>
                let dataStorage = JSON.parse(localStorage.getItem("data_profile"));
                
                $("#bagian_filus").html(`<option value="${dataStorage.bagian}">
                    ${dataStorage.bagian}
                </option>`);

                bagianOnChange(dataStorage.bagian);
            <?php } else if ($previlege == 'kasubag') {?>
                let dataStorage = JSON.parse(localStorage.getItem("data_profile"));

                $("#bagian_filus").html(`<option value="${dataStorage.bagian}">
                    ${dataStorage.bagian}
                </option>`);
                $("#subagian_filus").html(`<option value="${dataStorage.subagian}">
                    ${dataStorage.subagian}
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
<?= $this->endSection(); ?>

<?= $this->section('contentHtml'); ?> 
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