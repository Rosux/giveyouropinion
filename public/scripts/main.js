class MobileHeader{
    constructor(){
        this.header = document.getElementsByClassName("mobile-header")[0];
    }
    hide(){
        this.header.style.display = "none";
    }
    show(){
        this.header.style.display = "block";
    }
}
const mobileHeader = new MobileHeader();