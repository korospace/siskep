let webUrl      = window.location.href;
document.cookie = `lasturl=${webUrl}; path=/;SameSite=None; Secure`;

/**
 * Toggle Nav
 */
$('#toggle_nav').on('click', function(e) {
    $('#aside_wraper aside').toggleClass("-translate-x-80");
})

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