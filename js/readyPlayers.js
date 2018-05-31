var myVar = setInterval(checkReady, 1000);

function checkReady() {
    var d = new Date();
    alert(d.toLocaleTimeString());
}