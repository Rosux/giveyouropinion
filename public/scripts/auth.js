class Form{
    login(){
        document.querySelector(".auth-login").style.display = "flex";
        document.querySelector(".auth-register").style.display = "none";
        // change url to login
        window.history.pushState({}, "", "login");
    }
    register(){
        document.querySelector(".auth-register").style.display = "flex";
        document.querySelector(".auth-login").style.display = "none";
        // change url to register
        window.history.pushState({}, "", "register");
    }
}
const form = new Form;