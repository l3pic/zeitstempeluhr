//----------------------Funktionen---------------------------------------------------------------------------------------------------------------
//----------------------formatieren--von--Daten--------------------------------------------------
function dateToDateInputFormat(dt_tbval) {
    return (
        dt_tbval.slice(-4) + "-" + 
        dt_tbval.slice(9, 11) + "-" + 
        dt_tbval.slice(6, 8) + "T" + 
        dt_tbval.slice(0, 2) + ":" + 
        dt_tbval.slice(3, 5)
    );
}

function dateInputFormatToStrDate(date_input){
    return (
        date_input.slice(-5) + " " +
        date_input.slice(8, 10) + "-" +
        date_input.slice(5, 7) + "-" +
        date_input.slice(0, 4)
    );
}

function datetimeToIntDatetime(datetime) {
    return (datetime.replaceAll('-', '').replaceAll(':', '').replaceAll('T',''));
}


//----------------------Bestätigungsabfrage-------------------------------------------------------
async function confirmAlert(text) {
    return new Promise((resolve, reject) => {
        confirm_alert.classList.remove('hide');
        confirm_alert_text.innerText = text;

        backdrop.addEventListener("click", () => {
            confirm_alert.classList.add('hide');
            resolve(false);
        });

        alert_submit.addEventListener("click", () => {
            confirm_alert.classList.add('hide');  
            backdrop.classList.add('hide');   
            resolve(true);
        });

        alert_cancel.addEventListener("click", () => {
            confirm_alert.classList.add('hide');
            resolve(false);
        });
    });
}

//----------------------Benachrichtigungsfeld-----------------------------------------------------
function notificationAlert(title, text, duration) {
    notification_alert.classList.remove('hide');
    notification_title.innerText = title;
    notification_text.innerText = text;
    notification_alert_pbar.max = duration;
    notification_alert_pbar.value = duration;
    setTimeout(() =>  {notification_alert_pbar.value -= 1;}, 100)
    
    interval = setInterval(()=> {
        if (notification_alert_pbar.value == 0) {
            notification_alert.classList.add('hide');
            clearInterval(interval);
        }
        notification_alert_pbar.value -= 1;
    }, 1000)
}