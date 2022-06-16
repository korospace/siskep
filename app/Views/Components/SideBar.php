<?= $this->extend('Layout/template') ?>

<!-- JS -->
<?= $this->section('layoutJs'); ?>
	<script>
		//smoothscroll
		$('#href_tugas_fungsi a').on('click', function (e) {
			e.preventDefault();
			
			$('#container #wraper main').animate({
				scrollTop: $($.attr(this, 'href')).offset().top-100
			}, 500);

		});

        $('#href_sk a').on('click', function (e) {
			e.preventDefault();
			
			$('#container #wraper main').animate({
				scrollTop: $($.attr(this, 'href')).offset().top-100
			}, 500);

		});
	</script>
<?= $this->endSection(); ?>

<div
    id="aside_wraper"
    class="relative z-10 w-0 sm:w-72 h-screen transition-all duration-500 overflow-visible">
    <aside
        class="w-max absolute z-10 top-5 bottom-5 left-5 px-5 py-5 bg-white sm:bg-transparent sm:backdrop-blur-md rounded-xl shadow-lg transform -translate-x-80 sm:translate-x-0 transition-all duration-500 overflow-auto">
        
        <div
            class="w-max flex items-center mb-12">
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
            class="<?= ($title=='dashboard') ? 'bg-gray-300 sm:bg-white shadow-md' : ''?> mt-5 p-3 flex items-center rounded-xl">
            <div
                class="bg-indigo-900 w-8 h-8 flex justify-center items-center mr-3 rounded-md">
                <i class="fas fa-home text-white text-md"></i>
            </div>
            <span class="text-indigo-900">Dashboard</span>
        </a>
        <a
            href="<?= base_url("/tugas_fungsi"); ?>"
            class="<?= ($title=='tugas & fungsi') ? 'bg-gray-300 sm:bg-white shadow-md' : ''?> mt-5 p-3 flex items-center rounded-xl">
            <div
                class="bg-indigo-900 w-8 h-8 flex justify-center items-center mr-3 rounded-md">
                <i class="fas fa-clipboard-check text-white text-md"></i>
            </div>
            <span class="text-indigo-900">Tugas & Fungsi</span>
        </a>
        <?php if ($title=='tugas & fungsi' && $previlege == 'admin') { ?>
        <div id="href_tugas_fungsi" class="w-full pl-7 flex flex-col">
            <a href="#header_table_bagian" class="pt-4 pb-2 text-zinc-500 hover:text-zinc-700 text-xs">
                <i class="fas fa-angle-right mr-2"></i>
                <span>bagian</span>
            </a>
            <a href="#header_table_subagian" class="pt-2 pb-2 text-zinc-500 hover:text-zinc-700 text-xs">
                <i class="fas fa-angle-right mr-2"></i>
                <span>subagian</span>
            </a>
            <a href="#header_table_kedudukan" class="pt-2 pb-2 text-zinc-500 hover:text-zinc-700 text-xs">
                <i class="fas fa-angle-right mr-2"></i>
                <span>kedudukan</span>
            </a>
        </div>
        <?php } ?>
        <?php if ($previlege != 'nonasn') { ?>
        <a
            href="<?= base_url("/pegawai"); ?>"
            class="<?= ($title=='pegawai') ? 'bg-gray-300 sm:bg-white shadow-md' : ''?> mt-5 p-3 flex items-center rounded-xl">
            <div
                class="bg-indigo-900 w-8 h-8 flex justify-center items-center mr-3 rounded-md">
                <i class="fas fa-user-friends text-white text-md"></i>
            </div>
            <span class="text-indigo-900">Pegawai</span>
        </a>
        <?php } ?>
        <a
            href="<?= base_url("/sk"); ?>"
            class="<?= ($title=='surat keputusan') ? 'bg-gray-300 sm:bg-white shadow-md' : ''?> mt-5 p-3 flex items-center rounded-xl">
            <div
                class="bg-indigo-900 w-8 h-8 flex justify-center items-center mr-3 rounded-md">
                <i class="fas fa-file-alt text-white text-md"></i>
            </div>
            <span class="text-indigo-900">Surat Keputusan</span>
        </a>
        <?php if ($title=='surat keputusan' && $previlege != 'nonasn') { ?>
        <div id="href_sk" class="w-full pl-7 flex flex-col">
            <a href="#form_sk" class="pt-4 pb-2 text-zinc-500 hover:text-zinc-700 text-xs">
                <i class="fas fa-angle-right mr-2"></i>
                <span>form surat keputusan</span>
            </a>
            <a href="#list_sk" class="pt-2 pb-2 text-zinc-500 hover:text-zinc-700 text-xs">
                <i class="fas fa-angle-right mr-2"></i>
                <span>daftar surat keputusan</span>
            </a>
        </div>
        <?php } ?>
        <?php if ($previlege == 'admin') { ?>
        <div
            class="mt-5 p-3 flex items-center rounded-xl cursor-pointer"
            onclick="showEditInformation();">
            <div
                class="bg-indigo-900 w-8 h-8 flex justify-center items-center mr-3 rounded-md">
                <i class="fas fa-info-circle text-white text-md"></i>
            </div>
            <span class="text-indigo-900">Information</span>
        </div>
        <?php } ?>
        <a
            href="<?= base_url("/update_profile"); ?>"
            <?= ($previlege != 'nonasn') ? "onclick='showEditProfAdmin(this,event);'" :"" ?>
            class="<?= ($title=='update profile') ? 'bg-gray-300 sm:bg-white shadow-md' : ''?> mt-5 p-3 flex items-center rounded-xl">
            <div
                class="bg-indigo-900 w-8 h-8 flex justify-center items-center mr-3 rounded-md">
                <i class="fas fa-user text-white text-md"></i>
            </div>
            <span class="text-indigo-900">Profile</span>
        </a>
        <hr class="mt-5 border-t border-gray-400">
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