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

    // Função para obter o termo da busca
    function getSearchTerm() {
        // 1. Tenta pegar do input principal de busca
        var input = document.querySelector('.listivo-main-search-form input[type="text"]');
        if (input && input.value) {
            return input.value.trim();
        }
        // 2. Tenta pegar do filtro ativo na página de resultado
        var filterSpan = document.querySelector('.listivo-search-filter span');
        if (filterSpan && filterSpan.textContent) {
            return filterSpan.textContent.trim();
        }
        // 3. Alternativamente, pode adaptar para outros seletores se necessário
        return '';
    }

    // Handler do clique no botão
    var saveBtn = document.getElementById('savebtn');
    if (saveBtn) {
        saveBtn.addEventListener('click', function(e) {
            e.preventDefault();
            var term = getSearchTerm();
            if (!term) {
                alert('Termo de busca não encontrado.');
                return;
            }
            saveBtn.classList.add('loading');
            fetch(window.ajaxurl || '/wp-admin/admin-ajax.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'action=save_search_term&term=' + encodeURIComponent(term)
            })
            .then(response => response.json())
            .then(data => {
                saveBtn.classList.remove('loading');
                if (data.success) {
                    alert('Busca salva com sucesso!');
                    saveBtn.classList.add('hidden');
                } else {
                    alert(data.data && data.data.message ? data.data.message : 'Erro ao salvar.');
                }
            })
            .catch(() => {
                saveBtn.classList.remove('loading');
                alert('Erro ao salvar.');
            });
        });
    }
}); 