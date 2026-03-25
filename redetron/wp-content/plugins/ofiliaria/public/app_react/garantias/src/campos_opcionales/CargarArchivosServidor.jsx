import { useEffect, useRef, useState } from 'react';
import { useAppState } from "../state";
import { useFieldArray, Controller, set } from "react-hook-form";
import { useTranslation } from 'react-i18next';
import CloudUploadIcon from '@mui/icons-material/CloudUpload';
import Grid from '@mui/material/Grid2';
import {
  Stack,
  Button,
  } from '@mui/material';
import { GifEspere } from "../varios";
import { 
  ModalBasico, 
  ModalDialogoBasico, 
  AlertaSatisfactorio,
  AlertaAviso,
  AlertaError,
  InputRadioRHF, 
  InputFormControlMultilineaRHF
  } from '../mui';
import axios from 'axios';
import CloseIcon from '@mui/icons-material/Close';

export const CargarArchivosServidor = ({ control, multiplesArchivos, tipoArchivos, ubicacionesRequeridas, subDirectorio, tabla, nombreCampo, campoUbicaciones, campoContador, id, contadorArchivos, actualizarMensajeError, etiqueta, etiqueta2 }) => {
  const [state, setState] = useAppState();
  const ocultarInput = useRef(null);
  const { t } = useTranslation();
  const [gifEspere, setGifEspere] = useState('');
  const [alertaFija, setAlertaFija] = useState('');
  const [ubicacionesArchivos, setUbicacionesArchivos] = useState([]);
  const [mensajeCargaArchivos, setMensajeCargaArchivos] = useState('');

  useEffect(() => {
    (async () => {
      await ajustesIniciales();
    })();
  }, []);

  const ajustesIniciales = () => {
    cargarUbicaciones(ubicacionesRequeridas.current);
  };

  const adjuntarArchivos = (e) => {
    e.preventDefault();
    ocultarInput.current.click();
  };

  const agregarArchivos = async (event) => {
    var archivosCargados = [];
    if (multiplesArchivos == true)
    {
      archivosCargados = Array.from(event.target.files);
    }
    else
    {
      archivosCargados = [event.target.files[0]];
    }
    var contadorArchivosCargados = 1;
    var cantidadTotalArchivos = archivosCargados.length;

    for (let i = 0; i < archivosCargados.length; i++) 
    {
      setMensajeCargaArchivos(t('texto_340', {archivo : contadorArchivosCargados, total : cantidadTotalArchivos}))
      const formulario = new FormData();
      formulario.append("archivo_cargado", archivosCargados[i]);
      formulario.append("datos", JSON.stringify(
        {
          multiples_archivos : multiplesArchivos,
          ambiente : state.ambiente,
          sub_directorio : subDirectorio,
          nombre_campo : nombreCampo,
          ubicaciones_archivos : campoUbicaciones,
          contador_archivos : campoContador,
        }));

      setGifEspere(<GifEspere />);
      try {
        const respuesta = await axios.post(state.endpoint+'/'+tabla+'/guardarArchivos/'+id, formulario, { headers: { 'Authorization': `Bearer ${state.token_laravel}`, "Content-Type": "multipart/form-data" } });
        setGifEspere('');
        console.log('CargarArchivosServidor, respuesta.data', respuesta.data)
        if (respuesta.data.codigoRetorno == 0)
        {
          ubicacionesRequeridas.current = respuesta.data.ubicacionesArchivos;
          contadorArchivos.current = respuesta.data.contadorArchivos;
          cargarUbicaciones(respuesta.data.ubicacionesArchivos);
          if (contadorArchivosCargados == cantidadTotalArchivos)
          {
            setMensajeCargaArchivos('');
          }
          else
          {
            contadorArchivosCargados++;
          }
          actualizarMensajeError('');
        }
        else
        {
          setAlertaFija(<AlertaError texto={t('texto_184')} />);
          setTimeout(() => {
            setAlertaFija('');
          }, 10000);
        }
      } catch (error) {
        setGifEspere('');
        setAlertaFija(<AlertaError texto={t("Hubo un error en el servidor")} />);
        setTimeout(() => {
          setAlertaFija('');
        }, 10000);
        console.log('Error en el servidor', error);
      }
    }
  };

  const eliminarArchivo = async (ubicacion) => {
    const formulario = new FormData();
    formulario.append("datos", JSON.stringify(
      {
        ambiente : state.ambiente,
        nombre_campo : nombreCampo,
        ubicacion_archivo : ubicacion,
        ubicaciones_archivos : campoUbicaciones,
        contador_archivos : campoContador,
      }));

    setGifEspere(<GifEspere />);
    try {
      const respuesta = await axios.post(state.endpoint+'/'+tabla+'/eliminarArchivo/'+id, formulario, { headers: { 'Authorization': `Bearer ${state.token_laravel}`, "Content-Type": "multipart/form-data" } });
      setGifEspere('');
      if (respuesta.data.codigoRetorno == 0)
      {
        ubicacionesRequeridas.current = respuesta.data.ubicacionesArchivos;
        contadorArchivos.current = respuesta.data.contadorArchivos;
        cargarUbicaciones(respuesta.data.ubicacionesArchivos);
      }
      else
      {
        setAlertaFija(<AlertaError texto={t('texto_184')} />);
        setTimeout(() => {
          setAlertaFija('');
        }, 10000);
      }
    } catch (error) {
      setGifEspere('');
      setAlertaFija(<AlertaError texto={t("Hubo un error en el servidor")} />);
      setTimeout(() => {
        setAlertaFija('');
      }, 10000);
      console.log('Error en el servidor', error);
    }
  };

  const cargarUbicaciones = (ubicaciones) => {
    if (ubicaciones != null && ubicaciones != '')
    {
      if (Array.isArray(ubicaciones) == true)
      {
        if (ubicaciones.length > 0)
        {
          setUbicacionesArchivos(ubicaciones);
        }
        else
        {
          setUbicacionesArchivos([]);
        }
      }
      else
      {
        setUbicacionesArchivos([]);
      }
    }
    else
    {
      setUbicacionesArchivos([]);
    }  
  }

  const PrepararImagen = ({ubicacion}) => {
    let vectorUbicacion = ubicacion.split('.');
    let ultimoElemento = vectorUbicacion.length - 1;
    let urlImagen = '';
    if (vectorUbicacion[ultimoElemento] == 'pdf')
    {
      urlImagen = 'https://dev-backend.ofiliaria.com/public/imagenes/pdf.png';
    } 
    else
    {
      urlImagen = state.url_almacenamiento+ubicacion;
    }
    return (<img src={urlImagen} className="img-thumbnail" width="100" />);
  }

  console.log('CargarArchivosServidor, state', state);

  return (
    <>
      <label htmlFor={nombreCampo}>{etiqueta}</label>
      <br />
      <Button
        component="label"
        role={undefined}
        variant="outlined"
        tabIndex={-1}
        startIcon={<CloudUploadIcon />}
        onClick={adjuntarArchivos}
        sx={{ fontSize : 12}}
      >
        {etiqueta2}
      </Button>
      <br /><br />
      {
        multiplesArchivos ?
          <input
          type="file"
          accept={tipoArchivos}
          multiple
          onChange={agregarArchivos}
          id={nombreCampo}
          ref={ocultarInput}
          style={{ display: 'none' }}
          />
          :
          <input
          type="file"
          accept={tipoArchivos}
          onChange={agregarArchivos}
          id={nombreCampo}
          ref={ocultarInput}
          style={{ display: 'none' }}
          />
      }
      {mensajeCargaArchivos}
      <br />      
      <div className="ra_flex_imagenes">  
        {
          ubicacionesArchivos.map((ubicacion, indice) => (
            <div key={indice}>
              <Controller
                control={control}
                name={`${nombreCampo}.${indice}`}
                render={ () => (
                  <>
                    <a href="#" onClick={(e) => { e.preventDefault(); eliminarArchivo(ubicacion) }}><CloseIcon /></a>
                    <a href={state.url_almacenamiento+ubicacion} target="_blank"><PrepararImagen ubicacion={ubicacion} /></a>
                    <br />
                  </>
                )}
              />
            </div>
          ))
        }
      </div>
      <br />
      {gifEspere}
      <div className='ra_alerta_fija'>
        {alertaFija}
      </div>
    </>
  );
};