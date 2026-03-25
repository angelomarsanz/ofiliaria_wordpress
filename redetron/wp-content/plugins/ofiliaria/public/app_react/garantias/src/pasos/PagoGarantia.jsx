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

export const PagoGarantia = () => {
  const [state, setState] = useAppState();
  const [imagenAseguradora, setImagenAseguradora] = useState('');
  const ubicacionesComprobantePagoRef = useRef(state.ubicaciones_comprobante_pago);
  const contadorComprobantePago = useRef(0);
  const [errorComprobantePago, setErrorComprobantePago] = useState('');
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

  console.log('InventarioGarantia, state', state);

  const ajustesIniciales = () => {
    contadorComprobantePago.current = state.contador_comprobante_pago;
  }

  const regresar = async (event) => {
    event.preventDefault();
    await setState({...state, estatus_garantia : 'Paso 9, Esperando firma del contrato'});
    navigate('/firma-contrato/'+idGarantia)
  }

  const irAlIndice = () => {
    setState(datosInicio);   
    navigate('/garantias');
  }

  const actualizarMensajeErrorComprobantePago = (mensaje) => {
    setErrorComprobantePago(mensaje);
  };

  const saveData = async (data) => {
    let indicadorErrores = 0;
    setErrorComprobantePago('');

    if (contadorComprobantePago.current == 0)
    {
      actualizarMensajeErrorComprobantePago(<MensajeError mensaje={t('texto_349')} />);
      indicadorErrores = 1;
    }

    if (indicadorErrores == 0)
    {
      setGifEspere(<GifEspere />);

      let datosActualizados = 
        {
          ...state, 
          ...data, 
          comprobante_pago : 'comprobante_pago',
          etiqueta_comprobante_pago : t('texto_348'),
          estatus_garantia : 'Paso 11, Proceso finalizado',
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
          console.log('PagoGarantia, respuesta.data', respuesta.data);
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
                  {t('texto_333')}
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
          <Grid container>
            <Grid key={'1'} size={{ xs : 6, sm : 6, md : 9, lg : 9, xl : 9 }}>
              <Typography variant="h4">{t('texto_331')}</Typography>
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
          <br />
          <Form onSubmit={handleSubmit(saveData)}>
            <fieldset>
              <Grid container>
                  <Grid key={'3'} sx={{ p : 2}}size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                    <CargarArchivosServidor control={control} multiplesArchivos={true} tipoArchivos='image/png, image/jpg, image/jpeg, .pdf' ubicacionesRequeridas={ubicacionesComprobantePagoRef} subDirectorio='contrato' tabla='garantias' nombreCampo='comprobante_pago' campoUbicaciones='ubicaciones_comprobante_pago' campoContador='contador_comprobante_pago' id={state.garantia_id} contadorArchivos={contadorComprobantePago} actualizarMensajeError={actualizarMensajeErrorComprobantePago} etiqueta={t('texto_348')} etiqueta2={t('Seleccionar medios')} />
                    {errorComprobantePago}
                  </Grid>
                  <Grid key={'4'} sx={{ p : 10}}size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                    <Typography sx={{fontSize : '16px', marginBottom : '1rem'}}>{t('texto_320')}</Typography>
                    <Typography sx={{fontSize : '16px', marginBottom : '1rem'}}>{t('texto_321')}</Typography>
                    <Typography sx={{fontSize : '16px', marginBottom : '1rem'}}>{t('texto_322')}</Typography>
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