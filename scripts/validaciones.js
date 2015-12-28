function emailValido(email) {
    "use strict";
    var re = /^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/i;
    return re.test(email);
}

function passwordValido(pass) {
    "use strict";
    var re = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z!@#$%]{7,15}$/i;
    return re.test(pass);
}

function campoNoVacio(valor) {
    "use strict";
    if ((valor.length === 0) || (valor === undefined) || (valor === null) || (/^\s+$/.test(valor)))
        return false;

    return true;
}

function validarFormulario(formulario) {
    "use strict";
    var inputs = [];
    var textareas = [];

    for (var i = 0, len = formulario.children.length; i < len; i++) {
        if (formulario.children[i].tagName === "INPUT")
            inputs[inputs.length] = formulario.children[i];
        if (formulario.children[i].tagName === "TEXTAREA")
            textareas[textareas.length] = formulario.children[i];
    }

    for (var i = 0, len = inputs.length; i < len; i++) {
        if(!campoNoVacio(inputs[i].value)) {
            inputs[i].focus();
            alert("No deje un campo vacío.");
            return false;
        }
        var inputTipo = inputs[i].type;
        switch(inputTipo) {
            case "email":
                if(!emailValido(inputs[i].value)) {
                    inputs[i].focus();
                    alert("Asegúrese que el email es correcto.");
                    return false;
                }
                break;
            case "password":
                if(!passwordValido(inputs[i].value)) {
                    inputs[i].focus();
                    alert("Asegúrese que el password es válido.");
                    return false;
                }
                break;
        }
    }

    for (var i = 0, len = textareas.length; i < len; i++) {
        if (!campoNoVacio(textareas[i].value)) {
            textareas[i].focus();
            alert("No deje un campo vacío.");
            return false;
        }
    }
    return true;
}
