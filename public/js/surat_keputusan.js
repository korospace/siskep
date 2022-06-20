/**
 * tambah baris
 */
const tambahBaris = () => {
    let totalBaris = $('.baris_pegawai').size();
    let elementRow = `<td class="text-gray-400 p-1.5 border border-slate-300">
        <div
          class="flex justify-center items-center h-8 w-full px-3 bg-red-400 hover:bg-red-500 active:bg-red-600 text-sm text-white rounded-md cursor-pointer"
          onclick="hapusBaris(this);">
            <i class="fas fa-times"></i>
        </div>
    </td>
    <td class="hidden">
        <input
          type="hidden" 
          name="sk_detail[slot${totalBaris+1}][user_id]" 
          class="input_user_id" />
    </td>
    <td class="text-gray-400 p-1.5 border border-slate-300">
        <div
          class="label_fly w-max h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
            <select
              autocomplete="off" 
              class="select_pegawai validate block p-2 w-max max-w-10 h-8 focus:outline-none transition-all bg-white text-sm text-zinc-600 rounded-md" 
              onchange="pegawaiOnChange(this,event);"
            >
                ${optionPegawai}
            </select>
        </div>
    </td>
    <td class="text-gray-400 p-1.5 border border-slate-300">
        <div
          class="label_fly w-max h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
            <select
              name="sk_detail[slot${totalBaris+1}][id_bagian]" autocomplete="off" 
              class="select_bagian validate block p-2 w-max max-w-10 h-8 focus:outline-none transition-all bg-white text-sm text-zinc-600 rounded-md" 
              ${PREVILEGE != "kasubag" ? "onchange='bagianOnChange(this);'" : ""}
            >
                ${optionBagian}
            </select>
        </div>
    </td>
    <td class="text-gray-400 p-1.5 border border-slate-300">
        <div
          class="label_fly w-max h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
            <select
              name="sk_detail[slot${totalBaris+1}][id_subagian]" autocomplete="off" 
              class="select_subagian validate block p-2 w-max max-w-10 h-8 focus:outline-none transition-all bg-white text-sm text-zinc-600 rounded-md" 
              ${PREVILEGE != "kasubag" ? "disabled" : ""}
            >
                ${optionSubagian}
            </select>
        </div>
    </td>
    <td class="text-gray-400 p-1.5 border border-slate-300">
        <div
          class="label_fly w-max h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
            <select
              name="sk_detail[slot${totalBaris+1}][id_kedudukan]" autocomplete="off" 
              class="select_kedudukan validate block p-2 w-max max-w-10 h-8 focus:outline-none transition-all bg-white text-sm text-zinc-600 rounded-md" 
            >
                ${optionKedudukan}
            </select>
        </div>
    </td>
    <td class="text-gray-400 p-1.5 border border-slate-300">
        <div
          class="label_fly w-full h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
            <input
              type="number" name="sk_detail[slot${totalBaris+1}][masa_kerja]" 
              autocomplete="off" placeholder="0"
              class="input_masa_kerja validate block p-2 w-full h-8 focus:outline-none bg-white text-sm text-zinc-600 rounded-md" />
        </div>
    </td>
    <td class="text-gray-400 p-1.5 border border-slate-300">
        <div
          class="label_fly w-full h-max relative border-2 border-zinc-400 focus-within:border-zinc-600 rounded-md">
            <input
              type="number" name="sk_detail[slot${totalBaris+1}][income]"
              autocomplete="off" placeholder="0" 
              class="input_income validate block p-2 w-max max-w-10 h-8 focus:outline-none bg-white text-sm text-zinc-600 rounded-md"
              oninput="countTotalIncome()" />
        </div>
    </td>`

    let tr = document.createElement('tr');
    tr.classList.add('baris_pegawai');
    
    tr.innerHTML=elementRow;
    document.querySelector('#input_pegawai tbody').insertBefore(tr,document.querySelector('#special_tr'));
}
if (PREVILEGE != "nonasn") {
    tambahBaris();
}

/**
 * hapus baris
 */
const hapusBaris = (el) => {
    el.parentElement.parentElement.remove();
    countTotalIncome();
}


/**
 * bagian on change
 */
const pegawaiOnChange = (el,event) =>{
    let userId       = el.options[el.selectedIndex].value;
    let currentRow   = el.parentElement.parentElement.parentElement;
    let inputUserId  = currentRow.querySelector("input.input_user_id");
    let selectBagian = currentRow.querySelector("select.select_bagian");
    let selectSubagian  = currentRow.querySelector("select.select_subagian");
    let selectKedudukan = currentRow.querySelector("select.select_kedudukan");
    let inputMasaKerja  = currentRow.querySelector("input.input_masa_kerja");
    let inputIncome     = currentRow.querySelector("input.input_income");

    if (userId == "") {
        
    }
    else {
        let userSelected = arrUser.filter(e => e.id == userId);
        userSelected = userSelected[0];

        inputUserId.value     = userSelected.id;
        selectBagian.value    = (userSelected.id_bagian == null)    ? "" : userSelected.id_bagian;
        selectKedudukan.value = (userSelected.id_kedudukan == null) ? "" : userSelected.id_kedudukan;
        inputMasaKerja.value  = (userSelected.masa_kerja == null)   ? 0  : userSelected.masa_kerja;
        inputIncome.value     = (userSelected.income == null)       ? 0  : userSelected.income;
        
        if (PREVILEGE != "kasubag") {
            bagianOnChange(selectBagian);
        }
        selectSubagian.value  = (userSelected.id_subagian == null)    ? "" : userSelected.id_subagian;
        countTotalIncome();
    }
};

/**
 * bagian on change
 */
const bagianOnChange = (el = null,idBagian = null) =>{
    let bagValue   = idBagian == null ? el.options[el.selectedIndex].value : idBagian;
    optionSubagian = "<option value=''>-- pilih subagian --</option>"

    if (PREVILEGE == "admin" || PREVILEGE == "kabag") {    
        arrSubagian.forEach(e => {
            if (e.id_bagian == bagValue) {
                optionSubagian += `<option value="${e.id}">${e.name}</option>`;
            }
        });
    }
    else if (PREVILEGE == "kasubag") {
        optionSubagian += `<option value="${IDSUBAGIAN}">${SUBAGIAN}</option>`;
    }

    let elInputSubagian = el.parentElement.parentElement.nextElementSibling.children[0].children[0];
    elInputSubagian.innerHTML = optionSubagian;

    if (bagValue != '') {
        elInputSubagian.removeAttribute('disabled');
    } 
    else {
        elInputSubagian.setAttribute('disabled',true);
    }
};

/**
 * Count total income
 */
// count total harga sampah
const countTotalIncome = () =>{
    let total = 0;
    $(`.input_income`).each(function() {
        total = total + parseFloat($(this).val() == "" ? 0 : $(this).val());
    });

    $('#special_tr #total_income').html(total.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ","));
};

/**
 * Form Submit
 */
$('#form_sk').on('submit', async function(e) {
    e.preventDefault();
    
    if (validateCreateSk()) {
        let form   = new FormData(e.target);
        let newTgl = form.get('tgl_sk').split('-');
        form.set('tgl_sk',`${newTgl[2]}-${newTgl[1]}-${newTgl[0]}`);

        showLoadingSpinner();
        let httpResponse = await httpRequestPost(`${BASE_URL}/sk/create/`,form);
        hideLoadingSpinner();

        if (httpResponse.status === 201) {
            getDataSk();
            clearForm();
            getDataPegawai(false);

            showAlert({
                message: `<strong>Success...</strong> SK berhasil ditambah!`,
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

const validateCreateSk = () => { 
    let status = true;

    // clear error message first
    $('.label_fly').addClass('border-zinc-400 focus-within:border-zinc-600');
    $('.label_fly').removeClass('border-red-500 focus-within:border-red-500');

    $('#form_sk .validate').each(function() {
        let isEmpty = $(this).val() == "";

        if (isEmpty) {
            $(this).parent().removeClass('border-zinc-400 focus-within:border-zinc-600');
            $(this).parent().addClass('border-red-500 focus-within:border-red-500');
            status = false;
        }
    })

    return status;
}

/**
 * Clean Form
 */
const clearForm = () => {
    $('.baris_pegawai').remove();
    $(".validate").val("");
    tambahBaris();
    countTotalIncome();
}

/**
 * Get list of SK
 */
async function getDataSk() {
    $("#list_sk #body_main").html("");
    $("#list_sk #body_skeleton").removeClass("hidden");
    $("#list_sk #body_main").addClass("hidden"); 

    let httpResponse = await httpRequestGet(`${BASE_URL}/sk/show`);

    $("#list_sk #body_skeleton").addClass("hidden");
    $("#list_sk #body_main").removeClass("hidden"); 

    if (httpResponse.status === 200) {
        let list = "";
        let data = httpResponse.data.data;

        data.forEach(e => {
            list += `<div class="flex justify-between mb-4 pb-4 border-b border-zinc-300">
            <div>
                <p class="text-sm text-zinc-500 mb-1">no: ${e.no_sk}</p>
                <h1 class="text-xl text-zinc-700">
                    <span style="display: -webkit-box;-webkit-line-clamp: 2;-webkit-box-orient: vertical;overflow: hidden;text-overflow: ellipsis;">
                        ${e.title}
                    </span>
                </h1>
            </div>
            <div class="flex flex-col justify-center items-center ml-4">
                <div class="${PREVILEGE == "nonasn" ? "hidden" : ""} px-2 pt-2 pb-1 bg-red-400 hover:bg-red-500 active:bg-red-600 text-white rounded-md cursor-pointer"
                onclick="deleteSk('${e.no_sk}')">
                    <i class="fas fa-trash text-md"></i>
                </div>
                <a href="${e.file_sk}" target="_blank" class="mt-5 text-zinc-600 hover:text-zinc-800">
                    <i class="fas fa-download text-xl"></i>
                </a>
            </div>
          </div>`;
        })
    
        $("#list_sk #body_main").html(list);
    }
}
getDataSk();

/**
 * Delete SK
 */
 function deleteSk(noSk) {
    Swal.fire({
        title: 'DELETE SK',
        text: "Anda yakin menghapus SK ini?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'iya',
        cancelButtonText: 'tidak',
        showLoaderOnConfirm: true,
        preConfirm: () => {
          return httpRequestDelete(`${BASE_URL}/sk/delete/${noSk}`)
          .then((e) => {
            if (e.status == 201) {
                getDataPegawai(false);
                getDataSk();
            }
          })
        },
        allowOutsideClick: () => !Swal.isLoading()
    })
  }