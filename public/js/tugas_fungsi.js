/**
 * Get data
 */
let arrSubagian = [];
async function getDataBagian() {
    $("#table_bagian_wraper #body_main").html("");
    $("#table_bagian_wraper #body_skeleton").removeClass("hidden");
    $("#table_bagian_wraper #body_main").addClass("hidden"); 

    let httpResponse = await httpRequestGet(`${BASE_URL}/bagian/show`);

    if (httpResponse.status === 200) {
        arrSubagian = httpResponse.data.data;
    }

    $("#table_bagian_wraper #body_skeleton").addClass("hidden");
    $("#table_bagian_wraper #body_main").removeClass("hidden"); 

    let list = "";
    
    arrSubagian.forEach((e,i) => {
        list += `<tr class="${(i%2==1) ? "bg-gray-200 hover:bg-gray-300" : "bg-gray-400 hover:bg-gray-500"} cursor-pointer">
        <td class="p-4 text-gray-800">
            ${++i}
        </td>
        <td class="p-4 text-gray-800">
            ${e.name}
        </td>
        <td class="p-4 flex flex-col items-center text-gray-800">
          <div
            class="w-16 mb-1 text-center py-1 rounded-md bg-amber-200 hover:bg-amber-400 text-yellow-700 text-xs cursor-pointer"
            onclick="showCrudBagian('edit bagian','${e.id}')">
              edit
          </div>
          <div class="w-16 mb-1 text-center py-1 rounded-md bg-red-200 hover:bg-red-400 text-red-700 text-xs cursor-pointer"
          onclick="deleteBagian('${e.id}','${e.name}')">
            delete
          </div>
        </td>
      </tr>`;
    })

    $("#table_bagian_wraper #body_main").html(list);
}

async function getDataSubagian() {
    $("#table_subagian_wraper #body_main").html("");
    $("#table_subagian_wraper #body_skeleton").removeClass("hidden");
    $("#table_subagian_wraper #body_main").addClass("hidden"); 
    
    let httpResponse = await httpRequestGet(`${BASE_URL}/subagian/show`);
    
    $("#table_subagian_wraper #body_skeleton").addClass("hidden");
    $("#table_subagian_wraper #body_main").removeClass("hidden"); 
    
    let data = httpResponse.data.data;
    let list = "";
    
    data.forEach((e,i) => {
        list += `<tr class="${(i%2==1) ? "bg-gray-200 hover:bg-gray-300" : "bg-gray-400 hover:bg-gray-500"} cursor-pointer">
        <td class="p-4 text-gray-800">
            ${++i}
        </td>
        <td class="p-4 text-gray-800">
            ${e.name}
        </td>
        <td class="p-4 text-gray-800">
            ${e.bagian}
        </td>
        <td class="p-4 flex flex-col items-center text-gray-800">
          <div
            class="w-16 mb-1 text-center py-1 rounded-md bg-amber-200 hover:bg-amber-400 text-yellow-700 text-xs cursor-pointer"
            onclick="showCrudSubagian('edit subagian','${e.id}')">
              edit
          </div>
          <div class="w-16 mb-1 text-center py-1 rounded-md bg-red-200 hover:bg-red-400 text-red-700 text-xs cursor-pointer"
          onclick="deleteSubagian('${e.id}','${e.name}')">
            delete
          </div>
        </td>
      </tr>`;
    })

    $("#table_subagian_wraper #body_main").html(list);
}

async function getDataKedudukan() {
    $("#table_kedudukan_wraper #body_main").html("");
    $("#table_kedudukan_wraper #body_skeleton").removeClass("hidden");
    $("#table_kedudukan_wraper #body_main").addClass("hidden"); 
    
    let httpResponse = await httpRequestGet(`${BASE_URL}/kedudukan/show`);
    
    $("#table_kedudukan_wraper #body_skeleton").addClass("hidden");
    $("#table_kedudukan_wraper #body_main").removeClass("hidden"); 
    
    let data = httpResponse.data.data;
    let list = "";
    
    data.forEach((e,i) => {
        list += `<tr class="${(i%2==1) ? "bg-gray-200 hover:bg-gray-300" : "bg-gray-400 hover:bg-gray-500"} cursor-pointer">
        <td class="p-4 text-gray-800">
            ${++i}
        </td>
        <td class="p-4 text-gray-800">
            ${e.name}
        </td>
        <td class="p-4 flex flex-col items-center text-gray-800">
          <div
            class="w-16 mb-1 text-center py-1 rounded-md bg-amber-200 hover:bg-amber-400 text-yellow-700 text-xs cursor-pointer"
            onclick="showCrudKedudukan('edit kedudukan','${e.id}','${e.name}')">
              edit
          </div>
          <div class="w-16 mb-1 text-center py-1 rounded-md bg-red-200 hover:bg-red-400 text-red-700 text-xs cursor-pointer"
          onclick="deleteKedudukan('${e.id}','${e.name}')">
            delete
          </div>
        </td>
      </tr>`;
    })

    $("#table_kedudukan_wraper #body_main").html(list);
}

async function getDetailBagian() {
  let httpResponse = await httpRequestGet(`${BASE_URL}/bagian/detail/${IDBAGIAN}`);

  data = httpResponse.data.data;

  $("#bag_name").html(data.name);
  $("#body_tf_bagian").html(data.description);
}

async function getDetailSubagian() {
  let httpResponse = await httpRequestGet(`${BASE_URL}/subagian/detail/${IDSUBAGIAN}`);

  data = httpResponse.data.data;
  
  $("#subag_name").html(data.name);
  $("#body_tf_subagian").html(data.description);
}

if (PREVILEGE == "admin") {
  getDataBagian();
  getDataSubagian();
  getDataKedudukan();
}
else {
  getDetailBagian();
  getDetailSubagian();
}

/**
 * Popup CRUD Bagian
 */
new Quill(`#editor_description_bag`, {
    modules: {
        formula: true,
        syntax: true,
        toolbar: `#toolbar_description_bag`
    },
    theme: 'snow'
});

// show popup
function showCrudBagian(title = null,bagId = null) {
    $('#crud_bagian .title_popup').html(title);

    $('#bg_crud_bagian').removeClass('-z-1 none');
    $('#bg_crud_bagian').addClass('z-50 flex');
    setTimeout(() => {
        $('#bg_crud_bagian').removeClass('opacity-0');
        $('#crud_bagian').removeClass('scale-75');
    }, 50);

    if (bagId != null) {
        getDetailBag(bagId);
    }
}

// hide popup
function hideCrudBagian() {
    $('#crud_bagian').addClass('scale-75');
    $('#bg_crud_bagian').addClass('opacity-0');
    setTimeout(() => {
        $('#bg_crud_bagian').removeClass('z-50 flex');
        $('#bg_crud_bagian').addClass('-z-1 none');
    }, 500);
}

// btn close
$("#close_popup_crudbagian").on("click",() => {
    hideCrudBagian();
    cleanFormBagian();
});

// Get Detail Bagian
async function getDetailBag(bagId) {
    $('.label_fly').addClass('py-4 bg-zinc-400 animate-pulse');
    $('#description_wraper').addClass('min-h-72');
    $('.label_fly >* ').addClass('hidden');
    
    let httpResponse = await httpRequestGet(`${BASE_URL}/bagian/detail/${bagId}`);
    let data         = httpResponse.data.data;

    $('.label_fly').removeClass('py-4 bg-zinc-400 animate-pulse');
    $('#description_wraper').removeClass('min-h-72');
    $('.label_fly >* ').removeClass('hidden');

    $("#bagian_id").val(data.id);
    $("#name_bagian").val(data.name);
    $("#editor_description_bag .ql-editor").html(data.description);
}

$('#crud_bagian').on('submit', async function(e) {
    e.preventDefault();
    
    if (validateCrudBagian()) {
        // clear error message first
        $('.label_fly').addClass('border-zinc-400 focus-within:border-zinc-600');
        $('.label_fly').removeClass('border-red-500 focus-within:border-red-500');
        
        let httpResponse = "";
        let form = new FormData(e.target);

        form.append("description",$(`#editor_description_bag .ql-editor`).html());
        
        $("#btn_simpan_crudbag #text").toggleClass("hidden inline");
        $("#btn_simpan_crudbag #spinner").toggleClass("inline hidden");

        if (form.get("id") == "") {
            httpResponse = await httpRequestPost(`${BASE_URL}/bagian/create/`,form);
        } 
        else {
            httpResponse = await httpRequestPut(`${BASE_URL}/bagian/update/`,form);
        }
            
        $("#btn_simpan_crudbag #text").toggleClass("hidden inline");
        $("#btn_simpan_crudbag #spinner").toggleClass("inline hidden");

        if (httpResponse.status === 201) {
            if (form.get("id") == "") {
                cleanFormBagian();
            }
              
            localStorage.removeItem("data_bagian");
            getDataBagian(); // tugas_fungsi.js

            showAlert({
                message: `<strong>Success...</strong> bagian berhasil ${form.get("id") == "" ? "ditambah" : "diubah"}!`,
                autohide: true,
                type:'success'
            })
        }
        else if (httpResponse.status === 400) {
            let msgList = ``;
        
            for (const key in httpResponse.message) {
                msgList += `<li>${httpResponse.message[key]}</li>`;
                $(`#crud_bagian #${key}_wraper`).removeClass('border-zinc-400 focus-within:border-zinc-600');
                $(`#crud_bagian #${key}_wraper`).addClass('border-red-500 focus-within:border-red-500');
            }
            
            showAlert({
                message: `<ul class="list-disc list-inside">${msgList}</ul>`,
                autohide: true,
                type:'warning'
            })
        }
    }
})

function validateCrudBagian() {
    let status = true;

    // clear error message first
    $('.label_fly').addClass('border-zinc-400 focus-within:border-zinc-600');
    $('.label_fly').removeClass('border-red-500 focus-within:border-red-500');

    if ($("#name_bagian").val() == "") {
        $("#name_bagian").parent().removeClass('border-zinc-400 focus-within:border-zinc-600');
        $("#name_bagian").parent().addClass('border-red-500 focus-within:border-red-500');
        status = false;
    }

    let description = $(`#editor_description_bag .ql-editor`).html().replace(/(<([^>]+)>)/ig,"");

    if (description == "") {
        $("#description_wraper").removeClass('border-zinc-400 focus-within:border-zinc-600');
        $("#description_wraper").addClass('border-red-500 focus-within:border-red-500');
        status = false;
    }

    return status;
}

function cleanFormBagian() {
    // clear error message first
    $('.label_fly').addClass('border-zinc-400 focus-within:border-zinc-600');
    $('.label_fly').removeClass('border-red-500 focus-within:border-red-500');

    $("#bagian_id").val("");
    $("#name_bagian").val("");
    $(`#editor_description_bag .ql-editor`).html("");
}

/**
 * Popup CRUD Subagian
 */
// Quil Initialization
new Quill(`#editor_description_subag`, {
    modules: {
        formula: true,
        syntax: true,
        toolbar: `#toolbar_description_subag`
    },
    theme: 'snow'
});

// show popup
function showCrudSubagian(title = null,subagId = null) {
    let option = "<option value=''>-- pilih id bagian --</option>";
        
    arrSubagian.forEach(e => {
        option += `<option value="${e.id}">${e.name}</option>`;
    });

    $("#id_bagian").html(option);
    $('#crud_subagian .title_popup').html(title);

    $('#bg_crud_subagian').removeClass('-z-1 none');
    $('#bg_crud_subagian').addClass('z-50 flex');
    setTimeout(() => {
        $('#bg_crud_subagian').removeClass('opacity-0');
        $('#crud_subagian').removeClass('scale-75');
    }, 50);

    if (subagId != null) {
        getDetailSubag(subagId);
    }
}

// hide popup
function hideCrudSubagian() {
    $('#crud_subagian').addClass('scale-75');
    $('#bg_crud_subagian').addClass('opacity-0');
    setTimeout(() => {
        $('#bg_crud_subagian').removeClass('z-50 flex');
        $('#bg_crud_subagian').addClass('-z-1 none');
    }, 500);
}

// btn close
$("#close_popup_crudsubagian").on("click",() => {
    hideCrudSubagian();
    cleanFormSubagian();
});

// Get Detail Subagian
async function getDetailSubag(subagId) {
    $('.label_fly').addClass('py-4 bg-zinc-400 animate-pulse');
    $('#description_subagian_wraper').addClass('min-h-72');
    $('.label_fly >* ').addClass('hidden');
    
    let httpResponse = await httpRequestGet(`${BASE_URL}/subagian/detail/${subagId}`);
    let data         = httpResponse.data.data;

    $('.label_fly').removeClass('py-4 bg-zinc-400 animate-pulse');
    $('#description_subagian_wraper').removeClass('min-h-72');
    $('.label_fly >* ').removeClass('hidden');

    $("#subagian_id").val(data.id);
    $("#name_subagian").val(data.name);
    $("#id_bagian").val(data.id_bagian);
    $("#editor_description_subag .ql-editor").html(data.description);
}

$('#crud_subagian').on('submit', async function(e) {
    e.preventDefault();
    
    if (validateCrudSubagian()) {
        // clear error message first
        $('.label_fly').addClass('border-zinc-400 focus-within:border-zinc-600');
        $('.label_fly').removeClass('border-red-500 focus-within:border-red-500');
        
        let httpResponse = "";
        let form = new FormData(e.target);

        form.append("description",$(`#editor_description_subag .ql-editor`).html());
        
        $("#btn_simpan_crudsubag #text").toggleClass("hidden inline");
        $("#btn_simpan_crudsubag #spinner").toggleClass("inline hidden");

        if (form.get("id") == "") {
            httpResponse = await httpRequestPost(`${BASE_URL}/subagian/create/`,form);
        } 
        else {
            httpResponse = await httpRequestPut(`${BASE_URL}/subagian/update/`,form);
        }
            
        $("#btn_simpan_crudsubag #text").toggleClass("hidden inline");
        $("#btn_simpan_crudsubag #spinner").toggleClass("inline hidden");

        if (httpResponse.status === 201) {
            if (form.get("id") == "") {
                cleanFormSubagian();
            }
              
            getDataSubagian(); // tugas_fungsi.js

            showAlert({
                message: `<strong>Success...</strong> subagian berhasil  ${form.get("id") == "" ? "ditambah" : "diubah"}!`,
                autohide: true,
                type:'success'
            })
        }
        else if (httpResponse.status === 400) {
            let msgList = ``;
        
            for (const key in httpResponse.message) {
                msgList += `<li>${httpResponse.message[key]}</li>`;
                $(`#crud_subagian #${key}_wraper`).removeClass('border-zinc-400 focus-within:border-zinc-600');
                $(`#crud_subagian #${key}_wraper`).addClass('border-red-500 focus-within:border-red-500');
            }
            
            showAlert({
                message: `<ul class="list-disc list-inside">${msgList}</ul>`,
                autohide: true,
                type:'warning'
            })
        }
    }
})

function validateCrudSubagian() {
    let status = true;

    // clear error message first
    $('.label_fly').addClass('border-zinc-400 focus-within:border-zinc-600');
    $('.label_fly').removeClass('border-red-500 focus-within:border-red-500');

    if ($("#name_subagian").val() == "") {
        $("#name_subagian").parent().removeClass('border-zinc-400 focus-within:border-zinc-600');
        $("#name_subagian").parent().addClass('border-red-500 focus-within:border-red-500');
        status = false;
    }

    if ($("#id_bagian").val() == "") {
        $("#id_bagian").parent().removeClass('border-zinc-400 focus-within:border-zinc-600');
        $("#id_bagian").parent().addClass('border-red-500 focus-within:border-red-500');
        status = false;
    }

    let description = $(`#editor_description_subag .ql-editor`).html().replace(/(<([^>]+)>)/ig,"");

    if (description == "") {
        $("#description_subagian_wraper").removeClass('border-zinc-400 focus-within:border-zinc-600');
        $("#description_subagian_wraper").addClass('border-red-500 focus-within:border-red-500');
        status = false;
    }

    return status;
}

function cleanFormSubagian() {
    // clear error message first
    $('.label_fly').addClass('border-zinc-400 focus-within:border-zinc-600');
    $('.label_fly').removeClass('border-red-500 focus-within:border-red-500');

    $("#subagian_id").val("");
    $("#name_subagian").val("");
    $("#id_bagian").val("");
    $(`#editor_description_subag .ql-editor`).html("");
}

/**
 * Popup CRUD Kedudukan
 */

// show popup
function showCrudKedudukan(title = null,id = null, name = null) {
    $('#crud_kedudukan .title_popup').html(title);

    $('#bg_crud_kedudukan').removeClass('-z-1 none');
    $('#bg_crud_kedudukan').addClass('z-50 flex');
    setTimeout(() => {
        $('#bg_crud_kedudukan').removeClass('opacity-0');
        $('#crud_kedudukan').removeClass('scale-75');
    }, 50);

    if (id) {
        $("#kedudukan_id").val(id);
        $("#name_kedudukan").val(name);
    }
}

// hide popup
function hideCrudKedudukan() {
    $('#crud_kedudukan').addClass('scale-75');
    $('#bg_crud_kedudukan').addClass('opacity-0');
    setTimeout(() => {
        $('#bg_crud_kedudukan').removeClass('z-50 flex');
        $('#bg_crud_kedudukan').addClass('-z-1 none');
    }, 500);
}

// btn close
$("#close_popup_crudkedudukan").on("click",() => {
    hideCrudKedudukan();
    cleanFormKedudukan();
});

$('#crud_kedudukan').on('submit', async function(e) {
    e.preventDefault();
    
    if (validateCrudKedudukan()) {
        // clear error message first
        $('.label_fly').addClass('border-zinc-400 focus-within:border-zinc-600');
        $('.label_fly').removeClass('border-red-500 focus-within:border-red-500');
        
        let httpResponse = "";
        let form = new FormData(e.target);
        
        $("#btn_simpan_crudkedudukan #text").toggleClass("hidden inline");
        $("#btn_simpan_crudkedudukan #spinner").toggleClass("inline hidden");

        if (form.get("id") == "") {
            httpResponse = await httpRequestPost(`${BASE_URL}/kedudukan/create/`,form);
        } 
        else {
            httpResponse = await httpRequestPut(`${BASE_URL}/kedudukan/update/`,form);
        }
            
        $("#btn_simpan_crudkedudukan #text").toggleClass("hidden inline");
        $("#btn_simpan_crudkedudukan #spinner").toggleClass("inline hidden");

        if (httpResponse.status === 201) {
            if (form.get("id") == "") {
                cleanFormKedudukan();
            }
              
            getDataKedudukan(); // tugas_fungsi.js

            showAlert({
                message: `<strong>Success...</strong> kedudukan berhasil  ${form.get("id") == "" ? "ditambah" : "diubah"}!`,
                autohide: true,
                type:'success'
            })
        }
        else if (httpResponse.status === 400) {
            let msgList = ``;
        
            for (const key in httpResponse.message) {
                msgList += `<li>${httpResponse.message[key]}</li>`;
                $(`#crud_kedudukan #${key}_wraper`).removeClass('border-zinc-400 focus-within:border-zinc-600');
                $(`#crud_kedudukan #${key}_wraper`).addClass('border-red-500 focus-within:border-red-500');
            }
            
            showAlert({
                message: `<ul class="list-disc list-inside">${msgList}</ul>`,
                autohide: true,
                type:'warning'
            })
        }
    }
})

function validateCrudKedudukan() {
    let status = true;

    // clear error message first
    $('.label_fly').addClass('border-zinc-400 focus-within:border-zinc-600');
    $('.label_fly').removeClass('border-red-500 focus-within:border-red-500');

    if ($("#name_kedudukan").val() == "") {
        $("#name_kedudukan").parent().removeClass('border-zinc-400 focus-within:border-zinc-600');
        $("#name_kedudukan").parent().addClass('border-red-500 focus-within:border-red-500');
        status = false;
    }

    return status;
}

function cleanFormKedudukan() {
    // clear error message first
    $('.label_fly').addClass('border-zinc-400 focus-within:border-zinc-600');
    $('.label_fly').removeClass('border-red-500 focus-within:border-red-500');

    $("#kedudukan_id").val("");
    $("#name_kedudukan").val("");
}

/**
 * Delete
 */
// bagian
function deleteBagian(bagianId,bagianName) {
    Swal.fire({
        title: 'Anda yakin?',
        html: `semua akun dengan bagian <b>'${bagianName}'</b> akan ikut terhapus`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'iya',
        cancelButtonText: 'tidak',
        showLoaderOnConfirm: true,
        preConfirm: () => {
          return httpRequestDelete(`${BASE_URL}/bagian/delete/${bagianId}`)
          .then((e) => {
              if (e.status == 201) {
                localStorage.removeItem("data_bagian");
                getDataBagian();
                getDataSubagian();
              }
          })
        },
        allowOutsideClick: () => !Swal.isLoading()
    })
}

// subagian
function deleteSubagian(subagianId,subagianName) {
    Swal.fire({
        title: 'Anda yakin?',
        html: `semua akun dengan subagian <b>'${subagianName}'</b> akan ikut terhapus`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'iya',
        cancelButtonText: 'tidak',
        showLoaderOnConfirm: true,
        preConfirm: () => {
          return httpRequestDelete(`${BASE_URL}/subagian/delete/${subagianId}`)
          .then((e) => {
              if (e.status == 201) {
                getDataSubagian();
              }
          })
        },
        allowOutsideClick: () => !Swal.isLoading()
    })
}

// kedudukan
function deleteKedudukan(kedudukanId,kedudukanName) {
    Swal.fire({
        title: 'Anda yakin?',
        html: `semua akun dengan kedudukan <b>'${kedudukanName}'</b> akan ikut terhapus`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'iya',
        cancelButtonText: 'tidak',
        showLoaderOnConfirm: true,
        preConfirm: () => {
          return httpRequestDelete(`${BASE_URL}/kedudukan/delete/${kedudukanId}`)
          .then((e) => {
              if (e.status == 201) {
                getDataKedudukan();
              }
          })
        },
        allowOutsideClick: () => !Swal.isLoading()
    })
}