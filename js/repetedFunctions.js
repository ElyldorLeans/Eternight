var myVar = setInterval(checkRepart, 1000);

function checkRepart(idServer) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            repart = document.getElementById("repart");
            //alert(this.responseText);
            repart.innerHTML = this.responseText;
        }
    };
    xhttp.open("POST", "repartPlayerDB.php?server=" + idServer, true);
    xhttp.send();
}
