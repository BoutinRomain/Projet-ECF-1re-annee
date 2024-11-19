// footer.js
const footer = document.createElement('footer');
footer.className = 'footer';
footer.innerHTML = `
    &copy; 2024 Esportify Événementiel E-SPORTS. Tous droits réservés.
`;

document.body.appendChild(footer);

const footerCSS = document.createElement('link');
footerCSS.rel = 'stylesheet';
footerCSS.href = 'css/footer.css';

document.head.appendChild(footerCSS);
