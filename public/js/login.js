
$('#form_login').on('submit', function(e) {
    e.preventDefault();

    if (validateLogin()) {
        let formLogin = new FormData(e.target);

        // for (let index = 0; index < 20; index++) {
        //     axios
        //     .post(`${BASE_URL}/login/create`,formLogin, {})
        //     .then(() => {})
        //     .catch((error) => {})
        // }
        // return 0;

        showLoadingSpinner();

        axios
        .post(`${BASE_URL}/login/create`,formLogin, {
            headers: {
                // header options 
            }
        })
        .then((response) => {
            hideLoadingSpinner();
            
            let url = BASE_URL;
            if (LASTURL != '' && LASTURL != 'null' && LASTURL != null) {
                url = LASTURL;
            }

            document.cookie = `token=${response.data.data.token}; path=/;SameSite=None; Secure`;
            window.location.replace(url);
        })
        .catch((error) => {
            hideLoadingSpinner();

            // error email/password
            if (error.response.status == 400) {
                showAlert({
                    message:error.response.data.message,
                    type:"warning",
                    autohide:true
                })
            }
            // server error
            else if (error.response.status == 500){
                showAlert({
                    message: `<strong>Ups . . .</strong> terjadi kesalahan, coba sekali lagi!`,
                    type:'danger' ,
                    autohide: true,
                })
            }
        })
    }
})

function validateLogin() {
    let status = true;

    // clear error message first
    $('#username_wraper').addClass('border-zinc-400');
    $('.label_fly').removeClass('border-red-500');

    // email validation
    if ($('#username').val() == '') {
        $('#username_wraper').removeClass('border-zinc-400');
        $('#username_wraper').addClass('border-red-500');
        status = false;
    }
    // password validation
    if ($('#password').val() == '') {
        $('#password_wraper').removeClass('border-zinc-400');
        $('#password_wraper').addClass('border-red-500');
        status = false;
    }

    return status;
}