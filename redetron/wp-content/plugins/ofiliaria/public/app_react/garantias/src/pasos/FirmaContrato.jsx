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

export const FirmaContrato = () => {
  const [state, setState] = useAppState();
  const [imagenAseguradora, setImagenAseguradora] = useState('');
  
  const ubicacionesContratoFirmadoRef = useRef(state.ubicaciones_contrato_firmado);
  const contadorContratoFirmado = useRef(0); 

  const ubicacionesInventarioFirmadoRef = useRef(state.ubicaciones_inventario_firmado);
  const contadorInventarioFirmado = useRef(0);

  const ubicacionesFormularioFirmadoRef = useRef(state.ubicaciones_formulario_firmado);
  const contadorFormularioFirmado = useRef(0);
  
  const [errorContratoFirmado, setErrorContratoFirmado] = useState('');
  const [errorInventarioFirmado, setErrorInventarioFirmado] = useState('');
  const [errorFormularioFirmado, setErrorFormularioFirmado] = useState('');
  const [gifEspere, setGifEspere] = useState('');
  const [alertaFija, setAlertaFija] = useState('');
  const [vistaContrato, setVistaContrato] = useState('');

  useEffect(() => {( async () => {
    logoAseguradora();
    await ajustesIniciales();
  })();},[]);

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

  console.log('FirmaContrato, state', state);

  const ajustesIniciales = async () => {
    contadorContratoFirmado.current = state.contador_contrato_firmado;
    contadorInventarioFirmado.current = state.contador_inventario_firmado;
    contadorFormularioFirmado.current = state.contador_formulario_firmado;
  }

  const regresar = async (event) => {
    event.preventDefault();
    await setState({...state, estatus_garantia : 'Paso 8, Esperando carga del inventario'});
    navigate('/inventario-garantia/'+idGarantia)
  }

  const irAlIndice = () => {
    setState(datosInicio);   
    navigate('/garantias');
  }

  const actualizarMensajeErrorContratoFirmado = (mensaje) => {
    setErrorContratoFirmado(mensaje);
  };

  const actualizarMensajeErrorInventarioFirmado = (mensaje) => {
    setErrorInventarioFirmado(mensaje);
  };

  const actualizarMensajeErrorFormularioFirmado = (mensaje) => {
    setErrorFormularioFirmado(mensaje);
  };



  const ocultarAlertaFija = () => {
    setAlertaFija('');
  }

  const saveData = async (data) => {
    console.log('InventarioGarantia, data', data);
    let indicadorErrores = 0;
    setErrorContratoFirmado('');
    setErrorInventarioFirmado('');
    setErrorFormularioFirmado('');

    if (contadorContratoFirmado.current == 0)
    {
      actualizarMensajeErrorContratoFirmado(<MensajeError mensaje={t('texto_336')} />);
      indicadorErrores = 1;
    }

    if (contadorInventarioFirmado.current == 0)
    {
      actualizarMensajeErrorInventarioFirmado(<MensajeError mensaje={t('texto_338')} />);
      indicadorErrores = 1;
    }

    if (contadorFormularioFirmado.current == 0)
    {
      actualizarMensajeErrorFormularioFirmado(<MensajeError mensaje={t('texto_347')} />);
      indicadorErrores = 1;
    }

    if (indicadorErrores == 0)
    {
      setGifEspere(<GifEspere />);

      let datosActualizados = 
        {
          ...state, 
          ...data, 
          contrato_firmado : 'contrato_firmado',
          etiqueta_contrato_firmado : t('texto_337'),
          inventario_firmado : 'inventario_firmado',
          etiqueta_inventario_firmado : t('texto_339'),
          formulario_firmado : 'formulario_firmado',
          etiqueta_formulario_firmado : t('texto_346'),
          estatus_garantia : 'Paso 10, Esperando pago',
          personas : null 
        };   
        
      /*
      for (const pair of formulario.entries()) {
        console.log(
          pair[0],
          pair[1].name + ", " + pair[1].size + ", " + pair[1].type + ", " + pair[1].lastModifiedDate
        );
      }
      */

      const formulario = new FormData();

      formulario.append("datos", JSON.stringify(datosActualizados));
  
      try {
        const respuesta = await axios.post(state.endpoint+'/garantias/update/'+state.garantia_id, formulario, { headers: { 'Authorization': `Bearer ${state.token_laravel}`, "Content-Type": "multipart/form-data" } });
        setGifEspere('');
        if (respuesta.data.codigoRetorno == 0)
        {
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
              <div className='ra_nav_siguiente'>
                <Fab variant="extended" color="primary" sx={{ fontSize : 12, borderRadius : 1 }} type='submit' >
                  {t('texto_332')}
                </Fab>
              </div>
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
          <Typography variant="h4">{t('texto_330')}</Typography>
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
          <Form onSubmit={handleSubmit(saveData)}>
            <fieldset>
                <Grid container>
                  <Grid key={'1'} sx={{ p : 2}}size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                    <Stack direction="row" spacing={2}>
                      <img src={imagenAseguradora} alt="Logo" width="20%"></img>
                      <Typography variant='h3'>{state.aseguradora}</Typography>
                    </Stack> 
                  </Grid>
                  <Grid key={'2'} sx={{ p : 2}}size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>                    
                    <Box sx={{ lineHeight: '3rem', p : 2, marginTop : 2, marginBottom : 2, backgroundColor : '#3458FF', color : 'white', borderRadius : 2 }}>
                      <Typography variant='h4'>{t('texto_350', { idGarantia : state.garantia_id})}</Typography>
                    </Box>     
                  </Grid>
                  <Grid key={'3'} sx={{ p : 2}}size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                    <CargarArchivosServidor control={control} multiplesArchivos={true} tipoArchivos='image/png, image/jpg, image/jpeg, .pdf' ubicacionesRequeridas={ubicacionesContratoFirmadoRef} subDirectorio='contrato' tabla='garantias' nombreCampo='contrato_firmado' campoUbicaciones='ubicaciones_contrato_firmado' campoContador='contador_contrato_firmado' id={state.garantia_id} contadorArchivos={contadorContratoFirmado} actualizarMensajeError={actualizarMensajeErrorContratoFirmado} etiqueta={t('texto_337')} etiqueta2={t('Seleccionar medios')} />
                    {errorContratoFirmado}
                  </Grid>
                  <Grid key={'4'} sx={{ p : 2}}size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                    <Box sx={{ lineHeight: '3rem', p : 2, marginTop : 2, marginBottom : 2, backgroundColor : '#FFF3B2', color : '#7A7A7A', borderRadius : 2 }}>
                      <Typography variant='h5'>{t('texto_351')}</Typography>
                    </Box>     
                  </Grid>
                  <Grid key={'5'} sx={{ p : 2}}size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                    <CargarArchivosServidor control={control} multiplesArchivos={true} tipoArchivos='image/png, image/jpg, image/jpeg, .pdf' ubicacionesRequeridas={ubicacionesInventarioFirmadoRef} subDirectorio='inventario' tabla='garantias' nombreCampo='inventario_firmado' campoUbicaciones='ubicaciones_inventario_firmado' campoContador='contador_inventario_firmado' id={state.garantia_id} contadorArchivos={contadorInventarioFirmado} actualizarMensajeError={actualizarMensajeErrorInventarioFirmado} etiqueta={t('texto_339')} etiqueta2={t('Seleccionar medios')} />
                    {errorInventarioFirmado}
                  </Grid>
                  <Grid key={'6'} sx={{ p : 2}}size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                    <Box sx={{ lineHeight: '3rem', p : 2, marginTop : 2, marginBottom : 2, backgroundColor : '#FFF3B2', color : '#7A7A7A', borderRadius : 2 }}>
                      <Typography variant='h5'>{t('texto_352')}</Typography>
                    </Box>     
                  </Grid>
                  <Grid key={'7'} sx={{ p : 2}}size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                    <CargarArchivosServidor control={control} multiplesArchivos={true} tipoArchivos='image/png, image/jpg, image/jpeg, .pdf' ubicacionesRequeridas={ubicacionesFormularioFirmadoRef} subDirectorio='contrato' tabla='garantias' nombreCampo='formulario_firmado' campoUbicaciones='ubicaciones_formulario_firmado' campoContador='contador_formulario_firmado' id={state.garantia_id} contadorArchivos={contadorFormularioFirmado} actualizarMensajeError={actualizarMensajeErrorFormularioFirmado} etiqueta={t('texto_346')} etiqueta2={t('Seleccionar medios')} />
                    {errorFormularioFirmado}
                  </Grid>
                  <Grid key={'8'} sx={{ p : 2}}size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                    <Box sx={{ lineHeight: '3rem', p : 2, marginTop : 2, marginBottom : 2, backgroundColor : '#FFF3B2', color : '#7A7A7A', borderRadius : 2 }}>
                      <Typography variant='h5'>{t('texto_353')}</Typography>
                    </Box>     
                  </Grid>
                </Grid>
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