<?= $this->extend('Layout/template') ?>

<!-- Css -->
<?= $this->section('contentCss'); ?>

<?= $this->endSection(); ?>

<!-- JS -->
<?= $this->section('contentJs'); ?>
    <script src="<?= base_url('js/update_profile.js'); ?>"></script>
<?= $this->endSection(); ?>

<!-- Html -->
<?= $this->section('contentHtml'); ?>

    <div
      id="container" 
      style="background-image: url('<?= base_url('images/bg.webp'); ?>');"
      class="h-screen bg-cover bg-no-repeat"
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
              class="flex-1 max-h-screen overflow-auto pl-4 sm:pl-6 pr-4 py-5">
                <!-- nav bar -->
                <?= $this->include('Components/Navbar'); ?>
                
                <form
                  id="update_profile"
                  class="h-max overflow-auto mt-10 backdrop-blur-md rounded-xl shadow-lg">
                  <div
                    class="px-5 pt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 grid-rows-11 md:grid-rows-6 lg:grid-rows-3 gap-x-4 gap-y-10 md:gap-y-12">
                      <!-- Username -->
                      <div
                        id="username_wraper"
                        class="label_fly w-full h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
                          <input
                          id="username" type="text" name="username" placeholder="username" autocomplete="off" 
                          class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md" />
                          <label 
                          for="username" 
                          class="px-4 py-2 absolute top-0 text-zinc-400 duration-300 origin-0 cursor-text">
                              username
                          </label>
                      </div>
  
                      <!-- new_password -->
                      <div
                        id="new_password_wraper"
                        class="label_fly w-full h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
                          <input
                          id="password" type="password" name="new_password" placeholder="password" autocomplete="off" 
                          class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md" />
                          <label 
                          for="password" 
                          class="px-4 py-2 absolute top-0 text-zinc-400 duration-300 origin-0 cursor-text">
                              password
                          </label>
                      </div>
  
                      <!-- email -->
                      <div
                        id="email_wraper"
                        class="label_fly w-full h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
                          <input
                          id="email" type="email" name="email" placeholder="email" autocomplete="off" 
                          class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md" />
                          <label 
                          for="email" 
                          class="px-4 py-2 absolute top-0 text-zinc-400 duration-300 origin-0 cursor-text">
                              email
                          </label>
                      </div>
  
                      <!-- nama_lengkap -->
                      <div
                      id="nama_lengkap_wraper"
                      class="label_fly w-full h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
                          <input
                          id="nama_lengkap" type="text" name="nama_lengkap" placeholder="nama_lengkap" autocomplete="off" 
                          class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md" />
                          <label 
                          for="nama_lengkap" 
                          class="px-4 py-2 absolute top-0 text-zinc-400 duration-300 origin-0 cursor-text">
                              nama lengkap
                          </label>
                      </div>
  
                      <!-- nik -->
                      <div
                      id="nik_wraper"
                      class="label_fly w-full h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
                          <input
                          id="nik" type="text" name="nik" placeholder="nik" autocomplete="off" 
                          class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md" />
                          <label 
                          for="nik" 
                          class="px-4 py-2 absolute top-0 text-zinc-400 duration-300 origin-0 cursor-text">
                              nik
                          </label>
                      </div>
  
                      <!-- pendidikan -->
                      <div
                      id="pendidikan_wraper"
                      class="label_fly w-full h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
                          <input
                          id="pendidikan" type="text" name="pendidikan" placeholder="pendidikan" autocomplete="off" 
                          class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md" />
                          <label 
                          for="pendidikan" 
                          class="px-4 py-2 absolute top-0 text-zinc-400 duration-300 origin-0 cursor-text">
                              pendidikan
                          </label>
                      </div>
  
                      <!-- notelp -->
                      <div
                      id="notelp_wraper"
                      class="label_fly w-full h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
                          <input
                          id="notelp" type="text" name="notelp" placeholder="notelp" autocomplete="off" 
                          class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md" />
                          <label 
                          for="notelp" 
                          class="px-4 py-2 absolute top-0 text-zinc-400 duration-300 origin-0 cursor-text">
                              nomor telepon
                          </label>
                      </div>
  
                      <!-- alamat -->
                      <div
                      id="alamat_wraper"
                      class="label_fly w-full h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
                          <input
                          id="alamat" type="text" name="alamat" placeholder="alamat" autocomplete="off" 
                          class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md" />
                          <label 
                          for="alamat" 
                          class="px-4 py-2 absolute top-0 text-zinc-400 duration-300 origin-0 cursor-text">
                              alamat
                          </label>
                      </div>
                      
                      <!-- agama -->
                      <div
                      id="agama_wraper"
                      class="label_fly w-full h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
                          <select
                          id="agama" type="text" name="agama" placeholder="agama" autocomplete="off" 
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
                          class="px-4 py-2 absolute z-0 px-1.5 py-0 text-zinc-600 transform scale-75 -top-7 cursor-text">
                              agama
                          </label>
                      </div>
  
                      <!-- kelamin -->
                      <div
                      id="kelamin_wraper"
                      class="label_fly w-full h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
                          <select
                          id="kelamin" type="text" name="kelamin" placeholder="kelamin" autocomplete="off" 
                          class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md" >
                              <option value="">-- pilih kelamin --</option>
                              <option value="laki-laki">laki-laki</option>
                              <option value="perempuan">perempuan</option>
  
                          </select>
                          <label 
                          for="kelamin" 
                          class="px-4 py-2 absolute z-0 px-1.5 py-0 text-zinc-600 transform scale-75 -top-7 cursor-text">
                              kelamin
                          </label>
                      </div>
  
                      <!-- tgl_lahir -->
                      <div
                      id="tgl_lahir_wraper"
                      class="label_fly w-full h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
                          <input
                          id="tgl_lahir" type="date" name="tgl_lahir" placeholder="tgl_lahir" autocomplete="off" 
                          class="validate block px-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md"/>
                          <label 
                          for="tgl_lahir" 
                          class="px-4 py-2 absolute z-0 px-1.5 py-0 text-zinc-600 transform scale-75 top-0 cursor-text">
                              tanggal lahir
                          </label>
                      </div>
                  </div>
                  <div
                   class="mt-8 px-5 pb-8">
                        <button class="w-full px-10 py-2 bg-emerald-400 active:bg-emerald-600 text-white rounded-md">
                            simpan
                        </button>
                  </div>
                </form>
            </main>
        </div>
    </div>
	
<?= $this->endSection(); ?>