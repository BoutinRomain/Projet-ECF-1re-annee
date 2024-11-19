// header.js
fetch('header.php')
    .then(response => response.text())
    .then(data => {
        document.getElementById('header').innerHTML = data;

        const link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = 'css/header.css';
        document.head.appendChild(link);

        const currentPage = window.location.pathname.split("/").pop();
        const navLinks = document.querySelectorAll('.navigation a');
        navLinks.forEach(link => {
            if (link.getAttribute('href') === currentPage) {
                link.classList.add('active');
            }
        });
    })
    .catch(error => console.error('Erreur lors du chargement du header:', error));