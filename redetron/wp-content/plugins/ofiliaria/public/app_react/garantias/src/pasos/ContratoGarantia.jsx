import { useState, useRef, useEffect, useCallback } from 'react';
import { useForm } from "react-hook-form";
import { useNavigate, Link } from "react-router-dom";
import { useParams } from "react-router-dom";
import { GifEspere, prepararCamposPersonas } from "../varios";
import { Form, Field, Input } from "../forms";
import { useAppState } from "../state.jsx";
import {
    datosInicio, 
    inputsAseguradoras, 
    opcionesAseguradoras, 
    datosInicioPersona, 
    aseguradorasTiposPersonas,
    opcionesInputs 
  } from "../vectores_objetos";
import { CargarArchivosServidor } from '../campos_opcionales';
import axios from 'axios';
import { useLocation } from "react-router-dom";
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
import Grid from '@mui/material/Grid2';
import { 
    PasoAPasoContrato, 
    InputFormControlRHF,
    InputNumericFormatRHF,
    InputSelectRHF,
    InputRadioRHF,
    MensajeError,
    InputFormControlMultilineaRHF,
    ModalBasico, 
    ModalDialogoBasico, 
    AlertaSatisfactorio,
    AlertaAviso,
    AlertaError
  } from '../mui';
import AddIcon from '@mui/icons-material/Add';
import RemoveIcon from '@mui/icons-material/Remove';
import KeyboardArrowDownIcon from '@mui/icons-material/KeyboardArrowDown';
import KeyboardArrowLeftIcon from '@mui/icons-material/KeyboardArrowLeft';
import KeyboardArrowRightIcon from '@mui/icons-material/KeyboardArrowRight';
import DatePicker from 'react-date-picker';

import { EditorState, ContentState, convertToRaw } from 'draft-js';
import { Editor } from 'react-draft-wysiwyg';
import { convertToHTML, convertFromHTML } from 'draft-convert';
import DOMPurify from 'dompurify';
import { renderToString } from 'react-dom/server';
import { ContratoSura, ContratoPorto, ContratoSancor, ContratoMapfre, ContratoSbi } from '../contratos_garantia';
import { useReactToPrint } from "react-to-print";
import { conversionDias, conversionMeses, generarDatosContrato } from "../vectores_objetos";
  
export const ContratoGarantia = () => {
  const [state, setState] = useAppState();
  const { t } = useTranslation();
  const location = useLocation();
  const paginaActual = useRef('');
  paginaActual.current = location.pathname.split('/')[1];
  const [inicioPantalla, setInicioPantalla] = useState('');
  const [imagenAseguradora, setImagenAseguradora] = useState('');
  const [gifEspere, setGifEspere] = useState('');
  const [alertaFija, setAlertaFija] = useState('');
  const [mostrarFormulario, setMostrarFormulario] = useState(true);
  const [mostrarDatosFormulario, setMostrarDatosFormulario] = useState(false);
  const vectorOpcionesAseguradoras = opcionesAseguradoras();
  const [errorTipoPersona, setErrorTipoPersona] = useState(false); 
  const [errorEmail, setErrorEmail] = useState(false);
  const [errorTelefono, setErrorTelefono] = useState(false);
  const [errorTipoContrato, setErrorTipoContrato] = useState(false);
  const [errorFechaInicioAlquiler, setErrorFechaInicioAlquiler] = useState('');
  const [errorPlazoAlquiler, setErrorPlazoAlquiler] = useState(false);
  const [errorTipoPlazoAlquiler, setErrorTipoPlazoAlquiler] = useState(false);
  const [errorTipoPagoAlquiler, setErrorTipoPagoAlquiler] = useState(false);
  const [errorRegimenAjusteAlquiler, setErrorRegimenAjusteAlquiler] = useState(false);
  const [errorDepartamentoFirma, setErrorDepartamentoFirma] = useState(false);
  const [errorCiudadFirma, setErrorCiudadFirma] = useState(false);
  const [errorTerminosCondiciones, setErrorTerminosCondiciones] = useState(false);
  const [errorBanco, setErrorBanco] = useState(false);
  const [errorNumeroSucursalBanco, setErrorNumeroSucursalBanco] = useState(false);
  const [errorNombresTitularCuenta, setErrorNombresTitularCuenta] = useState(false);
  const [errorApellidosTitularCuenta, setErrorApellidosTitularCuenta] = useState(false);
  const [errorMoneda, setErrorMoneda] = useState(false);
  const [errorNumeroCuenta, setErrorNumeroCuenta] = useState(false);
  const [errorTipoCuenta, setErrorTipoCuenta] = useState(false);

  const [modalBasico, setModalBasico] = useState(false);
  const accionModalBasico = useRef();
  const [tituloModalBasico, setTituloModalBasico] = useState(false);
  const [contenidoModalBasico, setContenidoModalBasico] = useState(false);

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

  const [mostrarTipoDocumentoIdentidad, setMostrarTipoDocumentoIdentidad] = useState(true);
  const [errorTipoDocumentoIdentidad, setErrorTipoDocumentoIdentidad] = useState(false); 
 
  const [mostrarNroIdentArrend, setMostrarNroIdentArrend] = useState(true);
  const [errorNroIdentArrend, setErrorNroIdentArrend] = useState(false);

  const [mostrarNombres, setMostrarNombres] = useState(true);
  const [errorNombres, setErrorNombres] = useState(false);

  const [mostrarApellidos, setMostrarApellidos] = useState(true);
  const [errorApellidos, setErrorApellidos] = useState(false);

  const [errorDomicilioPersona, setErrorDomicilioPersona] = useState(false); 
  const [errorDepartamentoDomicilio, setErrorDepartamentoDomicilio] = useState(false);
  const [errorCiudadDomicilio, setErrorCiudadDomicilio] = useState(false);

  const [MostrarDatosAdicionalesPersonaFisica, setMostrarDatosAdicionalesPersonaFisica] = useState(false);
  const [errorClasificacionPersonaFisica, setErrorClasificacionPersonaFisica] = useState(false); 

  const [mostrarNroIdentEmp, setMostrarNroIdentEmp] = useState(false);
  const [errorNroIdentEmp, setErrorNroIdentEmp] = useState(false);

  const [mostrarEmpresa, setMostrarEmpresa] = useState(false);
  const [errorEmpresa, setErrorEmpresa] = useState(false);

  const [MostrarDatosPersonaJuridica, setMostrarDatosPersonaJuridica] = useState(false);
  const [errorClasificacionPersonaJuridica, setErrorClasificacionPersonaJuridica] = useState(false); 

  const [mostrarIdentidad, setMostrarIdentidad] = useState(true);
  const ubicacionIdentidadRef = useRef(state.ubicacion_identidad);
  const contadorIdentidad = useRef('');
  const [errorIdentidad, setErrorIdentidad] = useState('');

  const [mostrarCertIngMod, setMostrarCertIngMod] = useState(false);
  const ubicacionesCertIngModRef = useRef(state.ubicaciones_cert_ing_mod);
  const contadorCertIngMod = useRef(0);
  const [etiquetaCertIngMod, setEtiquetaCertIngMod] = useState(t('Poder notariado'));
  const [etiquetaCertIngMod2, setEtiquetaCertIngMod2] = useState(t('Cargar poder notariado'));
  const [errorCertIngMod, setErrorCertIngMod] = useState('');

  const [mostrarRut, setMostrarRut] = useState(false);
  const ubicacionesRutRef = useRef(state.ubicaciones_rut);
  const contadorRut = useRef(0);
  const [errorRut, setErrorRut] = useState('');

  const [mostrarNotasPersona, setMostrarClasificacionNotasPersona] = useState(false);
  const [errorClasificacionNotasPersona, setErrorClasificacionNotasPersona] = useState(false);

  const [mensajesUsuarioEncabezado, setMensajesUsuarioEncabezado] = useState('');
  const [subTituloFormulario, setSubTituloFormulario] = useState('');
  const { idGarantia } = useParams();

  const [fechaInicioDelAlquiler, setFechaInicioDelAlquiler] = useState(new Date());
  const fechaInicioDelAlquilerTexto = useRef('');
  const fechaInicioAlquilerDesglosada = useRef({diaNumero : '', diaLetras: '', mesNumero : '', mesLetras: '', anio : ''});

  const [mostrarContrato, setMostrarContrato] = useState(false);

  const [editorState, setEditorState] = useState(
    () => EditorState.createEmpty(),
  );

  const [vistaContrato, setVistaContrato] = useState('');

  const contentRef = useRef(null);
  const reactToPrintFn = useReactToPrint({ contentRef : contentRef });
  const dataContrato = useRef({});
  const indicadorVerificacionContrato = useRef(false);
  const datosContrato = useRef({});
  
  useEffect(() => {( async () => {
    logoAseguradora(state.aseguradora);
    ajustesIniciales();
    opciones(state.tipo_persona);
    setInicioPantalla(window.scrollTo(0,0));
  })();},[]);

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

  const ajustesIniciales = async () => {
    if (state.agregando_persona == true || state.editando_persona == true)
    {
      cambiarMostrarDatosFormulario(true);
    }
    if (state.persona_eliminada == true)
    {
      setAlertaFija(<AlertaSatisfactorio texto={t('texto_206')} />);
      setTimeout(() => {
        setAlertaFija('');
      }, 10000);
    }
    if (state.fecha_inicio_alquiler == null || state.fecha_inicio_alquiler == '')
    {
      let diaFechaInicioDelAlquiler = fechaInicioDelAlquiler.getDate();
      let mesFechaInicioDelAlquiler = parseInt(fechaInicioDelAlquiler.getMonth())+1;
      let anioFechaInicioDelAlquiler = fechaInicioDelAlquiler.getFullYear();
      
      fechaInicioDelAlquilerTexto.current = diaFechaInicioDelAlquiler+'/'+mesFechaInicioDelAlquiler+'/'+anioFechaInicioDelAlquiler;
      fechaInicioAlquilerDesglosada.current.diaNumero = diaFechaInicioDelAlquiler;
      fechaInicioAlquilerDesglosada.current.diaLetras = conversionDias[diaFechaInicioDelAlquiler];
      fechaInicioAlquilerDesglosada.current.mesNumero = mesFechaInicioDelAlquiler;
      fechaInicioAlquilerDesglosada.current.mesLetras = conversionMeses[mesFechaInicioDelAlquiler];
      fechaInicioAlquilerDesglosada.current.anio = anioFechaInicioDelAlquiler;
    }
    else
    {
      let vectorFecha = state.fecha_inicio_alquiler.split('/');
      let objetoFecha = new Date(vectorFecha[2]+'/'+vectorFecha[1]+'/'+vectorFecha[0]);
      setFechaInicioDelAlquiler(objetoFecha);  
      fechaInicioDelAlquilerTexto.current = state.fecha_inicio_alquiler;
      fechaInicioAlquilerDesglosada.current.diaNumero = vectorFecha[0];
      fechaInicioAlquilerDesglosada.current.diaLetras = conversionDias[vectorFecha[0]];
      fechaInicioAlquilerDesglosada.current.mesNumero = vectorFecha[1];
      fechaInicioAlquilerDesglosada.current.mesLetras = conversionMeses[vectorFecha[1]];
      fechaInicioAlquilerDesglosada.current.anio = vectorFecha[2];
    }
    contadorIdentidad.current = state.contador_identidad;   
    contadorCertIngMod.current = state.contador_cert_ing_mod;        
    contadorRut.current = state.contador_rut;
  }

  const opciones = (tipoPersona) => {    
    if (tipoPersona != '')
    {
      if (tipoPersona == 'Física')
      {
          setMostrarDatosAdicionalesPersonaFisica(true);

          if (state.clasificacion_persona_fisica == 'Apoderado')
          {
            setMostrarCertIngMod(true);
          }
      
          setMostrarNroIdentEmp(false);
          unregister('numero_identidad_empresa');

          setMostrarEmpresa(false);
          unregister('empresa');

          setMostrarDatosPersonaJuridica(false);
          unregister('clasificacion_persona_juridica');          

          setMostrarRut(false);
          unregister('rut');
      }
      else
      {
        setMostrarNroIdentEmp(true);
        setMostrarEmpresa(true);
        setMostrarDatosPersonaJuridica(true);
        setMostrarRut(true);

        setMostrarDatosAdicionalesPersonaFisica(false);
        unregister('clasificacion_persona_fisica');
        setMostrarCertIngMod(false);
        unregister('cert_ing_mod');
      }
    }
    else
    {
      setMostrarDatosAdicionalesPersonaFisica(false);
      unregister('clasificacion_persona_fisica');

      setMostrarCertIngMod(false);
      unregister('cert_ing_mod');

      setMostrarNroIdentEmp(false);
      unregister('numero_identidad_empresa');

      setMostrarEmpresa(false);
      unregister('empresa');

      setMostrarDatosPersonaJuridica(false);
      unregister('clasificacion_persona_juridica');   

      setMostrarRut(false);
      unregister('rut');
    }  
  };

  const { handleSubmit, register, unregister, setValue, watch, setFocus, control, formState: { errors } } = useForm({ defaultValues: state, mode: "onChange" });

  const navigate = useNavigate();

  const abrirModalBasico = () => {
    setModalBasico(true);
  }

  const cerrarModalBasico = () => {
    setModalBasico(false);
  }

  const abrirModalDialogoBasico = () => {
    setModalDialogoBasico(true);
  }

  const cerrarModalDialogoBasico = () => { 
    setModalDialogoBasico(false);
  }

  const funcionAdicionalTipoContrato = (event) => {
    if (event.target.value != '')
    {
      // 
    }
  };

  const funcionAdicionalFechaInicioAlquiler = (event) => {
    if (event.target.value != '')
    {
      // 
    }
  };

  const funcionAdicionalPlazoAlquiler = (event) => {
    if (event.target.value != '')
    {
      // 
    }
  };

  const funcionAdicionalTipoPlazoAlquiler = (event) => {
    if (event.target.value != '')
    {
      // 
    }
  };

  const funcionAdicionalTipoPagoAlquiler = (event) => {
    if (event.target.value != '')
    {
      // 
    }
  };

  const funcionAdicionalRegimenAjusteAlquiler = (event) => {
    if (event.target.value != '')
    {
      // 
    }
  };

  const funcionAdicionalDepartamentoFirma = (event) => {
    if (event.target.value != '')
    {
      // 
    }
  };

  const funcionAdicionalCiudadFirma = (event) => {
    if (event.target.value != '')
    {
      // 
    }
  };

  const funcionAdicionalTerminosCondiciones = (event) => {
    if (event.target.value != '')
    {
      // 
    }
  };

  const funcionAdicionalBanco = (event) => {
    if (event.target.value != '')
    {
      // 
    }
  };

  const funcionAdicionalNumeroSucursalBanco = (event) => {
    if (event.target.value != '')
    {
      // 
    }
  };

  const funcionAdicionalNombresTitularCuenta = (event) => {
    if (event.target.value != '')
    {
      // 
    }
  };

  const funcionAdicionalApellidosTitularCuenta = (event) => {
    if (event.target.value != '')
    {
      // 
    }
  };

  const funcionAdicionalMoneda = (event) => {
    if (event.target.value != '')
    {
      // 
    }
  };

  const funcionAdicionalNumeroCuenta = (event) => {
    if (event.target.value != '')
    {
      // 
    }
  };

  const funcionAdicionalTipoCuenta = (event) => {
    if (event.target.value != '')
    {
      // 
    }
  };

  const funcionAdicionalTipoPersona = (event) => {
    if (event.target.value != '')
    {
      opciones(event.target.value);
    }
  };

  const funcionAdicionalTipoDocumentoIdentidad = (event) => {
    if (event.target.value != '')
    {
      // 
    }
  };

  const funcionAdicionalNroIdentArrend = (event) => {
    if (event.target.value != '')
    {
      // 
    }
  };

  const funcionAdicionalNombres = (event) => {
    if (event.target.value != '')
    {
      // 
    }
  };

  const funcionAdicionalApellidos = (event) => {
    if (event.target.value != '')
    {
      // 
    }
  };

  const funcionAdicionalClasificacionPersonaFisica = (event) => {
    if (event.target.value == 'Apoderado')
    {
      setMostrarCertIngMod(true);
    }
    else
    {
      setMostrarCertIngMod(false);
    }
  };

  const funcionAdicionalNroIdentEmp = (event) => {
    if (event.target.value != '')
    {
      // 
    }
  };

  const funcionAdicionalEmpresa = (event) => {
    if (event.target.value != '')
    {
      // 
    }
  };

  const funcionAdicionalClasificacionPersonaJuridica = (event) => {
    if (event.target.value != '')
    {
      // 
    }
  };

  const funcionAdicionalDomicilioPersona = (event) => {
    if (event.target.value != '')
    {
      // 
    }
  };

  const funcionAdicionalDepartamentoDomicilio = (event) => {
    if (event.target.value != '')
    {
      // 
    }
  };

  const funcionAdicionalCiudadDomicilio = (event) => {
    if (event.target.value != '')
    {
      // 
    }
  };

  const funcionAdicionalEmail = (event) => {
    if (event.target.value != '')
    {
      // 
    }
  }

  const funcionAdicionalTelefono = (event) => {
    if (event.target.value != '')
    {
      // 
    }
  }

  const funcionAdicionalNotasPersona = (event) => {
    if (event.target.value != '')
    {
      // 
    }
  }

  const funcionAdicionalDatePicker = (event) => {
    //
  }

  const actualizarFechaInicioAlquiler = (fecha) => {
    setFechaInicioDelAlquiler(fecha);
    if (fecha == null)
    {
      fechaInicioDelAlquilerTexto.current = fecha;
    }
    else
    {
      let indicadorErrorFecha = 0;
      let diaFechaInicioDelAlquiler = fecha.getDate();
      let mesFechaInicioDelAlquiler = parseInt(fecha.getMonth())+1;
      let anioFechaInicioDelAlquiler = fecha.getFullYear();
      if (diaFechaInicioDelAlquiler < 1 && diaFechaInicioDelAlquiler > 31)
      {
        indicadorErrorFecha = 1;
      }
      if (mesFechaInicioDelAlquiler < 1 && mesFechaInicioDelAlquiler > 12)
      {
        indicadorErrorFecha = 1;
      }
      if (anioFechaInicioDelAlquiler < 2025)
      {
        indicadorErrorFecha = 1;
      }
      if (indicadorErrorFecha == 0)
      {
        fechaInicioDelAlquilerTexto.current = diaFechaInicioDelAlquiler+'/'+mesFechaInicioDelAlquiler+'/'+anioFechaInicioDelAlquiler;
        fechaInicioAlquilerDesglosada.current.diaNumero = diaFechaInicioDelAlquiler;
        fechaInicioAlquilerDesglosada.current.diaLetras = conversionDias[diaFechaInicioDelAlquiler];
        fechaInicioAlquilerDesglosada.current.mesNumero = mesFechaInicioDelAlquiler;
        fechaInicioAlquilerDesglosada.current.mesLetras = conversionMeses[mesFechaInicioDelAlquiler];
        fechaInicioAlquilerDesglosada.current.anio = anioFechaInicioDelAlquiler;
        }
      else
      {
        fechaInicioAlquilerDesglosada.current.diaNumero = '';
        fechaInicioAlquilerDesglosada.current.diaLetras = '';
        fechaInicioAlquilerDesglosada.current.mesNumero = '';
        fechaInicioAlquilerDesglosada.current.mesLetras = '';
        fechaInicioAlquilerDesglosada.current.anio = '';
      }
    }
  }

  const actualizarMensajeErrorIdentidad = (mensaje) => {
    setErrorIdentidad(mensaje);
  };

  const actualizarMensajeErrorCertIngMod = (mensaje) => {
    setErrorCertIngMod(mensaje);
  };

  const actualizarMensajeErrorRut = (mensaje) => {
    setErrorRut(mensaje);
  };

  const editarPersona = (persona) => {
    let personasEdicion = state.personas;
    setState({...state, ...persona, agregando_persona : false, editando_persona : true, persona_eliminada : false, personas : personasEdicion });
    navigate('/revision-garantia/9999999999');  
  }

  const eliminarPersona = async (data) => {  
    try {  
        const respuesta = await axios.post(state.endpoint+'/personas/destroy/'+data.id, {}, { headers: { 'Authorization': `Bearer ${state.token_laravel}`, "Content-Type": "application/json", "Accept" :  "application/json"} 
      });
      setGifEspere('');
      if (respuesta.data.codigoRetorno == 0)
      {
        let eliminarPersonas = state.personas;
        let posicionElemento = 0;
        for (let i = 0; i < eliminarPersonas.length; i++) 
        {
          if (eliminarPersonas[i].id == data.id)
          {
            posicionElemento = i;
            break;
          }
        }
        eliminarPersonas.splice(posicionElemento, 1);
        
        if (eliminarPersonas.length == 1)
        {
          agregarDatosPropietario('eliminarPersona', data);
        }
        else
        {
          let ultimaPersona = eliminarPersonas.length -1;
          if (eliminarPersonas[ultimaPersona].tipo_persona == null)
          {
            setState({ ...state, ...data, ...eliminarPersonas[ultimaPersona], tipo_persona : '', agregando_persona : false, editando_persona : false, persona_eliminada : true, personas : eliminarPersonas });
          }
          else
          {
            setState({ ...state, ...data, ...eliminarPersonas[ultimaPersona], persona_eliminada : true, agregando_persona : false, editando_persona : false, personas : eliminarPersonas });
          }
          navigate('/revision-garantia/9999999999');
        }  
      }
      else
      {
        setAlertaFija(<AlertaError texto={t("No se pudo eliminar el registro de la persona")} />);
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

  const cambiarMostrarDatosFormulario = (valor) => {
    setMostrarDatosFormulario(valor);
  }

  const saveData = async (data) => {
    let indicadorErrores = 0;
    setErrorTipoPersona(false);
    setErrorTipoDocumentoIdentidad(false);
    setErrorNroIdentArrend(false);
    setErrorNombres(false);
    setErrorApellidos(false);
    setErrorClasificacionPersonaFisica(false);
    setErrorNroIdentEmp(false);
    setErrorEmpresa(false);
    setErrorClasificacionPersonaJuridica(false);
    setErrorDomicilioPersona(false);
    setErrorDepartamentoDomicilio(false);
    setErrorCiudadDomicilio(false);
    setErrorEmail(false);
    setErrorTelefono(false);
    
    setErrorIdentidad('');
    setErrorCertIngMod('');
    setErrorRut('');

    let personasActualizadas = state.personas;
    let datosActualizados = {};
    let posicionPropietarioActual = 0;

    if (data.tipo_persona == null  || data.tipo_persona == '')
    {
      setErrorTipoPersona(true);
      indicadorErrores = 1;
    }

    if (mostrarTipoDocumentoIdentidad == true)
    {
      if (data.tipo_documento_identidad == null || data.tipo_documento_identidad == '')
      {
        setErrorTipoDocumentoIdentidad(true);
        indicadorErrores = 1;
      }
    }

    if (mostrarNroIdentArrend == true)
    {
      if (data.numero_identidad_arrendatario == null || data.numero_identidad_arrendatario == '' || data.numero_identidad_arrendatario == '0' || data.numero_identidad_arrendatario == 0)
      {
        setErrorNroIdentArrend(true);
        indicadorErrores = 1;
      }
    }
    if (mostrarNombres == true)
    {
      if (data.nombres_arrendatario == null || data.nombres_arrendatario == '')
      {
        setErrorNombres(true);
        indicadorErrores = 1;
      }
    }
    if (mostrarApellidos == true)
    {
      if (data.apellidos_arrendatario == null || data.apellidos_arrendatario == '')
      {
        setErrorApellidos(true);
        indicadorErrores = 1;
      }
    }

    if (MostrarDatosAdicionalesPersonaFisica == true)
    {
      if (data.clasificacion_persona_fisica == null || data.clasificacion_persona_fisica == '')
      {
        setErrorClasificacionPersonaFisica(true);
        indicadorErrores = 1;
      }
    }

    if (mostrarNroIdentEmp == true)
    {
      if (data.numero_identidad_empresa == null || data.numero_identidad_empresa == '' || data.numero_identidad_empresa == '0' || data.numero_identidad_empresa == 0)
      {
        setErrorNroIdentEmp(true);
        indicadorErrores = 1;
      }
    }

    if (mostrarEmpresa == true)
    {
      if (data.empresa == null || data.empresa == '')
      {
        setErrorEmpresa(true);
        indicadorErrores = 1;
      }
    }

    if (MostrarDatosPersonaJuridica == true)
    {
      if (data.clasificacion_persona_juridica == null || data.clasificacion_persona_juridica == '')
      {
        setErrorClasificacionPersonaJuridica(true);
        indicadorErrores = 1;
      }
    }

    if (data.domicilio_persona == null || data.domicilio_persona == '')
    {
        setErrorDomicilioPersona(true);
        indicadorErrores = 1;
    }

    if (data.departamento_domicilio == null || data.departamento_domicilio == '')
    {
        setErrorDepartamentoDomicilio(true);
        indicadorErrores = 1;
    }

    if (data.ciudad_domicilio == null || data.ciudad_domicilio == '')
    {
        setErrorCiudadDomicilio(true);
        indicadorErrores = 1;
    }

    if (data.email_arrendatario == null || data.email_arrendatario == '')
    {
        setErrorEmail(true);
        indicadorErrores = 1;
    }

    if (data.telefono_arrendatario == null || data.telefono_arrendatario == '' || data.telefono_arrendatario == '0' || data.telefono_arrendatario == 0)
    {
      setErrorTelefono(true);
      indicadorErrores = 1;
    }
    if (mostrarIdentidad == true && contadorIdentidad.current == 0)
    {
      actualizarMensajeErrorIdentidad(<MensajeError mensaje={'La imagen del documento de identidad es requerida'} />);
      indicadorErrores = 1;
    }

    if (mostrarCertIngMod == true && contadorCertIngMod.current == 0)
    {
      actualizarMensajeErrorCertIngMod(<MensajeError mensaje={t('El poder es requerido')} />);
      indicadorErrores = 1;
    }

    if (mostrarRut == true && contadorRut.current == 0)
    {
      actualizarMensajeErrorRut(<MensajeError mensaje={t("La tarjeta RUT es requerida")} />);
      indicadorErrores = 1;
    }

    if (indicadorErrores == 0)
    {
      setGifEspere(<GifEspere />);
 
      datosActualizados = 
        {
          ...state, 
          ...data, 
          identidad : 'identidad',
          etiqueta_identidad : t('texto_62'),
          cert_ing_mod : 'cert_ing_mod', 
          etiqueta_cert_ing_mod : t('Poder notariado'),
          rut : 'rut', 
          etiqueta_rut : t("Tarjeta RUT *"),
          personas : null 
        };          

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
      // console.log('ContratoGarantia, formulario', [...formulario]);
      
      try {  
        const respuesta = await axios.post(state.endpoint+'/personas/update/'+state.id, formulario, { headers: { 'Authorization': `Bearer ${state.token_laravel}`, "Content-Type": "multipart/form-data" } });
        setGifEspere('');
        if (respuesta.data.codigoRetorno == 0)
        {  
          if (state.agregando_persona == true)
          {
            setAlertaFija(<AlertaSatisfactorio texto={t('texto_229')} />);
            setTimeout(() => {
              setAlertaFija('');
            }, 10000);
    
          }
    
          if (state.editando_persona == true)
          {
            setAlertaFija(<AlertaSatisfactorio texto={t('texto_230')} />);
            setTimeout(() => {
              setAlertaFija('');
            }, 10000);
          }

          for (let i = 0; i < respuesta.data.personas.length; i++) 
          {
            if (respuesta.data.personas[i].id == state.id)
            {
              posicionPropietarioActual = i;
              break;
            }
          }

          setState({...state, ...respuesta.data.personas[posicionPropietarioActual], agregando_persona : false, editando_persona : false, persona_eliminada : false, personas : respuesta.data.personas });
          setMostrarDatosFormulario(false);
        }
        else
        {
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
  }

  console.log("ContratoGarantia, state", state);

  const Propietarios = () => {
    const encabezados = [t('texto_196'), t('texto_197'), t('texto_198'), t('texto_199')];

    const BasicMenu = ({persona, propietario}) => {
      const [anchorEl, setAnchorEl] = useState(null);
      const open = Boolean(anchorEl);
      const handleClick = (event) => {
        setAnchorEl(event.currentTarget);
      };
      const handleClose = () => {
        setAnchorEl(null);
      };
  
      return (
        <div>
          <Button
            id="basic-button"
            variant="contained"
            aria-controls={open ? 'basic-menu' : undefined}
            aria-haspopup="true"
            aria-expanded={open ? 'true' : undefined}
            onClick={handleClick}
            endIcon={<KeyboardArrowDownIcon />}
          >
            Acciones
          </Button>
          <Menu
            id="basic-menu"
            anchorEl={anchorEl}
            open={open}
            onClose={handleClose}
            MenuListProps={{
              'aria-labelledby': 'basic-button',
            }}
          >
            <MenuItem onClick={() => { editarPersona(persona) }}>Editar</MenuItem>
            <MenuItem onClick={ handleSubmit((data) => modalEliminarPersona(data, persona, propietario)) }>{t('texto_163')}</MenuItem>
          </Menu>
        </div>
      );
    }

    const modalEliminarPersona = (data, persona, propietario) => {
      data = { ...data, id : persona.id };
      accionModalDialogoBasico.current = cerrarModalDialogoBasico;
      setTituloModalDialogoBasico(t('texto_280'));
      setContenidoModalDialogoBasico(t('texto_281', {propietario : propietario}));
      setTextoAccion1DialogoBasico(t('texto_113'));
      accion1DialogoBasico.current = eliminarPersona;
      setParametrosAccion1DialogoBasico(data);
      setTextoAccion2DialogoBasico(t('texto_114'));
      accion2DialogoBasico.current = cerrarModalDialogoBasico;
      setParametrosAccion2DialogoBasico('');
      setModalDialogoBasico(true);
    } 

    return (
      <>
        <Box component={Paper} elevation={12} sx={{ p : 2, borderRadius : 3 }}>
          <div className='ra_tabla_escritorio'>
            <br />
            <TableContainer>
              <Table sx={{ minWidth: 650 }} aria-label="simple table">
                <TableHead>
                  <TableRow>
                    {encabezados.map((encabezado, indice) => (
                      <TableCell key={indice} align="left">
                        {encabezado}
                      </TableCell>
                    ))}
                  </TableRow>
                </TableHead>
                <TableBody>
                  { 
                    state.personas.map( (persona) => {
                      if (persona.tipo_arrendatario == 'Propietario' && persona.tipo_persona != null) 
                      {
                        if (persona.nombres_arrendatario != null || persona.empresa != null)
                        {
                          let propietario = '';
                          if (persona.tipo_persona == 'Empresa')
                          {
                            propietario = persona.empresa;
                          }
                          else
                          {
                            propietario = persona.nombres_arrendatario+' '+persona.apellidos_arrendatario;
                          }
                          return (
                            <TableRow
                              key={persona.id}
                              sx={{ '&:last-child td, &:last-child th': { border: 0 } }}
                            >
                              <TableCell align="left">{propietario}</TableCell>
                              <TableCell align="left">{persona.tipo_persona}</TableCell>
                              <TableCell align="left">{persona.numero_identidad_arrendatario}</TableCell>
                              <TableCell align="left">{persona.telefono_arrendatario}</TableCell>
                              <TableCell align="left">
                                <BasicMenu persona={persona} propietario={propietario} />
                              </TableCell>
                            </TableRow>
                          );
                        }
                      }
                    })
                  }
                </TableBody>
              </Table>
            </TableContainer>
          </div>  
          <div className="ra_tabla_movil">
            <br />
            { 
              state.personas.map( (persona) => {
                if (persona.tipo_arrendatario == 'Propietario' && persona.tipo_persona != null) 
                {
                  if (persona.nombres_arrendatario != null || persona.empresa != null)
                  {
                    let propietario = '';
                    if (persona.tipo_persona == 'Empresa')
                    {
                      propietario = persona.empresa;
                    }
                    else
                    {
                      propietario = persona.nombres_arrendatario+' '+persona.apellidos_arrendatario;
                    }
                    return (
                      <Box key={persona.id} component={Paper} elevation={12} sx={{ p : 2, marginBottom : 2, borderRadius : 3}}>
                        <Typography variant="h3" sx={{marginBottom : '0.5rem'}}>{propietario}</Typography>
                        <div className='ra_flex_tabla_movil'>
                          <div className='ra_flex_simple'>
                            {persona.tipo_persona}
                          </div>
                        </div>
                        <div className='ra_flex_tabla_movil'>
                          <div className='ra_flex_doble'>
                            {persona.numero_identidad_arrendatario}
                          </div>
                          <div className='ra_flex_doble'>
                            {persona.telefono_arrendatario}
                          </div>
                        </div>
                        <div className='ra_flex_tabla_movil'>
                          <div className='ra_flex_simple'>
                            <BasicMenu persona={persona} propietario={propietario}/>
                          </div>
                        </div>
                      </Box>
                    );
                  }
                }
              })
            }
          </div>
        </Box>
        <br />
        <br />
      </>
    );
  }

  const FormularioPropietario = ({ mostrarDatosFormulario, cambiarMostrarDatosFormulario }) => {
    const [mostrarMensajeFaltante, setMostrarMensajeFaltante] = useState(false);
    const { t } = useTranslation();
    const [contenidoLineaTiempo, setcontenidoLineaTiempo] = useState(
      {
        paso1 : <><div className="ra_tilde glyphicon glyphicon-ok"></div><span numero-paso="" titulo-paso="Aseguradora"></span></>, 
        paso2 : <><div className="ra_tilde glyphicon glyphicon-ok"></div><span numero-paso="" titulo-paso="Propiedad"></span></>, 
        paso3 : <span numero-paso="3" titulo-paso="Inquilino"></span>, 
        paso4 : <span numero-paso="4" titulo-paso="Finalizar"></span>
      });
    const vectorOpcionesInputs = opcionesInputs();

    useEffect(() => {( async () => {
      // 
    })();},[]);

    const procesoPropietario = (data) => {
      if (mostrarDatosFormulario == true)
      {
        setState({...state, agregando_persona : false, editando_persona : false, persona_eliminada : false });
        navigate('/revision-garantia/9999999999'); 
      }
      else
      {
        agregarPropietario(data);
      }
    }

    const agregarPropietario = async (data) => {
      await guardarDatosContrato(data, 'No', 'No', 'No');
      let cantidadAcumuladaPropietarios = 0;
      for (let i = 0; i < state.personas.length; i++) 
      {
        if (state.personas[i].tipo_arrendatario == 'Propietario' && state.personas[i].tipo_persona != null)
        {
          cantidadAcumuladaPropietarios++;
        }
      }

      if (state.cantidad_propietarios == cantidadAcumuladaPropietarios)
      {
        modalLimitePropietarios();
      }
      else
      {
        agregarDatosPropietario('agregarPropietario', data);
      }
    }

    const modalSinPropietarios = () => {
      setTituloModalBasico(t(''));
      accionModalBasico.current = cerrarModalBasico;
      setContenidoModalBasico(t('texto_323'));
      setModalBasico(true);
    }

    const modalLimitePropietarios = () => {
      setTituloModalBasico(t('texto_203'));
      accionModalBasico.current = cerrarModalBasico;
      setContenidoModalBasico(t('texto_204'));
      setModalBasico(true);
    }

    const agregarDatosPropietario = async (origen, data) => {
      setGifEspere(<GifEspere />);
      let agregandoPersona = false;
      let personaEliminada = false;   
      if (origen == 'agregarPropietario')
      {
        agregandoPersona = true;
      } 
      else if (origen == 'eliminarPersona')
      {
        personaEliminada = true;
      }
      let registroNulo = 0;
      let posicionRegistroNulo = 0;
      for (let i = 0; i < state.personas.length; i++) 
      {
        if (state.personas[i].tipo_arrendatario == 'Propietario' && state.personas[i].tipo_persona == null && state.personas[i].nombres_arrendatario == '' && state.personas[i].apellidos_arrendatario == '' && state.personas[i].empresa == '' && state.personas[i].monto_ingreso == 0)
        {
          registroNulo = 1;
          posicionRegistroNulo = i;
        }
      }
      if (registroNulo == 0)
      {
        let datosCreacionPropietario = {...datosInicioPersona, tipo_arrendatario : 'Propietario', garantia_id : state.garantia_id};
        try {  
          const respuesta = await axios.post(state.endpoint+'/personas/store', datosCreacionPropietario, {
            headers: {
              'Authorization': `Bearer ${state.token_laravel}`
            }
          });
          setGifEspere('');
          if (respuesta.data.codigoRetorno == 0)
          {
            var personasPreparadas = prepararCamposPersonas(respuesta.data.personas);
            let ultimaPersona = personasPreparadas.length -1;
            setState({...state, ...data, ...personasPreparadas[ultimaPersona], tipo_persona : '', agregando_persona : agregandoPersona, editando_persona : false, persona_eliminada : personaEliminada, fecha_inicio_alquiler : fechaInicioDelAlquilerTexto.current, personas : personasPreparadas });
              navigate('/revision-garantia/9999999999');     
          }
          else
          {
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
      else
      {
        setState({ ...state, ...data, ...state.personas[posicionRegistroNulo], tipo_persona : '', agregando_persona : agregandoPersona, editando_persona : false, persona_eliminada : personaEliminada, fecha_inicio_alquiler : fechaInicioDelAlquilerTexto.current });
        navigate('/revision-garantia/9999999999');     
      }
    }
  
    const regresar = (event) => {
      event.preventDefault();
      if (state.usuario_administrador == 'Sí')
      {
        let personasActuales = state.personas;
        setState({ ...state, agregando_persona : false, editando_persona : false, persona_eliminada : false, ...state.personas[0], personas : personasActuales });
        navigate('/revision-garantia/'+state.garantia_id);  
      }
      else
      {
        irAlIndice();
      }
    }

    const regresarEdicionDatosContrato = async (event) => {
      event.preventDefault();
      setMostrarFormulario(true);
      setMostrarContrato(false);
    }

    const createMarkup = (html) => {
      return {
        __html: DOMPurify.sanitize(html)
      }
    }

    const prepararTextoContrato = (data) => {
      dataContrato.current = {...data, fecha_inicio_alquiler : fechaInicioDelAlquilerTexto.current, fecha_inicio_alquiler_desglosada : fechaInicioAlquilerDesglosada.current, personas : state.personas };
      if (state.texto_contrato != null && state.texto_contrato != '')
      {
        modalVerificacionContrato();
      }
      else
      {  
        contratoEnLinea();
      }
    }

    const modalVerificacionContrato = () => {
      accionModalDialogoBasico.current = cerrarModalDialogoBasico;
      setTituloModalDialogoBasico(t("Edición del contrato"));
      setContenidoModalDialogoBasico(t("Estimado usuario, ya existe un contrato guardado para esta garantía. Desea editarlo ?"));
      setTextoAccion1DialogoBasico(t('texto_113'));
      accion1DialogoBasico.current = contratoBaseDatos;
      setParametrosAccion1DialogoBasico();
      setTextoAccion2DialogoBasico(t('texto_114'));
      accion2DialogoBasico.current = contratoEnLinea;
      setParametrosAccion2DialogoBasico('');
      setModalDialogoBasico(true);
    } 

    const contratoBaseDatos = () => {  
      setModalDialogoBasico(false);
      const editorDataState = EditorState.createWithContent(convertFromHTML(state.texto_contrato));
      setEditorState(editorDataState);
      setMostrarFormulario(false);
      setMostrarContrato(true);
      setVistaContrato('');
    }

    const contratoEnLinea = async () => {
      setModalDialogoBasico(false);
      await generarDatosContrato(datosContrato, dataContrato);
      let modeloContrato = seleccionModeloContrato();
      const textoInicialContrato = renderToString(modeloContrato);
      const editorDataState = EditorState.createWithContent(convertFromHTML(textoInicialContrato));
      setEditorState(editorDataState);
      setMostrarFormulario(false);
      setMostrarContrato(true);
      setVistaContrato('');
    }

    const seleccionModeloContrato = () => {
      var modeloContrato = '';
      switch (state.aseguradora) {
        case 'Sura':
          modeloContrato = <ContratoSura datosContrato={datosContrato.current} />;
          break;
        case 'Porto':
          modeloContrato = <ContratoPorto datosContrato={datosContrato.current} />;
          break;
        case 'Sancor':
          modeloContrato = <ContratoSancor datosContrato={datosContrato.current} />;
          break;
        case 'Mapfre':
          modeloContrato = <ContratoMapfre datosContrato={datosContrato.current} />;
          break;
        case 'Sbi':
          modeloContrato = <ContratoSbi datosContrato={datosContrato.current} />;
      } 
      return modeloContrato;   
    }
            
    const guardarDatosContrato = async (data, validarDatos, editarContrato, salir) => {
      let indicadorErroresContrato = 0;
      let guardarDatos = {};
      const textoContrato = convertToHTML(editorState.getCurrentContent());
      if (validarDatos == 'Sí')
      {
        let cantidadAcumuladaPropietarios = 0;
        for (let i = 0; i < state.personas.length; i++) 
        {
          if (state.personas[i].tipo_arrendatario == 'Propietario' && state.personas[i].tipo_persona != null)
          {
            cantidadAcumuladaPropietarios++;
          }
        }
        if (cantidadAcumuladaPropietarios == 0)
        {
          indicadorErroresContrato = 1;
          modalSinPropietarios();
        }
        
        if (data.tipo_contrato == null || data.tipo_contrato == '')
        {
          setErrorTipoContrato(true);
          indicadorErroresContrato = 1;
        }
        if (fechaInicioDelAlquilerTexto.current == '')
        {
          setErrorFechaInicioAlquiler(<MensajeError mensaje={t('texto_232')} />);
          indicadorErroresContrato = 1;
        }
        if (data.plazo_alquiler == null || data.plazo_alquiler == '')
        {
          setErrorPlazoAlquiler(true);
          indicadorErroresContrato = 1;
        }
        if (data.tipo_plazo_alquiler == null || data.tipo_plazo_alquiler == '')
        {
          setErrorTipoPlazoAlquiler(true);
          indicadorErroresContrato = 1;
        }
        if (data.tipo_pago_alquiler == null || data.tipo_pago_alquiler == '')
        {
          setErrorTipoPagoAlquiler(true);
          indicadorErroresContrato = 1;
        }
        if (data.regimen_ajuste_alquiler == null || data.regimen_ajuste_alquiler == '')
        {
          setErrorRegimenAjusteAlquiler(true);
          indicadorErroresContrato = 1;
        }
        if (data.departamento_firma == null || data.departamento_firma == '')
        {
          setErrorDepartamentoFirma(true);
          indicadorErroresContrato = 1;
        }
        if (data.ciudad_firma == null || data.ciudad_firma == '')
        {
          setErrorCiudadFirma(true);
          indicadorErroresContrato = 1;
        }
        if (data.banco == null || data.banco == '')
        {
          setErrorBanco(true);
          indicadorErroresContrato = 1;
        }
        if (data.nombres_titular_cuenta == null || data.nombres_titular_cuenta == '')
        {
          setErrorNombresTitularCuenta(true);
          indicadorErroresContrato = 1;
        }
        if (data.apellidos_titular_cuenta == null || data.apellidos_titular_cuenta == '')
        {
          setErrorApellidosTitularCuenta(true);
          indicadorErroresContrato = 1;
        }
        if (data.moneda == null || data.moneda == '')
        {
          setErrorMoneda(true);
          indicadorErroresContrato = 1;
        }
        if (data.numero_cuenta == null || data.numero_cuenta == '')
        {
          setErrorNumeroCuenta(true);
          indicadorErroresContrato = 1;
        }
        if (data.tipo_cuenta == null || data.tipo_cuenta == '')
        {
          setErrorTipoCuenta(true);
          indicadorErroresContrato = 1;
        }
        if (indicadorErroresContrato == 0)
        {  
          guardarDatos = { ...state, ...data, estatus_garantia : 'Paso 7.1, Esperando datos del contrato', fecha_inicio_alquiler : fechaInicioDelAlquilerTexto.current, personas : null };
        }
      }
      else
      {
        if (salir == 'Sí')
        { 
          guardarDatos = { ...state, estatus_garantia : 'Paso 8, Esperando carga del inventario', contrato : 'contrato', texto_contrato : textoContrato, personas : null };
        }
        else
        {
          guardarDatos = { ...state, ...data, fecha_inicio_alquiler : fechaInicioDelAlquilerTexto.current, texto_contrato : textoContrato, personas : null };
        }
      }
      if (indicadorErroresContrato == 0)
      {
        setGifEspere(<GifEspere />);
        const formulario = new FormData();
        formulario.append("datos", JSON.stringify(guardarDatos));
        try {
          const respuesta = await axios.post(state.endpoint+'/garantias/update/'+state.garantia_id, formulario, { headers: { 'Authorization': `Bearer ${state.token_laravel}`, "Content-Type": "multipart/form-data" } });
          setGifEspere('');
          if (respuesta.data.codigoRetorno == 0)
          {
            console.log('ContratoGarantia, respuesta.data', respuesta.data);
            if (editarContrato == 'Sí')
            {
              prepararTextoContrato(data);
            }
            else if (salir == 'Sí')
            {
              irAlIndice();
            }
            else
            {
              return;
            }
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

    const irAlIndice = () => {
      setState(datosInicio);   
      navigate('/garantias');
    }
    
    const BotonesGuardarNavegacion = () => {
      return (
            <>
              <br />
              <Grid container>
                <Grid key={'1'} size={{ xs : 12, sm : 12, md : 12, lg : 12, xl : 12 }} sx={{textAlign : 'center'}}>
                  <Button variant="outlined" sx={{ fontSize : 16, borderRadius : 1 }} type='submit'>
                    {t('texto_200')}
                  </Button>
                </Grid>
              </Grid>
            </>
      );
    }

    const BotonesNavegacion = () => {
      return (
            <>
              <div className='botones_navegacion_fijos'>
                {
                  mostrarFormulario &&
                    <>
                      <div className='ra_nav_anterior'>
                        <Fab variant="extended" color="secondary" sx={{ fontSize : 12, borderRadius : 1}} onClick={ event => {regresar(event) }} >
                          <KeyboardArrowLeftIcon />
                          {t('texto_201')}
                        </Fab>
                      </div>
                      <div className='ra_nav_siguiente'>
                        <Fab variant="extended" color="primary" sx={{ fontSize : 12, borderRadius : 1 }} onClick={ handleSubmit((data) => guardarDatosContrato(data, 'Sí', 'Sí', 'No'))}  >
                          {t('Previsualizar contrato')}
                        </Fab>
                      </div>
                    </>
                }
              </div>
            </>
      );
    }
  
    return (
      <>
        {inicioPantalla}
        <Box component={Paper} elevation={12} sx={{ marginTop : '14rem', p : 2, borderRadius : 3 }}>
          <Stack sx={{width : '100%'}}>
          <PasoAPasoContrato rutaPaso={''} />
          </Stack>
          <br />
          <div className='ra_escritorio'>
            <Grid container>
              <Grid key={'1'} size={{ xs : 6, sm : 6, md : 9, lg : 9, xl : 9 }}>
                <Typography variant="h4">{t('texto_120')}</Typography>
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
              <Typography variant="h4" sx={{marginTop : '1rem', marginBottom : '1rem'}}>{t('texto_120')}</Typography>
              <img src={imagenAseguradora} alt="Logo" width="30%"></img>
              <Typography variant='h5' sx={{marginTop : '0.5rem'}}>{state.aseguradora+' '+t("Aseguradora")+' '+t('texto_110')}</Typography>
            </Stack>
          </div>
          <br />
          <Stack>
            <Box>
              {mensajesUsuarioEncabezado}  
            </Box>
              <>
                <Box sx={{ lineHeight: '3rem', p : 2, marginTop : 2, marginBottom : 2, backgroundColor : '#F0F0F0', borderRadius : 2 }}>
                  {t('texto_202', {cantidadPropietarios : state.cantidad_propietarios})}
                </Box>
              </>
          </Stack>
          { 
            mostrarFormulario &&
              <Form onSubmit={handleSubmit(saveData)}>
                <fieldset>
                  {
                    mostrarDatosFormulario == false &&
                      <>
                        <Grid container sx={{marginTop : '3rem'}} spacing={{ xs : 3, sm : 3, md : 3, lg : 3, xl : 3 }}>
                          <Grid key={'1'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                            <InputSelectRHF nombre={'tipo_contrato'} control={control} etiqueta={t('texto_227')} opcionesInputs={vectorOpcionesInputs['tipo_contrato']} textoAdicional={''} funcionAdicional={funcionAdicionalTipoContrato} textoError={t('texto_228')} errorInput={errorTipoContrato} />            
                          </Grid>
                        </Grid>
                        <Grid container sx={{marginTop : '3rem'}} spacing={{ xs : 3, sm : 3, md : 3, lg : 3, xl : 3 }} >
                          <Grid key={'1'} size={{ xs : 12, sm : 12, md : 3, lg : 3, xl : 3 }}>
                            <label htmlFor="fecha_inicio_alquiler">{t('texto_231')}</label>
                            <br />
                            <DatePicker id='fecha_inicio_alquiler' value={fechaInicioDelAlquiler} onChange={actualizarFechaInicioAlquiler} />
                            {errorFechaInicioAlquiler}
                          </Grid>
                          <Grid key={'2'} size={{ xs : 12, sm : 12, md : 3, lg : 3, xl : 3 }}>
                            <InputSelectRHF nombre={'plazo_alquiler'} control={control} etiqueta={t('texto_233')} opcionesInputs={vectorOpcionesInputs['plazo_alquiler']} textoAdicional={''} funcionAdicional={funcionAdicionalPlazoAlquiler} textoError={t('texto_234')} errorInput={errorPlazoAlquiler} />            
                          </Grid>
                          <Grid key={'3'} size={{ xs : 12, sm : 12, md : 3, lg : 3, xl : 3 }}>
                            <InputSelectRHF nombre={'tipo_plazo_alquiler'} control={control} etiqueta={t('*')} opcionesInputs={vectorOpcionesInputs['tipo_plazo_alquiler']} textoAdicional={''} funcionAdicional={funcionAdicionalTipoPlazoAlquiler} textoError={t('texto_234')} errorInput={errorTipoPlazoAlquiler} />            
                          </Grid>
                        </Grid>
                        <br />
                        <Grid container sx={{marginTop : '3rem'}} rowSpacing={5} columnSpacing={{ xs : 3, sm : 3, md : 3, lg : 3, xl : 3 }} >
                          <Grid key={'1'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                            <InputRadioRHF nombre={'tipo_pago_alquiler'} control={control} etiqueta={t('texto_235')} opcionesInputs={vectorOpcionesInputs['tipo_pago_alquiler']} textoAdicional={''} funcionAdicional={funcionAdicionalTipoPagoAlquiler} textoError={t('texto_236')} errorInput={errorTipoPagoAlquiler} />            
                          </Grid>
                          <Grid key={'2'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                            <InputRadioRHF nombre={'regimen_ajuste_alquiler'} control={control} etiqueta={t('texto_237')} opcionesInputs={vectorOpcionesInputs['regimen_ajuste_alquiler']} textoAdicional={''} funcionAdicional={funcionAdicionalRegimenAjusteAlquiler} textoError={t('texto_238')} errorInput={errorRegimenAjusteAlquiler} />            
                          </Grid>
                          <Grid key={'3'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                            <InputSelectRHF nombre={'departamento_firma'} control={control} etiqueta={t('texto_239')} opcionesInputs={vectorOpcionesInputs['departamento_firma']} textoAdicional={''} funcionAdicional={funcionAdicionalDepartamentoFirma} textoError={t('texto_240')} errorInput={errorDepartamentoFirma} />            
                          </Grid>
                          <Grid key={'4'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                            <InputFormControlRHF nombre={'ciudad_firma'} control={control} etiqueta={t('texto_241')} textoAdicional={''} funcionAdicional={funcionAdicionalCiudadFirma} textoError={t('texto_242')} errorInput={errorCiudadFirma} />         
                          </Grid>
                          <Grid key={'5'} size={{ xs : 12, sm : 12, md : 12, lg : 12, xl : 12 }}>
                            <InputFormControlMultilineaRHF nombre={'terminos_condiciones'} control={control} etiqueta={t("Términos y condiciones adicionales para mencionar en el contrato")} textoAdicional={''} funcionAdicional={funcionAdicionalTerminosCondiciones} textoError={t("Los términos y condiciones son requeridos")} errorInput={errorTerminosCondiciones} />
                          </Grid>
                        </Grid>
                      </>
                  }
                  <br /><br /><br />
                  {
                    mostrarDatosFormulario == true ?
                      <Typography variant="h4">{state.agregando_persona ? t('texto_194') : t('texto_283') }</Typography> :
                      <Typography variant="h4">{t('texto_195')}</Typography>
                  }
                  <br />
                  <Button 
                    size="large" 
                    variant="contained" 
                    onClick={ handleSubmit((data) => procesoPropietario(data))} 
                    startIcon={mostrarDatosFormulario ? <KeyboardArrowLeftIcon /> : <AddIcon />} 
                  >
                    {mostrarDatosFormulario ? t("Volver") : t('texto_194')} 
                  </Button>
                  <br /><br />
                  {
                    mostrarDatosFormulario == false &&
                      <>
                        <Propietarios />
                      </>
                  }
                  {
                    mostrarDatosFormulario &&
                      <> 
                        <Box sx={{ border : 'solid 1px', p : 2, borderRadius : 3 }}>
                          <Grid container sx={{marginTop : '3rem'}} rowSpacing={5} columnSpacing={{ xs : 3, sm : 3, md : 3, lg : 3, xl : 3 }} >
                            <Grid key={'10'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                              <InputSelectRHF nombre={'tipo_persona'} control={control} etiqueta={t('texto_122')} opcionesInputs={vectorOpcionesInputs['tipos_propietarios']} textoAdicional={''} funcionAdicional={funcionAdicionalTipoPersona} textoError={t('texto_123')} errorInput={errorTipoPersona} />            
                            </Grid>
                          </Grid>
                          {
                            MostrarDatosPersonaJuridica &&
                              <Box sx={{ border : 'solid 1px', mt : 2, p : 2, borderRadius : 3 }}>
                                <Typography variant={'h4'}>{t('texto_325')}</Typography>
                                <Grid container sx={{marginTop : '3rem'}} rowSpacing={5} columnSpacing={{ xs : 3, sm : 3, md : 3, lg : 3, xl : 3 }} >
                                  {
                                    mostrarNroIdentEmp &&
                                    <Grid key={'10'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                                      <InputFormControlRHF nombre={'numero_identidad_empresa'} control={control} etiqueta={t('texto_53')} textoAdicional={''} funcionAdicional={funcionAdicionalNroIdentEmp} textoError={t("El RUT de la empresa es requerido")} errorInput={errorNroIdentEmp} />
                                    </Grid>
                                  }
                                  {
                                    mostrarEmpresa &&
                                    <Grid key={'20'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                                      <InputFormControlRHF nombre={'empresa'} control={control} etiqueta={t('texto_54')} textoAdicional={''} funcionAdicional={funcionAdicionalEmpresa} textoError={t("El nombre de la empresa es requerido")} errorInput={errorEmpresa} />
                                    </Grid>
                                  }
                                  <Grid key={'30'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                                    <InputFormControlRHF nombre={'domicilio_persona'} control={control} etiqueta={t('texto_276')} textoAdicional={''} funcionAdicional={funcionAdicionalDomicilioPersona} textoError={t('texto_277')} errorInput={errorDomicilioPersona} />
                                  </Grid>
                                  <Grid key={'31'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                                    <InputSelectRHF nombre={'departamento_domicilio'} control={control} etiqueta={t('texto_326')} opcionesInputs={vectorOpcionesInputs['departamento_firma']} textoAdicional={''} funcionAdicional={funcionAdicionalDepartamentoDomicilio} textoError={t('texto_327')} errorInput={errorDepartamentoDomicilio} />            
                                  </Grid>
                                  <Grid key={'32'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                                    <InputFormControlRHF nombre={'ciudad_domicilio'} control={control} etiqueta={t('texto_328')} textoAdicional={''} funcionAdicional={funcionAdicionalCiudadDomicilio} textoError={t('texto_329')} errorInput={errorCiudadDomicilio} />
                                  </Grid>
                                  <Grid key={'40'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                                    <InputFormControlRHF nombre={'email_arrendatario'} control={control} etiqueta={t('texto_209')} textoAdicional={''} funcionAdicional={funcionAdicionalEmail} textoError={t('texto_46')} errorInput={errorEmail} />
                                  </Grid>
                                  <Grid key={'50'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                                    <InputFormControlRHF nombre={'telefono_arrendatario'} control={control} etiqueta={t('texto_210')} textoAdicional={''} funcionAdicional={funcionAdicionalTelefono} textoError={t("El número de teléfono es requerido")} errorInput={errorTelefono} />
                                  </Grid>
                                  <Grid key={'60'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                                    <InputRadioRHF nombre={'clasificacion_persona_juridica'} control={control} etiqueta={t('texto_274')} opcionesInputs={vectorOpcionesInputs['clasificacion_persona_juridica']} textoAdicional={''} funcionAdicional={funcionAdicionalClasificacionPersonaJuridica} textoError={t('texto_275')} errorInput={errorClasificacionPersonaJuridica} />            
                                  </Grid>
                                </Grid>
                              </Box>  
                          } 
                          <Box sx={{ border : 'solid 1px', mt : 2, p : 2, borderRadius : 3 }}>
                            <Typography variant={'h4'}>{t('texto_324')}</Typography>
                            <Grid container sx={{marginTop : '3rem'}} rowSpacing={5} columnSpacing={{ xs : 3, sm : 3, md : 3, lg : 3, xl : 3 }} >                                                
                              <Grid key={'10'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                                <InputSelectRHF nombre={'tipo_documento_identidad'} control={control} etiqueta={t('texto_270')} opcionesInputs={vectorOpcionesInputs['tipo_documento_identidad']} textoAdicional={''} funcionAdicional={funcionAdicionalTipoDocumentoIdentidad} textoError={t('texto_271')} errorInput={errorTipoDocumentoIdentidad} />            
                              </Grid>
                              <Grid key={'20'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                                <InputFormControlRHF nombre={'numero_identidad_arrendatario'} control={control} etiqueta={t("Número de cédula *")} textoAdicional={''} funcionAdicional={funcionAdicionalNroIdentArrend} textoError={t("El número de cédula es requerido")} errorInput={errorNroIdentArrend} />
                              </Grid>
                              <Grid key={'30'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                                <InputFormControlRHF nombre={'nombres_arrendatario'} control={control} etiqueta={t('texto_207')} textoAdicional={''} funcionAdicional={funcionAdicionalNombres} textoError={t("Los nombres son requeridos")} errorInput={errorNombres} />
                              </Grid>
                              <Grid key={'40'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                                <InputFormControlRHF nombre={'apellidos_arrendatario'} control={control} etiqueta={t('texto_208') } textoAdicional={''} funcionAdicional={funcionAdicionalApellidos} textoError={t("Los apellidos son requeridos")} errorInput={errorApellidos} />
                              </Grid>
                              {
                                MostrarDatosAdicionalesPersonaFisica &&
                                  <>
                                    <Grid key={'50'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                                      <InputFormControlRHF nombre={'domicilio_persona'} control={control} etiqueta={t('texto_276')} textoAdicional={''} funcionAdicional={funcionAdicionalDomicilioPersona} textoError={t('texto_277')} errorInput={errorDomicilioPersona} />
                                    </Grid>
                                    <Grid key={'51'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                                      <InputSelectRHF nombre={'departamento_domicilio'} control={control} etiqueta={t('texto_326')} opcionesInputs={vectorOpcionesInputs['departamento_firma']} textoAdicional={''} funcionAdicional={funcionAdicionalDepartamentoDomicilio} textoError={t('texto_327')} errorInput={errorDepartamentoDomicilio} />            
                                    </Grid>
                                    <Grid key={'52'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                                      <InputFormControlRHF nombre={'ciudad_domicilio'} control={control} etiqueta={t('texto_328')} textoAdicional={''} funcionAdicional={funcionAdicionalCiudadDomicilio} textoError={t('texto_329')} errorInput={errorCiudadDomicilio} />
                                    </Grid>
                                    <Grid key={'60'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                                      <InputFormControlRHF nombre={'email_arrendatario'} control={control} etiqueta={t('texto_209')} textoAdicional={''} funcionAdicional={funcionAdicionalEmail} textoError={t('texto_46')} errorInput={errorEmail} />
                                    </Grid>
                                    <Grid key={'70'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                                      <InputFormControlRHF nombre={'telefono_arrendatario'} control={control} etiqueta={t('texto_210')} textoAdicional={''} funcionAdicional={funcionAdicionalTelefono} textoError={t("El número de teléfono es requerido")} errorInput={errorTelefono} />
                                    </Grid>
                                    <Grid key={'80'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                                      <InputRadioRHF nombre={'clasificacion_persona_fisica'} control={control} etiqueta={t('texto_272')} opcionesInputs={vectorOpcionesInputs['clasificacion_persona_fisica']} textoAdicional={''} funcionAdicional={funcionAdicionalClasificacionPersonaFisica} textoError={t('texto_273')} errorInput={errorClasificacionPersonaFisica} />            
                                    </Grid>
                                  </>
                              }
                            </Grid>
                          </Box>
                          <br />
                          <Grid container spacing={{ xs : 2, sm : 2, md : 3, lg : 3, xl : 3 }}>
                            {
                              mostrarRut &&
                              <Grid key={'10'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                                <CargarArchivosServidor control={control} multiplesArchivos={false} tipoArchivos='image/png, image/jpg, image/jpeg, .pdf' ubicacionesRequeridas={ubicacionesRutRef} subDirectorio={state.id} tabla='personas' nombreCampo='rut' campoUbicaciones='ubicaciones_rut' campoContador='contador_rut' id={state.id} contadorArchivos={contadorRut} actualizarMensajeError={actualizarMensajeErrorRut} etiqueta={t("Tarjeta RUT *")} etiqueta2={t('texto_128')} />
                                {errorRut}
                              </Grid>
                            }
                            <Grid key={'20'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                              <CargarArchivosServidor control={control} multiplesArchivos={false} tipoArchivos='image/png, image/jpg, image/jpeg, .pdf' ubicacionesRequeridas={ubicacionIdentidadRef} subDirectorio={state.id} tabla='personas' nombreCampo='identidad' campoUbicaciones='ubicacion_identidad' campoContador='contador_identidad' id={state.id} contadorArchivos={contadorIdentidad} actualizarMensajeError={actualizarMensajeErrorIdentidad} etiqueta={t('texto_62')} etiqueta2={t('texto_127')} />
                              {errorIdentidad}
                            </Grid>
                            {
                              mostrarCertIngMod &&
                                <Grid key={'30'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                                  <CargarArchivosServidor control={control} multiplesArchivos={true} tipoArchivos='image/png, image/jpg, image/jpeg, .pdf' ubicacionesRequeridas={ubicacionesCertIngModRef} subDirectorio={state.id} tabla='personas' nombreCampo='cert_ing_mod' campoUbicaciones='ubicaciones_cert_ing_mod' campoContador='contador_cert_ing_mod' id={state.id} contadorArchivos={contadorCertIngMod} actualizarMensajeError={actualizarMensajeErrorCertIngMod} etiqueta={etiquetaCertIngMod} etiqueta2={etiquetaCertIngMod2} />
                                  {errorCertIngMod}
                                </Grid>
                            }
                          </Grid>
                          <BotonesGuardarNavegacion />
                        </Box>
                        <br />
                      </>
                  }
                  <br /><br />
                  {
                    mostrarDatosFormulario == false &&
                      <>
                        <Typography variant={'h4'}>{t('texto_282')}</Typography>
                        <Box id='caja_bancos' sx={{ p : 2, marginTop : 2, border : 'solid 1px #6D6D6D', borderRadius : 1 }}>
                          <Grid container sx={{marginTop : '3rem'}} rowSpacing={5} columnSpacing={{ xs : 3, sm : 3, md : 3, lg : 3, xl : 3 }} >
                            <Grid key={'1'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                              <InputSelectRHF nombre={'banco'} control={control} etiqueta={t('texto_245')} opcionesInputs={vectorOpcionesInputs['banco']} textoAdicional={''} funcionAdicional={funcionAdicionalBanco} textoError={t('texto_246')} errorInput={errorBanco} />            
                            </Grid>
                            <Grid key={'2'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                              <InputFormControlRHF nombre={'numero_sucursal_banco'} control={control} etiqueta={t('texto_268')} textoAdicional={''} funcionAdicional={funcionAdicionalNumeroSucursalBanco} textoError={t('texto_269')} errorInput={errorNumeroSucursalBanco} />
                            </Grid>
                            <Grid key={'3'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                              <InputFormControlRHF nombre={'nombres_titular_cuenta'} control={control} etiqueta={t('texto_247')} textoAdicional={''} funcionAdicional={funcionAdicionalNombresTitularCuenta} textoError={t('texto_248')} errorInput={errorNombresTitularCuenta} />
                            </Grid>
                            <Grid key={'4'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                              <InputFormControlRHF nombre={'apellidos_titular_cuenta'} control={control} etiqueta={t('texto_249')} textoAdicional={''} funcionAdicional={funcionAdicionalApellidosTitularCuenta} textoError={t('texto_250')} errorInput={errorApellidosTitularCuenta} />
                            </Grid>
                            <Grid key={'5'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                              <InputSelectRHF nombre={'moneda'} control={control} etiqueta={t('texto_251')} opcionesInputs={vectorOpcionesInputs[ 'moneda']} textoAdicional={''} funcionAdicional={funcionAdicionalMoneda} textoError={t('texto_252')} errorInput={errorMoneda} />           
                            </Grid>
                            <Grid key={'6'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                              <InputFormControlRHF nombre={'numero_cuenta'} control={control} etiqueta={t('texto_253')} textoAdicional={''} funcionAdicional={funcionAdicionalNumeroCuenta} textoError={t('texto_254')} errorInput={errorNumeroCuenta} />
                            </Grid>
                            <Grid key={'7'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                              <InputSelectRHF nombre={'tipo_cuenta'} control={control} etiqueta={t('texto_255')} opcionesInputs={vectorOpcionesInputs[ 'tipo_cuenta']} textoAdicional={''} funcionAdicional={funcionAdicionalTipoCuenta} textoError={t('texto_256')} errorInput={errorTipoCuenta} />           
                            </Grid>
                          </Grid>
                        </Box>
                        <br /><br />
                      </>
                  }
                </fieldset>
              </Form>
          }
          {
            mostrarContrato &&
            <>
              <header className="ra-App-header">
                <h3>{t('texto_292')}</h3>
                <h5>{t('texto_293')}</h5>
              </header>
              <Editor
                editorState={editorState}
                onEditorStateChange={setEditorState}
                wrapperClassName="ra-wrapper-class"
                editorClassName="ra-editor-class"
                toolbarClassName="ra-toolbar-class"
                toolbar={{
                  options: [
                    'inline',
                    'blockType',
                    'fontSize',
                    'fontFamily',
                    'list',
                    'textAlign',
                    'history'
                  ],
                  inline: {
                    options: ['bold', 'italic', 'underline', 'strikethrough', 'monospace', 'superscript', 'subscript'],
                  },
                  list: {
                    options: ['unordered', 'ordered', 'indent', 'outdent'],
                  },
                  textAlign: {
                    options: ['left', 'center', 'right', 'justify'],
                  },
                  history: {
                    options: ['undo', 'redo'],
                  },
                }}
                hashtag={{
                  separator: ' ',
                  trigger: '#',
                }}
                mention={{
                  separator: ' ',
                  trigger: '@',
                  suggestions: [
                    { text: 'JavaScript', value: 'javascript', url: 'js' },
                    { text: 'Golang', value: 'golang', url: 'go' },
                  ],
                }}
              />
              <br />
              <Grid container>
                <Grid key={'1'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }} sx={{textAlign : 'center'}}>
                  <Fab variant="extended" color="secondary" sx={{ fontSize : 12, borderRadius : 1}} onClick={ event => {regresarEdicionDatosContrato(event) }} >
                    <KeyboardArrowLeftIcon />
                    {t('texto_201')}
                  </Fab>
                </Grid>
                <Grid key={'2'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }} sx={{textAlign : 'center'}}>
                  <Fab variant="extended" color="primary" sx={{ fontSize : 12, borderRadius : 1 }} onClick={ () => { guardarDatosContrato('sinData', 'No', 'No', 'Sí')}} >
                    {t('Guardar')}
                  </Fab>
                </Grid>
              </Grid>
            </>
          }
          <div ref={contentRef} className='ra_ocultar'>
            <div
              ref={contentRef}
              dangerouslySetInnerHTML={createMarkup(vistaContrato)}>
            </div>
          </div>
          {
            mostrarDatosFormulario == false &&
              <>
                <BotonesNavegacion />
              </>
          }
          <br /><br />
                    
          <ModalBasico open={modalBasico} handleClose={accionModalBasico.current} tituloModal={tituloModalBasico} contenidoModal={contenidoModalBasico} />
          
          <ModalDialogoBasico open={modalDialogoBasico} handleClose={accionModalDialogoBasico.current} tituloModal={tituloModalDialogoBasico} contenidoModal={contenidoModalDialogoBasico} textoAccion1={textoAccion1DialogoBasico} accion1={accion1DialogoBasico.current} parametrosAccion1={parametrosAccion1DialogoBasico} textoAccion2={textoAccion2DialogoBasico} accion2={accion2DialogoBasico.current} parametrosAccion2={parametrosAccion2DialogoBasico} />

          {gifEspere}
          <div className='ra_alerta_fija'>
            {alertaFija}
          </div>
        </Box>
      </>
    );
  }

  return state.id > 0 ? <FormularioPropietario mostrarDatosFormulario={mostrarDatosFormulario} cambiarMostrarDatosFormulario={cambiarMostrarDatosFormulario} /> : <GifEspere /> 
};