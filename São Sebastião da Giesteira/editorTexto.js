document.addEventListener('DOMContentLoaded', function () {
    tinymce.init({
        selector: '#noticiaTA',
        language: 'pt_PT',
        plugins: 'image link media table code lists',
        toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | image media link | bullist numlist | code',
        menubar: false,
        height: 400,
        branding: false,
        automatic_uploads: true,
        images_upload_handler: function(blobInfo) {
            return new Promise((resolve, reject) => {
                const tituloInput = document.getElementById('TituloI');
                if (!tituloInput) {
                reject("Campo de título não encontrado.");
                return;
                }

                const titulo = tituloInput.value.trim();
                if (!titulo) {
                reject("Você precisa preencher o título antes de adicionar uma imagem.");
                return;
                }

                const pastaNome = titulo.replace(/[^a-zA-Z0-9-_]/g, '_');
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'upload_imagem.php?titulo=' + encodeURIComponent(pastaNome));

                const csrfInput = document.querySelector('[name="csrf_token"]');
                if (!csrfInput) {
                reject("Token CSRF não encontrado.");
                return;
                }
                xhr.setRequestHeader('X-CSRF-Token', csrfInput.value);

                xhr.onload = function() {
                if (xhr.status === 200) {
                    try {
                    const json = JSON.parse(xhr.responseText);
                    if (json && json.location) {
                        resolve(json.location);
                    } else {
                        reject("Resposta inválida do servidor.");
                    }
                    } catch (e) {
                    reject("Erro ao interpretar resposta do servidor: " + e.message);
                    }
                } else {
                    reject("Erro HTTP: " + xhr.status);
                }
                };

                xhr.onerror = function() {
                reject("Erro de conexão ao enviar imagem.");
                };

                const file = blobInfo.blob();
                const filename = blobInfo.filename();
                const extensao = filename.split('.').pop().toLowerCase();
                const mimeAceitos = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'mp4', 'webm'];

                if (!mimeAceitos.includes(extensao)) {
                reject("Tipo de ficheiro não suportado: " + extensao);
                return;
                }

                const formData = new FormData();
                formData.append('file', file, filename);
                xhr.send(formData);
            });
            },
        init_instance_callback: function (editor) {
            if (typeof loadDraft === 'function') {
                loadDraft();
            }

            editor.on('Change KeyUp', function () {
                saveDraft();
            });
        }
    });

    document.getElementById("FormPub").addEventListener("submit", function(e) {
        const content = tinymce.get("noticiaTA").getContent({ format: 'text' }).trim();

        if (!content) {
            alert("A notícia não pode estar vazia.");
            e.preventDefault();
            return false;
        }
    });

});
