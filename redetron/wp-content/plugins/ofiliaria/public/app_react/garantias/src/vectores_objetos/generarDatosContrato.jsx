const unirPersonas = (lista) => {
    if (lista.length === 0) return '';
    if (lista.length === 1) return lista[0];
    const todosMenosElUltimo = lista.slice(0, -1).join(', ');
    const ultimo = lista[lista.length - 1];
    return `${todosMenosElUltimo} y ${ultimo}`;
};

export const generarDatosContrato = async (datosContrato, dataContrato) => {
  datosContrato.current = dataContrato.current;
  const personas = datosContrato.current.personas.filter(p => p.nombres_arrendatario && p.nombres_arrendatario.trim() !== '');

  // Generar string para Arrendadores (Propietarios)
  const propietarios = personas.filter(p => p.tipo_arrendatario === 'Propietario');
  const arrendadoresTextos = propietarios.map(p => {
    const nombreCompleto = `${p.nombres_arrendatario} ${p.apellidos_arrendatario}`;
    const domicilioCompleto = [p.domicilio_persona, p.ciudad_domicilio, p.departamento_domicilio].filter(Boolean).join(', ');
    return `${nombreCompleto}, titular del(la) ${p.tipo_documento_identidad} nro. ${p.numero_identidad_arrendatario} con domicilio constituido en ${domicilioCompleto}`;
  });
  datosContrato.current.texto_arrendador = unirPersonas(arrendadoresTextos);

  // Generar string para Arrendatarios (Solicitante y Cosolicitantes)
  const arrendatarios = personas.filter(p => p.tipo_arrendatario === 'Solicitante' || p.tipo_arrendatario === 'Cosolicitante');
  const arrendatariosTextos = arrendatarios.map(p => {
    const nombreCompleto = `${p.nombres_arrendatario} ${p.apellidos_arrendatario}`;
    return `${nombreCompleto}, titular del(la) ${p.tipo_documento_identidad} nro. ${p.numero_identidad_arrendatario}`;
  });
  datosContrato.current.texto_arrendatario = unirPersonas(arrendatariosTextos);

  // Para mantener compatibilidad con cláusulas que solo usan el primer propietario o solicitante
  const primerPropietario = propietarios[0];
  if (primerPropietario) {
      datosContrato.current.nombres_apellidos_propietario_1 = `${primerPropietario.nombres_arrendatario} ${primerPropietario.apellidos_arrendatario}`;
  }

  const solicitantePrincipal = arrendatarios.find(p => p.tipo_arrendatario === 'Solicitante');
  if (solicitantePrincipal) {
      datosContrato.current.nombres_apellidos_solicitante = `${solicitantePrincipal.nombres_arrendatario} ${solicitantePrincipal.apellidos_arrendatario}`;
  } else if (arrendatarios.length > 0) { // Fallback si no hay 'Solicitante'
      const primerArrendatario = arrendatarios[0];
      datosContrato.current.nombres_apellidos_solicitante = `${primerArrendatario.nombres_arrendatario} ${primerArrendatario.apellidos_arrendatario}`;
    }

  return;
};