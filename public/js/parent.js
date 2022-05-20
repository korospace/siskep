let webUrl      = window.location.href;
document.cookie = `lasturl=${webUrl}; path=/;SameSite=None; Secure`;

/**
 * Toggle Nav
 */
$('#toggle_nav').on('click', function(e) {
    $('#aside_wraper aside').toggleClass("-translate-x-80");
})

/**
 * API REQUEST GET
 */
 const httpRequestGet = (url) => {

    return axios
        .get(url,{
            headers: {
                token: TOKEN
            }
        })
        .then((response) => {
            return {
                'status':200,
                'data':response.data
            };
        })
        .catch((error) => {
            // unauthorized
            if (error.response.status == 401) {
                if (error.response.data.messages == 'token expired') {
                    Swal.fire({
                        icon : 'error',
                        title : '<strong>LOGIN EXPIRED</strong>',
                        text: 'silahkan login ulang untuk perbaharui login anda',
                        showCancelButton: false,
                        confirmButtonText: 'ok',
                    }).then(() => {
                        document.cookie = `token=null;expires=;path=/;SameSite=None; Secure`;
                        window.location.replace(`${BASE_URL}/login`);
                    })
                }
                else{
                    document.cookie = `token=null;expires=;path=/;SameSite=None; Secure`;
                    window.location.replace(`${BASE_URL}/login`);
                }
            }
            // server error
            else if (error.response.status == 500){
                showAlert({
                    message: `<strong>Ups...</strong> terjadi kesalahan pada server, silahkan refresh halaman.`,
                    autohide: true,
                    type:'danger' 
                })
            }
            
            return {
                'status':error.response.status,
            };
        })
};

/**
 * API REQUEST PUT
 */
 const httpRequestPut = (url,form) => {
    let newForm = new FormData();

    for (var pair of form.entries()) {
        let noPair = ['username','new_password'];

        if (noPair.includes(pair[0]) == false) {
            // newForm.set(pair[0], pair[1].trim().toLowerCase());
            newForm.set(pair[0], pair[1].trim());
        }
        else{
            if (pair[1].type) {
                newForm.set(pair[0], pair[1], pair[1].name);
            } 
            else {
                newForm.set(pair[0], pair[1]);                
            }
        }
    }

    return axios
        .put(url,newForm, {
            headers: {
                token: TOKEN
            }
        })
        .then(() => {
            return {
                'status':201,
            };
        })
        .catch((error) => {
            // unauthorized
            if (error.response.status == 401) {
                if (error.response.data.messages == 'token expired') {
                    Swal.fire({
                        icon : 'error',
                        title : '<strong>LOGIN EXPIRED</strong>',
                        text: 'silahkan login ulang untuk perbaharui login anda',
                        showCancelButton: false,
                        confirmButtonText: 'ok',
                    }).then(() => {
                        document.cookie = `token=null;expires=;path=/;SameSite=None; Secure`;
                        window.location.replace(`${BASE_URL}/login`);
                    })
                }
                else{
                    document.cookie = `token=null;expires=;path=/;SameSite=None; Secure`;
                    window.location.replace(`${BASE_URL}/login`);
                }
            }
            // error server
            else if (error.response.status == 500){
                showAlert({
                    message: `<strong>Ups . . .</strong> terjadi kesalahan pada server, coba sekali lagi`,
                    autohide: true,
                    type:'danger'
                })
            }
            
            return {
                'status':error.response.status,
                'message':error.response.data.message
            };
        })
};

/**
* LOGOUT
*/
$('#btn_logout').on('click', function(e) {
    e.preventDefault();

    Swal.fire({
        title: 'LOGOUT',
        text: "Anda yakin ingin keluar dari dashboad?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'iya',
        cancelButtonText: 'tidak',
        showLoaderOnConfirm: true,
        preConfirm: () => {
            return axios
            .delete(`${BASE_URL}/login/delete`, {
                headers: {
                    token: TOKEN
                }
            })
            .then(() => {
                Swal.close();

                document.cookie = `token=null; path=/;SameSite=None; Secure`;
                document.cookie = `lasturl=null; path=/;SameSite=None; Secure`;
                window.location.replace(`${BASE_URL}/login`);
            })
            .catch(error => {
                // unauthorized
                if (error.response.status == 401) {
                    Swal.close();

                    document.cookie = `token=null; path=/;SameSite=None; Secure`;
                    document.cookie = `lasturl=null; path=/;SameSite=None; Secure`;
                    window.location.replace(`${BASE_URL}/login`);
                }
                // error server
                else if (error.response.status == 500) {
                    Swal.showValidationMessage(
                        `server error: coba sekali lagi!`
                    )
                }
            })
        },
        allowOutsideClick: () => !Swal.isLoading()
    })
})

// logout
function doLogout() {
    showLoadingSpinner();
    axios
        .delete(`${BASE_URL}/login/delete`, {
            headers: {
                token: TOKEN
            }
        })
        .then(() => {
            hideLoadingSpinner();
            document.cookie = `token=null; path=/;SameSite=None; Secure`;
            window.location.replace(`${BASE_URL}/login`);
        })
        .catch(error => {
            hideLoadingSpinner();
            document.cookie = `token=null; path=/;SameSite=None; Secure`;
            window.location.replace(`${BASE_URL}/login`);
        })
}