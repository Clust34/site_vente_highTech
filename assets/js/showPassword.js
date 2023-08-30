// récupère tous les input de type password
const inputPassword = document.querySelectorAll('input[type= "password"]');

// Vérifie si il y a des élément dedans
if(inputPassword) {
    // query selector all donc c'est un tableau
    inputPassword.forEach(input => {
        // creer une div
        const divParent = document.createElement('div');
        // ajoute une class à la div
        divParent.classList.add('parent-password');
        // creer et ajoute icon class
        const icon = document.createElement('i');
        icon.classList.add('bi', 'bi-eye-slash-fill', 'icon-password');

        // Ajout div avant le input password
        input.before(divParent);
        // Déplacer le input puis l'icon dans la div
        divParent.append(input, icon);

        icon.addEventListener('click', e => {
            // si input deja un password
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            // change le type de input
            input.type = type;

            if (type === 'password') {
                icon.classList.remove('bi-eye-fill');
                icon.classList.add('bi-eye-slash-fill');
            } else {
                icon.classList.remove('bi-eye-slash-fill');
                icon.classList.add('bi-eye-fill');
            }
        });
    });
}