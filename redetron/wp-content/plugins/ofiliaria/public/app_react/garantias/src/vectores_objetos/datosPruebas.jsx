export const datosPruebas = async (datosDePruebas) => {
  await fetch('https://i.imgur.com/fHyEMsl.jpg')
  .then((res) => res.blob())
  .then((myBlob) => {
    const myFile = new File([myBlob], 'image.jpeg', {type: myBlob.type});
    console.log('EstablecerDatosPruebas, myFile', myFile);
    datosDePruebas.current = {
      aseguradora: 'Sancor',
      id_propiedad : 0,
      nombre_propiedad : 'Apartamento de tres habitaciones',
      direccion_propiedad : 'Uruguay',
      tipo_propiedad : 'Apartamento',
      moneda_propiedad : 'UYU',
      costo_alquiler : 30000,
      tipo_arrendatario: 'Solicitante',
      tipo_persona : 'Persona física',
      nombres_arrendatario : 'Pedro',
      apellidos_arrendatario : 'Pérez',
      email_arrendatario : 'pperez@gmail.com',
      telefono_arrendatario : 123,
      monto_ingreso: 500,
      ingreso: 'Empleado (trabajador dependiente)',
      sueldo : 'Sueldo fijo',
      // identidad : 'identidad',
      identidad : myFile,
      ubicacion_identidad : 'ubicacion_identidad',
      // rec_sueldo : 'rec_sueldo',
      rec_sueldo : [{file : myFile}],
      ubicaciones_rec_sueldo : 'ubicaciones_rec_sueldo',
      contador_rec_sueldo : 1,
      // dgi : 'dgi',
      dgi : [{file : myFile}],
      ubicaciones_dgi : 'ubicaciones_dgi',
      contador_dgi : 1,
    }
    console.log('EstablecerDatosPruebas, datosPruebas.current', datosPruebas.current);
  });
}; 