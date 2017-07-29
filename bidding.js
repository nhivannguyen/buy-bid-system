// Student: VAN NHI NGUYEN (101256529)
// Assignment 2: COS30020 Web application Developments
// File function:
// Send requests to different php


function ajax(method, php, data, cb) { // create async conn and call back
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

function dispBid() {
    ajax("POST", "biddisplay.php", "", function(res) {
        disp.innerHTML = res;
    })
        setTimeout(dispBid, 5000); // after 5 sec it refresh
}

function bid(inum) { // send request for bidding
    var newBp = prompt("Enter your bid price: ");
    if (newBp == null || parseFloat(newBp) == NaN) {
        alert("Please enter a valid bid price!");
    } else {
        var data = "bp=" + encodeURIComponent(newBp) + "&inum=" + encodeURIComponent(inum);

        ajax("POST", "bidding.php", data, function(res) {
            alert(res);
        });
    }
}

function buy(inum) { // send request for buying
    var data = "inum=" + encodeURIComponent(inum);
    ajax("POST", "buying.php", data, function(res) {
        if (res == 'failure') {
            // window.location = 'login.htm'
        }
        alert(res);
    });
}
