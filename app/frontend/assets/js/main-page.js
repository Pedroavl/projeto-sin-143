const containerEventos = document.getElementById('eventos');
const paginationContainer = document.getElementById('pagination-links');

const eventos = [
    { imgSrc: '../images/Rectangle 22.png', description: '(WSIS) Workshop de Sistemas de Informação' },
    { imgSrc: '../images/Rectangle 22.png', description: '(WSIS) Workshop de Sistemas de Informação' },
    { imgSrc: '../images/Rectangle 22.png', description: '(WSIS) Workshop de Sistemas de Informação' },
    { imgSrc: '../images/Rectangle 22.png', description: '(WSIS) Workshop de Sistemas de Informação' },
    { imgSrc: '../images/Rectangle 22.png', description: '(WSIS) Workshop de Sistemas de Informação' },
    { imgSrc: '../images/Rectangle 22.png', description: '(WSIS) Workshop de Sistemas de Informação' },
    { imgSrc: '../images/Rectangle 22.png', description: '(WSIS) Workshop de Sistemas de Informação' },
    { imgSrc: '../images/Rectangle 22.png', description: '(WSIS) Workshop de Sistemas de Informação' },
    { imgSrc: '../images/Rectangle 22.png', description: '(WSIS) Workshop de Sistemas de Informação' },
    { imgSrc: '../images/Rectangle 22.png', description: '(WSIS) Workshop de Sistemas de Informação' },
    { imgSrc: '../images/Rectangle 22.png', description: '(WSIS) Workshop de Sistemas de Informação' },
    { imgSrc: '../images/Rectangle 22.png', description: '(WSIS) Workshop de Sistemas de Informação' },
    { imgSrc: '../images/Rectangle 22.png', description: '(WSIS) Workshop de Sistemas de Informação' },
    { imgSrc: '../images/Rectangle 22.png', description: '(WSIS) Workshop de Sistemas de Informação' },
    { imgSrc: '../images/Rectangle 22.png', description: '(WSIS) Workshop de Sistemas de Informação' },
    { imgSrc: '../images/Rectangle 22.png', description: '(WSIS) Workshop de Sistemas de Informação' },
    { imgSrc: '../images/Rectangle 22.png', description: '(WSIS) Workshop de Sistemas de Informação' },
    { imgSrc: '../images/Rectangle 22.png', description: '(WSIS) Workshop de Sistemas de Informação' },
    { imgSrc: '../images/Rectangle 22.png', description: '(WSIS) Workshop de Sistemas de Informação' },
    { imgSrc: '../images/Rectangle 22.png', description: '(WSIS) Workshop de Sistemas de Informação' },
    { imgSrc: '../images/Rectangle 22.png', description: '(WSIS) Workshop de Sistemas de Informação' },
    { imgSrc: '../images/Rectangle 22.png', description: '(WSIS) Workshop de Sistemas de Informação' },
    { imgSrc: '../images/Rectangle 22.png', description: '(WSIS) Workshop de Sistemas de Informação' },
    { imgSrc: '../images/Rectangle 22.png', description: '(WSIS) Workshop de Sistemas de Informação' },
    { imgSrc: '../images/Rectangle 22.png', description: '(WSIS) Workshop de Sistemas de Informação' },
    { imgSrc: '../images/Rectangle 22.png', description: '(WSIS) Workshop de Sistemas de Informação' },
];

const itemsPerPage = 12;
let currentPage = 1;

function renderPage(page) {
    containerEventos.innerHTML = '';
    const startIndex = (page - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const eventosToShow = eventos.slice(startIndex, endIndex);

    eventosToShow.forEach(element => {
        const divEvento = document.createElement('div');
        const imgEvento = document.createElement('img');
        const pEvento = document.createElement('p');

        divEvento.className = 'col-md-2 border rounded back-input m-4 fw-bold cursor-pointer';
        divEvento.style.width = '250px';
        divEvento.style.height = '250px';
        divEvento.style.cursor = 'pointer';

        imgEvento.className = 'img-fluid max-width';
        imgEvento.src = element.imgSrc;
        imgEvento.alt = element.description;

        pEvento.textContent = element.description;
        pEvento.style.margin = '10px';

        divEvento.appendChild(imgEvento);
        divEvento.appendChild(pEvento);

        divEvento.addEventListener('click', () => {
            alert(`Você clicou no evento: ${element.description}`);
        });

        containerEventos.appendChild(divEvento);
    });
}

function setupPagination() {
    const totalPages = Math.ceil(eventos.length / itemsPerPage);
    paginationContainer.innerHTML = '';

    for (let i = 1; i <= totalPages; i++) {
        const li = document.createElement('li');
        li.className = `page-item ${i === currentPage ? 'active' : ''} m-2`;
        const a = document.createElement('a');
        a.className = 'page-link rounded';
        a.href = '#';
        a.textContent = i;
        a.addEventListener('click', (event) => {
            event.preventDefault();
            currentPage = i;
            renderPage(currentPage);
            updatePagination();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
        li.appendChild(a);
        paginationContainer.appendChild(li);
    }
}

function updatePagination() {
    const paginationItems = document.querySelectorAll('.pagination .page-item');
    paginationItems.forEach((item, index) => {
        if (index + 1 === currentPage) {
            item.classList.add('active');
        } else {
            item.classList.remove('active');
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    renderPage(currentPage);
    setupPagination();
});