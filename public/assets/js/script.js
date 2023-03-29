document.addEventListener("DOMContentLoaded", () => {
    showTime();
});

// Redirect
function toRft() {
    location.href = "/rft";
}

function toDefect() {
    location.href = "/defect";
}

function toDefectHistory() {
    location.href = "/defect-history";
}

function toReject() {
    location.href = "/reject";
}

function toRework() {
    location.href = "/rework";
}

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

// defect
function showDefectModal() {
    $("#defect-modal").modal("show");
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
        denyButtonText: `Batal`,
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
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
      })
}
