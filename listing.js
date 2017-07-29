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


function listItem() { // send new item data to php
    var iname = document.getElementById("iname").value;
    var ctg = document.getElementById("ctg").value;
    var desc = document.getElementById("desc").value;
    var sp = document.getElementById("sp").value;
    var rp = document.getElementById("rp").value;
    var binp = document.getElementById("binp").value;
    var durd = document.getElementById("durd").value;
    var durh = document.getElementById("durh").value;
    var durm = document.getElementById("durm").value;

    var data = "action=" + encodeURIComponent("getlist") +
        "&iname=" + encodeURIComponent(iname) +
        "&ctg=" + encodeURIComponent(ctg) +
        "&desc=" + encodeURIComponent(desc) +
        "&sp=" + encodeURIComponent(sp) +
        "&rp=" + encodeURIComponent(rp) +
        "&binp=" + encodeURIComponent(binp) +
        "&durd=" + encodeURIComponent(durd) +
        "&durh=" + encodeURIComponent(durh) +
        "&durm=" + encodeURIComponent(durm);

    ajax("POST", "listing.php", data, function(serverResponse) {
        var res = JSON.parse(serverResponse);
        if (res["success"]) {
            alert(res["sMsg"]);
        }
        for (var key in res) {
            var elm = document.getElementsByClassName(key);
            if (elm[0] != undefined)
                elm[0].innerHTML = res[key];
        }
    });
}

function getCat() { // get all categories from xml to display
    var data = "action=" + encodeURIComponent("getcat");
    ajax("POST", "listing.php", data, function(res) {
        if (res == "failure") {
            alert("Please log in!");
        } else {
            var ctgs = JSON.parse(res);
            for (var key in ctgs) {
                var option = document.getElementById("ctg");
                option.innerHTML += "<option value=" + ctgs[key] + ">"
                + ctgs[key] + "</option>";
            }
        }
    });
}

function getOther() { // take in new category
    var otherV = document.getElementById("other");
    otherV.value = prompt("Please enter the category: ");
}
