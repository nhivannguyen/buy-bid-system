// Student: VAN NHI NGUYEN (101256529)
// Assignment 2: COS30020 Web application Developments
// File function: Send request to get name and display the name of the currently logged in customer

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

function getName() {
    ajax("POST", "username.php", "", function(res) {
        cusname.innerHTML = res;
        if (res == "stranger") {
            cusname.innerHTML = "<a href='login.htm' style='color:#9d9d9d; text-decoration:none'>" + res + "</a>";
        };
    });
}
