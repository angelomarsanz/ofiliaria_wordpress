export const generarDatosContrato = async (datosContrato, dataContrato) => { 
    datosContrato.current = dataContrato.current;
    let personas = datosContrato.current.personas;
    let contadorPropietarios = 1;
    let contadorCodeudor = 1;
    for (let i = 0; i < personas.length; i++) 
    {
      if (personas[i].nombres_arrendatario != null && personas[i].nombres_arrendatario != '' && personas[i].nombres_arrendatario != '')
      {
        if (personas[i].tipo_arrendatario == 'Propietario')
        {
            datosContrato.current['nombres_apellidos_propietario_'+contadorPropietarios] = personas[i].nombres_arrendatario+' '+personas[i].apellidos_arrendatario; 
            datosContrato.current['tipo_documento_identidad_propietario_'+contadorPropietarios] = personas[i].tipo_documento_identidad;
            datosContrato.current['numero_documento_identidad_propietario_'+contadorPropietarios] = personas[i].numero_identidad_arrendatario;
            datosContrato.current['domicilio_propietario_'+contadorPropietarios] = personas[i].domicilio_persona;
            contadorPropietarios++;
        }
        if (personas[i].tipo_arrendatario == 'Solicitante')
        {
            datosContrato.current['nombres_apellidos_solicitante'] = personas[i].nombres_arrendatario+' '+personas[i].apellidos_arrendatario; 
            datosContrato.current['tipo_documento_identidad_solicitante'] = personas[i].tipo_documento_identidad;
            datosContrato.current['numero_documento_identidad_solicitante'] = personas[i].numero_identidad_arrendatario;
        }     
        if (personas[i].tipo_arrendatario == 'Cosolicitante')
        {
            datosContrato.current['nombres_apellidos_codeudor_'+contadorCodeudor] = personas[i].nombres_arrendatario+' '+personas[i].apellidos_arrendatario; 
            datosContrato.current['tipo_documento_identidad_codeudor_'+contadorCodeudor] = personas[i].tipo_documento_identidad;
            datosContrato.current['numero_documento_identidad__codeudor_'+contadorCodeudor] = personas[i].numero_identidad_arrendatario;
            contadorCodeudor++;
        }           
      }
    }
    return;
};