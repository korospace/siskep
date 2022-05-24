<?= $this->extend('Dashboard/index') ?>

<!-- Css -->
<?= $this->section('dashboardCss'); ?>

<?= $this->endSection(); ?>

<!-- JS -->
<?= $this->section('dashboardJs'); ?>
    <script src="<?= base_url('js/update_profile.js'); ?>"></script>
<?= $this->endSection(); ?>

<!-- Html -->
<?= $this->section('dashboardPage'); ?>
<div
    class="relative z-10 h-max mt-5 rounded-xl shadow-lg">
    <div class="max-h-64 overflow-hidden rounded-xl">
        <img class="w-full" src="<?= base_url('images/gedung.webp'); ?>" alt="">
    </div>

    <div
        class="flex items-center absolute left-10 right-10 -bottom-12 p-3 backdrop-blur-md rounded-xl shadow-lg">
            <img 
            class="w-24 mr-5 rounded-xl shadow-md"
            src="<?= base_url('images/default-profile.webp'); ?>" alt="">
            <div>
                <p id="username_profile" class="text-gray-600 text-lg md:text-2xl font-extrabold">_ _ _ _</p>
                <p id="id_profile" class="mt-2 text-gray-600 text-md md:text-xl">id:_ _ _ _</p>
            </div>
    </div>
</div>

<form
    id="update_profile"
    class="h-max flex-1 mt-24 backdrop-blur-md rounded-xl shadow-lg">
    <div
    id="title_wraper"
    class="px-8 pt-8 pb-4 flex justify-between items-center border-b border-gay-400">
        <p id="title" class="text-lg md:text-2xl text-gray-600 font-bold capitalize">
            personal information
        </p>
        <div id="btn_show_form" class="shadow-md rounded-md bg-white active:bg-gray-200 py-2 pl-3 pr-2 cursor-pointer transition duration-300 active:scale-90">
            <i class="fas fa-user-edit text-gray-600 text-md"></i>
        </div>
    </div>

    <div
    id="data_wraper"
    class="px-8 py-8 grid grid-cols-3-fit grid-rows-5 gap-4">
        
    </div>
    
    <div
    id="inputs_wraper"
    class="hidden px-5 pt-12 grid-cols-1 md:grid-cols-2 lg:grid-cols-4 grid-rows-11 md:grid-rows-6 lg:grid-rows-3 gap-x-4 gap-y-10 md:gap-y-12">
        <!-- Username -->
        <div
        id="username_wraper_uprof"
        class="label_fly w-full h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
            <input
            id="username_uprof" type="text" name="username" placeholder="username" autocomplete="off" 
            class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md" />
            <label 
            for="username_uprof" 
            class="py-3 absolute top-0 left-5 text-zinc-400 duration-300 origin-0 cursor-text">
                username
            </label>
        </div>

        <!-- new_password -->
        <div
        id="new_password_wraper_uprof"
        class="label_fly w-full h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
            <input
            id="password_uprof" type="password" name="new_password" placeholder="password" autocomplete="off" 
            class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md" />
            <label 
            for="password_uprof" 
            class="py-3 absolute top-0 left-5 text-zinc-400 duration-300 origin-0 cursor-text">
                password
            </label>
        </div>

        <!-- email -->
        <div
        id="email_wraper_uprof"
        class="label_fly w-full h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
            <input
            id="email_uprof" type="email" name="email" placeholder="email" autocomplete="off" 
            class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md" />
            <label 
            for="email_uprof" 
            class="py-3 absolute top-0 left-5 text-zinc-400 duration-300 origin-0 cursor-text">
                email
            </label>
        </div>

        <!-- nama_lengkap -->
        <div
        id="nama_lengkap_wraper_uprof"
        class="label_fly w-full h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
            <input
            id="nama_lengkap_uprof" type="text" name="nama_lengkap" placeholder="nama_lengkap" autocomplete="off" 
            class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md" />
            <label 
            for="nama_lengkap_uprof" 
            class="py-3 absolute top-0 left-5 text-zinc-400 duration-300 origin-0 cursor-text">
                nama lengkap
            </label>
        </div>

        <!-- nik -->
        <div
        id="nik_wraper_uprof"
        class="label_fly w-full h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
            <input
            id="nik_uprof" type="text" name="nik" placeholder="nik" autocomplete="off" 
            class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md" />
            <label 
            for="nik_uprof" 
            class="py-3 absolute top-0 left-5 text-zinc-400 duration-300 origin-0 cursor-text">
                nik
            </label>
        </div>

        <!-- pendidikan -->
        <div
        id="pendidikan_wraper_uprof"
        class="label_fly w-full h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
            <input
            id="pendidikan_uprof" type="text" name="pendidikan" placeholder="pendidikan" autocomplete="off" 
            class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md" />
            <label 
            for="pendidikan_uprof" 
            class="py-3 absolute top-0 left-5 text-zinc-400 duration-300 origin-0 cursor-text">
                pendidikan
            </label>
        </div>

        <!-- notelp -->
        <div
        id="notelp_wraper_uprof"
        class="label_fly w-full h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
            <input
            id="notelp_uprof" type="text" name="notelp" placeholder="notelp" autocomplete="off" 
            class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md" />
            <label 
            for="notelp_uprof" 
            class="py-3 absolute top-0 left-5 text-zinc-400 duration-300 origin-0 cursor-text">
                nomor telepon
            </label>
        </div>

        <!-- alamat -->
        <div
        id="alamat_wraper_uprof"
        class="label_fly w-full h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
            <input
            id="alamat_uprof" type="text" name="alamat" placeholder="alamat" autocomplete="off" 
            class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md" />
            <label 
            for="alamat_uprof" 
            class="py-3 absolute top-0 left-5 text-zinc-400 duration-300 origin-0 cursor-text">
                alamat
            </label>
        </div>
        
        <!-- agama -->
        <div
        id="agama_wraper_uprof"
        class="label_fly w-full h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
            <select
            id="agama_uprof" type="text" name="agama" placeholder="agama" autocomplete="off" 
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
            for="agama" 
            class="py-2 absolute left-2 -top-8 z-0 text-zinc-600 cursor-text text-xs">
                agama
            </label>
        </div>

        <!-- kelamin -->
        <div
        id="kelamin_wraper_uprof"
        class="label_fly w-full h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
            <select
            id="kelamin_uprof" type="text" name="kelamin" placeholder="kelamin" autocomplete="off" 
            class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md" >
                <option value="">-- pilih kelamin --</option>
                <option value="laki-laki">laki-laki</option>
                <option value="perempuan">perempuan</option>

            </select>
            <label 
            for="kelamin_uprof" 
            class="py-2 absolute left-2 -top-8 z-0 text-zinc-600 cursor-text text-xs">
                kelamin
            </label>
        </div>

        <!-- tgl_lahir -->
        <div
        id="tgl_lahir_wraper_uprof"
        class="label_fly w-full h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
            <input
            id="tgl_lahir_uprof" type="date" name="tgl_lahir" placeholder="tgl_lahir" autocomplete="off" 
            class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md"/>
            <label 
            for="tgl_lahir_uprof" 
            class="py-3 absolute top-0 left-5 text-zinc-400 duration-300 origin-0 cursor-text">
                tanggal lahir
            </label>
        </div>
    </div>
    <div
    id="btn_wraper"
    class="hidden mt-8 px-5 pb-8">
        <div id="btn_hide_form" class="w-full mr-4 px-10 py-2 bg-red-400 active:bg-red-600 text-white text-center rounded-md cursor-pointer">
            tunda
        </div>
        <button id="btn_simpan_uprof" class="w-full px-10 py-2 bg-emerald-400 active:bg-emerald-600 text-white text-center rounded-md">
            <span id="text" class="inline">simpan</span>
            <span id="spinner" class="hidden">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: rgba(0, 0, 0, 0) none repeat scroll 0% 0%; display: block; shape-rendering: auto;" width="14px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                        <circle cx="50" cy="50" fill="none" stroke="#ffffff" stroke-width="10" r="35" stroke-dasharray="164.93361431346415 56.97787143782138">
                        <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" values="0 50 50;360 50 50" keyTimes="0;1"></animateTransform>
                        </circle>
                </svg>
            </span>
        </button>
    </div>
</form>
<?= $this->endSection(); ?>