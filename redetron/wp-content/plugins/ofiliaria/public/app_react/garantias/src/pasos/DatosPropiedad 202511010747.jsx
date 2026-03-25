import { useState, useEffect, useRef, forwardRef } from 'react';
import { useForm } from "react-hook-form";
import { Controller } from "react-hook-form";
import { useNavigate, Link } from "react-router-dom";
import { useAppState } from "../state";
import { Form } from "../forms";
import Stepper from "./Stepper.jsx";
import axios from 'axios';
import { ReactSearchAutocomplete } from 'react-search-autocomplete';
import { GifEspere, AlertPelSC, AlertPelFij } from "../varios";
import { opcionesInputs, textosMensajes } from "../vectores_objetos";
import { useTranslation } from 'react-i18next';
import { NumericFormat } from 'react-number-format';
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
  Fab
  }from '@mui/material';
import Grid from '@mui/material/Grid2';
import PropTypes from 'prop-types';
import { 
  InputFormControlRHF,
  InputNumericFormatRHF,
  InputSelectRHF,
} from '../mui';
import { 
    PasoAPaso 
  } from '../mui';
// import useDetectScroll, { Direction } from "@smakss/react-scroll-direction";
import KeyboardArrowLeftIcon from '@mui/icons-material/KeyboardArrowLeft';
import KeyboardArrowRightIcon from '@mui/icons-material/KeyboardArrowRight';

const BotonesPasos = () => {
  const [state] = useAppState();
  const navigate = useNavigate();
  const [errorAvance, setErrorAvance] = useState("");

  const mensajeError = () => {
    if (state.propiedad_registrada == null) {
      setErrorAvance("Estimado usuario, debe seleccionar una opción para continuar con el siguiente paso");
    }
  }

  return (
    <>
      <span className='error'>{errorAvance}</span>
      <br />
      <Box
        sx={{
          display: 'flex',
          flexWrap: 'wrap',
          justifyContent: 'space-around'
        }}
      >
        <div>
          <Fab variant="extended" color="secondary" sx={{ fontSize : 12, borderRadius : 1}}  onClick={() => {navigate('/seleccionar-aseguradora/'+state.garantia_id)}} >
            <KeyboardArrowLeftIcon />
            Anterior
          </Fab>
        </div>
        <div>
          <Fab variant="extended" color="primary" sx={{ fontSize : 12, borderRadius : 1 }} onClick={mensajeError}>
            Siguiente
            <KeyboardArrowRightIcon />
          </Fab>
        </div>
      </Box>
    </>
  )
}

const IdPropiedad = () => {
  const [state] = useAppState();
  const cambioIdPropiedad = () => {
    // Algún cambio
  }
  return (
    <>
      <form>
        <h5>ID de la propiedad</h5>
        <label className="radio-inline">
          <input type="radio" id="propiedad_id" name="propiedad_id" value={state.propiedad_id} checked={state.propiedad_id ? true : false} onChange={cambioIdPropiedad} />
          {state.propiedad_id}
        </label>
      </form>
      <br />
    </>
  );
}

const FormularioPropiedad = () => {
  const [state, setState] = useAppState();
  const [idPropiedad, setIdPropiedad] = useState("");
  const [gifEspere, setGifEspere] = useState('');
  const [alertaFija, setAlertaFija] = useState('');
  const { t } = useTranslation();
  const [errorNombrePropiedad, setErrorNombrePropiedad] = useState(false);
  const [errorTipoPropiedad, setErrorTipoPropiedad] = useState(false);  
  const [errorDireccionPropiedad, setErrorDireccionPropiedad] = useState(false);  
  const [errorMonedaPropiedad, setErrorMonedaPropiedad] = useState(false);
  const [errorCostoAlquiler, setErrorCostoAlquiler] = useState(false);
  const vectorOpcionesInputs = opcionesInputs();
  // const { scrollDir, scrollPosition } = useDetectScroll();

  useEffect(() => {
    if (state.propiedad_id > 0) {
      setIdPropiedad(<IdPropiedad />);
    }
  }, []);

  useEffect(() => { 
    /* 
    let elem = document.getElementById('caja_botones_navegacion');
    if (isInViewport(elem)) 
    {
      const botonesNavegacionFijos = document.getElementsByClassName('botones_navegacion_fijos');   
      for (var i = 0; i<botonesNavegacionFijos.length; i++) 
      {
        botonesNavegacionFijos[i].classList.add("ra_ocultar");
      }
    }
    */
  });

  const {
    handleSubmit,
    register,
    control,
    formState: { errors },
  } = useForm({ defaultValues: state });

  const navigate = useNavigate();

  const actualizarTipoPropiedad = (event) => {
    setState({...state, tipo_propiedad : event.target.value});
  };

  const actualizarMonedaPropiedad = (event) => {
    setState({...state, moneda_propiedad : event.target.value});
  };

  const NumericFormatCustom = forwardRef(
    function NumericFormatCustom(props, ref) {
      const { onChange, ...other } = props;
  
      return (
        <NumericFormat
          {...other}
          getInputRef={ref}
          onValueChange={(values) => {
            onChange({
              target: {
                name: props.name,
                value: values.value,
              },
            });
          }}
          valueIsNumericString
          allowLeadingZeros 
          thousandSeparator='.' 
          decimalSeparator=","
        />
      );
    },
  );
  
  NumericFormatCustom.propTypes = {
    name: PropTypes.string.isRequired,
    onChange: PropTypes.func.isRequired,
  };

  function isInViewport(elem) {
    var distance = elem.getBoundingClientRect();
    return (
        distance.top < (window.innerHeight || document.documentElement.clientHeight) && distance.bottom > 0
    );
  }

  const funcionAdicionalNombrePropiedad = (event) => {
    if (event.target.value != '')
    {
      // setErrorNombrePropiedad(false);
    }
  };

  const funcionAdicionalNumeroIdentidadPropiedad = (event) => {
    //
  }

  const funcionAdicionalDireccionPropiedad = (event) => {
    if (event.target.value != '')
    {
      // setErrorDireccionPropiedad(false);
    }
  }

  const funcionAdicionalTipoPropiedad = (event) => {
    if (event.target.value != '')
    {
      // setErrorTipoPropiedad(false);
    }
  }

  const funcionAdicionalMonedaPropiedad = (event) => {
    if (event.target.value != '')
    {
      // setErrorMonedaPropiedad(false);
    }
  }

  const funcionAdicionalCostoAlquiler = (event) => {
    if (event.target.value != '')
    {
      // setErrorCostoAlquiler(false);
    }    
  }
  
  const saveData = async (data) => {
    console.log('DatosPropiedad, data', data);
    let indicadorErrores = 0;
    setErrorNombrePropiedad(false);
    setErrorTipoPropiedad(false);
    setErrorDireccionPropiedad(false);
    setErrorMonedaPropiedad(false)
    setErrorCostoAlquiler(false);

    if (data.nombre_propiedad == null || data.nombre_propiedad == '')
    {
      setErrorNombrePropiedad(true);
      indicadorErrores = 1;
    }

    if (data.tipo_propiedad == null || data.tipo_propiedad == '')
    {
      setErrorTipoPropiedad(true);
      indicadorErrores = 1;
    }

    if (data.direccion_propiedad == null || data.direccion_propiedad == '')
    {
      setErrorDireccionPropiedad(true);
      indicadorErrores = 1;
    }

    if (data.moneda_propiedad == null || data.moneda_propiedad == '')
    {
      setErrorMonedaPropiedad(true);
      indicadorErrores = 1;
    }

    if (data.costo_alquiler == null || data.costo_alquiler == 0) {
      setErrorCostoAlquiler(true);
      indicadorErrores = 1;
    }

    if (indicadorErrores == 0) {
      setGifEspere(<GifEspere />);
      let datosActualizados = { ...state, ...data, estatus_garantia: 'Paso 2, Borrador' };
      const formulario = new FormData();
      formulario.append("datos", JSON.stringify({ ...datosActualizados, personas: null }));
      try {
        const respuesta = await axios.post(state.endpoint + '/garantias/update/' + state.garantia_id, formulario, { headers: { 'Authorization': `Bearer ${state.token_laravel}`, "Content-Type": "multipart/form-data" } });
        setGifEspere('');
        if (respuesta.data.codigoRetorno == 0) 
        {
          if (state.tipo_persona == null) {
            await setState({ ...datosActualizados, tipo_persona: '' });
          }
          else {
            await setState(datosActualizados);
          }
          let idPersona = state.id;
          navigate("/datos-arrendatario/" + idPersona);
        }
        else {
          setAlertaFija(<AlertaError texto={t("Error al guardar los datos")} />);
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
      };
    }
  };

  const BotonesNavegacion = () => {
    return (
          <>
            <div className='botones_navegacion_fijos'>
              <div className='ra_nav_anterior'>
                <Fab variant="extended" color="secondary" sx={{ fontSize : 12, borderRadius : 1}}  onClick={() => {navigate('/seleccionar-aseguradora/'+state.garantia_id)}} >
                  <KeyboardArrowLeftIcon />
                  Anterior
                </Fab>
              </div>
              <div className='ra_nav_siguiente'>
                <Fab variant="extended" color="primary" sx={{ fontSize : 12, borderRadius : 1 }} type='submit'>
                  Siguiente
                  <KeyboardArrowRightIcon />
                </Fab>
              </div>
            </div>
            <Box
              id="caja_botones_navegacion"
              sx={{
                display: 'flex',
                flexWrap: 'wrap',
                justifyContent: 'space-around'
              }}
              className='ra_ocultar'
            >
              <div>
                <Fab variant="extended" color="secondary" sx={{ fontSize : 12, borderRadius : 1}}  onClick={() => {navigate('/seleccionar-aseguradora/'+state.garantia_id)}} >
                  <KeyboardArrowLeftIcon />
                  Anterior
                </Fab>
              </div>
              <div>
                <Fab variant="extended" color="primary" sx={{ fontSize : 12, borderRadius : 1 }} type='submit'>
                  Siguiente
                  <KeyboardArrowRightIcon />
                </Fab>
              </div>
            </Box>
          </>
    );
  }

  return (
    <>
      <br />
        {idPropiedad}
        <Form onSubmit={handleSubmit(saveData)}>
          <Grid container spacing={{ xs : 2, sm : 2, md : 3, lg : 3, xl : 3 }}>
            <Grid key={'1'} size={{ xs : 12, sm : 6, md : 6, lg : 6, xl : 6 }}>
              <InputFormControlRHF nombre={'nombre_propiedad'} control={control} etiqueta={t('texto_89')} textoAdicional={t('texto_90')} funcionAdicional={funcionAdicionalNombrePropiedad} textoError={t('texto_91')} errorInput={errorNombrePropiedad} />
            </Grid>
            <Grid key={'2'} size={{ xs : 12, sm : 6, md : 6, lg : 6, xl : 6 }}>
              <InputFormControlRHF nombre={'numero_identidad_propiedad'} control={control} etiqueta={t('texto_92')} textoAdicional={''} funcionAdicional={funcionAdicionalNumeroIdentidadPropiedad} textoError={''} errorInput={false} />            
            </Grid>
            <Grid key={'3'} size={{ xs : 12, sm : 6, md : 6, lg : 6, xl : 6 }}>
              <InputSelectRHF nombre={'tipo_propiedad'} control={control} etiqueta={t('texto_100')} opcionesInputs={vectorOpcionesInputs['tipo_propiedad']} textoAdicional={''} funcionAdicional={funcionAdicionalTipoPropiedad} textoError={t('texto_101')} errorInput={errorTipoPropiedad} />            
            </Grid>
            <Grid key={'4'} size={{ xs : 12, sm : 6, md : 6, lg : 6, xl : 6 }}>
              <InputFormControlRHF nombre={'direccion_propiedad'} control={control} etiqueta={t('texto_93')} textoAdicional={''} funcionAdicional={funcionAdicionalDireccionPropiedad} textoError={t('texto_94')} errorInput={errorDireccionPropiedad} />            
            </Grid>
          </Grid>
          <Box id='caja_precio' sx={{ p : 2, marginTop : 2, border : 'solid 1px #6D6D6D', borderRadius : 1 }}>
            <Typography variant={'h6'}>{t('texto_107')}</Typography>
            <Grid container spacing={{ xs : 2, sm : 2, md : 3, lg : 3, xl : 3 }} sx={{marginTop : 1}}>
              <Grid key={'1'} size={{ xs : 12, sm : 6, md : 6, lg : 6, xl : 6 }}>
                <InputSelectRHF nombre={'moneda_propiedad'} control={control} etiqueta={t('texto_95')} opcionesInputs={vectorOpcionesInputs['moneda']} textoAdicional={''} funcionAdicional={funcionAdicionalMonedaPropiedad} textoError={t('texto_99')} errorInput={errorMonedaPropiedad} />            
              </Grid>
              <Grid key={'2'} size={{ xs : 12, sm : 6, md : 6, lg : 6, xl : 6 }}>
                <InputNumericFormatRHF nombre={'costo_alquiler'} control={control} etiqueta={'Costo del alquiler *'} textoAdicional={''} funcionAdicional={funcionAdicionalCostoAlquiler} textoError={t('texto_63')} errorInput={errorCostoAlquiler} />    
              </Grid>
            </Grid>
          </Box>
          <br />
          <BotonesNavegacion />
        </Form>
      {gifEspere}
      {alertaFija}
    </>
  );
}

const BusquedaInmuebles = () => {
  const [state, setState] = useAppState();
  const [cargado, setCargado] = useState(false);
  const [listadoInmuebles, setListadoInmuebles] = useState(null);
  const [botonesPasos, setBotonesPasos] = useState(<BotonesPasos />);
  const [formularioPropiedad, setFormularioPropiedad] = useState("");
  const [gifEspere, setGifEspere] = useState('');
  const [alertaFija, setAlertaFija] = useState('');
  const { t } = useTranslation();

  useEffect(() => {
    if (state.propiedad_registrada == 'si_registrada') {
      setBotonesPasos("");
      setFormularioPropiedad(<FormularioPropiedad />);
    }
    if (state.ambiente == 'Desarrollo') {
      setCargado(true);
      setListadoInmuebles(listadoInmueblesDesarrollo);
    }
    else {
      obtenerListadoInmuebles();
    }

  }, []);

  const listadoInmueblesDesarrollo = [
    {
      id: '1',
      name: 'Casa',
      direccion: 'Dirección casa'
    },
    {
      id: '2',
      name: 'Apartamento',
      direccion: 'Dirección apartamento'
    },
    {
      id: '3',
      name: 'Local comercial',
      direccion: 'Dirección apartamento'
    },
    {
      id: '4',
      name: 'Local comercial',
      direccion: 'Dirección apartamento'
    }
  ];

  const obtenerListadoInmuebles = async () => {
    const ajaxUrlReact = variables_php_javascript.ajax_url;
    var params = new URLSearchParams();
    params.append('action', 'listado_inmuebles');
    params.append('agencia_id', state.agencia_id);
    params.append('agente_id', state.agente_id);
    setGifEspere(<GifEspere />);
    try {
      setGifEspere('');
      const respuesta = await axios.post(ajaxUrlReact, params);
      setCargado(true);
      setListadoInmuebles(respuesta.data.listado_inmuebles);
    } catch (error) {
      setGifEspere('');
      setAlertaFija(<AlertaError texto={t("Hubo un error en el servidor")} />);
      setTimeout(() => {
        setAlertaFija('');
      }, 10000);
      console.log('Error en el servidor', error);
    };
  }

  const handleOnSearch = (string, results) => {
    // onSearch will have as the first callback parameter
    // the string searched and for the second the results.
  }

  const handleOnHover = (result) => {
    // the item hovered
  }

  const handleOnSelect = (item) => {
    // the item selected
    setState({ ...state, propiedad_id: item.id, nombre_propiedad: item.name, direccion_propiedad: item.direccion });
    setBotonesPasos("");
    setFormularioPropiedad(<FormularioPropiedad />);
  }

  const handleOnFocus = () => {

  }

  const formatResult = (item) => {
    return (
      <>
        <span style={{ display: 'block', textAlign: 'left' }}>{item.name}</span>
      </>
    )
  }

  const InputBusqueda = () => {
    return (
      <>
        <br />
        <div className="App">
          <header className="App-header">
            <div className='input_busqueda'>
              <ReactSearchAutocomplete
                items={listadoInmuebles}
                onSearch={handleOnSearch}
                onHover={handleOnHover}
                onSelect={handleOnSelect}
                onFocus={handleOnFocus}
                autoFocus
                formatResult={formatResult}
                styling={{ borderRadius: 5, backgroundColor: '#e8e8e8', position: 'absolute', zIndex: 1 }}
              />
            </div>
          </header>
        </div>
        {botonesPasos}
        {formularioPropiedad}
        {gifEspere}
        {alertaFija}
      </>
    );
  }

  return cargado === false
    ? <GifEspere />
    : <InputBusqueda />;
}

export const DatosPropiedad = () => {
  const [state, setState] = useAppState();
  const [datosPropiedad, setDatosPropiedad] = useState(<BotonesPasos />);
  const { t } = useTranslation();
  const [imagenAseguradora, setImagenAseguradora] = useState('');
  const [valorPropiedadRadio, setValorPropiedadRadio] = useState('');

  useEffect(() => {
    (async () => {
      if (state.propiedad_registrada == 'si_registrada') {
        setValorPropiedadRadio(state.propiedad_registrada);
        setDatosPropiedad(<BusquedaInmuebles />);
      }
      else if (state.propiedad_registrada == 'no_registrada') {
        setValorPropiedadRadio(state.propiedad_registrada);
        setDatosPropiedad(<FormularioPropiedad />);
      }
      logoAseguradora(state.aseguradora);
    })();
  }, []);

  const navigate = useNavigate();

  const logoAseguradora = (aseguradora) => {
    switch (aseguradora) {
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

  const registradaNoRegistrada = (event) => {
    setValorPropiedadRadio(event.target.value);
    if (event.target.value == 'si_registrada')
    {
      setState({ ...state, propiedad_registrada: event.target.value });
      setDatosPropiedad(<BusquedaInmuebles />);
    }
    else
    {
      setState({ ...state, propiedad_registrada: event.target.value, propiedad_id: 0 });
      setDatosPropiedad(<FormularioPropiedad />);
    }
  };

  console.log('DatosPropiedad, state', state);

  return (
    <>
      {window.scrollTo(0, 0)}
      <Box component={Paper} elevation={12} sx={{ marginTop : '14rem', p : 2, borderRadius : 3 }}>
        <Stack sx={{width : '100%'}}>
          <PasoAPaso rutaPaso={''}/>
        </Stack>
        <br />
        <div className='ra_escritorio'>
          <Grid container>
            <Grid key={'1'} size={{ xs : 6, sm : 6, md : 9, lg : 9, xl : 9 }}>
              <Typography variant="h4">{t('texto_108')}</Typography>
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
            <Typography variant="h4" sx={{marginTop : '1rem', marginBottom : '1rem'}}>{t('texto_108')}</Typography>
            <img src={imagenAseguradora} alt="Logo" width="30%"></img>
            <Typography variant='h5' sx={{marginTop : '0.5rem'}}>{state.aseguradora+' '+t("Aseguradora")+' '+t('texto_110')}</Typography>
          </Stack>
        </div>
        <br />
        <Grid container>
          <Grid key={'1'} size={{ xs : 12, sm : 12, md : 12, lg : 12, xl : 12 }}>
            <form>
              <FormControl>
                <FormLabel id="etiqueta_propiedad_radio" sx={{color: '#000000de', fontSize : 16}}>Esta propiedad está en Ofiliaria ?</FormLabel>
                <RadioGroup
                  row
                  aria-labelledby="etiqueta_propiedad_radio"
                  name="propiedad_radio"
                  value={valorPropiedadRadio}
                  onChange={registradaNoRegistrada}
                >
                  <FormControlLabel value='si_registrada' control={<Radio />} label="Sí" />
                  <FormControlLabel value='no_registrada' control={<Radio />} label="No" />
                </RadioGroup>
              </FormControl>
            </form>
            {datosPropiedad}
          </Grid>
        </Grid>
      </Box>
    </>
  );
}