class Form{
    constructor(){
        // this.loginForm = document.querySelector(".auth-login");
        // this.registerForm = document.querySelector(".auth-register");
    }
    login(){
        document.querySelector(".auth-login").style.display = "flex";
        document.querySelector(".auth-register").style.display = "none";
        // display login
        return;
    }
    register(){
        document.querySelector(".auth-register").style.display = "flex";
        document.querySelector(".auth-login").style.display = "none";
        // display register
        return;
    }
}
const form = new Form;