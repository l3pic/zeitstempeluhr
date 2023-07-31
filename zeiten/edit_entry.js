var tb_btn_edit = document.querySelectorAll(".tb-edit");
var tb_btn_del = document.querySelectorAll(".tb-del");
var backdrop = document.getElementById("backdrop");
var form = document.getElementById("edit_form");
var form_edit_name = document.getElementById("edit_name");
var form_edit_date = document.getElementById("edit_date");
var form_edit_formatted_date = document.getElementById("formatted_date");
var form_edit_nfc_uid = document.getElementById("edit_nfc_uid");
var form_edit_submit_btn = document.getElementById("edit_submit_btn");
var confirm_alert = document.getElementById("confirm_alert");
var alert_submit = document.getElementById("alert_submit");
var alert_cancel = document.getElementById("alert_cancel");
var confirm_alert_text = document.getElementById("confirm_alert_text");
var notification_alert = document.getElementById("notification_alert");
var notification_alert_pbar = document.getElementById("notification_alert_pbar");
var notification_text = document.getElementById("notification_text");
var notification_title = document.getElementById("notification_title");
var clear_datefilters_btn = document.getElementById("clear_datefilters");
var date_form_1 = document.getElementById("date_form_1");
var date_form_2 = document.getElementById("date_form_2");

//----------------------------------
clear_datefilters_btn.addEventListener("click", (event) => {
    date_form_1.value = "";
    date_form_2.value = "";
    event.preventDefault();
})


//-----------------------Sessionstorage--überprüfen----------------------------------------------------------------------------
if(sessionStorage.getItem('notification') != null) {
    let alert_date = JSON.parse(sessionStorage.getItem('notification'));
    notificationAlert(alert_date.title, alert_date.text, alert_date.duration);
    sessionStorage.removeItem('notification');
}

if(sessionStorage.getItem('editmode') != null && sessionStorage.getItem('editmode') == 'true') {
    btn_switch.checked = true;
    let btns_edit = document.querySelectorAll(".tb-edit")
    btns_edit.forEach((el) => {
        el.classList.remove("hide");
    });

    let btns_del = document.querySelectorAll(".tb-del")
    btns_del.forEach((el) => {
        el.classList.remove("hide");
    });
}


//-----------------------Eintrag--löschen--------------------------------------------------------------------------------------
tb_btn_del.forEach((el) => {
    el.addEventListener("click", async () => {
        let tb_data_name = el.parentElement.querySelector(".tb-name").innerText;
        let tb_data_str_datetime = el.parentElement.querySelector(".tb-datetime").innerText;
        let tb_data_nfc_uid = el.parentElement.querySelector(".tb-nfc-uid").innerText;

        backdrop.classList.remove('hide');
        try {
            const confirmed = await confirmAlert(
                "Sicher, dass du den Eintrag:\nName: \t" + tb_data_name + 
                "\nZeit: \t" + tb_data_str_datetime + 
                "\nNFC-UID: \t" + tb_data_nfc_uid + 
                "\nlöschen willst?"
            );

            if (confirmed) {
                $.ajax({
                    type: "POST",
                    url: 'edit_entry.php',
                    data: {
                        operation: "del", 
                        id: el.id
                    },
                    success: function(response) {
                        var jsonData = JSON.parse(response);
                        if(jsonData.success == true) {
                            let msg = {
                                title: 'Erfolg:',
                                text: 'Der Eintrag wurde erfolgreich gelöscht!',
                                duration: 5
                            }
                            sessionStorage.setItem('notification', JSON.stringify(msg));
                            location.reload();
                        } else {
                            notificationAlert("Fehler: ", `Der Eintrag konnte nicht gelöscht werden: ${jsonData.sql_error}`, 5);
                        }
                    }
                });
            }
        } catch (error) {
            console.log("Error", error);
        }
    });
});


//-----------------------Eintrag--bearbeiten------------------------------------------------------------------------------------
tb_btn_edit.forEach((el) => {
    el.addEventListener("click", () => {
        entry_id = el.id;
        form.classList.remove("hide");
        backdrop.classList.remove("hide");

        tb_data_name = el.parentElement.querySelector(".tb-name").innerText;
        tb_data_str_datetime = el.parentElement.querySelector(".tb-datetime").innerText;
        tb_data_nfc_uid = el.parentElement.querySelector(".tb-nfc-uid").innerText;

        tb_data_datetime = dateToDateInputFormat(tb_data_str_datetime);
        form_edit_formatted_date.value = datetimeToIntDatetime(tb_data_datetime);
        
        form_edit_name.value = tb_data_name;
        form_edit_date.value = tb_data_datetime;
        form_edit_nfc_uid.value = tb_data_nfc_uid;
    });
});

form_edit_submit_btn.addEventListener("click", async () => {
    if (tb_data_name == form_edit_name.value && tb_data_datetime == form_edit_date.value && tb_data_nfc_uid == form_edit_nfc_uid.value) {
        notificationAlert("Fehler:", "Es muss mindestens eine Sache geändert werden!", 5);
    } else {
        let datetime_value = dateInputFormatToStrDate(form_edit_date.value);
        try {
            const confirmed = await confirmAlert(
                "Sicher, dass du den Eintrag zu:\nName: \t" + form_edit_name.value + 
                "\nZeit: \t" + datetime_value + 
                "\nNFC-UID: \t" + form_edit_nfc_uid.value + 
                "\nändern willst?"
            );

            if (confirmed) {
                $.ajax({
                    type: "POST",
                    url: 'edit_entry.php',
                    data: {
                        operation: "edit", 
                        id: entry_id,
                        datetime: datetime_value,
                        nfc_uid: form_edit_nfc_uid.value,
                        nfc_tag: form_edit_name.value,
                        int_datetime: form_edit_formatted_date.value
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


form_edit_date.addEventListener("change", () => {
    form_edit_formatted_date.value = datetimeToIntDatetime(form_edit_date.value);
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