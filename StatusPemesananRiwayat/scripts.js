document.querySelectorAll('.detail-toggle').forEach(button => {
    button.addEventListener('click', function() {
        const card = this.closest('.order-card');
        const detailContent = card.querySelector('.detail-content');
        const arrow = this.innerHTML.includes('▼') ? '▲' : '▼';
        
        detailContent.classList.toggle('active');
        this.innerHTML = `Detail Pesanan ${arrow}`;
    });
});