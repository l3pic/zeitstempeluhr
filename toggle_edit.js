var btn_switch = document.getElementById("btn_editmode");
var logout_btn = document.getElementById("logout_btn");

btn_switch.addEventListener('change', (el) => {
    edit = el.target.checked;
    if(edit == true) {
        let btns_edit = document.querySelectorAll(".tb-edit")
        btns_edit.forEach((el) => {
            el.classList.remove("hide");
        });

        let btns_del = document.querySelectorAll(".tb-del")
        btns_del.forEach((el) => {
            el.classList.remove("hide");
        });

        sessionStorage.setItem('editmode', 'true');
    } else {
        let btns_edit = document.querySelectorAll(".tb-edit")
        btns_edit.forEach((el) => {
            el.classList.add("hide");
        });

        let btns_del = document.querySelectorAll(".tb-del")
        btns_del.forEach((el) => {
            el.classList.add("hide");
        });

        sessionStorage.setItem('editmode', 'false');
    }
});

logout_btn.addEventListener("click", () => {
    sessionStorage.clear();
});