class DarkMode{constructor(t="",e=""){this.dmt=t,this.lmt=e,this.mode=this.#t(),"complete"===document.readyState||"interactive"===document.readyState?(this.setTheme(),this.applyListener()):window.addEventListener("DOMContentLoaded",(()=>{this.setTheme(),this.applyListener()}))}defaultColorScheme(){this.mode=window.matchMedia("(prefers-color-scheme: dark)").matches,this.#e()}on(){this.mode=!0,this.#e()}off(){this.mode=!1,this.#e()}toggle(){this.mode=!this.mode,this.#e()}getMode(){return this.mode}async applyListener(){const t=document.querySelectorAll("[darkmode-button]");for(let e=0;e<t.length;e++)t[e].addEventListener("click",(t=>{"on"===t.target.closest("[darkmode-button]").getAttribute("darkmode-button")?this.on():"off"===t.target.closest("[darkmode-button]").getAttribute("darkmode-button")?this.off():"switch"===t.target.closest("[darkmode-button]").getAttribute("darkmode-button")?this.toggle():"default"===t.target.closest("[darkmode-button]").getAttribute("darkmode-button")&&this.defaultColorScheme(),t.target.setAttribute("darkmode-data",this.mode)}));const e=document.querySelectorAll("[darkmode-selector]");for(let t=0;t<e.length;t++)e[t].addEventListener("change",(t=>{"false"===t.target.getAttribute("darkmode-selector")?t.target.checked?this.off():this.on():t.target.checked?this.on():this.off()}));this.updateButtons()}async updateButtons(){const t=document.querySelectorAll("[darkmode-button]");for(let e=0;e<t.length;e++)t[e].setAttribute("darkmode-data",this.mode);const e=document.querySelectorAll("[darkmode-selector]");for(let t=0;t<e.length;t++){const o=e[t];"false"===o.getAttribute("darkmode-selector")?this.mode?o.checked=!1:o.checked=!0:this.mode?o.checked=!0:o.checked=!1}}setTheme(){this.mode?document.body.style.cssText=this.dmt:document.body.style.cssText=this.lmt}#e(){this.setTheme(),this.updateButtons(),this.#o()}#t(){return null===localStorage.getItem("darkmode")&&localStorage.setItem("darkmode",window.matchMedia("(prefers-color-scheme: dark)").matches),"true"===localStorage.getItem("darkmode")}#o(){localStorage.setItem("darkmode",this.mode)}}

const darkModeTheme = `
    --header-color: #111;
    --background-color: #111;
    --text-color: #fff;
    --theme-color: #719A51;
    --theme-color-dark: #426D54;
    --theme-color-light: #B0CF98;
    --border-color: #373737;
    color-scheme: dark;
`;
const lightModeTheme = `
    --header-color: #fff;
    --background-color: #fff;
    --text-color: #111;
    --theme-color: #719A51;
    --theme-color-dark: #426D54;
    --theme-color-light: #B0CF98;
    --border-color: #e6e6e6;
    color-scheme: light;
`;
const darkmode = new DarkMode(darkModeTheme, lightModeTheme);



// if(document.readyState === "complete" || document.readyState === "interactive"){
//     darkmode.applyListener();
// }else{
//     window.addEventListener("DOMContentLoaded", ()=>{
//         darkmode.applyListener();
//     });
// }

// function addDarkModeButtons(){
//     const buttons = document.querySelectorAll("[dark-mode-switch]");
//     buttons.forEach(e => {
//         e.addEventListener("click", ()=>{
//             darkmode.toggle();
//         })
//     });
// }