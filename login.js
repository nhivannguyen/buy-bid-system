// Student: VAN NHI NGUYEN (101256529)
// Assignment 2: COS30020 Web application Developments
// File function:
// Send request to php

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
    if ((xhr.readyState == 4) && (xhr.status == 200))
    {
        var res = xhr.responseText;
        if (res == "false")
        {
            document.getElementById("err").innerHTML = "Your email or password is incorrect";
        }
        else
        {
            alert("You have logged in successfully! :)");
            window.location.href="bidding.htm";
        }
    }
}

function checkInp()
{
    var email = document.getElementById("email").value;
    var pass = document.getElementById("password").value;
    xhr.open("GET", "login.php?"
                    + "email=" + encodeURIComponent(email)
                    + "&pass=" + encodeURIComponent(pass));

    xhr.onreadystatechange = getData;
    xhr.send(null);
}
