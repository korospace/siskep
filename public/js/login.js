$('#form_login').on('submit', function(e) {
    e.preventDefault();

    if (validateLogin()) {
        showLoadingSpinner();
        let formLogin = new FormData(e.target);

        axios
        .post(`${BASE_URL}/login/create`,formLogin, {
            headers: {
                // header options 
            }
        })
        .then((response) => {
            hideLoadingSpinner();

            document.cookie = `token=${response.data.data.token}; path=/;SameSite=None; Secure`;
            window.location.replace(`${BASE_URL}/dashboard`);
        })
        .catch((error) => {
            hideLoadingSpinner();

            // error email/password
            if (error.response.status == 400) {
                showAlert({
                    message:"<b>Username</b> atau <b>Password</b> salah!",
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
    $('.label_fly').removeClass('border-red-500');

    // email validation
    if ($('#username').val() == '') {
        $('#username_wraper').addClass('border-2 border-red-500');
        status = false;
    }
    // password validation
    if ($('#password').val() == '') {
        $('#password_wraper').addClass('border-2 border-red-500');
        status = false;
    }

    return status;
}