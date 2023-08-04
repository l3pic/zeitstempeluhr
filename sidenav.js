var path = window.location.pathname;

switch (path) {
    case "/zeiten/zeiten.php":
        document.getElementById("zeiten").style.background = "#A63D40";
        break;
    
    case "/user/user.php":
        document.getElementById("user").style.background = "#A63D40";
        break;

    case "/docs.php":
        document.getElementById("docs").style.background = "#A63D40";
        break;
}

document.getElementById("username").addEventListener("click", (el) => {
    navigator.clipboard.writeText(el.target.innerText)
})

document.getElementById("nfc_uid").addEventListener("click", (el) => {
    navigator.clipboard.writeText(el.target.innerText)
})
