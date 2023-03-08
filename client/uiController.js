window.addEventListener("load", initialize);

var doctors;
var Valid = "lightgreen";
var Invalid = "pink";
var Initial = "white"
let patitent = null;
let nameValidation = false;
let mobileValidation = false;
let emailValidation = false;
let dateValidation = true;
let timeValidation = true;
let doctorValidation = false;

let Name = null;
let Mobile = null;
let MEmail = null;
let Doctor = null;
let Date = null;
let Time = null;

var baseurl = "http://127.0.0.1/project_HNDIT_R/server/";

function Appointment(name, mobile, email, date, time, doctor) {
    this.name = name;
    this.mobile = mobile;
    this.email = email;
    this.date = date;
    this.time = time;
    this.doctor = doctor;
}

function initialize() {

    emailjs.init('g_n-ft5RbmAV8cJZY');
    doctors = get("doctorcontroller.php");

    loadForm();
    btnClear.addEventListener("click", clearForm);
    btnAdd.addEventListener("click", Add);
    btnAdd.removeAttribute("disabled", "disabled");
    txtName.addEventListener("input", txtNameKU);
    txtMobile.addEventListener("input", txtMobileKU);
    txtEmail.addEventListener("input", txtEmailKU);
    cmbDoctor.addEventListener("change", cmbDoctorCH); //Arrow function like annonymous function.




    form.setAttribute("style", "display:none");
    bookAppointment();

}

function loadView() {
    patitent = get("appointmentcontroller.php");
    console.log(patitent);
    loadData();


}

function loadData() {

     Name = patitent[0]['name'];
     Mobile = patitent[0]['mobile'];
     MEmail = patitent[0]['email'];
     Doctor = (patitent[0]['doctor']).name;
     Date = patitent[0]['date'];
     Time = patitent[0]['time'];

    lblName.value = Name;
    lblMobile.value = Mobile;
    lblEmail.value = MEmail;
    lblDoctor.value = Doctor;
    lblDate.value = Date;
    lblTime.value = Time;

}

function bookAppointment() {

    const btn = document.getElementById('btnOk');
    document.getElementById('form')
        .addEventListener('submit', function(event) {
            event.preventDefault();

            btn.value = 'Sending E-mail...';

            const serviceID = 'default_service';
            const templateID = 'template_wi1l66t';

            emailjs.sendForm(serviceID, templateID, this)
                .then(() => {
                    alert('Sent Email!');
                    clearForm();
                    form.setAttribute("style", "display:none");
                    form2.setAttribute("style", "display:block");
                }, (err) => {

                    alert(JSON.stringify(err));
                });
        });


}

function loadForm() {
    doctors = get("doctorcontroller.php");
    FillCombo(doctors, cmbDoctor);
}

function clearForm() {
    txtName.value = "";
    txtMobile.value = "";
    txtEmail.value = "";
    txtDate.value = "";
    cmbDoctor.value = null;

    // btnAdd.removeAttribute("disabled");
    txtName.style.backgroundColor = Initial;
    txtMobile.style.backgroundColor = Initial;
    txtEmail.style.backgroundColor = Initial;
    txtDate.style.backgroundColor = Initial;
    cmbDoctor.style.backgroundColor = Initial;

}

function txtNameKU() {
    let name = txtName.value;
    let namePattern = new RegExp(/^[a-zA-Z]+ [a-zA-Z]+$/);
    if (!namePattern.test(name)) {
        txtName.style.backgroundColor = Invalid;
        nameValidation = false;
    } else {

        txtName.style.backgroundColor = Valid;
        nameValidation = true;

    }
}

function txtMobileKU() {
    let mobile = txtMobile.value;
    let mobilePattern = new RegExp("^07[0-9][0-9]{7}$");
    console.log(mobilePattern.test(mobile));
    if (!mobilePattern.test(mobile)) {
        txtMobile.style.backgroundColor = Invalid;
        mobileValidation = false;
    } else {

        txtMobile.style.backgroundColor = Valid;
        mobileValidation = true;
    }
}

function txtEmailKU() {
    let email = txtEmail.value;
    let emailPattern = new RegExp("^[a-z0-9]+[@][a-z]+.[a-z]+$");

    if (!emailPattern.test(email)) {
        txtEmail.style.backgroundColor = Invalid;
        emailValidation = false;
    } else {

        txtEmail.style.backgroundColor = Valid;
        emailValidation = true;

    }
}

function cmbDoctorCH() {
    let doctor = JSON.parse(cmbDoctor.value);

    if (doctor == null) {
        cmbDoctor.style.backgroundColor = Invalid;
        doctorValidation = false;
    } else {

        cmbDoctor.style.backgroundColor = Valid;
        doctorValidation = true;


    }

}

function getErrors() {
    let errors = "";
    if (!nameValidation) errors += "\nInvalid Name";
    if (!mobileValidation) errors += "\nInvalid Mobile";
    if (!emailValidation) errors += "\nInvalid Email";
    if (!dateValidation) errors += "\nInvalid Date";
    if (!timeValidation) errors += "\nInvalid Time";
    if (!doctorValidation) errors += "\nInvalid Doctor";

    return errors;
}

function Add() {
    let errors = getErrors();

    if (errors !== "") {
        window.alert("You have following errors\n" + errors);
    } else {

        let appointment = new Appointment();
        appointment.name = txtName.value;
        appointment.mobile = txtMobile.value;
        appointment.email = txtEmail.value;
        appointment.date = txtDate.value;
        appointment.doctor = JSON.parse(cmbDoctor.value);

        let userConfirm = window.confirm("Are you sure you want to add this record? \n" + "Name : " + appointment.name + "\nMobile : " + appointment.mobile + "\nEmail : " + appointment.email + "\nDate : " + appointment.date + "\nDoctor : " + appointment.doctor.name);
        if (userConfirm) {

            let result = post("appointmentcontroller.php", "appointment=" + JSON.stringify(appointment));
            if (result !== "") {
                window.alert(result);
            } else {
                form2.setAttribute("style", "display:none");

                form.setAttribute("style", "display:block");
                loadView();

                window.alert("Success ..!");


            }


        }
    }
}

function FillCombo(data, combo) {
    var optionHint = document.createElement("option");
    optionHint.innerHTML = "select a doctor";
    optionHint.value = null;
    optionHint.setAttribute("disabled", "disabled");
    optionHint.setAttribute("selected", "selected");
    combo.appendChild(optionHint);

    for (let i = 0; i < data.length; i++) {
        const datum = data[i];
        var option = document.createElement("option");
        option.innerHTML = datum.name;
        option.value = JSON.stringify(datum);
        combo.appendChild(option);

    }
}

function post(url, querry1) {
    var url = baseurl + url;
    var http = new XMLHttpRequest();
    http.open("POST", url, false);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send(querry1);
    if (http.status == 200) {
        return http.responseText;
    }
    return null;
}

function get(url) {
    var url = baseurl + url;
    var http = new XMLHttpRequest();
    http.open("GET", url, false);
    http.send();
    var data = JSON.parse(http.responseText);
    return data;
}

