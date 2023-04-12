document.addEventListener("DOMContentLoaded", () => {
    showTime();

    $('#input-type').hide();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.select2').select2({
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
    });
});

// General

// show time
function showTime(){
    let date = new Date();
    let h = date.getHours(); // 0 - 23
    let m = date.getMinutes(); // 0 - 59
    let s = date.getSeconds(); // 0 - 59
    let session = " AM";

    if(h == 0){
        h = 12;
    }

    if(h == 12){
        session = " PM";
    }

    if(h > 12){
        h = h - 12;
        session = " PM";
    }

    h = (h < 10) ? "0" + h : h;
    m = (m < 10) ? "0" + m : m;
    s = (s < 10) ? "0" + s : s;

    let dateFormat = setDateFormat(date);
    let time = h + ":" + m + session;

    if (document.getElementById("tanggal")) {
        document.getElementById("tanggal").value = dateFormat;
    }

    if (document.getElementById("jam")) {
        document.getElementById("jam").value = time;
    }

    setTimeout(showTime, 1000);
}

// yy-mm-dd format
function setDateFormat(date) {
    var d = new Date(date),
        month = "" + (d.getMonth() + 1),
        day = "" + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2)
        month = "0" + month;
    if (day.length < 2)
        day = "0" + day;

    return [year, month, day].join("-");
}

// Authentication
function login(e, evt) {
    evt.preventDefault();

    $.ajax({
        url: e.getAttribute('action'),
        type: e.getAttribute('method'),
        data: new FormData(e),
        processData: false,
        contentType: false,
        success: function(res) {
            if (res.status == 200) {
                console.log(res.message);
                location.href = res.redirect;
            } else {
                console.error(res.message);
                for(let i = 0;i < res.additional.length;i++) {
                    document.getElementById(res.additional[i]).classList.add('is-invalid');
                }
                iziToast.error({
                    title: 'Error',
                    message: res.message,
                    position: 'topCenter'
                });
            }
        }, error: function (jqXHR) {
            let res = jqXHR.responseJSON;
            let message = '';
            console.log(res.message);
            for (let key in res.errors) {
                message += res.errors[key]+' ';
                document.getElementById(key).classList.add('is-invalid');
            };
            iziToast.error({
                title: 'Error',
                message: message,
                position: 'topCenter'
            });
        }
    });
}

function logout() {
    Swal.fire({
        title: 'Logout?',
        showConfirmButton: true,
        showDenyButton: true,
        confirmButtonText: 'Logout',
        confirmButtonColor: '#535394',
        denyButtonText: 'Cancel',
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/login/unauthenticate',
                type: 'post',
                data: {confirmed : result.isConfirmed},
                success: function(res) {
                    if (res.status == 200) {
                        console.log(res.message);
                        location.href = res.redirect;
                    }
                }
            });
        }
    });
}

// Production Panel View Change
function toProductionPanel(id) {
    $(id).hide();
    $('#input-type').hide();
    $('#rft-input').val(1);
    $('#defect-input').val(1);
    $('#reject-input').val(1);
    $('#production-panel').show();
    $('.footer').hide();
}

function toRft() {
    $('#input-type').removeClass()
    $('#input-type').addClass('bg-rft w-100 fs-5 pb-1 mb-0 rounded text-center text-light fw-bold');
    $('#input-type').html('RFT');
    $('#input-type').show();
    $('#production-panel').hide();
    $('#rft-container').show();
    $('.footer').show();
}

function toDefect() {
    $('#input-type').removeClass()
    $('#input-type').addClass('bg-defect w-100 fs-5 pb-1 mb-0 rounded text-center text-light fw-bold');
    $('#input-type').html('DEFECT');
    $('#input-type').show();
    $('#production-panel').hide();
    $('#defect-container').show();
    $('.footer').show();
}

function toDefectHistory() {
    $('#input-type').removeClass()
    $('#input-type').addClass('bg-defect w-100 fs-5 pb-1 mb-0 rounded text-center text-light fw-bold');
    $('#input-type').html('DEFECT');
    $('#input-type').show();
    $('#production-panel').hide();
    $('#defect-history-container').show();
}

function toReject() {
    $('#input-type').removeClass()
    $('#input-type').addClass('bg-reject w-100 fs-5 pb-1 mb-0 rounded text-center text-light fw-bold');
    $('#input-type').html('REJECT');
    $('#input-type').show();
    $('#production-panel').hide();
    $('#reject-container').show();
    $('.footer').show();
}

function toRework() {
    $('#input-type').removeClass()
    $('#input-type').addClass('bg-rework w-100 fs-5 pb-1 mb-0 rounded text-center text-light fw-bold');
    $('#input-type').html('REWORK');
    $('#input-type').show();
    $('#production-panel').hide();
    $('#rework-container').show();
}

// defect modal
function showDefectModal() {
    $("#defect-modal").modal("show");
}

function hideDefectModal() {
    $("#defect-modal").modal("hide");
}

// rework
function reworkConfirmation() {
    Swal.fire({
        icon: 'info',
        title: 'REWORK this defect?',
        html: `<table class="table text-start w-auto mx-auto">
                    <tr>
                        <td>ID<td>
                        <td>:<td>
                        <td>?<td>
                    <tr>
                    <tr>
                        <td>Size<td>
                        <td>:<td>
                        <td>?<td>
                    <tr>
                    <tr>
                        <td>Defect Type<td>
                        <td>:<td>
                        <td>?<td>
                    <tr>
                    <tr>
                        <td>Defect Area<td>
                        <td>:<td>
                        <td>?<td>
                    <tr>
                </table>`,
        showConfirmButton: true,
        showDenyButton: true,
        confirmButtonText: 'Rework',
        confirmButtonColor: '#447efa',
        denyButtonText: 'Batal',
    }).then((result) => {
        if (result.isConfirmed) {
            location.reload;
        } else if (result.isDenied) {
            Swal.fire({
                icon: 'info',
                title: 'REWORK Canceled',
                confirmButtonText: 'Ok',
                confirmButtonColor: '#447efa',
            })
        }
    });
}

// qty input
function increment(id) {
    let element = document.getElementById(id);
    element.value = parseInt(element.value) + 1;
}

function decrement(id) {
    let element = document.getElementById(id);
    element.value = parseInt(element.value) - 1;
}

// popup notification
function showNotification(type, message) {
    switch (type) {
        case 'info' :
            iziToast.info({
                title: 'Information',
                message: message,
                position: 'topCenter'
            });
            break;
        case 'success' :
            iziToast.success({
                title: 'Success',
                message: message,
                position: 'topCenter'
            });
            break;
        case 'warning' :
            iziToast.warning({
                title: 'Warning',
                message: message,
                position: 'topCenter'
            });
            break;
        case 'error' :
            iziToast.error({
                title: 'Error',
                message: message,
                position: 'topCenter'
            });
            break;
    }
}
