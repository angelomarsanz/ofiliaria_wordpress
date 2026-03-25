import { convertirUrlArchivo } from "../varios";

export const convertirArchivosBase64 = async (personas, archivoObjeto, personasArchivosRef) => {
  var archivos64 = {};
  var archivosConvertidos = {};
  var personaArchivosConvertidos = [];
  var personasArchivosConvertidos = []; 
  for (let i = 0; i < personas.length; i++) 
  {
    if (personas[i].archivos_base64 != null && personas[i].archivos_base64 != '')
    {
      archivos64 = personas[i].archivos_base64; 
      archivosConvertidos = {};

      if (archivos64.hasOwnProperty('identidad') == true)
      {
        await convertirUrlArchivo(archivos64.identidad[0].nombreArchivo, archivos64.identidad[0].extensionArchivo, archivos64.identidad[0].archivoBase64, archivoObjeto);
        archivosConvertidos.identidad = archivoObjeto.current; 
      }

      if (archivos64.hasOwnProperty('rec_sueldo') == true)
      {
        archivosConvertidos.rec_sueldo = [];
        for (let i = 0; i < archivos64.rec_sueldo.length; i++) 
        {
          await convertirUrlArchivo(archivos64.rec_sueldo[i].nombreArchivo, archivos64.rec_sueldo[i].extensionArchivo, archivos64.rec_sueldo[i].archivoBase64, archivoObjeto);
          archivosConvertidos.rec_sueldo.push({file : archivoObjeto.current}); 
        }
      }

      if (archivos64.hasOwnProperty('cert_ing_mod') == true)
      {
        archivosConvertidos.cert_ing_mod = [];
        for (let i = 0; i < archivos64.cert_ing_mod.length; i++) 
        {
          await convertirUrlArchivo(archivos64.cert_ing_mod[i].nombreArchivo, archivos64.cert_ing_mod[i].extensionArchivo, archivos64.cert_ing_mod[i].archivoBase64, archivoObjeto);
          archivosConvertidos.cert_ing_mod.push({file : archivoObjeto.current}); 
        }
      }

      if (archivos64.hasOwnProperty('dgi') == true)
      {
        archivosConvertidos.dgi = [];
        for (let i = 0; i < archivos64.dgi.length; i++) 
        {
          await convertirUrlArchivo(archivos64.dgi[i].nombreArchivo, archivos64.dgi[i].extensionArchivo, archivos64.dgi[i].archivoBase64, archivoObjeto);
          archivosConvertidos.dgi.push({file : archivoObjeto.current}); 
        }
      }

      if (archivos64.hasOwnProperty('cert_dgi_caja') == true)
      {
        archivosConvertidos.cert_dgi_caja = [];
        for (let i = 0; i < archivos64.cert_dgi_caja.length; i++) 
        {
          await convertirUrlArchivo(archivos64.cert_dgi_caja[i].nombreArchivo, archivos64.cert_dgi_caja[i].extensionArchivo, archivos64.cert_dgi_caja[i].archivoBase64, archivoObjeto);
          archivosConvertidos.cert_dgi_caja.push({file : archivoObjeto.current}); 
        }
      }

      if (archivos64.hasOwnProperty('balance') == true)
      {
        archivosConvertidos.balance = [];
        for (let i = 0; i < archivos64.balance.length; i++) 
        {
          await convertirUrlArchivo(archivos64.balance[i].nombreArchivo, archivos64.balance[i].extensionArchivo, archivos64.balance[i].archivoBase64, archivoObjeto);
          archivosConvertidos.balance.push({file : archivoObjeto.current}); 
        }
      }

      if (archivos64.hasOwnProperty('rut') == true)
      {
        archivosConvertidos.rut = [];
        for (let i = 0; i < archivos64.rut.length; i++) 
        {
          await convertirUrlArchivo(archivos64.rut[i].nombreArchivo, archivos64.rut[i].extensionArchivo, archivos64.rut[i].archivoBase64, archivoObjeto);
          archivosConvertidos.rut.push({file : archivoObjeto.current}); 
        }
      }

      if (archivos64.hasOwnProperty('contrato_social') == true)
      {
        archivosConvertidos.contrato_social = [];
        for (let i = 0; i < archivos64.contrato_social.length; i++) 
        {
          await convertirUrlArchivo(archivos64.contrato_social[i].nombreArchivo, archivos64.contrato_social[i].extensionArchivo, archivos64.contrato_social[i].archivoBase64, archivoObjeto);
          archivosConvertidos.contrato_social.push({file : archivoObjeto.current}); 
        }
      }

      if (archivos64.hasOwnProperty('cert_uni') == true)
      {
        archivosConvertidos.cert_uni = [];
        for (let i = 0; i < archivos64.cert_uni.length; i++) 
        {
          await convertirUrlArchivo(archivos64.cert_uni[i].nombreArchivo, archivos64.cert_uni[i].extensionArchivo, archivos64.cert_uni[i].archivoBase64, archivoObjeto);
          archivosConvertidos.cert_uni.push({file : archivoObjeto.current}); 
        }
      }

      personaArchivosConvertidos = { ...personas[i], ...archivosConvertidos, archivos_base64 : null };
      personasArchivosConvertidos.push(personaArchivosConvertidos); 
    }
    else
    {
      personasArchivosConvertidos.push(personas[i]); 
    }
  }
  personasArchivosRef.current = personasArchivosConvertidos;
  return;
}