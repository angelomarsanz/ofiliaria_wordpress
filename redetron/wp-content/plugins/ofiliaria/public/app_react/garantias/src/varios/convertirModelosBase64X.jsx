import { convertirUrlArchivo } from "../varios";

export const convertirModelosBase64 = async (modelos, archivoObjeto, modelosRef) => {
  var modelosConvertidos = {};
  for (let i = 0; i < modelos.length; i++) 
  {
      await convertirUrlArchivo(modelos[i].nombreArchivo, modelos[i].extensionArchivo, modelos[i].archivoBase64, archivoObjeto);

      if (modelos[i].nombreArchivo.substring(0, 4) == 'sura')
      {
        modelosConvertidos.sura = archivoObjeto.current;
      }
      if (modelos[i].nombreArchivo.substring(0, 5) == 'porto')
      {
        modelosConvertidos.porto = archivoObjeto.current;
      }
      if (modelos[i].nombreArchivo.substring(0, 6) == 'sancor')
      {
        modelosConvertidos.sancor = archivoObjeto.current;
      }
      if (modelos[i].nombreArchivo.substring(0, 6) == 'mapfre')
      {
        modelosConvertidos.mapfre = archivoObjeto.current;
      }
      if (modelos[i].nombreArchivo.substring(0, 3) == 'sbi')
      {
        modelosConvertidos.sbi = archivoObjeto.current;
      }
  }
  modelosRef.current = modelosConvertidos;
  return;
}