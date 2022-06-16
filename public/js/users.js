/**
 * Get Users
 */
let arrUser = [];
async function getUsers(queries = "") {
    $("#body_skeleton").toggleClass("hidden");
    $("#body_main").toggleClass("hidden"); 
    let httpResponse = await httpRequestGet(`${BASE_URL}/user/show?${queries}`);
    $("#body_skeleton").toggleClass("hidden");
    $("#body_main").toggleClass("hidden"); 
    
    if (httpResponse.status === 200) {
        arrUser = httpResponse.data.data;
    } 
    else {
      arrUser = [];
    }
    
    createTableRow(arrUser);
}
getUsers();

/**
 * Search user
 */
$('#search-user').on('keyup', function() {
  let elSugetion   = '';
  let userFiltered = [];
  
  if ($(this).val() === "") {
      userFiltered = arrUser;
  } 
  else {
      userFiltered = arrUser.filter((n) => {
          return n.nama_lengkap.includes($(this).val().toLowerCase()) || n.nik.includes($(this).val());
      });
  }

  if (userFiltered.length != 0) {
    createTableRow(userFiltered);
  }
});

/**
 * Create Table row
 */
function createTableRow(data) {
  let list = "";

  data.forEach((e,i) => {
      list += `<tr class="${(i%2==1) ? "bg-gray-200 hover:bg-gray-300" : "bg-gray-400 hover:bg-gray-500"} cursor-pointer">
      <td class="p-4 text-gray-800">
          ${++i}
      </td>
      <td class="p-4 text-gray-800">
          ${e.username}
      </td>
      <td class="p-4 text-gray-800">
          ${(e.nama_lengkap != null) ? e.nama_lengkap : '-'}
      </td>
      <td class="p-4 text-gray-800">
        ${(e.nik != null) ? e.nik : '-'}
      </td>
      <td class="p-4 text-gray-800">
          ${e.previlege}
      </td>
      <td class="p-4 text-gray-800">
          ${e.bagian} ${(e.subagian) ? " | "+e.subagian : ""} 
      </td>
      <td class="p-4 text-gray-800">
        <div
          class="mb-1 px-4 py-1 rounded-md bg-amber-200 hover:bg-amber-400 text-yellow-700 text-xs cursor-pointer"
          onclick="showCrudUsers('edit akun','${e.id}')">
            edit
        </div>
        <div class="mb-1 px-4 py-1 rounded-md bg-red-200 hover:bg-red-400 text-red-700 text-xs cursor-pointer"
        onclick="deleteUser('${e.id}',this)">
          delete
        </div>
      </td>
    </tr>`;
  });

  $('#total').html(data.length+" akun");
  $("#body_main").html(list); 
}

/**
 * Delete User
 */
function deleteUser(userId,el) {
  Swal.fire({
      title: 'DELETE AKUN',
      text: "Anda yakin menghapus akun ini?",
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'iya',
      cancelButtonText: 'tidak',
      showLoaderOnConfirm: true,
      preConfirm: () => {
        return httpRequestDelete(`${BASE_URL}/user/delete/${userId}`)
        .then((e) => {
            if (e.status == 201) {
              arrUser = arrUser.filter(e => e.id != userId);
              createTableRow(arrUser);
            }
        })
      },
      allowOutsideClick: () => !Swal.isLoading()
  })
}