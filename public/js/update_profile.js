/**
 * Get Data Profile
 */
async function getDataProfile() {
    showLoadingSpinner();
    let httpResponse = await httpRequestGet(`${BASE_URL}/user/profile`);
    hideLoadingSpinner();
    
    if (httpResponse.status === 200) {
        let data = httpResponse.data.data;
        
        for (const key in data) {
            if (key=="tgl_lahir") {
                let tglLahir = data[key].split('-');
                $(`#${key}`).val(`${tglLahir[2]}-${tglLahir[1]}-${tglLahir[0]}`);
            }
            else if (key=="password") {
                $(`#${key}`).val(PASSWORD);
            }
            else{
                $(`#${key}`).val(data[key]);
            }
        }
    }
}

getDataProfile();

/**
 * Form On Submit
 */
 $('#update_profile').on('submit', async function(e) {
    e.preventDefault();

    if (validateUpdateProfile()) {
        let form   = new FormData(e.target);
        let newTgl = form.get('tgl_lahir').split('-');
        form.set('tgl_lahir',`${newTgl[2]}-${newTgl[1]}-${newTgl[0]}`)

        showLoadingSpinner();
        let httpResponse = await httpRequestPut(`${BASE_URL}/user/update_profile`,form);
        hideLoadingSpinner();

        if (httpResponse.status === 201) {
            showAlert({
                message: `<strong>Success...</strong> edit profile berhasil!`,
                autohide: true,
                type:'success'
            })

            if (form.get("new_password") !== PASSWORD) {
                setTimeout(() => {
                    Swal.fire({
                        icon  : 'info',
                        title : '<strong>INFO</strong>',
                        html  : 'Password telah diubah, silahkan login ulang',
                        showCancelButton: false,
                        confirmButtonText: 'ok',
                    })
                    .then(() => {
                        doLogout();
                    })
                }, 2000);
            }
        }
        else if (httpResponse.status === 400) {
            let msgList = ``;
            
            for (const key in httpResponse.message) {
                msgList += `<li>${httpResponse.message[key]}</li>`;
                $(`#update_profile #${key}_wraper`).removeClass('border-zinc-400 focus-within:border-zinc-600');
                $(`#update_profile #${key}_wraper`).addClass('border-red-500 focus-within:border-red-500');
            }
            
            showAlert({
                message: `<ul class="list-disc list-inside">${msgList}</ul>`,
                autohide: false,
                type:'warning'
            })
        }
    }
})

function validateUpdateProfile() {
    let status = true;

    // clear error message first
    $('.label_fly').addClass('border-zinc-400 focus-within:border-zinc-600');
    $('.label_fly').removeClass('border-red-500 focus-within:border-red-500');

    $('.validate').each(function() {
        if ($(this).val() == "") {
            $(this).parent().removeClass('border-zinc-400 focus-within:border-zinc-600');
            $(this).parent().addClass('border-red-500 focus-within:border-red-500');
            status = false;
        }
    })

    return status;
}