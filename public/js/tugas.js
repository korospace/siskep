/**
 * Get list of Tugas
 */
let arrTugas = [];
async function getTugas() {
    $("#list_tugas #body_main").html("");
    $("#list_tugas #body_skeleton").removeClass("hidden");
    $("#list_tugas #body_main").addClass("hidden"); 

    let httpResponse = await httpRequestGet(`${BASE_URL}/tugas/show`);

    $("#list_tugas #body_skeleton").addClass("hidden");
    $("#list_tugas #body_main").removeClass("hidden"); 

    if (httpResponse.status === 200) {
        arrTugas = httpResponse.data.data;
        createRowTugas(arrTugas);

        if (PREVILEGE != "nonasn") {
            filterTugas();
        }
    }
}
getTugas();

/**
 * Get detail tugas
 */
async function getDetailTugas(tugasId) {
    $('#crud_tugas #header_status').html("");
    $('#crud_tugas #header_status').attr("class",false);
    $('#parent_file_wraper').addClass('hidden');

    $('.label_fly').addClass('py-4 bg-zinc-400 animate-pulse');
    $('.label_fly >* ').addClass('hidden');
    $('#komentar_wraper').addClass('min-h-44');
    
    let httpResponse = await httpRequestGet(`${BASE_URL}/tugas/show/${tugasId}`);

    $('.label_fly').removeClass('py-4 bg-zinc-400 animate-pulse');
    $('.label_fly >* ').removeClass('hidden');
    $('#komentar_wraper').removeClass('min-h-44');

    if (httpResponse.status == 200) {
        let data = httpResponse.data.data;

        let classStatus = "text-xs ml-2 w-max px-1.5 py-1 rounded-sm ";
        if (data.status == "tugas baru") {
            classStatus += "text-white bg-sky-300";
        }
        else if (data.status == "revisi") {
            classStatus += "text-red-600 bg-red-200";
        }
        else if (data.status == "pengecekan") {
            classStatus += "text-yellow-600 bg-amber-200";
        }
        else if (data.status == "diterima") {
            classStatus += "text-green-600 bg-emerald-200";
        }

        $('#crud_tugas #header_status').addClass(classStatus);
        $('#crud_tugas #header_status').html(data.status);
        $('#crud_tugas #tugas_id').val(data.id_tugas);
        $('#crud_tugas #title_tugas').val(data.title);
        $('#crud_tugas #status_tugas').val(data.status);

        let komentar = (data.komentar != null) ? data.komentar : "";  
        
        if (komentar.replace(/(<([^>]+)>)/ig,"") != "") {
            $("#editor_komentar .ql-editor").html(data.komentar);
        }
        else {
            $('#komentar_wraper').addClass('hidden');
        }

        if (data.file_tugas.length != 0) {
            let el = "";
            $('#parent_file_wraper').removeClass('hidden');
            
            data.file_tugas.forEach(e => {
                let fileName = e.file_tugas.split("/");
                fileName     = fileName[fileName.length-1];

                el += `<div
                    class="w-full h-max mt-3 px-4 py-2 flex items-center justify-between relative border-b border-zinc-400">
                    <div class="text-xs text-zinc-600">
                        <span style="display: -webkit-box;-webkit-line-clamp: 1;-webkit-box-orient: vertical;overflow: hidden;text-overflow: ellipsis;">
                            ${fileName}
                        </span>
                    </div>
                    <div class="flex items-center ml-4">
                        <div class="px-1.5 pt-1.5 pb-1 bg-red-400 hover:bg-red-500 active:bg-red-600 text-white rounded-sm cursor-pointer"
                        onclick="deleteFile('${tugasId}','${e.id_file}')">
                            <i class="fas fa-trash text-sm"></i>
                        </div>
                        <a href="${e.file_tugas}" target="_blank" class="ml-3 text-zinc-600 hover:text-zinc-800">
                            <i class="fas fa-download text-sm"></i>
                        </a>
                    </div>
                </div>`;
            })

            $('#file_wraper').html(el);

        } 
    }

}

// create row tugas
function createRowTugas(data) {
    let list = "";

    data.forEach(e => {
        let date = timeCreation(e.created_at);

        let colorStatus = "";
        if (e.status == "tugas baru") {
            colorStatus = "text-white bg-sky-300";
        }
        else if (e.status == "revisi") {
            colorStatus = "text-red-600 bg-red-200";
        }
        else if (e.status == "pengecekan") {
            colorStatus = "text-yellow-600 bg-amber-200";
        }
        else if (e.status == "diterima") {
            colorStatus = "text-green-600 bg-emerald-200";
        }

        list += `<div class="flex justify-between pt-4 pb-4 px-4 border-b border-zinc-300 cursor-pointer hover:bg-zinc-300">
        <div class="flex-1" onclick="showCrudTugas('detil tugas','${e.id_tugas}')">
            <p class="flex items-center text-xs text-zinc-500">
                <i class="fas fa-clock mr-2"></i>
                <span>${date.month},${date.day} ${date.year} ${date.time}</span>
            </p>
            <p class="${PREVILEGE == "nonasn" ? "hidden" : ''} mt-2 flex items-center text-xs text-zinc-500">
                <i class="fas fa-user-alt mr-2"></i>
                <span>${e.nama_lengkap}</span>
            </p>
            <p class="text-xs mt-2 w-max px-1.5 py-1 rounded-sm ${colorStatus}">
                ${e.status}
            </p>
            <h1 class="text-xl text-zinc-700 mt-4">
                <span style="display: -webkit-box;-webkit-line-clamp: 2;-webkit-box-orient: vertical;overflow: hidden;text-overflow: ellipsis;">
                    ${e.title}
                </span>
            </h1>
        </div>
        <div class="flex flex-col justify-center items-center ml-4">
            <div class="px-2 pt-2 pb-1 bg-red-400 hover:bg-red-500 active:bg-red-600 text-white rounded-md cursor-pointer"
            onclick="deleteTugas('${e.id_tugas}')">
                <i class="fas fa-trash text-md"></i>
            </div>
        </div>
      </div>`;
    })

    $("#list_tugas #body_main").html(list);
}

// show popup
function showCrudTugas(title = null,tugasId = null) {
    $('#crud_tugas .title_popup').html(title);
    $('#crud_tugas #header_status').html("");
    $('#crud_tugas #header_status').attr("class",false);
    $('#parent_file_wraper').addClass('hidden');

    $('#bg_crud_tugas').removeClass('-z-1');
    $('#bg_crud_tugas').addClass('z-50 flex');
    setTimeout(() => {
        $('#bg_crud_tugas').removeClass('opacity-0');
        $('#crud_tugas').removeClass('scale-75');
    }, 50);

    if (tugasId != null) {
        $('#user_id_wraper').addClass('hidden');
        $('#user_id_tugas').removeClass('validate');
        $('#status_wraper').removeClass('hidden');
        $('#status_tugas').addClass('validate');
        $('#komentar_wraper').removeClass('hidden');

        if (PREVILEGE == "nonasn") {
            quilKomentar.enable(false);
        }
        else {
            quilKomentar.enable(true);
        }
        getDetailTugas(tugasId);
    }
    else if (title == "tambah tugas" && PREVILEGE != "nonasn") {
        $('#user_id_wraper').removeClass('hidden');
        $('#user_id_tugas').addClass('validate');
        $('#status_wraper').addClass('hidden');
        $('#status_tugas').removeClass('validate');
        $('#komentar_wraper').removeClass('hidden');
    }
    else{
        $('#komentar_wraper').addClass('hidden');
    }
}

// hide popup
function hideCrudTugas() {
    $('#crud_tugas').addClass('scale-75');
    $('#bg_crud_tugas').addClass('opacity-0');
    setTimeout(() => {
        $('#bg_crud_tugas').removeClass('z-50 flex');
        $('#bg_crud_tugas').addClass('-z-1');
    }, 500);
}

// btn close
$("#close_popup_crudtugas").on("click",() => {
    hideCrudTugas();
    clearForm();
});

// quiljs
let quilKomentar = new Quill(`#editor_komentar`, {
    modules: {
        formula: true,
        syntax: true,
        toolbar: (PREVILEGE == "nonasn") ? false : "#toolbar_komentar"
    },
    theme: 'snow'
});

/**
 * tambah input file
 */
const tambahInputFile = () => {
    let totalBaris = $('.baris_input_file').size();

    let elementRow = `<div
      id="file_tugas_wraper"
      class="label_fly w-full h-max flex items-center justify-between relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
        <input
          id="file_tugas" type="file" name="file_tugas[${totalBaris++}]" placeholder="file_tugas" autocomplete="off" 
          class="validate_file text-sm block pl-4 py-2 w-full appearance-none focus:outline-none transition-all bg-white text-zinc-600 rounded-md"/>
        <span
          class="bg-white px-4 text-gray-500 text-md cursor-pointer"
          onclick="hapusInputFile(this);">
            &times;
        </span>
    </div>`

    let tr = document.createElement('div');
    tr.classList.add('baris_input_file');
    tr.classList.add('w-full');
    tr.classList.add('mt-3');
    
    tr.innerHTML=elementRow;
    document.querySelector('#input_file_wraper').insertBefore(tr,document.querySelector('#special_dic'));
}
tambahInputFile();

/**
 * hapus input file
 */
const hapusInputFile = (el) => {
    if ($('.baris_input_file').size() > 1) {
        el.parentElement.parentElement.remove();
    }
}

/**
 * Form Submit
 */
$('#crud_tugas').on('submit', async function(e) {
    e.preventDefault();
    let title = $('#crud_tugas .title_popup').html();

    if (validateCrudTugas(title)) {
        let form = new FormData(e.target);
        let tugasId = form.get('id');

        if (PREVILEGE != "nonasn") {
            form.append("komentar",$(`#editor_komentar .ql-editor`).html());
        }

        $("#btn_simpan_crudtugas #text").toggleClass("hidden inline");
        $("#btn_simpan_crudtugas #spinner").toggleClass("inline hidden");

        let httpResponse = "";

        $(".validate_file").each(function() {
            if ($(this).val() == "") {
                form.delete($(this).attr("name"));
            }
        })

        if (tugasId == "") {
            httpResponse = await httpRequestPost(`${BASE_URL}/tugas/create`,form);
        } 
        else {
            httpResponse = await httpRequestPut(`${BASE_URL}/tugas/update/`+tugasId,form);
        }
        
        $("#btn_simpan_crudtugas #text").toggleClass("hidden inline");
        $("#btn_simpan_crudtugas #spinner").toggleClass("inline hidden");

        if (httpResponse.status === 201) {            
            if (tugasId == "") {
                urutan  = "terbaru";
                clearForm();
            } 
            else {
                $('.baris_input_file').remove();
                getDetailTugas(tugasId);
                tambahInputFile();
            }

            getTugas();

            showAlert({
                message: `<strong>Success...</strong> tugas berhasil ${tugasId == "" ? "dibuat" : "diupdate"}!`,
                autohide: true,
                type:'success'
            })
        }
        else if (httpResponse.status === 400) {
            let msgList = ``;
        
            for (const key in httpResponse.message) {
                msgList += `<li>${httpResponse.message[key]}</li>`;
                $(`#form_sk #${key}_wraper`).removeClass('border-zinc-400 focus-within:border-zinc-600');
                $(`#form_sk #${key}_wraper`).addClass('border-red-500 focus-within:border-red-500');
            }
            
            showAlert({
                message: `<ul class="list-disc list-inside">${msgList}</ul>`,
                autohide: true,
                type:'warning'
            })
        }
    }
})

const validateCrudTugas = (title) => { 
    let status = true;

    // clear error message first
    $('.label_fly').addClass('border-zinc-400 focus-within:border-zinc-600');
    $('.label_fly').removeClass('border-red-500 focus-within:border-red-500');

    $('#crud_tugas .validate').each(function() {
        let isEmpty = $(this).val() == "";

        if (isEmpty) {
            console.log($(this));
            $(this).parent().removeClass('border-zinc-400 focus-within:border-zinc-600');
            $(this).parent().addClass('border-red-500 focus-within:border-red-500');
            status = false;
        }
    })

    if (title == "tambah tugas" && PREVILEGE == "nonasn") {
        $('#crud_tugas .validate_file').each(function() {
            let isEmpty = $(this).val() == "";
    
            if (isEmpty) {
                $(this).parent().removeClass('border-zinc-400 focus-within:border-zinc-600');
                $(this).parent().addClass('border-red-500 focus-within:border-red-500');
                status = false;
            }
        })  
    }
    return status;
}

/**
 * Clean Form
 */
const clearForm = () => {
    $("#tugas_id").val("");
    $(".validate").val("");
    $("#editor_komentar .ql-editor").html("<p></p>");

    $('.baris_input_file').remove();
    tambahInputFile();
}

/**
 * Delete File
 */
function deleteFile(idTugas,idFile) {
    Swal.fire({
        title: 'DELETE FILE',
        text: "Anda yakin menghapus file ini?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'iya',
        cancelButtonText: 'tidak',
        showLoaderOnConfirm: true,
        preConfirm: () => {
          return httpRequestDelete(`${BASE_URL}/tugas/delete_file/${idFile}`)
          .then((e) => {
            if (e.status == 201) {
                getDetailTugas(idTugas);
            }
          })
        },
        allowOutsideClick: () => !Swal.isLoading()
    })
}

/**
 * Delete Tugas
 */
function deleteTugas(id) {
    Swal.fire({
        title: 'DELETE TUGAS',
        text: "Anda yakin menghapus tugas ini?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'iya',
        cancelButtonText: 'tidak',
        showLoaderOnConfirm: true,
        preConfirm: () => {
          return httpRequestDelete(`${BASE_URL}/tugas/delete/${id}`)
          .then((e) => {
            if (e.status == 201) {
                getTugas();
            }
          })
        },
        allowOutsideClick: () => !Swal.isLoading()
    })
}

/**
 * Filter tugas
 */
// show popup
function showFilterTugas() {
    $('#bg_filter_tugas').removeClass('-z-1 none');
    $('#bg_filter_tugas').addClass('z-50 flex');
    setTimeout(() => {
        $('#bg_filter_tugas').removeClass('opacity-0');
        $('#filter_tugas').removeClass('scale-75');
    }, 50);
}

// hide popup
function hideFilterTugas() {
    $('#filter_tugas').addClass('scale-75');
    $('#bg_filter_tugas').addClass('opacity-0');
    setTimeout(() => {
        $('#bg_filter_tugas').removeClass('z-50 flex');
        $('#bg_filter_tugas').addClass('-z-1 none');
    }, 500);
}

// btn close
$("#close_popup_filtug").on("click",() => {
    hideFilterTugas();
});

// filter on submit
let tmpArrTugas = [];
let urutan      = "terbaru";
let userId      = "semua pegawai";
$('#filter_tugas').on('submit', async function(e) {
    e.preventDefault();
    // let form = new FormData(document.querySelector("#filter_tugas"));
    let form = new FormData(e.target);
    urutan   = form.get("urutan");
    userId   = form.get("pegawai");
    filterTugas();
})

function filterTugas() {
    let namaPegawai = "";

    if (urutan == "terbaru") {
        tmpArrTugas = arrTugas.sort(function(a,b){
            return parseInt(b.created_at) - parseInt(a.created_at);
        });
    }
    else {
        tmpArrTugas = arrTugas.sort(function(a,b){
            return parseInt(a.created_at) - parseInt(b.created_at);
        });
    }

    if (userId == "semua pegawai") {
        namaPegawai = "semua pegawai";
        tmpArrTugas = arrTugas;
    }
    else{
        tmpArrTugas = arrTugas.filter(t => {
            if (t.user_id == userId) {
                namaPegawai = t.nama_lengkap;
                return t;
            }
        });
    }

    console.log(urutan,userId,namaPegawai,tmpArrTugas);
    hideFilterTugas();
    createRowTugas(tmpArrTugas);
    $("#status_filter").html(urutan+" - "+namaPegawai);
}