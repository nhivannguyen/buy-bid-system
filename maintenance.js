// Student: VAN NHI NGUYEN (101256529)
// Assignment 2: COS30020 Web application Developments
// File function:
// Send requests to php

function ajax(method, php, data, cb) {
    var xhr = false;
    if (window.XMLHttpRequest) {
        xhr = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xhr.open(method, php, true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    xhr.onreadystatechange = function() {
        if ((xhr.readyState == 4) && (xhr.status == 200)) {
            var serverResponse = xhr.responseText;
            cb(serverResponse);
        }
    }
    xhr.send(data);
}

function checkStt() {
    ajax("POST", "maintenance.php", "action=" + encodeURIComponent("check"), function(res) {
        alert(res);
    });
}

function genRep() {
    ajax("POST", "maintenance.php","action=" + encodeURIComponent("gen"), function(res) {
        report.innerHTML = res;
    });
}
