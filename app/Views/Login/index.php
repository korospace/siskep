<?= $this->extend('Layout/template') ?>

<!-- Css -->
<?= $this->section('contentCss'); ?>

<?= $this->endSection(); ?>

<!-- JS -->
<?= $this->section('contentJs'); ?>
    <script src="<?= base_url('js/login.js'); ?>"></script>
<?= $this->endSection(); ?>

<!-- Html -->
<?= $this->section('contentHtml'); ?>

    <div
      id="container" 
      style="background-image: url('<?= base_url('images/bg.webp'); ?>');"
      class="h-screen bg-cover bg-no-repeat px-5 v-340:px-0 flex flex-col justify-center items-center"
      >
        <!-- **** Alert info **** -->
        <?= $this->include('Components/alertInfo'); ?>
        <!-- **** Loading Spinner ****  -->
        <?= $this->include('Components/loadingSpinner'); ?>
        
        <!-- Form Login START -->
        <form
          id="form_login"
          class="bg-white w-full v-340:w-max px-8 py-5 flex flex-col justify-center items-center border border-zinc-400 rounded-lg shadow-md">
            <div
              class="rounded-full w-24 h-24 p-5 shadow-md">
                <img
                  src="<?= base_url('images/logo-kemendagri.webp'); ?>" 
                  alt="logo kemendagri"
                  class="w-full">
            </div>
            <h1
             class="mt-5 text-center opacity-90">
                Sistem Kepegawaian Non ASN <br>
                Kementrian Dalam Negeri
            </h1>

            <div
              id="username_wraper"
              class="label_fly w-full v-340:w-64 relative mt-14 border-2 border-zinc-400 focus-within:border-zinc-600 rounded-xl">
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
              id="password_wraper"
              class="label_fly w-full v-340:w-64 relative mt-8 border-2 border-zinc-400 focus-within:border-zinc-600 rounded-xl">
                <input
                  id="password" type="password" name="password" placeholder="password" autocomplete="off" 
                  class="block px-5 py-3 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-xl" />
                <label 
                  for="password" 
                  class="px-5 py-3 absolute top-0 text-zinc-400 duration-300 origin-0 cursor-text">
                    password
                </label>
            </div>

            <button
             class="w-max mt-8 mb-2 px-10 py-2 bg-violet-500 text-white rounded-full">
                login
            </button>
        </form>
    </div>
	
<?= $this->endSection(); ?>