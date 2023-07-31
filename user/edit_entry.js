var tb_btn_edit = document.querySelectorAll(".tb-edit");
var confirm_alert = document.getElementById("confirm_alert");
var alert_submit = document.getElementById("alert_submit");
var alert_cancel = document.getElementById("alert_cancel");
var confirm_alert_text = document.getElementById("confirm_alert_text");
var notification_alert = document.getElementById("notification_alert");
var notification_alert_pbar = document.getElementById("notification_alert_pbar");
var notification_text = document.getElementById("notification_text");
var notification_title = document.getElementById("notification_title");
var backdrop = document.getElementById("backdrop");
var form = document.getElementById("edit_form");
var form_edit_username = document.getElementById("edit_username");
var form_edit_sec_lvl = document.getElementById("edit_sec_lvl");
var form_edit_nfc_uid = document.getElementById("edit_nfc_uid");
var form_edit_passwd = document.getElementById("edit_passwd");
var form_edit_submit_btn = document.getElementById("edit_submit_btn");



if(sessionStorage.getItem('notification') != null) {
    let alert_date = JSON.parse(sessionStorage.getItem('notification'));
    notificationAlert(alert_date.title, alert_date.text, alert_date.duration);
    sessionStorage.removeItem('notification');
}

//-----------------------Eintrag--bearbeiten--------------------------------------------------------------------------------------
tb_btn_edit.forEach((el) => {
    el.addEventListener("click", () => {
        entry_id = el.id;
        form.classList.remove("hide");
        backdrop.classList.remove("hide");

        tb_data_username = el.parentElement.querySelector(".tb-username").innerText;
        console.log(tb_data_username);
        tb_data_sec_lvl = el.parentElement.querySelector(".tb-sec-lvl").innerText;
        console.log(tb_data_sec_lvl);
        tb_data_nfc_uid = el.parentElement.querySelector(".tb-nfc-uid").innerText;
        console.log(tb_data_nfc_uid);
        tb_data_passwd = el.parentElement.querySelector(".tb-passwd").innerText;
        console.log(tb_data_passwd);
        
        form_edit_username.value = tb_data_username;
        form_edit_sec_lvl.value = tb_data_sec_lvl;
        form_edit_nfc_uid.value = tb_data_nfc_uid;
        form_edit_passwd.value = tb_data_passwd;
    });
});

form_edit_submit_btn.addEventListener("click", async () => {
    if (tb_data_username == form_edit_username.value && tb_data_sec_lvl == form_edit_sec_lvl.value && tb_data_nfc_uid == form_edit_nfc_uid.value && tb_data_passwd == form_edit_passwd.value) {
        notificationAlert("Fehler:", "Es muss mindestens eine Sache geändert werden!", 5);
    } else {
        try {
            const confirmed = await confirmAlert(
                "Sicher, dass du den Eintrag zu:\nUsername: \t" + form_edit_username.value +
                "\nSecurity Level: \t" + form_edit_sec_lvl.value + 
                "\nNFC-UID: \t" + form_edit_nfc_uid.value + 
                "\nPasswort: \t" + form_edit_passwd.value +
                "\nändern willst?"
            );

            if (confirmed) {
                $.ajax({
                    type: "POST",
                    url: 'edit_user_entry.php',
                    data: {
                        id: entry_id,
                        username: form_edit_username.value,
                        sec_lvl: form_edit_sec_lvl.value,
                        nfc_uid: form_edit_nfc_uid.value,
                        passwd: form_edit_passwd.value
                    },
                    success: function(response) {
                        var jsonData = JSON.parse(response);
                        if(jsonData.success == true) {
                            let msg = {
                                title: 'Erfolg:',
                                text: 'Der Eintrag wurde erfolgreich geändert!',
                                duration: 5
                            }
                            sessionStorage.setItem('notification', JSON.stringify(msg));
                            location.reload();
                        } else {
                            notificationAlert("Fehler:", `Der Eintrag konnte nicht bearbeitet werden: ${jsonData.sql_error}`, 5);
                        }
                    }
                });
            }
        } catch (error) {
            console.log("Error", error);
        }
    }
});


//-----------------------Backdrop--schließen------------------------------------------------------------------------------------------
backdrop.addEventListener("click", () => {
    backdrop.classList.add("hide");
    if (!form.classList.contains('hide')) {
        form.classList.add("hide");
    }
    if (!add_form.classList.contains('hide')) {
        add_form.classList.add("hide");
    }
});