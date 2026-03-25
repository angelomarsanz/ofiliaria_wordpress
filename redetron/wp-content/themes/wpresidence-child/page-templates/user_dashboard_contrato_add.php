<?php
/** MILLDONE
 * Template Name: User Dashboard Agregar Contratos
 * src: page-templates\user_dashboard_contrato_add.php
 */

wpestate_dashboard_header_permissions();
get_header();
?>

<div class="row row_user_dashboard">
    <?php get_template_part('templates/dashboard-templates/dashboard-left-col'); ?>
    <div class="col-md-9 dashboard-margin">
        <?php wpestate_show_dashboard_title(get_the_title()); ?>

        <div class="col-md-12 wpestate_dash_coluns">
            <div class="wpestate_dashboard_content_wrapper">
                <div id="form-error-message" style="display:none; color: red; margin-bottom: 20px;"></div>
                <div id="alerta-crear" class="alert d-none" role="alert"></div>

                <form id="form-crear-contrato" enctype="multipart/form-data">
                    <div class="form-steps">
                        <div class="form-progress">
                            <div class="step-label step-label-1 active">Propietario</div>
                            <div class="step-label step-label-2">Arrendatario</div>
                            <div class="step-label step-label-3">Contrato</div>
                        </div>

                        <div class="step step-1 active">
                            <h4>Datos del Propietario</h4>
                            <input type="text" name="prop_nombre" placeholder="Nombre propietario" required>
                            <input type="text" name="prop_apellido" placeholder="Apellido propietario" required>
                            <select name="prop_doc_tipo" class="form-seleccionar" required >
                                <option value="">Tipo de documento</option>
                                <option value="CI">CI</option>
                                <option value="Pasaporte">Pasaporte</option>
                                <option value="Licencia de conducir">Licencia de conducir</option>
                                <option value="DNI">DNI</option>
                            </select>
                            <input type="text" name="prop_doc_num" placeholder="Número de documento" required>
                            <input type="email" name="prop_email" placeholder="Email propietario" required>
                            <input type="text" name="prop_telefono" placeholder="Teléfono móvil" required>
                        </div>

                        <div class="step step-2">
                            <h4>Datos del Arrendatario</h4>
                            <input type="text" name="arr_nombre" placeholder="Nombre inquilino" required>
                            <input type="text" name="arr_apellido" placeholder="Apellido inquilino" required>
                            <select name="arr_doc_tipo" class="form-seleccionar" required>
                                <option value="">Tipo de documento</option>
                                <option value="CI">CI</option>
                                <option value="Pasaporte">Pasaporte</option>
                                <option value="Licencia de conducir">Licencia de conducir</option>
                                <option value="DNI">DNI</option>
                            </select>
                            <br>
                            <input type="text" name="arr_doc_num" placeholder="Número de documento" required>
                            <input type="email" name="arr_email" placeholder="Email inquilino" required>
                            <input type="text" name="arr_telefono" placeholder="Teléfono móvil" required>
                        </div>

                        <div class="step step-3">
                            <h4>Datos del Contrato</h4>
                            <input type="text" name="titulo_contrato" placeholder="Título del contrato" required>
                            <select name="garantia" class="form-seleccionar" required>
                                <option value="">Tipo de garantía</option>
                                <option value="ANDA">ANDA</option>
                                <option value="Contaduria">Contaduria</option>
                                <option value="Sura">Sura</option>
                                <option value="Porto">Porto</option>
                                <option value="Mapfre">Mapfre</option>
                                <option value="Sancor">Sancor</option>
                                <option value="San Cristóbal">San Cristóbal</option>
                                <option value="BSE">BSE</option>
                                <option value="SBI">SBI</option>
                                <option value="Santander Zurich">Santander Zurich</option>
                                <option value="LUC">LUC</option>
                                <option value="Depósito BHU">Depósito BHU</option>
                                <option value="Depósito en Cuenta Propietario">Depósito en Cuenta Propietario</option>
                                <option value="Depósito">Depósito</option>
                                <option value="FIDECIU">FIDECIU</option>
                                <option value="ANV">ANV</option>
                                <option value="otro">Otro</option>
                            </select>
                            <br><br>
                            <label>Fecha de inicio</label><br>
                            <input type="date" name="fecha_inicio" class="campo-fecha-c" required>
                            <br><br>
                            <label>Fecha de vencimiento</label><br>
                            <input type="date" name="fecha_fin" class="campo-fecha-c" required>
                            <br><br>
                            <input type="number" name="monto" placeholder="Monto del contrato" required>
                            <select name="divisa" class="form-seleccionar" required>
                                <option value="">Divisa</option>
                                <option value="UYU">UYU</option>
                                <option value="USD">USD</option>
                            </select>
                            <br>
                            <select name="ciclo_pago" class="form-seleccionar" required>
                                <option value="">Ciclo de pago</option>
                                <option value="Mensual">Mensual</option>
                                <option value="Trimestral">Trimestral</option>
                                <option value="Semestral">Semestral</option>
                                <option value="Anual">Anual</option>
                            </select>
                            <br>
                            <label>Adjuntar documentos</label>
                            <input type="file" name="documentos[]" class="form-control" multiple>
                        </div>
                        <br><br>
                        <div class="step-navigation">
                            <button type="button" class="step-prev">Atrás</button>
                            <button type="button" class="step-next">Siguiente</button>
                            <button type="submit" class="step-submit" id="btn-crear-contrato" style="display: none;">
                           <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                             <span class="texto-btn">Guardar contrato</span>
                            </button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .form-steps .step { display: none; }
    .form-steps .step.active { display: block; }
    .form-progress { display: flex; justify-content: space-between; margin-bottom: 20px; }
    .step-label { padding: 10px; border-bottom: 2px solid #ccc; flex: 1; text-align: center; }
    .step-label.active { border-bottom: 3px solid #0073aa; font-weight: bold; }
</style>

<?php get_footer(); ?>