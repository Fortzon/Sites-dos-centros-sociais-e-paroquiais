const textarea = document.getElementById('noticiaTA');
const tituloInput = document.getElementById('TituloI');

function saveDraft() {
    const editor = tinymce.get('noticiaTA');
    if (editor) {
        localStorage.setItem('rascunho_titulo', tituloInput.value);
        localStorage.setItem('rascunho_conteudo', editor.getContent());
    }
}

function loadDraft() {
    const editor = tinymce.get('noticiaTA');
    if (!tituloInput.value && localStorage.getItem('rascunho_titulo')) {
        tituloInput.value = localStorage.getItem('rascunho_titulo');
    }
    if (editor && localStorage.getItem('rascunho_conteudo')) {
        editor.setContent(localStorage.getItem('rascunho_conteudo'));
    }
}

textarea.addEventListener('input', saveDraft);

window.onload = loadDraft;
