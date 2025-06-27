document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.btn-show-table');
    
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const modalName = this.getAttribute('data-modal');
            
            const allColumns = document.querySelectorAll('.container-list-column');
            
            allColumns.forEach(column => {
                if (column.classList.contains(modalName)) {
                    column.style.display = '';
                } else {
                    column.style.display = 'none';
                    column.innerHTML = '';
                }
            });
        });
    });
});