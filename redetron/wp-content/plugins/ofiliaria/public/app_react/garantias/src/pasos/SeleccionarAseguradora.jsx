import { useState, useEffect, useRef } from 'react';
import { set, useForm } from "react-hook-form";
import { useParams, useNavigate, Link } from "react-router-dom";
import { useAppState } from "../state";
import { Form } from "../forms";
import axios from 'axios';
import Stepper from "./Stepper.jsx";
import InformacionSura from "../informacion_aseguradoras/sura/InformacionSura.jsx";
import InformacionPorto from "../informacion_aseguradoras/porto/InformacionPorto.jsx";
import InformacionSancor from "../informacion_aseguradoras/sancor/InformacionSancor.jsx";
import InformacionMapfre from "../informacion_aseguradoras/mapfre/InformacionMapfre.jsx";
import InformacionSbi from "../informacion_aseguradoras/sbi/InformacionSbi.jsx";
import { datosInicio, datosPruebas, opcionesAseguradoras, textosMensajes } from "../vectores_objetos";
import { GifEspere, AlertPelSC, AlertPelFij } from "../varios";
import { useTranslation } from 'react-i18next';
import { TarjetaPrimaria } from '../mui/index.js';
import {
  Box,
  Paper,
  Stack,
  Table,
  TableContainer,
  TableBody,
  TableRow,
  TableCell,
  Button,
  Fab,
  Typography
 } from '@mui/material';

import Grid from '@mui/material/Grid2';
// import useDetectScroll, { Direction } from "@smakss/react-scroll-direction";
import KeyboardArrowLeftIcon from '@mui/icons-material/KeyboardArrowLeft';
import KeyboardArrowRightIcon from '@mui/icons-material/KeyboardArrowRight';
import { 
  PasoAPaso,
  AlertaSatisfactorio,
  AlertaAviso,
  AlertaError
} from '../mui';

export const SeleccionarAseguradora = () => {
  const [state, setState] = useAppState();
  const { idGarantia } = useParams();
  const [ aseguradora, setAseguradora ] = useState({nombre : "Sura",  componente: <InformacionSura />, claseComponente: "boton_sura"});
  const datosDePruebas = useRef('');
  const [inicioPantalla, setInicioPantalla] = useState('');
  const [gifEspere, setGifEspere] = useState('');
  const [AlertaFija, setAlertaFija] = useState(''); 
  const { t } = useTranslation();
  const transmisionDatos = useRef(true);
  const enfocarSura = useRef(null);
  const enfocarPorto = useRef(null);
  const enfocarSancor = useRef(null);
  const enfocarMapfre = useRef(null);
  const enfocarSbi = useRef(null);
  const vectorOpcionesAseguradoras = opcionesAseguradoras();

  // const { scrollDir, scrollPosition } = useDetectScroll();
 
  useEffect(() => {( async () => {
      if (idGarantia == 0 && state.pruebas == 'Sí')
      { 
        datosPruebas(datosDePruebas);
      }
      else
      {
        aseguradoraSeleccionada(state.aseguradora);
      }
      setInicioPantalla(window.scrollTo(0,0));
    })();},[]);

  useEffect(() => {  
    const botones = document.getElementsByClassName(aseguradora.claseComponente);   
    for (var i = 0; i<botones.length; i++) {
      botones[i].classList.remove("ra_gris");
    }
    
    switch (aseguradora.nombre) {
      case "Sura":
        enfocarSura.current.focus();
        break;
      case "Porto":
        enfocarPorto.current.focus();
        break;
      case "Sancor":
        enfocarSancor.current.focus();
        break;
      case "Mapfre":
        enfocarMapfre.current.focus();
        break;
      case "Sbi":
        enfocarSbi.current.focus();
        break;
    }
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
  } = useForm({ defaultValues: state, mode: "onSubmit" });

  const navigate = useNavigate();

  const aseguradoraSeleccionada = (nombreAseguradora) => {
    setInicioPantalla('');
    switch (nombreAseguradora) {
      case "Sura":
        setAseguradora({nombre : "Sura",  componente: <InformacionSura />, claseComponente: "boton_sura"});
        break;
      case "Porto":
        setAseguradora({nombre : "Porto",  componente: <InformacionPorto />, claseComponente: "boton_porto"});
        break;
      case "Sancor":
        setAseguradora({nombre : "Sancor",  componente: <InformacionSancor />, claseComponente: "boton_sancor"});
        break;
      case "Mapfre":
        setAseguradora({nombre : "Mapfre",  componente: <InformacionMapfre />, claseComponente: "boton_mapfre"});
        break;
      case "Sbi":
        setAseguradora({nombre : "Sbi",  componente: <InformacionSbi />, claseComponente: "boton_sbi"});
        break;
    }
  }

  function isInViewport(elem) {
    var distance = elem.getBoundingClientRect();
    return (
        distance.top < (window.innerHeight || document.documentElement.clientHeight) && distance.bottom > 0
    );
  }
  
  const saveData = async () => {
    if (transmisionDatos.current == true)
    {
      setGifEspere(<GifEspere />);
      let guardarDatos;
      let cantidadPersonasAdicionales = vectorOpcionesAseguradoras[aseguradora.nombre+' Cantidad personas adicionales'];
      if (idGarantia == 0)
      {
        if (state.pruebas == 'Sí')
        {
          guardarDatos = { ...state, ...datosDePruebas.current, aseguradora : aseguradora.nombre, cantidad_personas_adicionales : cantidadPersonasAdicionales, estatus_garantia : 'Paso 1, Borrador'};
        }
        else
        {
          guardarDatos = { ...state, aseguradora : aseguradora.nombre, cantidad_personas_adicionales : cantidadPersonasAdicionales, estatus_garantia : 'Paso 1, Borrador' };
        }
        console.log('SeleccionarAseguradora, guardarDatos', guardarDatos);
        try {
          const respuesta = await axios.post(state.endpoint+'/garantias/store', guardarDatos, {
            headers: {
              'Authorization': `Bearer ${state.token_laravel}`
            }
          });
          setGifEspere('');
          if (respuesta.data.codigoRetorno == 0)
          {
            for (let i = 0; i < respuesta.data.personas.length; i++) 
            {
                respuesta.data.personas[i].numero_identidad_arrendatario = '';
                respuesta.data.personas[i].nombres_arrendatario = '';
                respuesta.data.personas[i].apellidos_arrendatario = '';
                respuesta.data.personas[i].numero_identidad_empresa = '';
                respuesta.data.personas[i].empresa = '';
                respuesta.data.personas[i].cargo_empresa = '';
                respuesta.data.personas[i].email_arrendatario = '';
                respuesta.data.personas[i].telefono_arrendatario = '';
                respuesta.data.personas[i].moneda_ingreso = '';
                respuesta.data.personas[i].monto_ingreso = parseInt(respuesta.data.personas[i].monto_ingreso);
                respuesta.data.personas[i].ingreso = '';
                respuesta.data.personas[i].sueldo = '';
            }
            setState({ ...guardarDatos, ...respuesta.data.personas[0], personas : respuesta.data.personas });
            navigate("/datos-propiedad/"+respuesta.data.id);
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
      else
      {
        guardarDatos = { ...state, aseguradora : aseguradora.nombre, cantidad_personas_adicionales : cantidadPersonasAdicionales, formatos_certificacion_ingresos : false, estatus_garantia : 'Paso 1, Borrador', personas : null };
        const formulario = new FormData();
        formulario.append("datos", JSON.stringify(guardarDatos));
        try {
          const respuesta = await axios.post(state.endpoint+'/garantias/update/'+idGarantia, formulario, { headers: { 'Authorization': `Bearer ${state.token_laravel}`, "Content-Type": "multipart/form-data" } });
          setGifEspere('');
          if (respuesta.data.codigoRetorno == 0)
          {
            setState({ ...state, aseguradora : aseguradora.nombre, cantidad_personas_adicionales : cantidadPersonasAdicionales, estatus_garantia : 'Paso 1, Borrador' });
            navigate("/datos-propiedad/"+idGarantia);
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
  };
  
  
  const BotonesAseguradoras = () => {
    return(
      <>
        <br />
        <Grid container>
          <Grid key={'1'} size={{ xs : 12, sm : 12, md : 7, lg : 7, xl : 7 }}>
            <Typography variant="h4">Seleccionar aseguradora</Typography>
            <Typography variant="h6">Seleccione su aseguradora</Typography>
          </Grid>
        </Grid>
        <div className='ra_tabla_escritorio'>
          <Box
            sx={{
              display: 'flex',
              flexWrap: 'wrap',
              justifyContent: 'center'
            }}
          >
            <div className='boton_sura ra_gris' style={{margin : 10}} onClick={() => aseguradoraSeleccionada("Sura")}>
              <TarjetaPrimaria urlImagen='https://s3.sa-east-1.amazonaws.com/cdn.ofiliaria.com.uy/garantias-uy/imagenes/sura-logo-300-200.jpg' titulo='Sura' />
            </div>
            <div className='boton_porto ra_gris' style={{margin : 10}} onClick={() => aseguradoraSeleccionada("Porto")}>
              <TarjetaPrimaria urlImagen='https://s3.sa-east-1.amazonaws.com/cdn.ofiliaria.com.uy/garantias-uy/imagenes/porto-logo-300-200.png' titulo='Porto' />
            </div>
            <div className='boton_sancor ra_gris' style={{margin : 10}} onClick={() => aseguradoraSeleccionada("Sancor")}>
              <TarjetaPrimaria urlImagen='https://s3.sa-east-1.amazonaws.com/cdn.ofiliaria.com.uy/garantias-uy/imagenes/sancor-logo.jpg' titulo='Sancor' />
            </div>
            <div className='boton_mapfre ra_gris' style={{margin : 10}} onClick={() => aseguradoraSeleccionada("Mapfre")}>
              <TarjetaPrimaria urlImagen='https://s3.sa-east-1.amazonaws.com/cdn.ofiliaria.com.uy/garantias-uy/imagenes/maphre-logo.jpg' titulo='Mapfre' />
            </div>
            <div className='boton_sbi ra_gris' style={{margin : 10}} onClick={() => aseguradoraSeleccionada("Sbi")}>
              <TarjetaPrimaria urlImagen='https://s3.sa-east-1.amazonaws.com/cdn.ofiliaria.com.uy/garantias-uy/imagenes/sbi-logo-300-200.png' titulo='Sbi' />
            </div>
          </Box>
        </div>
        <div className="ra_tabla_movil">
          <TableContainer>
            <Table aria-label="simple table">
              <TableBody>
                <TableRow>
                  <TableCell>
                    <div id='boton_sura' className='boton_sura ra_gris' onClick={() => aseguradoraSeleccionada("Sura")} tabIndex='0' ref={enfocarSura}>
                      <TarjetaPrimaria urlImagen='https://s3.sa-east-1.amazonaws.com/cdn.ofiliaria.com.uy/garantias-uy/imagenes/sura-logo-300-200.jpg' titulo='Sura' />
                    </div>
                  </TableCell>
                  <TableCell>
                    <div id='boton_porto' className='boton_porto ra_gris' onClick={() => aseguradoraSeleccionada("Porto")} tabIndex='0' ref={enfocarPorto}>
                      <TarjetaPrimaria urlImagen='https://s3.sa-east-1.amazonaws.com/cdn.ofiliaria.com.uy/garantias-uy/imagenes/porto-logo-300-200.png' titulo='Porto' />
                    </div>
                  </TableCell>
                  <TableCell>
                    <div id='boton_sancor' className='boton_sancor ra_gris' onClick={() => aseguradoraSeleccionada("Sancor")} tabIndex='1' ref={enfocarSancor}>
                      <TarjetaPrimaria urlImagen='https://s3.sa-east-1.amazonaws.com/cdn.ofiliaria.com.uy/garantias-uy/imagenes/sancor-logo.jpg' titulo='Sancor' />
                    </div>
                  </TableCell>
                  <TableCell>
                    <div id='boton_mapfre' className='boton_mapfre ra_gris' onClick={() => aseguradoraSeleccionada("Mapfre")} tabIndex='0' ref={enfocarMapfre}>
                      <TarjetaPrimaria urlImagen='https://s3.sa-east-1.amazonaws.com/cdn.ofiliaria.com.uy/garantias-uy/imagenes/maphre-logo.jpg' titulo='Mapfre' />
                    </div>
                  </TableCell>
                  <TableCell>
                    <div id='boton_sbi' className='boton_sbi ra_gris' onClick={() => aseguradoraSeleccionada("Sbi")} tabIndex='0' ref={enfocarSbi}>
                      <TarjetaPrimaria urlImagen='https://s3.sa-east-1.amazonaws.com/cdn.ofiliaria.com.uy/garantias-uy/imagenes/sbi-logo-300-200.png' titulo='Sbi' />
                    </div>
                  </TableCell>
                </TableRow>
              </TableBody>
            </Table>
          </TableContainer>
        </div>
      </>
    );
  }

  const BotonesNavegacion = () => {
    return (
          <Form onSubmit={handleSubmit(saveData)}>
            <div className='botones_navegacion_fijos'>
              <div className='ra_nav_anterior'>
                <Fab variant="extended" color="secondary" sx={{ fontSize : 12, borderRadius : 1}} onClick={() => {setState(datosInicio); navigate('/garantias')}} >
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
                <Fab variant="extended" color="secondary" sx={{ fontSize : 12, borderRadius : 1}}  onClick={() => {setState(datosInicio); navigate('/garantias')}} >
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
          </Form>
    );
  }

  console.log('SeleccionarAseguradora, state', state);
  
  return (
    <>
      {inicioPantalla}
      <Box component={Paper} elevation={12} sx={{ marginTop : '14rem', borderRadius : 3,  p : 2 }}>
        <Stack sx={{width : '100%'}}>
          <PasoAPaso rutaPaso={''} />
        </Stack>
        <BotonesAseguradoras />
        {aseguradora.componente}
        <br /><br />
        <BotonesNavegacion />      
        {gifEspere}
        {AlertaFija}
      </Box>
    </>
  );
}
