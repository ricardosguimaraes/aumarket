document.addEventListener('DOMContentLoaded', function () {
    // Variável global passada pelo PHP
    if (typeof window.saveSearchUserLogged === 'undefined' || !window.saveSearchUserLogged) {
        return;
    }

    // Função para checar e exibir o botão
    function checkShowSaveBtn() {
        var resultsCount = document.querySelector('.listivo-search-results__results-number-count');
        var saveBtn = document.getElementById('savebtn');
        if (resultsCount && saveBtn) {
            var count = parseInt(resultsCount.textContent.trim(), 10);
            if (count === 0) {
                saveBtn.classList.remove('hidden');
            } else {
                saveBtn.classList.add('hidden');
            }
        }
    }

    // Checa ao carregar
    checkShowSaveBtn();

    // Se AJAX recarregar resultados, pode ser necessário observar mudanças
    var observer = new MutationObserver(checkShowSaveBtn);
    var resultsContainer = document.querySelector('.listivo-search-results__results-number-count');
    if (resultsContainer) {
        observer.observe(resultsContainer, { childList: true, subtree: true });
    }
}); 