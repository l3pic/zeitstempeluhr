var btn_switch = document.getElementById("btn_editmode");
var logout_btn = document.getElementById("logout_btn");

if(sessionStorage.getItem('editmode') != null && sessionStorage.getItem('editmode') == 'true') {
    btn_switch.checked = true;
    let btns_edit = document.querySelectorAll(".tb-edit")
    btns_edit.forEach((el) => {
        el.classList.remove("hide");
    });
    let passwds = document.querySelectorAll(".tb-passwd");
    passwds.forEach((el) => {
        el.classList.remove('blur-text');
    })
}

btn_switch.addEventListener('change', (el) => {
    edit = el.target.checked;
    if(edit == true) {
        let btns_edit = document.querySelectorAll(".tb-edit")
        btns_edit.forEach((el) => {
            el.classList.remove("hide");
        });

        let passwds = document.querySelectorAll(".tb-passwd");
        passwds.forEach((el) => {
            el.classList.remove('blur-text');
        })
        sessionStorage.setItem('editmode', 'true');
    } else {
        let btns_edit = document.querySelectorAll(".tb-edit")
        btns_edit.forEach((el) => {
            el.classList.add("hide");
        });

        let passwds = document.querySelectorAll(".tb-passwd");
        passwds.forEach((el) => {
            el.classList.add('blur-text');
        })
        sessionStorage.setItem('editmode', 'false');
    }
});

logout_btn.addEventListener("click", () => {
    sessionStorage.clear();
});