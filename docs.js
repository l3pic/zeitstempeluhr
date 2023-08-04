var select_field = document.getElementById("select_user");
var date_from = document.getElementById("from");
var date_to = document.getElementById("to");
var create_btn = document.getElementById("create_file");

$.ajax({
    type: "POST",
    url: '/zeiten/add_entry.php',
    data: {
        operation: "get"
    },
    success: function(response) {
        jsonData_users = JSON.parse(response);

        Object.keys(jsonData_users).forEach(key => {
            let select_option = document.createElement("option");
            select_option.value = jsonData_users[key].nfc_uid;
            select_option.innerText = jsonData_users[key].username;
            select_field.appendChild(select_option);
        });
    }
});

create_btn.addEventListener("click", () => {
    if (date_from.value == "") {
        var date_str_from = "all";
    } else {
        var date_str_from = date_from.value;
    }

    if (date_to.value == "") {
        var date_str_to = "all";
    } else {
        var date_str_to = date_to.value;
    }
    $.ajax({
        type: "POST",
        url: '/create_excel.php',
        data: {
            nfc_uid: select_field.value,
            from: datetimeToIntDatetime(date_from.value) + '0000',
            to: datetimeToIntDatetime(date_to.value) + '2359',
            str_from: date_str_from,
            str_to: date_str_to
        },
        success: function(response) {
            jsonData = JSON.parse(response);
    
            console.log(jsonData)
        }
    });
})