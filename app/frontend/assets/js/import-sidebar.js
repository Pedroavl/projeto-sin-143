//Modelo de import
//<div id="sidebar"></div>

fetch('../../../components/sidebar.html').
    then(res => res.text())
    .then(data => {

        const component = document.getElementById('sidebar');

        const parser = new DOMParser();
        const sidebar = parser.parseFromString(data, 'text/html');

        component.innerHTML = sidebar.body.innerHTML;
});

