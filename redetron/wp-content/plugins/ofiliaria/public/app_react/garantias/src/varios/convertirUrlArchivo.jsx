export const convertirUrlArchivo = async (nombreArchivo = '', extensionArchivo = '', archivoBase64 = '', archivoObjeto = '' ) => {
  let prefijoData = '';
  if (extensionArchivo == 'jpg' || extensionArchivo == 'jpeg' || extensionArchivo == 'png')
  {
    prefijoData = 'data:image/'+extensionArchivo+';base64,';
  } 
  else if (extensionArchivo == 'pdf')
  {
    prefijoData = 'data:application/pdf;base64,';
  }
  else if (extensionArchivo == 'docx')
  {
    prefijoData = 'data:application/octet-stream,';
  }
  if (prefijoData != '')
  {
    const base64Response = await fetch(prefijoData+archivoBase64);
    const myBlob = await base64Response.blob();     
    archivoObjeto.current = new File([myBlob], nombreArchivo, {type: myBlob.type});
  }
  else
  {
    archivoObjeto.current = '';
  }
}
