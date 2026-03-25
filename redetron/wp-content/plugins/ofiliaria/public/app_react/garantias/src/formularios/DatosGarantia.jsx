import { useState, useEffect, useRef } from 'react';
import { useAppState } from "../state";
import { useTranslation } from 'react-i18next';
import { useNavigate, Link } from "react-router-dom";
import { useForm } from "react-hook-form";
import axios from 'axios';
import { GifEspere } from "../varios";
import { datosInicio, opcionesInputs, inputsAseguradoras } from "../vectores_objetos";
import {
  Container,
  Paper,
  Stack,
  Box,
  Typography,
  Button,
  Fab
} from '@mui/material';
import Grid from '@mui/material/Grid2';
import {
  InputRadioRHF, 
  InputCheckboxRHF,
  PasoAPaso, 
  PasoAPasoContrato,
  InputFormControlMultilineaRHF,
  ModalDialogoBasico, 
  AcordionPersonas,
  AlertaSatisfactorio,
  AlertaAviso,
  AlertaError 
} from '../mui';
import { Form } from "../forms";

import KeyboardArrowLeftIcon from '@mui/icons-material/KeyboardArrowLeft';
import KeyboardArrowRightIcon from '@mui/icons-material/KeyboardArrowRight';
import { useLocation } from "react-router-dom";

export const DatosGarantia = ({idGarantia, origen, tituloVista}) => {
  const [state, setState] = useAppState();
  const { t } = useTranslation();
  const [gifEspere, setGifEspere] = useState('');
  const [alertaFija, setAlertaFija] = useState('');
  const [tipoPasoAPaso, setTipoPasoAPaso] = useState('1');
  const [rutaPaso, setRutaPaso] = useState('');
  const [imagenAseguradora, setImagenAseguradora] = useState('');
  const vectorOpcionesInputs = opcionesInputs();
  const [errorEnRevision, setErrorEnRevision] = useState(false);
  const [errorAprobacionGarantia, setErrorAprobacionGarantia] = useState(false);
  const [errorMotivoRechazoGarantia, setErrorMotivoRechazoGarantia] = useState(false);
  const [mostrarMotivoRechazo, setMostrarMotivoRechazo] = useState(false);

  useEffect(() => {( async () => {
    await prepararPasoaPaso();
    await logoAseguradora();
  })();},[]);

  const location = useLocation();
  const paginaActual = useRef('');
  paginaActual.current = location.pathname.split('/')[1];

  const [modalDialogoBasico, setModalDialogoBasico] = useState(false);
  const accionModalDialogoBasico = useRef();
  const [tituloModalDialogoBasico, setTituloModalDialogoBasico] = useState('');
  const [contenidoModalDialogoBasico, setContenidoModalDialogoBasico] = useState('');
  const [textoAccion1DialogoBasico, setTextoAccion1DialogoBasico] = useState('');
  const accion1DialogoBasico = useRef('');
  const [parametrosAccion1DialogoBasico, setParametrosAccion1DialogoBasico] = useState('');
  const [textoAccion2DialogoBasico, setTextoAccion2DialogoBasico] = useState('');
  const accion2DialogoBasico = useRef('');
  const [parametrosAccion2DialogoBasico, setParametrosAccion2DialogoBasico] = useState('');

  const abrirModalDialogoBasico = () => {
    setModalDialogoBasico(true);
  }

  const cerrarModalDialogoBasico = () => { 
    setModalDialogoBasico(false);
  }

  const navigate = useNavigate();

  const { handleSubmit, register, unregister, setValue, watch, setFocus, control, formState: { errors } } = useForm({ defaultValues: state, mode: "onChange" });

  const prepararPasoaPaso = () => {
    let vectorEstatusGarantia = state.estatus_garantia.split(',');
    let pasoActual = vectorEstatusGarantia[0];
    switch (pasoActual) {
      case 'Paso 1':
        setTipoPasoAPaso('1')
        setRutaPaso('seleccionar-aseguradora');
        break;
      case 'Paso 2':
        setTipoPasoAPaso('1')
        setRutaPaso('datos-propiedad');
        break;
      case 'Paso 3':
        setTipoPasoAPaso('1')
        setRutaPaso('datos-arrendatario');
        break;
      case 'Paso 4':
        setTipoPasoAPaso('1')
        setRutaPaso('personas-adicionales');
        break;
      case 'Paso 5':
        setTipoPasoAPaso('2')
        setRutaPaso('garantia-enviada');
        break;
      case 'Paso 6':
        setTipoPasoAPaso('2')
        setRutaPaso('revision-garantia');
        break;
      case 'Paso 7':
        setTipoPasoAPaso('2')
        setRutaPaso('contrato-garantia');
        break;
      case 'Paso 8':
        setTipoPasoAPaso('2')
        setRutaPaso('inventario-garantia');
        break;
      case 'Paso 9':
        setTipoPasoAPaso('2')
        setRutaPaso('firma-contrato');
        break;
      case 'Paso 10':
        setTipoPasoAPaso('2')
        setRutaPaso('pago-garantia');
    }    
  }

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

  const irAlIndice = async () => {
    await setState(datosInicio);   
    navigate('/garantias');
  }

  const modalIndicarRevision = () => {
    accionModalDialogoBasico.current = cerrarModalDialogoBasico;
    setTituloModalDialogoBasico(t('texto_211'));
    setContenidoModalDialogoBasico(t('texto_212'));
    setTextoAccion1DialogoBasico(t('texto_213'));
    accion1DialogoBasico.current = cerrarModalDialogoBasico;
    setParametrosAccion1DialogoBasico('');
    setTextoAccion2DialogoBasico(t('texto_214'));
    accion2DialogoBasico.current = actualizarEstatusEnviado;
    setParametrosAccion2DialogoBasico('');
    setModalDialogoBasico(true);
  } 

  const actualizarEstatusEnviado = () => {
    let vectorEstatusGarantia = state.estatus_garantia.split(',');
    if (vectorEstatusGarantia[0] != 'Paso 5')
    {
      let guardarDatos = { ...state, estatus_garantia : 'Paso 5, Enviado' };
      let pasoSiguiente = "/garantias";
      actualizarDatosGarantia(guardarDatos, pasoSiguiente);
    }
    else
    {
      irAlIndice();
    }
  }

  const modalAprobacionRechazo = () => {
    accionModalDialogoBasico.current = cerrarModalDialogoBasico;
    setTituloModalDialogoBasico(t('texto_215'));
    setContenidoModalDialogoBasico(t('texto_216'));
    setTextoAccion1DialogoBasico(t('texto_213'));
    accion1DialogoBasico.current = cerrarModalDialogoBasico;
    setParametrosAccion1DialogoBasico('');
    setTextoAccion2DialogoBasico(t('texto_214'));
    accion2DialogoBasico.current = actualizarEstatusEnRevision;
    setParametrosAccion2DialogoBasico('');
    setModalDialogoBasico(true);
  } 

  const actualizarEstatusEnRevision = () => {
    let vectorEstatusGarantia = state.estatus_garantia.split(',');
    if (vectorEstatusGarantia[0] != 'Paso 6')
    {
      let guardarDatos = { ...state, estatus_garantia : 'Paso 6, En revisión' };
      let pasoSiguiente = "/garantias";
      actualizarDatosGarantia(guardarDatos, pasoSiguiente);
    }
    else
    {
      irAlIndice();
    }
  }

  const regresarAEnviada = async () => {
    navigate('/garantia-enviada/'+idGarantia)
  }

  const BotonesNavegacion = () => {
    return (
          <>
            <div className='botones_navegacion_fijos'>
              {
                origen == 'DetalleGarantia' &&
                  <div className='ra_nav_anterior'>
                    <Fab variant="extended" color="secondary" sx={{ fontSize : 12, borderRadius : 1}} onClick={() => { irAlIndice() }} >
                      <KeyboardArrowLeftIcon />
                      {t("Volver")}
                    </Fab>
                  </div>
              }
              {
                origen == 'GarantiaEnviada' &&
                  <>
                    <div className='ra_nav_anterior'>
                      <Fab variant="extended" color="secondary" sx={{ fontSize : 12, borderRadius : 1}} onClick={() => { irAlIndice() }} >
                        <KeyboardArrowLeftIcon />
                        {t("Volver")}
                      </Fab>
                    </div>
                    <div className='ra_nav_siguiente'>
                      <Fab variant="extended" color="primary" sx={{ fontSize : 12, borderRadius : 1 }} type='submit'>
                        {t('texto_221')}
                        <KeyboardArrowRightIcon />
                      </Fab>
                    </div>
                  </>
              }
              {
                origen == 'RevisionGarantia' &&
                  <>
                    <div className='ra_nav_anterior'>
                      <Fab variant="extended" color="secondary" sx={{ fontSize : 12, borderRadius : 1}} onClick={() => { regresarAEnviada() }} >
                        <KeyboardArrowLeftIcon />
                        {t("Volver")}
                      </Fab>
                    </div>
                    <div className='ra_nav_siguiente'>
                      <Fab variant="extended" color="primary" sx={{ fontSize : 12, borderRadius : 1 }} type='submit'>
                        {t('Guardar')}
                        <KeyboardArrowRightIcon />
                      </Fab>
                    </div>
                  </>
              }
            </div>
          </>
    );
  }

  const funcionAdicionalEnRevision = async (event) => {
    //
  }

  const funcionAdicionalAprobacionGarantia = async (event) => {
    if (event.target.value == 'Sí')
    {
      if (mostrarMotivoRechazo == true)
      {
        setMostrarMotivoRechazo(false);        
      }
    }
    else
    {
      if (mostrarMotivoRechazo == false)
      {
        setMostrarMotivoRechazo(true);        
      }
    }
  }

  const funcionAdicionalMotivoRechazoGarantia = () => {

  }

  const saveData = async (data) => {
    let indicadorGuardar = 1;
    setErrorMotivoRechazoGarantia(false);

    if (origen == 'GarantiaEnviada')
    {
      if (data.en_revision == false)
      {
        modalIndicarRevision();
        indicadorGuardar = 0;
      }
    }

    if (origen == 'RevisionGarantia')
    {
      if (data.aprobacion_garantia == '')
      {
        modalAprobacionRechazo();
        indicadorGuardar = 0;
      }
      else if (data.aprobacion_garantia == 'No')
      {
        if (data.notas_garantia == '')
        {
          setErrorMotivoRechazoGarantia(true);
          indicadorGuardar = 0;
        }
      }
    }

    if (indicadorGuardar == 1)
    { 
      let estatusGarantia = '';
      let guardarDatos = {};
      let pasoSiguiente = '';     
      
      if (paginaActual.current == 'garantia-enviada')
      {
          guardarDatos = { ...state, estatus_garantia : 'Paso 6, En revisión', inputs_aseguradoras : {...inputsAseguradoras} };          
      }
      else if (paginaActual.current == 'revision-garantia')
      {
        if (data.aprobacion_garantia == 'Sí')
        {
          estatusGarantia = 'Paso 7.1, Esperando datos del contrato';
        }
        else
        {
          estatusGarantia = 'Paso 7.2, Rechazada';
        }
        guardarDatos = { ...state, estatus_garantia : estatusGarantia, aprobacion_garantia : data.aprobacion_garantia, notas_garantia : data.notas_garantia };
      }
      pasoSiguiente = "/garantias";
      actualizarDatosGarantia(guardarDatos, pasoSiguiente);
    }
  };

  const actualizarDatosGarantia = async (guardarDatos, pasoSiguiente) => {
    setGifEspere(<GifEspere />);
    const formulario = new FormData();
    formulario.append("datos", JSON.stringify(guardarDatos));
    try {
      const respuesta = await axios.post(state.endpoint+'/garantias/update/'+idGarantia, formulario, { headers: { 'Authorization': `Bearer ${state.token_laravel}`, "Content-Type": "multipart/form-data" } });
      console.log('DatosGarantias, respuestas.data', respuesta.data);
      setGifEspere('');
      if (respuesta.data.codigoRetorno == 0)
      {
        await setState(datosInicio);
        navigate(pasoSiguiente);
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

  console.log('DatosGarantia, state', state);

  return (
    <>
      <Stack sx={{width : '100%'}}>
        {
          tipoPasoAPaso == '1' ?
            <PasoAPaso rutaPaso={rutaPaso} />
            :
            <PasoAPasoContrato rutaPaso={rutaPaso} />
        }
      </Stack>
      <br />
      <Form onSubmit={handleSubmit(saveData)}>
        <div className='ra_escritorio'>
          <Grid container>
            <Grid key={'1'} size={{ xs : 6, sm : 6, md : 9, lg : 9, xl : 9 }}>
              <Typography variant="h4">{tituloVista}</Typography>
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
            <Grid key={'4'} size={{ xs : 6, sm : 6, md : 6, lg : 6, xl : 6 }}>
              {
                origen == 'GarantiaEnviada' &&
                  <InputCheckboxRHF nombre={'en_revision'} control={control} etiqueta={''} opcionesInputs={vectorOpcionesInputs['garantia_en_revision']} textoAdicional={''} funcionAdicional={funcionAdicionalEnRevision} textoError={t('texto_183')} errorInput={errorEnRevision} valorActual={state.en_revision} />
              }
              {
                origen == 'RevisionGarantia' &&
                  <>
                    <InputRadioRHF nombre={'aprobacion_garantia'} control={control} etiqueta={t('texto_186')} opcionesInputs={vectorOpcionesInputs['aprobacion_garantia']} textoAdicional={''} funcionAdicional={funcionAdicionalAprobacionGarantia} textoError={t('texto_187')} errorInput={errorAprobacionGarantia} />
                    {
                      mostrarMotivoRechazo == true &&
                        <InputFormControlMultilineaRHF nombre={'notas_garantia'} control={control} etiqueta={t('texto_219')} textoAdicional={''} funcionAdicional={funcionAdicionalMotivoRechazoGarantia} textoError={t('texto_220')} errorInput={errorMotivoRechazoGarantia} />
                    }
                  </>
              }
            </Grid>
          </Grid>
        </div>
        <div className='ra_movil'>
          <Stack>
            <Typography variant="h4" sx={{marginTop : '1rem', marginBottom : '1rem'}}>{tituloVista}</Typography>
            <img src={imagenAseguradora} alt="Logo" width="30%"></img>
            <Typography variant='h5' sx={{marginTop : '0.5rem'}}>{state.aseguradora+' '+t("Aseguradora")+' '+t('texto_110')}</Typography>
            {
              origen == 'GarantiaEnviada' &&
                <InputCheckboxRHF nombre={'en_revision'} control={control} etiqueta={''} opcionesInputs={vectorOpcionesInputs['garantia_en_revision']} textoAdicional={''} funcionAdicional={funcionAdicionalEnRevision} textoError={t('texto_183')} errorInput={errorEnRevision} valorActual={state.en_revision} />
            }
            {
              origen == 'RevisionGarantia' &&
                <>
                  <br />
                  <InputRadioRHF nombre={'aprobacion_garantia'} control={control} etiqueta={t('texto_186')} opcionesInputs={vectorOpcionesInputs['aprobacion_garantia']} textoAdicional={''} funcionAdicional={funcionAdicionalAprobacionGarantia} textoError={t('texto_187')} errorInput={errorAprobacionGarantia} />
                  {
                    mostrarMotivoRechazo == true &&
                      <InputFormControlMultilineaRHF nombre={'notas_garantia'} control={control} etiqueta={t('texto_219')} textoAdicional={''} funcionAdicional={funcionAdicionalMotivoRechazoGarantia} textoError={t('texto_220')} errorInput={errorMotivoRechazoGarantia} />
                  }
                </>
            }
          </Stack>
        </div>
        <br />
        <Typography variant={'h6'}>{t('texto_167')}</Typography>
        <Box id='caja_precio' sx={{ p : 2, border : 'solid 1px #6D6D6D', borderRadius : 1 }}>
          <Grid container spacing={{ xs : 2, sm : 2, md : 3, lg : 3, xl : 3 }}>
            <Grid key={'1'} size={{ xs : 12, sm : 6, md : 6, lg : 6, xl : 6 }}>
              <Typography sx={{ fontSize : 16 }}><strong>Nombre de la propiedad:</strong> {state.nombre_propiedad}</Typography>
            </Grid>
            <Grid key={'2'} size={{ xs : 12, sm : 6, md : 6, lg : 6, xl : 6 }}>
              {
                state.numero_identidad_propiedad != '' &&
                  <Typography sx={{ fontSize : 16 }}><strong>Número de identidad de la propiedad:</strong> {state.numero_identidad_propiedad}</Typography>
              }
            </Grid>
            <Grid key={'3'} size={{ xs : 12, sm : 6, md : 6, lg : 6, xl : 6 }}>
              <Typography sx={{ fontSize : 16 }}><strong>Tipo de propiedad:</strong> {state.tipo_propiedad}</Typography>
            </Grid>
            <Grid key={'4'} size={{ xs : 12, sm : 6, md : 6, lg : 6, xl : 6 }}>
              <Typography sx={{ fontSize : 16 }}><strong>Dirección de la propiedad:</strong> {state.direccion_propiedad}</Typography>         
            </Grid>
            <Grid key={'5'} size={{ xs : 12, sm : 6, md : 6, lg : 6, xl : 6 }}>
              <Typography sx={{ fontSize : 16 }}><strong>Costo del alquiler:</strong> {state.moneda_propiedad+' '+state.costo_alquiler}</Typography> 
            </Grid>
          </Grid>
        </Box>
        {
          state.personas != null &&
            <>
              <br />
              <AcordionPersonas ambiente={state.ambiente} aseguradora={state.aseguradora} personas={state.personas} urlAlmacenamiento={state.url_almacenamiento} />
            </>
        }
        <BotonesNavegacion />
      </Form>
      <ModalDialogoBasico open={modalDialogoBasico} handleClose={accionModalDialogoBasico.current} tituloModal={tituloModalDialogoBasico} contenidoModal={contenidoModalDialogoBasico} textoAccion1={textoAccion1DialogoBasico} accion1={accion1DialogoBasico.current} parametrosAccion1={parametrosAccion1DialogoBasico} textoAccion2={textoAccion2DialogoBasico} accion2={accion2DialogoBasico.current} parametrosAccion2={parametrosAccion2DialogoBasico} />
      {gifEspere}
      <div className='ra_alerta_fija'>
        {alertaFija}
      </div>
    </>
  );
};