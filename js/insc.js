const getSelector = ele => {
    return typeof ele === "string" ? document.querySelector(ele) : "";
}


// connection & inscription

const containerShow = () => {
    var show = getSelector(".container")
    show.className += " container-show"
}


window.onload = containerShow;
/*
function setInscTest(){
        let  loginBox = getSelector(".login-box"),
             signBox = getSelector(".sign-box");
        loginBox.className += 'animate_login';
        signBox.className += 'animate_sign';
}
*/
// switch
((window, document) => {

    // connecter -> inscription
    let toSignBtn = getSelector(".toSign"),
        toLoginBtn = getSelector(".toLogin"),
        loginBox = getSelector(".login-box"),
        signBox = getSelector(".sign-box");
    
    toSignBtn.onclick = () => {
        loginBox.className += ' animate_login';
        signBox.className += ' animate_sign';
    }

    toLoginBtn.onclick = () => {
        loginBox.classList.remove("animate_login");
        signBox.classList.remove("animate_sign");
    }


})(window, document);
