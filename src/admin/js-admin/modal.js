document.querySelectorAll('.btn-show-table').forEach(btn => {
  btn.addEventListener('click', () => {
    const target = btn.dataset.modal;
    document.querySelectorAll('.container-form').forEach(modal => modal.style.display = 'none');
    const modal = document.getElementById(`modal-${target}`);
    if (modal) modal.style.display = 'flex';
  });
});

window.addEventListener('click', (e) => {
  document.querySelectorAll('.container-form').forEach(modal => {
    if (e.target === modal) {
      modal.style.display = 'none';
    }
  });
});