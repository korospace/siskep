<?= $this->extend('Layout/template') ?>

<!-- Css -->
<?= $this->section('layoutCss'); ?>
    
<?= $this->endSection(); ?>

<!-- JS -->
<?= $this->section('jsComponent'); ?>
    <script>
        function showAlert(data) {
            $('#alert').removeClass('alert-success alert-danger alert-warning alert-info');
            $('#alert #message').html(data.message);
            $('#alert').removeClass(`none -z-1 -translate-y-4 opacity-0`);
            $('#alert').addClass(`flex z-70 alert-${data.type}`);
            if (data.autohide) {
                setTimeout(() => {
                    close();
                }, 5000);    
            }     
        }

        function close() {
            $('#alert').addClass(`none -z-1 -translate-y-4 opacity-0`);
            setTimeout(() => {
                $('#alert').removeClass('alert-success alert-danger alert-warning alert-info flex z-70');
            }, 1000);
        }

        document.querySelector("#close").addEventListener("click",() => {
            close();
        });
        
        if(!navigator.onLine){
            showAlert({
                message: `<strong>Ups . . .</strong> koneksi anda terputus!`,
                autohide: false,
                type:'danger'
            })
        }
        window.onoffline = () => {
            showAlert({
                message: `<strong>Ups . . .</strong> koneksi anda terputus!`,
                autohide: false,
                type:'danger'
            })
        };
        window.ononline = () => {
            close();
        };
    </script>
<?= $this->endSection(); ?>

<?= $this->section('layoutHtml'); ?>
  <div
    id="alert" 
    class="none justify-between items-start fixed z-70 top-0 left-0 right-0 p-4 transition transform -translate-y-4 opacity-0 rounded-md">
      <span class="text-lg" id="message">lorem</span>
      <span
        id="close" 
        class="text-gray-500 text-2xl cursor-pointer">
          &times;
      </span>
  </div>
<?= $this->endSection(); ?>