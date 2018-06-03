
function crypt() {
    pwd = document.getElementsById("pwd").value;
    login = document.getElementsById("login").value;
    jQuery(document).ready(function(){
        alert(test);
    });
}

function connexion() {
    pwd = document.getElementsById("pwd").value;
    login = document.getElementsById("login").value;
    try {
        Users::getUserConnect($login, $pwd);
        Users::saveIntoSession();
    }catch (Exception) {
        alert('User not found')
    }
}