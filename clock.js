function showDate() {
    var date = new Date;
    var y = date.getFullYear();
    var m = date.getMonth();
    var d = date.getDay();

    if (d < 10) d = ("0" + d);
    if (m < 10) m = ("0" + m);

    var display_date = d + "." + m + "." + y;

    document.getElementById("dateDisplay").innerText = display_date;
    setTimeout(showDate, 1000);
}

function showTime(){
    var date = new Date();
    var h = date.getHours();
    var m = date.getMinutes();
    var s = date.getSeconds();

    h = (h < 10) ? "0" + h : h;
    m = (m < 10) ? "0" + m : m;
    s = (s < 10) ? "0" + s : s;

    var time = h + ":" + m + ":" + s;
    document.getElementById("clockDisplay").innerText = time;

    setTimeout(showTime, 1000);

}

showDate();
showTime();