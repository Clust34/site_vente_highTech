// On récupère l'élément HTML balise a pour pouvoir ajouter la classe open au click
let burgerBtn = document.querySelector('.link-burger');

// on récupère l'élément HTML balise ul avec le menu pour ajouter la classe
// open au click sur l'élément burgerBtn
let navbarLinks = document.querySelector('.navbar-links ul');
let navbarLinksApp = document.querySelectorAll('.nav-links-app');

if (burgerBtn && navbarLinks && navbarLinksApp) {
    burgerBtn.addEventListener('click', () => {
        burgerBtn.classList.toggle('open');
        navbarLinks.classList.toggle('open');


        navbarLinksApp.forEach(app => {
            app.classList.toggle('open');
        });
    });
}


