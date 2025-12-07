import '../css/app.css';

document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.getElementById('themeToggle');
    const root = document.documentElement; // <html>

    if (!toggle) {
        console.warn('theme-toggle checkbox not found');
        return;
    }

    // Load stored theme
    const storedTheme = localStorage.getItem('theme');

    if (storedTheme === 'dark') {
        root.classList.add('dark');
        toggle.checked = true;
    } else if (storedTheme === 'light') {
        root.classList.remove('dark');
        toggle.checked = false;
    } else {
        // default (you can change to light if you want)
        root.classList.add('dark');
        toggle.checked = true;
    }

    // Listen for changes
    toggle.addEventListener('change', () => {
        if (toggle.checked) {
            root.classList.add('dark');
            localStorage.setItem('theme', 'dark');
        } else {
            root.classList.remove('dark');
            localStorage.setItem('theme', 'light');
        }
    });
});
