<div
    id="aside_wraper"
    class="relative z-10 w-0 sm:w-72 h-screen transition-all duration-500 overflow-visible">
    <aside
        class="w-max absolute z-10 top-5 bottom-5 left-5 px-5 py-5 backdrop-blur-md rounded-xl shadow-lg transform -translate-x-80 sm:translate-x-0 transition-all duration-500 overflow-auto">
        <div
            class="w-max flex items-center mb-14">
            <img
                src="<?= base_url('images/logo-kemendagri.webp'); ?>" 
                alt="logo kemendagri"
                class="w-8 mr-3">
            <span
                class="text-md text-indigo-900 text-extrabold opacity-90">
                SISTEM KEPEGAWAIAN</span>
        </div>
        <a
            href="<?= base_url(); ?>"
            class="<?= ($title=='dashboard') ? 'bg-white shadow-md' : ''?> mt-5 p-3 flex items-center rounded-xl">
            <div
                class="bg-indigo-900 w-8 h-8 flex justify-center items-center mr-3 rounded-md">
                <i class="fas fa-home text-white text-md"></i>
            </div>
            <span class="text-indigo-900">Dashboard</span>
        </a>
        <a
            href=""
            class="<?= ($title=='tugas & fungsi') ? 'bg-white shadow-md' : ''?> mt-5 p-3 flex items-center rounded-xl">
            <div
                class="bg-indigo-900 w-8 h-8 flex justify-center items-center mr-3 rounded-md">
                <i class="fas fa-clipboard-check text-white text-md"></i>
            </div>
            <span class="text-indigo-900">Tugas & Fungsi</span>
        </a>
        <a
            href=""
            class="<?= ($title=='pembuatan sk') ? 'bg-white shadow-md' : ''?> mt-5 p-3 flex items-center rounded-xl">
            <div
                class="bg-indigo-900 w-8 h-8 flex justify-center items-center mr-3 rounded-md">
                <i class="fas fa-file-alt text-white text-md"></i>
            </div>
            <span class="text-indigo-900">Pembuatan SK</span>
        </a>
        <a
            href=""
            class="<?= ($title=='pegawai') ? 'bg-white shadow-md' : ''?> mt-5 p-3 flex items-center rounded-xl">
            <div
                class="bg-indigo-900 w-8 h-8 flex justify-center items-center mr-3 rounded-md">
                <i class="fas fa-user-friends text-white text-md"></i>
            </div>
            <span class="text-indigo-900">Pegawai</span>
        </a>
        <a
            href=""
            class="<?= ($title=='laporan') ? 'bg-white shadow-md' : ''?> mt-5 p-3 flex items-center rounded-xl">
            <div
                class="bg-indigo-900 w-8 h-8 flex justify-center items-center mr-3 rounded-md">
                <i class="fas fa-paste text-white text-md"></i>
            </div>
            <span class="text-indigo-900">Laporan</span>
        </a>
        <a
            href="<?= base_url("/update_profile"); ?>"
            <?= ($previlege == 'admin') ? "onclick='showEditProfAdmin(this,event);'" :"" ?>
            class="<?= ($title=='update profile') ? 'bg-white shadow-md' : ''?> mt-5 p-3 flex items-center rounded-xl">
            <div
                class="bg-indigo-900 w-8 h-8 flex justify-center items-center mr-3 rounded-md">
                <i class="fas fa-user text-white text-md"></i>
            </div>
            <span class="text-indigo-900">Profile</span>
        </a>
        <hr class="mt-5 border border-indigo-300">
        <a
            id="btn_logout"
            href=""
            class="mt-5 p-3 flex items-center rounded-xl">
            <div
                class="bg-indigo-900 w-8 h-8 flex justify-center items-center mr-3 rounded-md">
                <i class="fas fa-power-off text-white text-md"></i>
            </div>
            <span class="text-indigo-900">Logout</span>
        </a>
    </aside>
</div>