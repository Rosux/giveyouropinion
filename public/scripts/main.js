class MobileHeader{
    constructor(){
        this.header = document.getElementsByClassName("mobile-header")[0];

        document.querySelector("header > .header-links-mobile-button > svg").addEventListener("click", (e)=>{this.show();});
        document.querySelector(".mobile-header > .mobile-button > svg").addEventListener("click", (e)=>{this.hide();});

        const mobileMenuWidth = window.matchMedia('(min-width: 750px)');
        mobileMenuWidth.addEventListener("change", ()=>{
            if(mobileMenuWidth.matches){
                this.hide();
            }
        });
    }
    hide(){
        this.header.style.transition = "none";
        this.header.style.right = "-100vw";
    }
    show(){
        this.header.style.transition = "none";
        this.header.style.right = "0vw";
    }
}
const mobileHeader = new MobileHeader();
