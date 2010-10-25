
function check_email( value ) {
    if (!value.match(/[^\s]/g)) return "Не введен логин"
    var re = /^[\w-]+(\.[\w-]+)*@([\w-]+)\.+[a-zA-Z]{2,3}$/;
    if( !value.match(re) )
        return "Не верный вид логина"
}

function check_password( value) {
    if (!value.match(/[^\s]/g)) return "Не введен пароль"
    var re = /^[a-zA-Z]{8,50}$/;
    if( !value.match(re) )
        return "Не верный пароль"
}

function message_login( value ) {
    var answer = check_email(value)
    if( answer ) alert(answer);
}

function message_password( value ) {
    var answer = check_password(value)
    if( answer ) alert(answer);
}
