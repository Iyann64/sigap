function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    if (sidebar && overlay) {
        sidebar.classList.toggle('open');
        overlay.classList.toggle('active');
    }
}

window.toggleSidebar = toggleSidebar;
