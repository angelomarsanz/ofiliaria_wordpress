jQuery(document).ready(function($) {
    // Lógica para los pasos del formulario
    var currentStep = 1;
    var totalSteps = $('.form-steps .step').length;

    function updateStepDisplay() {
        $('.form-steps .step').removeClass('active');
        $('.form-steps .step-label').removeClass('active');
        $('.form-steps .step-' + currentStep).addClass('active');
        $('.step-label-' + currentStep).addClass('active');

        if (currentStep === 1) {
            $('.step-prev').hide();
        } else {
            $('.step-prev').show();
        }

        if (currentStep === totalSteps) {
            $('.step-next').hide();
            $('.step-submit').show();
        } else {
            $('.step-next').show();
            $('.step-submit').hide();
        }
    }

    updateStepDisplay();

    $('.step-next').on('click', function() {
        if (currentStep < totalSteps) {
            currentStep++;
            updateStepDisplay();
        }
    });

    $('.step-prev').on('click', function() {
        if (currentStep > 1) {
            currentStep--;
            updateStepDisplay();
        }
    });

    // Lógica para la animación del spinner
    // Crear el elemento del spinner y el mensaje
    const spinnerOverlay = document.createElement('div');
    spinnerOverlay.className = 'spinner-overlay';
    spinnerOverlay.style.cssText = 'position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255, 255, 255, 0.8); z-index: 9999; display: none; align-items: center; justify-content: center; flex-direction: column;';

    const spinner = document.createElement('div');
    spinner.style.cssText = 'border: 4px solid #f3f3f3; border-top: 4px solid #3498db; border-radius: 50%; width: 50px; height: 50px; animation: spin 2s linear infinite;';
    spinner.id = 'loading-spinner';

    const message = document.createElement('p');
    message.innerText = 'Por favor espere...';
    message.style.cssText = 'margin-top: 10px; font-weight: bold;';

    spinnerOverlay.appendChild(spinner);
    spinnerOverlay.appendChild(message);
    document.body.appendChild(spinnerOverlay);

    // Agregar la animación CSS al <head>
    const style = document.createElement('style');
    style.innerHTML = `
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    `;
    document.head.appendChild(style);

    // Función para mostrar/ocultar el spinner
    function toggleSpinner(show, msg = 'Por favor espere...') {
        message.innerText = msg;
        spinnerOverlay.style.display = show ? 'flex' : 'none';
    }

    // Lógica para el envío del formulario y animación del botón
    $('#form-crear-contrato').on('submit', function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        formData.append('action', 'guardar_contrato_ajax');
        formData.append('nonce', contrato_form_data.nonce_crear);

        // Mostrar el spinner antes de enviar la petición
        toggleSpinner(true, 'Por favor espere mientras se guarda el contrato...');

        $.ajax({
            url: contrato_form_data.ajaxurl,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                // ...
            },
            success: function(response) {
                if (response.success) {
                    // Actualizar el mensaje del spinner para la redirección
                    toggleSpinner(true, '¡Contrato guardado! Redireccionando...');
                    
                    // Esperar 1 segundo y luego redireccionar
                    setTimeout(function() {
                        window.location.href = '/contratos-externos/';
                    }, 1000); // 1000ms = 1 segundo
                } else {
                    // Si hay un error, mostrar la alerta y ocultar el spinner
                    alert('Error: ' + (response.data));
                    toggleSpinner(false);
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                alert('Error AJAX: ' + error);
                toggleSpinner(false);
            },
            complete: function() {
                // Ya no necesitamos ocultar el spinner aquí si la redirección es exitosa
                // La página se recargará, lo que lo ocultará automáticamente.
            }
        });
    });

    // Opcional: Quitar el borde rojo al corregir el error en tiempo real
    $(document).on('input change', '[required]', function() {
        if (this.value) {
            $(this).removeClass('input-error');
        }
    });

    // ===================================
    // Lógica para el formulario de edición
    // ===================================
    function handleEditForm() {
        // Asegurarse de que las variables de PHP están disponibles
        if (typeof contrato_edicion_data === 'undefined') {
            return; // No estamos en la página de edición, salir
        }

        // Inicializar el campo oculto con los IDs existentes
        var documentosExistentesIds = contrato_edicion_data.documentos_ids;
        $('#documentos-existentes-input').val(documentosExistentesIds.join(','));

        // Lógica para eliminar un documento del DOM y de la base de datos
        $(document).on('click', '.eliminar-documento-btn', function() {
            var docId = $(this).data('id');
            var listItem = $(this).closest('li');

            // Confirmación antes de eliminar
            if (confirm('¿Estás seguro de que deseas eliminar este documento? Esta acción es irreversible.')) {
                
                toggleSpinner(true, 'Por favor espere mientras se elimina el archivo...');

                $.ajax({
                    url: contrato_form_data.ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'eliminar_documento_ajax',
                        documento_id: docId,
                        contrato_id: contrato_edicion_data.contrato_id,
                        nonce: contrato_form_data.nonce_eliminar
                    },
                    success: function(response) {
                        if (response.success) {
                            documentosExistentesIds = documentosExistentesIds.filter(id => id !== docId);
                            $('#documentos-existentes-input').val(documentosExistentesIds.join(','));

                            listItem.fadeOut('slow', function() {
                                $(this).remove();
                                if ($('#documentos-existentes-lista li').length === 0) {
                                    $('#documentos-existentes-lista').parent().append('<p>No hay documentos adjuntos.</p>');
                                }
                            });
                        } else {
                            alert('Error al eliminar el documento: ' + (response.data || 'Error desconocido.'));
                        }
                    },
                    error: function() {
                        alert('Error en la comunicación con el servidor.');
                    },
                    complete: function() {
                        toggleSpinner(false);
                    }
                });
            }
        });

        // Lógica para el envío del formulario de edición
        $('#form-editar-contrato').on('submit', function(e) {
            e.preventDefault();

            // Deshabilitar botón y ocultar la alerta
            var btn = $('#btn-editar-contrato');
            btn.prop('disabled', true);
            $('#alerta-edicion').removeClass('alert-success alert-danger').addClass('d-none');
            
            // Mostrar spinner con mensaje de guardado
            toggleSpinner(true, 'Por favor espere mientras se guardan los cambios...');

            var form = this;
            var formData = new FormData(form);
            formData.append('nonce', contrato_form_data.nonce_editar); // <-- Agregamos el nonce de edición

            $.ajax({
                url: contrato_form_data.ajaxurl,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        // Cambiar mensaje y redirigir
                        toggleSpinner(true, '¡Cambios guardados! Redirigiendo...');
                        setTimeout(function() {
                            window.location.href = '/contratos-externos/';
                        }, 2000);
                    } else {
                        // Ocultar spinner y mostrar alerta de error
                        toggleSpinner(false);
                        var alerta = $('#alerta-edicion');
                        alerta.addClass('alert-danger').text(response.data || 'Error al actualizar el contrato.').fadeIn();
                    }
                },
                error: function() {
                    toggleSpinner(false);
                    var alerta = $('#alerta-edicion');
                    alerta.addClass('alert-danger').text('Error inesperado.').fadeIn();
                },
                complete: function() {
                    // El botón se habilita de nuevo si no hay redirección
                    if (!$('#alerta-edicion').hasClass('alert-success')) {
                        btn.prop('disabled', false);
                    }
                }
            });
        });
    }

    // Llamar a la función de edición si el formulario de edición existe en la página
    if ($('#form-editar-contrato').length) {
        handleEditForm();
    }
    
    // Función para manejar la eliminación del contrato, utilizada en varias vistas
    function handleContractDeletion(contratoId, afterSuccessCallback) {
        if (confirm('¿Estás seguro de que deseas eliminar este contrato?')) {
            toggleSpinner(true, 'Por favor espere mientras se elimina el contrato...');

            $.ajax({
                url: contrato_form_data.ajaxurl,
                type: 'POST',
                data: {
                    action: 'eliminar_contrato_ajax',
                    contrato_id: contratoId,
                    nonce: contrato_form_data.nonce_eliminar
                },
                success: function(response) {
                    if (response.success) {
                        toggleSpinner(true, 'Contrato eliminado. Redireccionando...');
                        setTimeout(function() {
                            window.location.href = '/contratos-externos/';
                        }, 2000);
                    } else {
                        console.log('eliminar_contrato', response);
                        alert(response.data || 'Ocurrió un error al eliminar');
                        toggleSpinner(false);
                    }
                },
                error: function() {
                    alert('Error en la comunicación con el servidor');
                    toggleSpinner(false);
                }
            });
        }
    }

    // Lógica para eliminar un contrato desde la vista de lista
    $(document).on('click', '.eliminar-contrato', function(e) {
        e.preventDefault();
        const contratoId = $(this).data('id');
        handleContractDeletion(contratoId);
    });
    
    // Lógica para eliminar un contrato desde la vista de detalles
    $(document).on('click', '#btn-eliminar-detalles', function(e) {
        e.preventDefault();
        const contratoId = $(this).data('id');
        handleContractDeletion(contratoId);
    });

});