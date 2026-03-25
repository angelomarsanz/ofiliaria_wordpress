import { convertirUrlArchivo } from "../varios";

export const convertirOtrosArchivosBase64 = async (archivosBase64, archivosObjeto, archivosRef) => {
  if (archivosBase64 != null && archivosBase64 != '')
  {
    var archivosConvertidos = [];
    for (let i = 0; i < archivosBase64.length; i++) 
    {
      await convertirUrlArchivo(archivosBase64[i].nombreArchivo, archivosBase64[i].extensionArchivo, archivosBase64[i].archivoBase64, archivosObjeto);
      archivosConvertidos.push({file : archivosObjeto.current}); 
    }
    archivosRef.current = archivosConvertidos;
  }
  return;
}