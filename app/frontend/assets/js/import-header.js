//Modelo de import
//<div id="header" data-img-path="../images/logo-ufv.png" data-img-alt="Logo UFV" data-first-link="https://www.youtube.com/" data-first-text="Sair" data-second-link="#" data-second-text="Phelipe Romano"></div>

function capitalize(str) {
    return str.replace(/\b\w/g, char => char.toUpperCase());
}


fetch('../../components/header.html').
    then(res => res.text())
    .then(data => {

        fetch('../php/get-user-name.php').
        then(res => res.text())
        .then(name => {

            const component = document.getElementById('header');
            
            const imgPath  = component.getAttribute('data-img-path');
            const imgAlt  = component.getAttribute('data-img-alt');

            const firstLink  = component.getAttribute('data-first-link');
            const firstText  = component.getAttribute('data-first-text');

            const secondLink  = component.getAttribute('data-second-link');

            const parser = new DOMParser();
            const header = parser.parseFromString(data, 'text/html');

            const image = header.getElementById('logo-ufv');
            image.src = imgPath;
            image.alt = imgAlt;

            const firstNav = header.getElementById('firstNav');
            firstNav.innerText = firstText;
            firstNav.href = firstLink;

            const secondNav = header.getElementById('secondNav');
            secondNav.innerText = capitalize(name);
            secondNav.href = secondLink;



            component.innerHTML = header.body.innerHTML;
        });
});

