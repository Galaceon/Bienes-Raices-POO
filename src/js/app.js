const mobileMenu = document.querySelector('.mobile-menu');
const navegacion = document.querySelector('.navegacion');
const botonDarkMode = document.querySelector('.dark-mode-boton')

mobileMenu.addEventListener("click", function() {
    navegacion.classList.toggle('mostrar');
})

function darkMode() {
    const userThemePreferences = window.matchMedia('(prefers-color-scheme: dark)');

    userThemePreferences.addEventListener('change', function() {
        if( userThemePreferences.matches) {
            document.body.classList.add('dark-mode')
        } else {
            document.body.classList.remove('dark-mode')
        }
    })


    botonDarkMode.addEventListener('click', function() {
        document.body.classList.toggle('dark-mode');
    })
}

darkMode();