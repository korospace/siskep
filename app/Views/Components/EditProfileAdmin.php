<?= $this->extend('Layout/template') ?>

<!-- Css -->
<?= $this->section('contentCss'); ?>
    <style>
    </style>
<?= $this->endSection(); ?>

<!-- JS -->
<?= $this->section('jsComponent'); ?>
    <script>
        async function getDataProfile() {
            let httpResponse = await httpRequestGet(`${BASE_URL}/user/profile`);

            if (httpResponse.status === 200) {
                let data = httpResponse.data.data;
                $("#edit_prof_admin #username").val(data.username);
                $("#edit_prof_admin #new_password").val(PASSWORD);
            }
        }

        getDataProfile();

        // show spinner
        function showEditProfAdmin(el=null,event=null) {
            event.preventDefault();

            $('#bg_edit_prof_admin').removeClass('-z-1 none');
            $('#bg_edit_prof_admin').addClass('z-50 flex');
            setTimeout(() => {
                $('#bg_edit_prof_admin').removeClass('opacity-0');
                $('#edit_prof_admin').removeClass('scale-75');
            }, 50);
        }

        // hide spinner
        function hideEditProfAdmin() {
            $('#edit_prof_admin').addClass('scale-75');
            $('#bg_edit_prof_admin').addClass('opacity-0');
            setTimeout(() => {
                $('#bg_edit_prof_admin').removeClass('z-50 flex');
                $('#bg_edit_prof_admin').addClass('-z-1 none');
            }, 500);
        }

        $("#close_popup").on("click",() => {
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
            if ($('#edit_prof_admin #username').val() == '') {
                $('#edit_prof_admin #username_wraper').removeClass('border-zinc-400');
                $('#edit_prof_admin #username_wraper').addClass('border-red-500');
                status = false;
            }
            // password validation
            if ($('#edit_prof_admin #new_password').val() == '') {
                $('#edit_prof_admin #new_password_wraper').removeClass('border-zinc-400');
                $('#edit_prof_admin #new_password_wraper').addClass('border-red-500');
                status = false;
            }

            return status;
        }
    </script>
<?= $this->endSection(); ?>

<?= $this->section('contentHtml'); ?> 
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
                    id="close_popup" 
                    class="text-gray-500 text-2xl cursor-pointer">
                    &times;
                </span>
            </div>

            <div class="flex flex-col items-center px-8 pb-5">
                <div
                    id="username_wraper"
                    class="label_fly w-full v-340:w-64 relative mt-8 border-2 border-zinc-400 focus-within:border-zinc-600 rounded-xl">
                    <input
                        id="username" type="text" name="username" placeholder="username" autocomplete="off" 
                        class="block px-5 py-3 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-xl" />
                    <label 
                        for="username" 
                        class="px-5 py-3 absolute top-0 text-zinc-400 duration-300 origin-0 cursor-text">
                        username
                    </label>
                </div>

                <div
                    id="new_password_wraper"
                    class="label_fly w-full v-340:w-64 relative mt-8 border-2 border-zinc-400 focus-within:border-zinc-600 rounded-xl">
                    <input
                        id="new_password" type="password" name="new_password" placeholder="password" autocomplete="off" 
                        class="block px-5 py-3 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-xl" />
                    <label 
                        for="new_password" 
                        class="px-5 py-3 absolute top-0 text-zinc-400 duration-300 origin-0 cursor-text">
                        password 
                    </label>
                </div>

                <button
                  class="w-max mt-7 mb-2 px-10 py-2 bg-violet-500 text-white rounded-full">
                    edit
                </button>
            </div>
        </form>
    </div>
<?= $this->endSection(); ?>