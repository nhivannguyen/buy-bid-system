// Student: VAN NHI NGUYEN (101256529)
// Assignment 2: COS30020 Web application Developments
// File function:
// send request to php
// display success message to new customer

var xhr = false;
if (window.XMLHttpRequest)
{
    xhr = new XMLHttpRequest();
}
else if (window.ActiveXObject)
{
    xhr = new ActiveXObject("Microsoft.XMLHTTP");
}

function getData()
{
    console.log("before");
    console.log(xhr.readyState);
    console.log(xhr.status);

    if ((xhr.readyState == 4) && (xhr.status == 200))
    {
        var serverResponse = xhr.responseText;
        var res = JSON.parse(serverResponse);
        if (res) {
            alert("You have registered successfully!");
            return;
        }
        for (var key in res)
        {
            var elm = document.getElementsByClassName(key);
            elm[0].innerHTML = res[key];
        }
    }
    console.log("after");
    console.log(xhr.readyState);
    console.log(xhr.status);
    console.log("end");
}

function addCust()
{
    var fname = document.getElementById("fname").value;
    var lname = document.getElementById("lname").value;
    var email = document.getElementById("email").value;

    xhr.open("GET", "register.php?"
                    + "fname=" + encodeURIComponent(fname)
                    + "&lname=" + encodeURIComponent(lname)
                    + "&email=" + encodeURIComponent(email));

    xhr.onreadystatechange = getData;
    xhr.send(null);
}
