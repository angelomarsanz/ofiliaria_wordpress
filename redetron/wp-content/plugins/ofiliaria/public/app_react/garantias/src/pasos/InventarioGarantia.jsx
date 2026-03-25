import { useState, useRef, useEffect } from 'react';
import { useAppState } from "../state";
import { useParams } from "react-router-dom";
import {
  Container, 
  Box,
  Paper,
  Stack,
  Typography,
  FormControl,
  FormControlLabel,
  FormLabel,
  TextField,
  Radio,
  RadioGroup,
  Button,
  Fab,
  Table,
  TableContainer,
  TableHead,
  TableBody,
  TableRow,
  TableCell,
  Menu,
  MenuItem
  } from '@mui/material';
import KeyboardArrowLeftIcon from '@mui/icons-material/KeyboardArrowLeft';
import KeyboardArrowRightIcon from '@mui/icons-material/KeyboardArrowRight';
import { useTranslation } from 'react-i18next';
import { useNavigate, Link } from "react-router-dom";
import { 
  PasoAPasoContrato,
  MensajeError 
  } from '../mui';
import Grid from '@mui/material/Grid2';
import { 
  ModalBasico, 
  ModalDialogoBasico, 
  AcordionContrato,
  AlertaSatisfactorio,
  AlertaAviso,
  AlertaError,
  InputRadioRHF, 
  InputFormControlMultilineaRHF
  } from '../mui';
import { CargarArchivosServidor } from '../campos_opcionales';
import { useForm } from "react-hook-form";
import {
  datosInicio,
  opcionesInputs 
} from "../vectores_objetos";
import { Form } from "../forms";
import { GifEspere } from "../varios";
import axios from 'axios';
import DOMPurify from 'dompurify';
import PictureAsPdfIcon from '@mui/icons-material/PictureAsPdf';

export const InventarioGarantia = () => {
  const [state, setState] = useAppState();
  const [imagenAseguradora, setImagenAseguradora] = useState('');
  const ubicacionesInventarioRef = useRef(state.ubicaciones_inventario);
  const contadorInventario = useRef(0);
  const [errorArchivosInventario, setErrorArchivosInventario] = useState('');
  const [gifEspere, setGifEspere] = useState('');
  const [alertaFija, setAlertaFija] = useState('');
  const targetRef = useRef();
  const [vistaContrato, setVistaContrato] = useState('');
  const [mostrarFotoInventario, setMostrarFotoInventario] = useState(false);
  const [mostrarInventarioPdf, setMostrarInventarioPdf] = useState(false);
  const [errorTipoInventario, setErrorTipoInventario] = useState(false); 
  const [errorDescripcionInventario, setErrorDescripcionInventario] = useState(false);
  const [errorObservacionesInventario, setErrorObservacionesInventario] = useState(false);

  useEffect(() => {( async () => {
    logoAseguradora();
    await ajustesIniciales();
  })();},[]);

  const vectorOpcionesInputs = opcionesInputs();

  const logoAseguradora = () => {
    switch (state.aseguradora) {
      case 'Sura':
        setImagenAseguradora('https://s3.sa-east-1.amazonaws.com/cdn.ofiliaria.com.uy/garantias-uy/imagenes/sura-logo-300-200.jpg');
        break;
      case 'Porto':
        setImagenAseguradora('https://s3.sa-east-1.amazonaws.com/cdn.ofiliaria.com.uy/garantias-uy/imagenes/porto-logo-300-200.png');
        break;
      case 'Sancor':
        setImagenAseguradora('https://s3.sa-east-1.amazonaws.com/cdn.ofiliaria.com.uy/garantias-uy/imagenes/sancor-logo.jpg');
        break;
      case 'Mapfre':
        setImagenAseguradora('https://s3.sa-east-1.amazonaws.com/cdn.ofiliaria.com.uy/garantias-uy/imagenes/maphre-logo.jpg');
        break;
      case 'Sbi':
        setImagenAseguradora('https://s3.sa-east-1.amazonaws.com/cdn.ofiliaria.com.uy/garantias-uy/imagenes/sbi-logo-300-200.png');
    }    
  }

  const { idGarantia } = useParams();
  const { t } = useTranslation();
  const navigate = useNavigate();
  const { handleSubmit, register, unregister, setValue, watch, setFocus, control, formState: { errors } } = useForm({ defaultValues: state, mode: "onChange" });

  console.log('InventarioGarantia, state', state);

  const ajustesIniciales = () => {
    contadorInventario.current = state.contador_inventario;
    if (state.tipo_inventario == 'Foto inventario')
    {
      setMostrarFotoInventario(true);
    }
    else
    {
      setMostrarInventarioPdf(true);
    }
  }

  const regresar = async (event) => {
    event.preventDefault();
    await setState({...state, estatus_garantia : 'Paso 7.1, Esperando datos del contrato'});
    navigate('/contrato-garantia/'+idGarantia)
  }

  const irAlIndice = () => {
    setState(datosInicio);   
    navigate('/garantias');
  }

  const actualizarMensajeErrorArchivosInventario = (mensaje) => {
    setErrorArchivosInventario(mensaje);
  };

  const ocultarAlertaFija = () => {
    setAlertaFija('');
  }

  const saveData = async (data) => {
    let indicadorErrores = 0;
    setErrorTipoInventario(false);
    setErrorDescripcionInventario(false);
    setErrorArchivosInventario('');

    if (data.tipo_inventario == null || data.tipo_inventario == '')
    {
      setErrorTipoInventario(true);
      indicadorErrores = 1;
    }

    if (mostrarFotoInventario == true)
    {
      if (data.descripcion_inventario == null  || data.descripcion_inventario == '')
      {
        setErrorDescripcionInventario(true);
        indicadorErrores = 1;
      }

      if (contadorInventario.current == 0)
      {
        actualizarMensajeErrorArchivosInventario(<MensajeError mensaje={t('texto_308')} />);
        indicadorErrores = 1;
      }
    }

    if (indicadorErrores == 0)
    {
      setGifEspere(<GifEspere />);

      let datosActualizados = 
        {
          ...state, 
          ...data,
          archivos_inventario : 'archivos_inventario', 
          etiqueta_inventario : t('Adjuntar fotos *'),
          estatus_garantia : 'Paso 9, Esperando firma del contrato',
          personas : null 
        };   
        
      console.log('InventarioGarantia, datosActualizados', datosActualizados);

      const formulario = new FormData();

      /*
      for (const pair of formulario.entries()) {
        console.log(
          pair[0],
          pair[1].name + ", " + pair[1].size + ", " + pair[1].type + ", " + pair[1].lastModifiedDate
        );
      }
      */

      formulario.append("datos", JSON.stringify(datosActualizados));
  
      try {
        const respuesta = await axios.post(state.endpoint+'/garantias/update/'+state.garantia_id, formulario, { headers: { 'Authorization': `Bearer ${state.token_laravel}`, "Content-Type": "multipart/form-data" } });
        setGifEspere('');
        if (respuesta.data.codigoRetorno == 0)
        {
          pdfFotoInventario();
          irAlIndice();
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
  }

  const pdfFotoInventario = () => {
    const formulario = new FormData();

    formulario.append("datos", JSON.stringify(
      {
        ambiente : state.ambiente, 
        foto_inventario : 'foto_inventario'
      }));

    try {
      axios.post(state.endpoint+'/garantias/fotoInventario/'+state.garantia_id, formulario, { headers: { 'Authorization': `Bearer ${state.token_laravel}`, "Content-Type": "multipart/form-data" } });
    } catch (error) {
      setGifEspere('');
      setAlertaFija(<AlertaError texto={t("Hubo un error en el servidor")} />);
      setTimeout(() => {
        setAlertaFija('');
      }, 10000);
      console.log('Error en el servidor', error);
    }
  }
  
  const createMarkup = (html) => {
    return {
      __html: DOMPurify.sanitize(html)
    }
  }

  const estilosContrato = {
    width : '800px',
    textAlign : 'justify',
    fontSize : '16px'
  }

  const funcionAdicionalTipoInventario = (event) => {
    if (event.target.value == 'Foto inventario')
    {
      setMostrarInventarioPdf(false);
      setMostrarFotoInventario(true);
    }
    else
    {
      setMostrarFotoInventario(false);
      setMostrarInventarioPdf(true);
    }
  };

  const funcionAdicionalDescripcionInventario = (event) => {
    if (event.target.value != '')
    {
      // 
    }
  };

  const funcionAdicionalObservacionesInventario = (event) => {
    if (event.target.value != '')
    {
      // 
    }
  };
  
  const BotonesNavegacion = () => {
    return (
          <>
            <div>
              <div className='ra_nav_anterior'>
                <Fab variant="extended" color="secondary" sx={{ fontSize : 12, borderRadius : 1}} onClick={ event => {regresar(event) }} >
                  <KeyboardArrowLeftIcon />
                  {t('texto_201')}
                </Fab>
              </div>
              { 
                mostrarFotoInventario &&
                  <div className='ra_nav_siguiente'>
                    <Fab variant="extended" color="primary" sx={{ fontSize : 12, borderRadius : 1 }} type='submit' >
                      {t('Guardar inventario')}
                    </Fab>
                  </div>
              }
              { 
                mostrarInventarioPdf &&
                  <div className='ra_nav_siguiente'>
                    <Fab variant="extended" color="primary" sx={{ fontSize : 12, borderRadius : 1 }} type='submit' >
                      {t('texto_319')}
                    </Fab>
                  </div>
              }
            </div>
          </>
    );
  }

  return (
    <>
      <Box component={Paper} elevation={12} sx={{ marginTop : '14rem', p : 2, borderRadius : 3 }}>
        <Stack sx={{width : '100%'}}>
          <PasoAPasoContrato rutaPaso={''} />
        </Stack>
        <br />
        <div className='ra_escritorio'>
          <Grid container>
            <Grid key={'1'} size={{ xs : 6, sm : 6, md : 9, lg : 9, xl : 9 }}>
              <Typography variant="h4">{t('Inventario del Inmueble')}</Typography>
            </Grid>
            <Grid key={'2'} size={{ xs : 3, sm : 3, md : 1, lg : 1, xl : 1 }}>
              <Stack>
                <img src={imagenAseguradora} alt="Logo" width="100%"></img>
              </Stack>
            </Grid>
            <Grid key={'3'} size={{ xs : 3, sm : 3, md : 2, lg : 2, xl : 2 }}>
              <Stack spacing={1}>
                <Typography variant='h5'>{state.aseguradora}</Typography>
                <Typography variant='h6'>{t("Aseguradora")}</Typography>
                <Typography variant='h6'>{t('texto_110')}</Typography>
              </Stack>
            </Grid>
          </Grid>
        </div>
        <div className='ra_movil'>
          <Stack>
            <Typography variant="h4" sx={{marginTop : '1rem', marginBottom : '1rem'}}>{t('Inventario del Inmueble')}</Typography>
            <img src={imagenAseguradora} alt="Logo" width="30%"></img>
            <Typography variant='h5' sx={{marginTop : '0.5rem'}}>{state.aseguradora+' '+t("Aseguradora")+' '+t('texto_110')}</Typography>
          </Stack>
        </div>
        <br />
        <Box component={Paper} elevation={3} sx={{ p : 2, borderRadius : 3 }}>
          <AcordionContrato estatusGarantia={state.estatus_garantia} ambiente={state.ambiente} indicadorAmbienteDev={state.indicador_ambiente_dev} aseguradora={state.aseguradora} idGarantia={state.garantia_id} regresar={regresar} />
        </Box>
        <br />
        <Box component={Paper} elevation={3} sx={{ p : 2, borderRadius : 3 }}>
          <Typography variant='h5'>{t('Inventario del Inmueble')}</Typography>
          <br />
          <Form onSubmit={handleSubmit(saveData)}>
            <fieldset>
              <Box component={Paper} elevation={0} sx={{ backgroundColor: '#F7EDFF', p : 2, borderRadius : 3 }}>
                <InputRadioRHF nombre={'tipo_inventario'} control={control} etiqueta={t('texto_310')} opcionesInputs={vectorOpcionesInputs['tipo_inventario']} textoAdicional={''} funcionAdicional={funcionAdicionalTipoInventario} textoError={t('texto_313')} errorInput={errorTipoInventario} />
              </Box>
              <br />            
              { 
                mostrarFotoInventario &&
                  <Grid container>
                    <Grid key={'1'} size={{ xs : 12, sm : 12, md : 12, lg : 12, xl : 12 }}>
                      <InputFormControlMultilineaRHF nombre={'descripcion_inventario'} control={control} etiqueta={t('Descripción *')} textoAdicional={t('texto_314')} funcionAdicional={funcionAdicionalDescripcionInventario} textoError={t('texto_315')} errorInput={errorDescripcionInventario} />
                    </Grid>
                    <Grid key={'2'} size={{ xs : 12, sm : 12, md : 12, lg : 12, xl : 12 }}>
                      <InputFormControlMultilineaRHF nombre={'observaciones_inventario'} control={control} etiqueta={t('texto_316')} textoAdicional={t('texto_317')} funcionAdicional={funcionAdicionalObservacionesInventario} textoError={''} errorInput={errorObservacionesInventario} />
                    </Grid>
                    <Grid key={'3'} sx={{ p : 2}}size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                      <CargarArchivosServidor control={control} multiplesArchivos={true} tipoArchivos='image/png, image/jpg, image/jpeg' ubicacionesRequeridas={ubicacionesInventarioRef} subDirectorio='inventario' tabla='garantias' nombreCampo='archivos_inventario' campoUbicaciones='ubicaciones_inventario' campoContador='contador_inventario' id={state.garantia_id} contadorArchivos={contadorInventario} actualizarMensajeError={actualizarMensajeErrorArchivosInventario} etiqueta={t('Adjuntar fotos *')} etiqueta2={t('Seleccionar medios')} />
                      {errorArchivosInventario}
                    </Grid>
                    <Grid key={'4'} sx={{ p : 10}}size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                      <Typography sx={{fontSize : '16px', marginBottom : '1rem'}}>{t('texto_320')}</Typography>
                      <Typography sx={{fontSize : '16px', marginBottom : '1rem'}}>{t('texto_321')}</Typography>
                      <Typography sx={{fontSize : '16px', marginBottom : '1rem'}}>{t('texto_322')}</Typography>
                    </Grid>
                  </Grid>
              }
              { 
                mostrarInventarioPdf &&
                  <Grid container>
                    <Grid key={'1'} size={{ xs : 12, sm : 12, md : 12, lg : 12, xl : 12 }}>
                      <Button variant="text" startIcon={<PictureAsPdfIcon />} href="https://s3.sa-east-1.amazonaws.com/cdn.ofiliaria.com.uy/garantias-uy/formularios_inventario/Formulario+inventario.pdf" download target="_blank" >{t('texto_318')}</Button>
                    </Grid>
                  </Grid>
              }
              <BotonesNavegacion />
            </fieldset>
          </Form>
        </Box>
      </Box>
      {vistaContrato}
      {gifEspere}
      <div className='ra_alerta_fija'>
        {alertaFija}
      </div>
    </>
  );
};