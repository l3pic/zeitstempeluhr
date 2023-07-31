var select_field = document.getElementById("select_user");
var btn_add = document.getElementById("btn_add");
var add_form = document.getElementById("add_form");
var add_nfc_uid = document.getElementById("add_nfc_uid");
var add_date = document.getElementById("add_date");
var formatted_add_date = document.getElementById("formatted_add_date");
var add_submit_btn = document.getElementById("add_submit_btn");
var jsonData_users;

btn_add.addEventListener("click", () => {
    add_form.classList.remove('hide');
    backdrop.classList.remove('hide');
    $.ajax({
        type: "POST",
        url: 'add_entry.php',
        data: {
            operation: "get"
        },
        success: function(response) {
            jsonData_users = JSON.parse(response);

            Object.keys(jsonData_users).forEach(key => {
                let select_option = document.createElement("option");
                select_option.value = jsonData_users[key].id;
                select_option.innerText = jsonData_users[key].username;
                select_field.appendChild(select_option);
            });

            add_nfc_uid.value = jsonData_users[select_field.value].nfc_uid;
        }
    });
    
    select_field.addEventListener("change", () => {
        add_nfc_uid.value = jsonData_users[select_field.value].nfc_uid;
    });

});

add_date.addEventListener("change", () => {
    formatted_add_date.value = datetimeToIntDatetime(add_date.value);
});

add_submit_btn.addEventListener("click", () => {
    if (!(add_date.value == '')) {
        $.ajax({
            type: "POST",
            url: 'add_entry.php',
            data: {
                operation: "insert",
                datetime: dateInputFormatToStrDate(add_date.value),
                nfc_uid: jsonData_users[select_field.value].nfc_uid,
                nfc_tag: jsonData_users[select_field.value].username,
                int_datetime: formatted_add_date.value
            },
            success: function(response) {
                var jsonData = JSON.parse(response);
                if(jsonData.success == true) {
                    let msg = {
                        title: 'Erfolg:',
                        text: 'Der Eintrag wurde erfolgreich erstellt!',
                        duration: 5
                    }
                    sessionStorage.setItem('notification', JSON.stringify(msg));
                    location.reload();
                } else {
                    notificationAlert("Fehler:", `Der Eintrag konnte nicht erstellt werden: ${jsonData.sql_error}`, 5);
                }
            }
        });
    }
});