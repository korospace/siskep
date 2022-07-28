const cancelTokenSource = axios.CancelToken.source();
let webUrl   = window.location.href;
let docTitle = document.title.split('|');
let title1   = docTitle[0].replace(/\s/,'');
let title2   = docTitle[1].replace(/\s/,'');
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
            },
            cancelToken: cancelTokenSource.token
        })
        .then((response) => {
            return {
                'status':200,
                'data':response.data
            };
        })
        .catch((error) => {
            let statusCode = error.response.status;

            // unauthorized
            if (statusCode == 401) {
                if (error.response.data.message == 'token expired') {
                    Swal.fire({
                        icon : 'error',
                        title : '<strong>LOGIN EXPIRED</strong>',
                        text: 'silahkan login ulang untuk perbaharui login anda',
                        showCancelButton: false,
                        confirmButtonText: 'ok',
                    }).then(() => {
                        doLogout();
                    })
                }
                else{
                    doLogout();
                }
            }
            // server error
            else if (statusCode == 500){
                showAlert({
                    message: `<strong>Ups...</strong> terjadi kesalahan pada server, silahkan refresh halaman.`,
                    autohide: true,
                    type:'danger' 
                })

                cancelTokenSource.cancel();
            }
            
            return {
                'status':statusCode,
            };
        })
};

/**
 * API REQUEST POST
 */
const httpRequestPost = (url,form) => {
    let newForm = new FormData();

    for (var pair of form.entries()) {
        let noPair = /username|password|new_password|email|file_sk|^file_tugas/;

        if (noPair.test(pair[0]) == false) {
            if (pair[0].includes('sk_detail')) {
                newForm.set(pair[0], pair[1].trim());    
            } 
            else {
                newForm.set(pair[0], pair[1].trim());    
            }
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
        .post(url,newForm, {
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
                if (error.response.data.message == 'token expired') {
                    Swal.fire({
                        icon : 'error',
                        title : '<strong>LOGIN EXPIRED</strong>',
                        text: 'silahkan login ulang untuk perbaharui login anda',
                        showCancelButton: false,
                        confirmButtonText: 'ok',
                    }).then(() => {
                        doLogout();
                    })
                }
                else{
                    doLogout();
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
 * API REQUEST PUT
 */
const httpRequestPut = (url,form) => {
    let newForm = new FormData();

    for (var pair of form.entries()) {
        let noPair = /username|password|new_password|email|new_logo|^file_tugas/;

        if (noPair.test(pair[0]) == false) {
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
                if (error.response.data.message == 'token expired') {
                    Swal.fire({
                        icon : 'error',
                        title : '<strong>LOGIN EXPIRED</strong>',
                        text: 'silahkan login ulang untuk perbaharui login anda',
                        showCancelButton: false,
                        confirmButtonText: 'ok',
                    }).then(() => {
                        doLogout();
                    })
                }
                else{
                    doLogout();
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
 * API REQUEST DELETE
 */
const httpRequestDelete = (url) => {
    return axios
        .delete(url, {
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
                if (error.response.data.message == 'token expired') {
                    Swal.fire({
                        icon : 'error',
                        title : '<strong>LOGIN EXPIRED</strong>',
                        text: 'silahkan login ulang untuk perbaharui login anda',
                        showCancelButton: false,
                        confirmButtonText: 'ok',
                    }).then(() => {
                        doLogout();
                    })
                }
                else{
                    doLogout();
                }
            }
            // error server
            else if (error.response.status == 500) {
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
 * Check token
 */
async function checkToken() {
    let dataLogin    = JSON.parse(localStorage.getItem('data_login'));
    let loginExpired = 0;
    let interval     = 1000;

    if (dataLogin == null) {
        let httpResponse = await httpRequestGet(`${BASE_URL}/login/show`);
        loginExpired     = httpResponse.data.data.expired+"000";
        
        localStorage.setItem("data_login",JSON.stringify({expired:loginExpired})); 
    } 
    else {
        loginExpired = dataLogin.expired;
    }
    
    let loginInterval = setInterval(() => {
        loginExpired -= interval;
        
        if (loginExpired <= 0) {
            Swal.fire({
                icon : 'error',
                title : '<strong>LOGIN EXPIRED</strong>',
                text: 'silahkan login ulang untuk perbaharui login anda',
                showCancelButton: false,
                confirmButtonText: 'ok',
            }).then(() => {
                doLogout();
            })

            clearInterval(loginInterval);
        }

        localStorage.setItem("data_login",JSON.stringify({expired:loginExpired})); 
    }, interval);
}

if (title2 !== "login") {
    checkToken();
}

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
            doLogout(true);
            return 0;
        },
        allowOutsideClick: () => !Swal.isLoading()
    })
})

function doLogout(removeLastUrl = false) {
    cancelTokenSource.cancel();
    localStorage.removeItem('data_login');
    document.cookie = `token=null; path=/;SameSite=None; Secure`;
    if (removeLastUrl) {
        document.cookie = `lasturl=null; path=/;SameSite=None; Secure`;
    }
    window.location.replace(`${BASE_URL}/login`);
}

/**
 * Image Preview
 */
let filePreview = '';
const changePreview = (el,target) => {
     let imgType = el.files[0].type.split('/');
     
     // If file is not image
     if(!/image/.test(imgType[0])){
         showAlert({
             message: `<strong>File yang anda upload bukan gambar!</strong>`,
             autohide: true,
             type:'warning'
         });
 
         el.value = "";
         return false;
     }
     // If image not in format
     else if(!["jpg","jpeg","png","webp"].includes(imgType[1])) {
         showAlert({
             message: `<strong>Format gambar yang diperbolehkan -> jpg/jpeg/png/webp!</strong>`,
             autohide: true,
             type:'warning'
         });
 
         el.value = "";
         return false;
     }
     else{
         const MAX_WIDTH  = 500;
         const MAX_HEIGHT = 308;
         const MIME_TYPE  = "image/webp";
         const QUALITY    = 1;
         const file       = el.files[0];
         const blobURL    = URL.createObjectURL(file);
         const img        = new Image();
 
         img.src    = blobURL;
         img.onload = function () {
             if(el.files[0].size < 2000000){
                 filePreview = el.files[0];
                 document.querySelector(target).src = blobURL;
             }
             else{
                 URL.revokeObjectURL(this.src);
                 const [newWidth, newHeight] = calculateSize(img, MAX_WIDTH, MAX_HEIGHT);
                 const canvas = document.createElement("canvas");
                 canvas.width = newWidth;
                 canvas.height = newHeight;
                 const ctx = canvas.getContext("2d");
                 ctx.drawImage(img, 0, 0, newWidth, newHeight);
                 canvas.toBlob(
                     (blob) => {
                         // Handle the compressed image. es. upload or save in local state
                     },
                     MIME_TYPE,
                     QUALITY
                 );
         
                 document.querySelector(target).src = canvas.toDataURL();
                 filePreview = dataURLtoFile(canvas.toDataURL(),'preview.webp');
             }
         }
 
         function calculateSize(img, maxWidth, maxHeight) {
             let width = img.width;
             let height = img.height;
           
             // calculate the width and height, constraining the proportions
             if (width > height) {
                 if (width > maxWidth) {
                     height = Math.round((height * maxWidth) / width);
                     width = maxWidth;
                 }
             } else {
                 if (height > maxHeight) {
                     width = Math.round((width * maxHeight) / height);
                     height = maxHeight;
                 }
             }
             return [width, height];
         }
 
         function dataURLtoFile(dataurl, filename) {
  
             var arr = dataurl.split(','),
                 mime = arr[0].match(/:(.*?);/)[1],
                 bstr = atob(arr[1]), 
                 n = bstr.length, 
                 u8arr = new Uint8Array(n);
                 
             while(n--){
                 u8arr[n] = bstr.charCodeAt(n);
             }
             
             return new File([u8arr], filename, {type:mime});
         }
     }
}

/**
 * Time creation
 */
function timeCreation(unix) {
    let date  = new Date(parseInt(unix) * 1000);
    let day   = date.toLocaleString("en-US",{day: "numeric"});
    let month = date.toLocaleString("id-ID",{month: "long"});
    let year  = date.toLocaleString("en-US",{year: "numeric"});
    let time  = date.toLocaleString("en-US",{hour: '2-digit', minute: '2-digit'} );

    return {day,month,year,time}
}