export const prepararCamposPersonas = (personas) => {
  for (let i = 0; i < personas.length; i++) 
  {
    if (personas[i].tipo_documento_identidad == null)
    {
      personas[i].tipo_documento_identidad = '';
    }
    if (personas[i].numero_identidad_arrendatario == null)
    {
      personas[i].numero_identidad_arrendatario = '';
    }
    if (personas[i].nombres_arrendatario == null)
    {
      personas[i].nombres_arrendatario = '';
    }

    if (personas[i].apellidos_arrendatario == null)
    {
      personas[i].apellidos_arrendatario = '';
    }
    if (personas[i].numero_identidad_empresa == null)
    {
      personas[i].numero_identidad_empresa = '';
    }
    if (personas[i].empresa == null)
    {
      personas[i].empresa = '';
    }
    if (personas[i].cargo_empresa == null)
    {
      personas[i].cargo_empresa = '';
    }
    if (personas[i].domicilio_persona == null)
    {
      personas[i].domicilio_persona = '';
    }
    if (personas[i].departamento_domicilio == null)
    {
      personas[i].departamento_domicilio = '';
    }
    if (personas[i].ciudad_domicilio == null)
    {
      personas[i].ciudad_domicilio = '';
    }
    if (personas[i].email_arrendatario == null)
    {
      personas[i].email_arrendatario = '';
    }
    if (personas[i].telefono_arrendatario == null)
    {
      personas[i].telefono_arrendatario = '';
    }
    if (personas[i].moneda_ingreso == null)
    {
      personas[i].moneda_ingreso = '';
    }
    personas[i].monto_ingreso = parseInt(personas[i].monto_ingreso);      
    if (personas[i].ingreso == null)
    {
      personas[i].ingreso = '';
    }
    if (personas[i].sueldo == null)
    {
      personas[i].sueldo = '';
    }
    if (personas[i].clasificacion_persona_fisica == null)
    {
      personas[i].clasificacion_persona_fisica = '';
    }
    if (personas[i].clasificacion_persona_juridica == null)
    {
      personas[i].clasificacion_persona_juridica = '';
    }
    if (personas[i].notas_persona == null)
    {
      personas[i].notas_persona = '';
    }
  }
  return personas;
}