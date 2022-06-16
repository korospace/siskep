/**
 * Get Data Profile
 */
async function fillInputForm(updateVarPass = true) {
    let httpResponse = await httpRequestGet(`${BASE_URL}/user/profile`);

    if (httpResponse.status === 200) {
        let data = httpResponse.data.data;

        if (updateVarPass) {
            PASSWORD = data.password;
        }
        
        $("#username_profile").html(data.username);
        $("#id_profile").html("id: "+data.id);
        $(`#data_wraper #data_status`).html(data.status);
        $(`#data_wraper #data_penempatan`).html(data.bagian+" | "+data.subagian);
        $(`#data_wraper #data_kedudukan`).html(data.kedudukan);
        $(`#data_wraper #data_income`).html("Rp "+data.income.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ","));
        $(`#data_wraper #data_masa_kerja`).html(data.masa_kerja+" tahun");
        $(`#data_wraper #data_nik`).html(data.nik);
        $(`#data_wraper #data_npwp`).html(data.npwp);
        $(`#data_wraper #data_email`).html(data.email);
        $(`#data_wraper #data_notelp`).html(data.notelp);
        $(`#data_wraper #data_nama_lengkap`).html(data.nama_lengkap);
        $(`#data_wraper #data_alamat`).html(data.alamat);
        $(`#data_wraper #data_tgl_lahir`).html(data.tgl_lahir);
        $(`#data_wraper #data_kelamin`).html(data.kelamin);
        $(`#data_wraper #data_agama`).html(data.agama);
        $(`#data_wraper #data_pendidikan`).html(data.pendidikan);
        
        for (const key in data) {
            if (key=="tgl_lahir") {
                let tglLahir = data[key].split('-');
                $(`#update_profile #${key}_uprof`).val(`${tglLahir[2]}-${tglLahir[1]}-${tglLahir[0]}`);
            }
            else if (key=="password") {
                $(`#update_profile #${key}_uprof`).val(PASSWORD);
            }
            else{
                $(`#update_profile #${key}_uprof`).val(data[key]);
            }    
        }        
    }

}
fillInputForm();

$("#btn_show_form").on("click", function () {
    $("#title").html("update information");
    $("#btn_show_form").toggleClass("hidden");
    $("#data_wraper").toggleClass("hidden grid");
    $("#inputs_wraper").toggleClass("hidden grid");
    $("#btn_wraper").toggleClass("hidden flex");
})

$("#btn_hide_form").on("click", function () {
    $("#title").html("personal information");
    $("#btn_show_form").toggleClass("hidden");
    $("#data_wraper").toggleClass("hidden grid");
    $("#inputs_wraper").toggleClass("hidden grid");
    $("#btn_wraper").toggleClass("hidden flex");
})

/**
 * Form On Submit
 */
 $('#update_profile').on('submit', async function(e) {
    e.preventDefault();

    // clear error message first
    $('.label_fly').addClass('border-zinc-400 focus-within:border-zinc-600');
    $('.label_fly').removeClass('border-red-500 focus-within:border-red-500');

    let form   = new FormData(e.target);
    let newTgl = form.get('tgl_lahir').split('-');
    form.set('tgl_lahir',`${newTgl[2]}-${newTgl[1]}-${newTgl[0]}`)

    showLoadingSpinner();
    $("#btn_simpan_uprof #text").toggleClass("hidden inline");
    $("#btn_simpan_uprof #spinner").toggleClass("inline hidden");
    
    let httpResponse = await httpRequestPut(`${BASE_URL}/user/update_profile`,form);

    hideLoadingSpinner();
    $("#btn_simpan_uprof #text").toggleClass("hidden inline");
    $("#btn_simpan_uprof #spinner").toggleClass("inline hidden");

    if (httpResponse.status === 201) {
        let newDataProfile = {};

        for (var pair of form.entries()) {
            if (pair[0] == "new_password") {
                newDataProfile["password"] = pair[1];
            } else {
                newDataProfile[pair[0]] = pair[1];
            }
        }

        localStorage.setItem("data_profile",JSON.stringify(newDataProfile));
        fillInputForm(false);
        
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
            $(`#update_profile #${key}_wraper_uprof`).removeClass('border-zinc-400 focus-within:border-zinc-600');
            $(`#update_profile #${key}_wraper_uprof`).addClass('border-red-500 focus-within:border-red-500');
        }
        
        showAlert({
            message: `<ul class="list-disc list-inside">${msgList}</ul>`,
            autohide: true,
            type:'warning'
        })
    }
})

// function validateUpdateProfile() {
//     let status = true;

//     // clear error message first
//     $('.label_fly').addClass('border-zinc-400 focus-within:border-zinc-600');
//     $('.label_fly').removeClass('border-red-500 focus-within:border-red-500');

//     $('#update_profile .validate').each(function() {
//         if ($(this).val() == "") {
//             console.log($(this));
//             $(this).parent().removeClass('border-zinc-400 focus-within:border-zinc-600');
//             $(this).parent().addClass('border-red-500 focus-within:border-red-500');
//             status = false;
//         }
//     })

//     return status;
// }