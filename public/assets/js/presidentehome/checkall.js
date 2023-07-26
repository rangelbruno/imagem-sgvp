// Adicionar um ouvinte de eventos para todas as caixas de seleção
let checkboxes = document.querySelectorAll('.todochkbox');
checkboxes.forEach(function(checkbox) {
    checkbox.addEventListener('change', function() {
        // Verificar quantas caixas de seleção estão selecionadas
        let checkboxesSelecionados = document.querySelectorAll('.todochkbox:checked');
        if (checkboxesSelecionados.length > 1) {
            // Mostrar o botão de votação em bloco se mais de uma caixa de seleção estiver selecionada
            document.querySelector('.btn-votacao-bloco').style.display = 'block';
        } else {
            // Ocultar o botão de votação em bloco se apenas uma caixa de seleção estiver selecionada
            document.querySelector('.btn-votacao-bloco').style.display = 'none';
        }

        // Verificar se todas as caixas de seleção estão selecionadas e atualizar o botão "check all" de acordo
        let checkAllButton = document.querySelector('#todoAll');
        if (checkboxesSelecionados.length === checkboxes.length) {
            checkAllButton.checked = true;
        } else {
            checkAllButton.checked = false;
        }
    });
});

// Adicionar um ouvinte de eventos para o botão "check all"
let checkAllButton = document.querySelector('#todoAll');
checkAllButton.addEventListener('change', function() {
    // Definir o valor "checked" de todas as caixas de seleção para o valor do botão "check all"
    let checkboxes = document.querySelectorAll('.todochkbox');
    checkboxes.forEach(function(checkbox) {
        checkbox.checked = checkAllButton.checked;
    });

    // Verificar quantas caixas de seleção estão selecionadas
    let checkboxesSelecionados = document.querySelectorAll('.todochkbox:checked');
    if (checkboxesSelecionados.length > 1) {
        // Mostrar o botão de votação em bloco se mais de uma caixa de seleção estiver selecionada
        document.querySelector('.btn-votacao-bloco').style.display = 'block';
    } else {
        // Ocultar o botão de votação em bloco se apenas uma caixa de seleção estiver selecionada
        document.querySelector('.btn-votacao-bloco').style.display = 'none';
    }
});