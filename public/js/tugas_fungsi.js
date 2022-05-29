async function getDataBagian() {
    $("#table_bagian_wraper #body_skeleton").removeClass("hidden");
    $("#table_bagian_wraper #body_main").addClass("hidden"); 

    let dataStorage = JSON.parse(localStorage.getItem('data_bagian'));

    if (dataStorage == null) {
        let httpResponse = await httpRequestGet(`${BASE_URL}/bagian/show`);

        if (httpResponse.status === 200) {
            dataStorage = httpResponse.data.data;
        }
        else {
            dataStorage = [];
        }

        localStorage.setItem("data_bagian",JSON.stringify(dataStorage));
    }

    $("#table_bagian_wraper #body_skeleton").addClass("hidden");
    $("#table_bagian_wraper #body_main").removeClass("hidden"); 

    let list = "";
    
    dataStorage.forEach((e,i) => {
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
    $("#table_subagian_wraper #body_skeleton").removeClass("hidden");
    $("#table_subagian_wraper #body_main").addClass("hidden"); 
    
    let httpResponse = await httpRequestGet(`${BASE_URL}/subagian/show`);
    data = httpResponse.data.data;

    $("#table_subagian_wraper #body_skeleton").addClass("hidden");
    $("#table_subagian_wraper #body_main").removeClass("hidden"); 

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
}
else {
  getDetailBagian();
  getDetailSubagian();
}

/**
 * Delete bagian
 */
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

/**
 * Delete subagian
 */
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