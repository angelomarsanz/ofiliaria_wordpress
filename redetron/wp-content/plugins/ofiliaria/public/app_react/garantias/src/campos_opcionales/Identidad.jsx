import { useState, useRef, useEffect } from 'react';
import { useAppState } from "../state.jsx";
import { useTranslation } from 'react-i18next';
import Button from '@mui/material/Button';
import CloudUploadIcon from '@mui/icons-material/CloudUpload';

export const Identidad = ({ imagen, actualizarMensajeError}) => {
  const [state, setState] = useAppState();
  const ocultarInput = useRef(null);
  const [preview, setPreview] = useState('');
  const [gifEspere, setGifEspere] = useState('');
  const urlArchivo = useRef('');
  const { t } = useTranslation();
  
  useEffect(() => {( async () => {
    let urlImage = '';
    if (imagen.current != '')
    {
      urlImage = URL.createObjectURL(imagen.current);
    }
    else if (state.identidad != null && state.identidad != 'identidad')
    {
      imagen.current = state.identidad;
      urlImage = URL.createObjectURL(state.identidad);
    }
    urlArchivo.current = urlImage;
    if (imagen.current.type == 'application/pdf')
    {
      setPreview('https://dev-backend.ofiliaria.com/public/imagenes/pdf.png');
    }
    else
    {
      setPreview(urlImage);
    }
  })();},[]);
 
  const adjuntarImagen = (e) => {
    e.preventDefault();
    ocultarInput.current.click();
  }

  const manejoImagen = (event) => {
    // A veces al cargar la imagen el usuario accidentalmente puede darle al botón cancelar. En ese caso debería verificarse previamente si event.target.files[0], si no tiene nada no ejecuta las instrucciones del procedimiento
    const file = event.target.files[0];
    const extensionArchivo = file.name.split('.').pop();
    const urlImage = URL.createObjectURL(file);
    urlArchivo.current = urlImage;
    if (extensionArchivo == 'pdf')
    {
      setPreview('https://dev-backend.ofiliaria.com/public/imagenes/pdf.png');
    }
    else
    {
      setPreview(urlImage);
    }
    imagen.current = event.target.files[0];
    actualizarMensajeError('');
  };

  return (
    <>
      <label htmlFor='identidad'>{t('texto_62')}</label>
      <br />
      <Button
        component="label"
        role={undefined}
        variant="outlined"
        tabIndex={-1}
        startIcon={<CloudUploadIcon />}
        onClick={adjuntarImagen}
        sx={{ fontSize : 12}}
      >
        {t('texto_127')}
      </Button>
      <br /><br />
      <input
        type="file"
        id='identidad'
        name="identidad"
        accept="image/png, image/jpg, image/jpeg, .pdf"
        onChange={manejoImagen}
        ref={ocultarInput}
        style={{display: 'none'}}
      />
      {
        urlArchivo.current != '' &&
          <a href={urlArchivo.current} target="_blank"><img src={preview} className="img-thumbnail" width="200" /></a>
      }
      <br />
      {gifEspere}
    </>
  );
};