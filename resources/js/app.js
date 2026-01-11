import '../css/app.css';
import './bootstrap';
// import Alpine from 'alpinejs';

// window.Alpine = Alpine;


// document.addEventListener('DOMContentLoaded', () => {
//     const html = document.documentElement;
//     const toggle = document.getElementById('themeToggle');

//     if (!toggle) {
//         console.warn('themeToggle not found');
//         return;
//     }

//     // Load theme from localStorage, default to 'dark'
//     const savedTheme = localStorage.getItem('theme') || 'dark';
//     applyTheme(savedTheme, html, toggle);

//     // When slider changes
//     toggle.addEventListener('change', () => {
//         const newTheme = toggle.checked ? 'dark' : 'light';
//         localStorage.setItem('theme', newTheme);
//         applyTheme(newTheme, html, toggle);
//     });
// });

// function applyTheme(theme, html, toggle) {
//     if (theme === 'dark') {
//         html.classList.add('dark');
//         html.setAttribute('data-theme', 'army'); // DaisyUI or custom "army" theme
//         toggle.checked = true;
//     } else {
//         html.classList.remove('dark');
//         html.setAttribute('data-theme', 'light'); // or any other theme name
//         toggle.checked = false;
//     }
// }
