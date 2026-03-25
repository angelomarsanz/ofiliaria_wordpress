import { useState, useRef, useEffect } from 'react';
import { useForm } from "react-hook-form";
import { useNavigate, Link } from "react-router-dom";
import { GifEspere, prepararCamposPersonas } from "../varios";
import { Form, Field, Input } from "../forms";
import Stepper from "../pasos/Stepper.jsx";
import { useAppState } from "../state.jsx";
import { Controller } from "react-hook-form";
import {
    datosInicio, 
    inputsAseguradoras, 
    opcionesAseguradoras, 
    datosInicioPersona, 
    textosMensajes, 
    aseguradorasTiposPersonas,
    opcionesInputs 
  } from "../vectores_objetos";
import { CargarArchivosServidor, RecSueldo, CertIngMod, Dgi, CertDgiCaja, Balance, Rut, ContratoSocial, CertUni } from '../campos_opcionales';
import axios from 'axios';
import { useLocation } from "react-router-dom";
import { useTranslation } from 'react-i18next';
import { NumericFormat } from 'react-number-format';
import { 
  ModalBasico, 
  ModalDialogoBasico, 
  AcordionFaltante,
  AlertaSatisfactorio,
  AlertaAviso,
  AlertaError 
  } from '../mui';

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
    PasoAPaso 
  } from '../mui';
import { 
    InputFormControlRHF,
    InputNumericFormatRHF,
    InputSelectRHF,
    InputRadioRHF,
    MensajeError
  } from '../mui';
import AddIcon from '@mui/icons-material/Add';
import RemoveIcon from '@mui/icons-material/Remove';
import KeyboardArrowDownIcon from '@mui/icons-material/KeyboardArrowDown';
import KeyboardArrowLeftIcon from '@mui/icons-material/KeyboardArrowLeft';
import KeyboardArrowRightIcon from '@mui/icons-material/KeyboardArrowRight';
  
export const Arrendatario = () => {
  const [state, setState] = useAppState();
  const { t } = useTranslation();
  const location = useLocation();
  const paginaActual = useRef('');
  paginaActual.current = location.pathname.split('/')[1];
  const [inicioPantalla, setInicioPantalla] = useState('');
  const [imagenAseguradora, setImagenAseguradora] = useState('');
  const [gifEspere, setGifEspere] = useState('');
  const [alertaFija, setAlertaFija] = useState('');
  const [existenCosolicitantes, setExistenCosolicitantes] = useState(false);
  const [mostrarDatosFormulario, setMostrarDatosFormulario] = useState(true);
  const vectorOpcionesAseguradoras = opcionesAseguradoras();
  const vectorAseguradorasTiposPersonas = aseguradorasTiposPersonas();
  const [errorTipoPersona, setErrorTipoPersona] = useState(false); 
  const [errorEmail, setErrorEmail] = useState(false);
  const [errorTelefono, setErrorTelefono] = useState(false);

  const [modalBasico, setModalBasico] = useState(false);
  const accionModalBasico = useRef();
  const [tituloModalBasico, setTituloModalBasico] = useState(false);
  const [contenidoModalBasico, setContenidoModalBasico] = useState(false);
  const [tipoAlertaModalBasico, setTipoAlertaModalBasico] = useState(null);

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

  // Campos opcionales
  const [mostrarTipoDocumentoIdentidad, setMostrarTipoDocumentoIdentidad] = useState(false);
  const [errorTipoDocumentoIdentidad, setErrorTipoDocumentoIdentidad] = useState(false);

  const [mostrarNroIdentArrend, setMostrarNroIdentArrend] = useState(false);
  const [errorNroIdentArrend, setErrorNroIdentArrend] = useState(false);

  const [mostrarNombres, setMostrarNombres] = useState(false);
  const [errorNombres, setErrorNombres] = useState(false);

  const [mostrarApellidos, setMostrarApellidos] = useState(false);
  const [errorApellidos, setErrorApellidos] = useState(false);

  const [mostrarMonedaIngreso, setMostrarMonedaIngreso] = useState(false);
  const [errorMoneda, setErrorMoneda] = useState(false);

  const [mostrarMontoIngreso, setMostrarMontoIngreso] = useState(false);
  const [errorMontoIngreso, setErrorMontoIngreso] = useState(false);

  const [mostrarNroIdentEmp, setMostrarNroIdentEmp] = useState(false);
  const [errorNroIdentEmp, setErrorNroIdentEmp] = useState(false);

  const [mostrarEmpresa, setMostrarEmpresa] = useState(false);
  const [errorEmpresa, setErrorEmpresa] = useState(false);

  const [mostrarCargoEmpresa, setMostrarCargoEmpresa] = useState(false);
  const [errorCargoEmpresa, setErrorCargoEmpresa] = useState(false);

  const [mostrarIngreso, setMostrarIngreso] = useState(false);
  const tipoIngreso = useRef('');
  const [sueldoSeleccionado, setSueldoSeleccionado] = useState(t("Recibos de sueldo o de cobro de jubilación o pensión *"));
  const [errorIngreso, setErrorIngreso] = useState(false);

  const [mostrarSueldo, setMostrarSueldo] = useState(false);
  const [errorSueldo, setErrorSueldo] = useState(false);

  const [mostrarIdentidad, setMostrarIdentidad] = useState(false);
  const ubicacionIdentidadRef = useRef(state.ubicacion_identidad);
  const contadorIdentidad = useRef('');
  const [errorIdentidad, setErrorIdentidad] = useState('');
  
  const [mostrarRecSueldo, setMostrarRecSueldo] = useState(false);
  const ubicacionesRecSueldoRef = useRef(state.ubicaciones_rec_sueldo);
  const contadorRecSueldo = useRef(0);
  const [errorRecSueldo, setErrorRecSueldo] = useState('');
  
  const [mostrarCertIngMod, setMostrarCertIngMod] = useState(false);
  const ubicacionesCertIngModRef = useRef(state.ubicaciones_cert_ing_mod);
  const contadorCertIngMod = useRef(0);
  const [etiquetaCertIngMod, setEtiquetaCertIngMod] = useState('');
  const [etiquetaCertIngMod2, setEtiquetaCertIngMod2] = useState('');
  const [errorCertIngMod, setErrorCertIngMod] = useState('');

  const [mostrarDgi, setMostrarDgi] = useState(false);
  const ubicacionesDgiRef = useRef(state.ubicaciones_dgi);
  const contadorDgi = useRef(0);
  const [errorDgi, setErrorDgi] = useState('');

  const [mostrarCertDgiCaja, setMostrarCertDgiCaja] = useState(false);
  const ubicacionesCertDgiCajaRef = useRef(state.ubicaciones_cert_dgi_caja);
  const contadorCertDgiCaja = useRef(0);
  const [errorCertDgiCaja, setErrorCertDgiCaja] = useState('');

  const [mostrarBalance, setMostrarBalance] = useState(false);
  const ubicacionesBalanceRef = useRef(state.ubicaciones_balance);
  const contadorBalance = useRef(0);
  const [etiquetaBalance, setEtiquetaBalance] = useState('');
  const [etiquetaBalance2, setEtiquetaBalance2] = useState('');
  const [errorBalance, setErrorBalance] = useState('');

  const [mostrarRut, setMostrarRut] = useState(false);
  const ubicacionesRutRef = useRef(state.ubicaciones_rut);
  const contadorRut = useRef(0);
  const [errorRut, setErrorRut] = useState('');

  const [mostrarContratoSocial, setMostrarContratoSocial] = useState(false);
  const ubicacionesContratoSocialRef = useRef(state.ubicaciones_contrato_social);
  const contadorContratoSocial = useRef(0);
  const [etiquetaContratoSocial, setEtiquetaContratoSocial] = useState('');
  const [etiquetaContratoSocial2, setEtiquetaContratoSocial2] = useState('');
  const [errorContratoSocial, setErrorContratoSocial] = useState('');

  const [mostrarCertUni, setMostrarCertUni] = useState(false);
  const ubicacionesCertUniRef = useRef(state.ubicaciones_cert_uni);
  const contadorCertUni = useRef(0);
  const [etiquetaCertUni, setEtiquetaCertUni] = useState('');
  const [etiquetaCertUni2, setEtiquetaCertUni2] = useState('');
  const [errorCertUni, setErrorCertUni] = useState('');
  const pasoFormulario = useRef('Arrendatario');
  const [mensajesEncabezado, setMensajesEncabezado] = useState(true);
  const [mensajesUsuarioEncabezado, setMensajesUsuarioEncabezado] = useState('');
  const [subTituloFormulario, setSubTituloFormulario] = useState('');
  
  useEffect(() => {( async () => {
    logoAseguradora(state.aseguradora);
    ajustesIniciales();
    tipoIngreso.current = state.ingreso;
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

  const ajustesIniciales = () => {
    if (state.ingreso == 'Empleado (trabajador dependiente)')
    {       
        setSueldoSeleccionado(vectorOpcionesAseguradoras[state.aseguradora+' Tipo sueldo '+state.ingreso+' '+state.sueldo]);
    }
    else if (state.ingreso == 'Jubilado o pensionista')
    {
      setSueldoSeleccionado(vectorOpcionesAseguradoras[state.aseguradora+' Tipo ingreso '+state.ingreso]);
    }

    let idPersona = 0;
    if (paginaActual.current == 'datos-arrendatario')
    {
      let ultimaPersona = state.personas.length -1;
      if (state.estatus_garantia.substring(0, 6) == 'Paso 2' || state.estatus_garantia.substring(0, 6) == 'Paso 3')
      {
        idPersona = state.personas[ultimaPersona].id;
        setState({...state, paso_anterior : '/datos-propiedad/'+state.garantia_id, paso_siguiente : '/personas-adicionales/'+idPersona });
      }
    }
    else if (paginaActual.current == 'personas-adicionales')
    {
      if (state.agregando_persona == true)
      {
        setMensajesEncabezado(false);
        setSubTituloFormulario(<><Typography variant="h3">{t("Agregar codeudor")}</Typography><br /></>)
      }
      else if (state.editando_persona == true)
      {
        setMensajesEncabezado(false);
        setSubTituloFormulario(<><Typography variant="h3">{t('texto_147')}</Typography><br /></>)
      }
      else
      {
        cambiarMostrarDatosFormulario(false);
      }

      if (state.persona_eliminada == true)
      {
        modalPersonaEliminada();
      }

      pasoFormulario.current = "Codeudor";
      if (state.estatus_garantia.substring(0, 6) == 'Paso 3' || state.estatus_garantia.substring(0, 6) == 'Paso 4')
      {
        idPersona = state.personas[0].id;
        setState({...state, persona_eliminada : false, paso_anterior : '/datos-arrendatario/'+idPersona, paso_siguiente : '/garantias/0'});
      }
      for (let i = 0; i < state.personas.length; i++) 
      {
        if (state.personas[i].tipo_arrendatario == 'Cosolicitante')
        {
          if (state.personas[i].tipo_persona == 'Empresa')
          {
            if (state.personas[i].empresa != null && state.personas[i].empresa != '' && state.personas[i].empresa != ' ')
            {
              setExistenCosolicitantes(true);
              break;    
            }
          }
          else
          {
            if (state.personas[i].nombres_arrendatario != null && state.personas[i].nombres_arrendatario != '' && state.personas[i].nombres_arrendatario != ' ')
            {
              setExistenCosolicitantes(true);
              break;    
            }
          }
        }
      }
    }
    contadorIdentidad.current = state.contador_identidad;
    contadorRecSueldo.current = state.contador_rec_sueldo;
    contadorCertIngMod.current = state.contador_cert_ing_mod;
    contadorDgi.current = state.contador_dgi;
    contadorCertDgiCaja.current = state.contador_cert_dgi_caja;
    contadorBalance.current = state.contador_balance;
    contadorRut.current = state.contador_rut;
    contadorContratoSocial.current = state.contador_contrato_social;
    contadorCertUni.current = state.contador_cert_uni;
  }

  const opciones = (tipoPersona) => {    
    if (tipoPersona != '')
    {
      if (vectorOpcionesAseguradoras[state.aseguradora+' CertIngMod etiqueta '+tipoPersona])
      {
        setEtiquetaCertIngMod(vectorOpcionesAseguradoras[state.aseguradora+' CertIngMod etiqueta '+tipoPersona]);
        setEtiquetaCertIngMod2(vectorOpcionesAseguradoras[state.aseguradora+' CertIngMod etiqueta2 '+tipoPersona]);
      }

      if (vectorOpcionesAseguradoras[state.aseguradora+' Balance etiqueta '+tipoPersona])
      {
        setEtiquetaBalance(vectorOpcionesAseguradoras[state.aseguradora+' Balance etiqueta '+tipoPersona]);
        setEtiquetaBalance2(vectorOpcionesAseguradoras[state.aseguradora+' Balance etiqueta2 '+tipoPersona]);
      }

      if (vectorOpcionesAseguradoras[state.aseguradora+' ContratoSocial etiqueta '+tipoPersona])
      {
        setEtiquetaContratoSocial(vectorOpcionesAseguradoras[state.aseguradora+' ContratoSocial etiqueta '+tipoPersona]);
        setEtiquetaContratoSocial2(vectorOpcionesAseguradoras[state.aseguradora+' ContratoSocial etiqueta2 '+tipoPersona]);
      }

      if (vectorOpcionesAseguradoras[state.aseguradora+' CertUni etiqueta '+tipoPersona])
      {
        setEtiquetaCertUni(vectorOpcionesAseguradoras[state.aseguradora+' CertUni etiqueta '+tipoPersona]);
        setEtiquetaCertUni2(vectorOpcionesAseguradoras[state.aseguradora+' CertUni etiqueta2 '+tipoPersona]);
      }
      
      if (inputsAseguradoras[state.aseguradora+' '+tipoPersona+' tipoDocumentoIdentidad'] == true)
      {
        setMostrarTipoDocumentoIdentidad(true);
      }
      else
      {         
        setMostrarTipoDocumentoIdentidad(false);
        unregister('tipo_documento_identidad');
      }

      if (inputsAseguradoras[state.aseguradora+' '+tipoPersona+' numeroIdentidadArrendatario'] == true)
      {
        setMostrarNroIdentArrend(true);
      }
      else
      {         
        setMostrarNroIdentArrend(false);
        unregister('numero_identidad_arrendatario');
      }

      if (inputsAseguradoras[state.aseguradora+' '+tipoPersona+' nombres'] == true)
      {
        setMostrarNombres(true);
      }
      else
      {         
        setMostrarNombres(false);
        unregister('nombres_arrendatario');
      }

      if (inputsAseguradoras[state.aseguradora+' '+tipoPersona+' apellidos'] == true)
      {
        setMostrarApellidos(true);
      }
      else
      {         
        setMostrarApellidos(false);
        unregister('apellidos_arrendatario');
      }

      if (inputsAseguradoras[state.aseguradora+' '+tipoPersona+' monedaIngreso'] == true)
      {
        setMostrarMonedaIngreso(true);
      }
      else
      {         
        setMostrarMonedaIngreso(false);
        unregister('moneda_ingreso');
      }

      if (inputsAseguradoras[state.aseguradora+' '+tipoPersona+' montoIngreso'] == true)
      {
        setMostrarMontoIngreso(true);
      }
      else
      {         
        setMostrarMontoIngreso(false);
        unregister('monto_ingreso');
      }

      if (inputsAseguradoras[state.aseguradora+' '+tipoPersona+' numeroIdentidadEmpresa'] == true)
      {
        setMostrarNroIdentEmp(true);
      }
      else
      {         
        setMostrarNroIdentEmp(false);
        unregister('numero_identidad_empresa');
      }

      if (inputsAseguradoras[state.aseguradora+' '+tipoPersona+' empresa'] == true)
      {
        setMostrarEmpresa(true);
      }
      else
      {         
        setMostrarEmpresa(false);
        unregister('empresa');
      }

      if (inputsAseguradoras[state.aseguradora+' '+tipoPersona+' cargo_empresa'] == true)
      {
        setMostrarCargoEmpresa(true);
      }
      else
      {         
        setMostrarCargoEmpresa(false);
        unregister('cargo_empresa');
      }

      if (inputsAseguradoras[state.aseguradora+' '+tipoPersona+' ingreso'] == true)
      {
        setMostrarIngreso(true);
      }
      else
      {         
        setMostrarIngreso(false);
        unregister('ingreso');
      }

      if (inputsAseguradoras[state.aseguradora+' '+tipoPersona+' ingreso'] == true)
      {
        setMostrarIngreso(true);
      }
      else
      {         
        setMostrarIngreso(false);
        unregister('ingreso');
      }

      if (inputsAseguradoras[state.aseguradora+' '+tipoPersona+' sueldo'] == true)
      {
        if (tipoIngreso.current == 'Empleado (trabajador dependiente)')
        {
          setMostrarSueldo(true);
        }
      }
      else
      {
        setMostrarSueldo(false);
        unregister('sueldo');
      }
      if (inputsAseguradoras[state.aseguradora+' '+tipoPersona+' identidad'] == true)
      {
        setMostrarIdentidad(true);
      }
      else
      {
        setMostrarIdentidad(false);
        unregister('identidad');
      }

      if (inputsAseguradoras[state.aseguradora+' '+tipoPersona+' recSueldo'] == true)
      {
        setMostrarRecSueldo(true);
      }
      else
      {
        setMostrarRecSueldo(false);
        unregister('rec_sueldo');
      }

      if (inputsAseguradoras[state.aseguradora+' '+tipoPersona+' certIngMod'] == true)
      {
        setMostrarCertIngMod(true);
      }
      else
      {
        setMostrarCertIngMod(false);
        unregister('cert_ing_mod');
      }

      if (inputsAseguradoras[state.aseguradora+' '+tipoPersona+' dgi'] == true)
      {
        setMostrarDgi(true);
      }
      else
      {
        setMostrarDgi(false);
        unregister('dgi');
      }

      if (inputsAseguradoras[state.aseguradora+' '+tipoPersona+' certDgiCaja'] == true)
      {
        setMostrarCertDgiCaja(true);
      }
      else
      {
        setMostrarCertDgiCaja(false);
        unregister('cert_dgi_caja');
      }

      if (inputsAseguradoras[state.aseguradora+' '+tipoPersona+' balance'] == true)
      {
        setMostrarBalance(true);
      }
      else
      {
        setMostrarBalance(false);
        unregister('balance');
      }

      if (inputsAseguradoras[state.aseguradora+' '+tipoPersona+' rut'] == true)
      {
        setMostrarRut(true);
      }
      else
      {
        setMostrarRut(false);
        unregister('rut');
      }

      if (inputsAseguradoras[state.aseguradora+' '+tipoPersona+' contratoSocial'] == true)
      {
        setMostrarContratoSocial(true);
      }
      else
      {
        setMostrarContratoSocial(false);
        unregister('contrato_social');
      }

      if (inputsAseguradoras[state.aseguradora+' '+tipoPersona+' certUni'] == true)
      {
        setMostrarCertUni(true);
      }
      else
      {
        setMostrarCertUni(false);
        unregister('cert_uni');
      }
    }
    else
    {
      setMostrarIngreso(false);
      unregister('ingreso');

      setMostrarSueldo(false);
      unregister('sueldo');

      setMostrarIdentidad(false);
      unregister('identidad');

      setMostrarRecSueldo(false);
      unregister('rec_sueldo');

      setMostrarCertIngMod(false);
      unregister('cert_ing_mod');

      setMostrarDgi(false);
      unregister('dgi');

      setMostrarCertDgiCaja(false);
      unregister('cert_dgi_caja');

      setMostrarBalance(false);
      unregister('balance');

      setMostrarRut(false);
      unregister('rut');

      setMostrarContratoSocial(false);
      unregister('contrato_social');

      setMostrarCertUni(false);
      unregister('cert_uni');
    }  
  };

  const { handleSubmit, register, unregister, setValue, watch, setFocus, control, formState: { errors } } = useForm({ defaultValues: state, mode: "onChange" });

  const navigate = useNavigate();

  const abrirModalBasico = () => {
    setModalBasico(true);
  }

  const cerrarModalBasico = () => {
    setModalBasico(false);
    setTipoAlertaModalBasico(null);
  }

  const abrirModalDialogoBasico = () => {
    setModalDialogoBasico(true);
  }

  const cerrarModalDialogoBasico = () => { 
    setModalDialogoBasico(false);
  }

  const funcionAdicionalTipoPersona = (event) => {
    if (event.target.value != '')
    {
      opciones(event.target.value);
      // setErrorTipoPersona(false);
    }
  };

  const funcionAdicionalTipoDocumentoIdentidad = (event) => {
    if (event.target.value != '')
    {
      // setErrorTipoDocumentoIdentidad(false);
    }
  };

  const funcionAdicionalNroIdentArrend = (event) => {
    if (event.target.value != '')
    {
      // setErrorNroIdentArrend(false);
    }
  };

  const funcionAdicionalNombres = (event) => {
    if (event.target.value != '')
    {
      // setErrorNombres(false);
    }
  };

  const funcionAdicionalApellidos = (event) => {
    if (event.target.value != '')
    {
      // setErrorApellidos(false);
    }
  };

  const funcionAdicionalNroIdentEmp = (event) => {
    if (event.target.value != '')
    {
      // setErrorNroIdentEmp(false);
    }
  };

  const funcionAdicionalEmpresa = (event) => {
    if (event.target.value != '')
    {
      // setErrorEmpresa(false);
    }
  };

  const funcionAdicionalCargoEmpresa = (event) => {
    if (event.target.value != '')
    {
      // setErrorCargoEmpresa(false);
    }
  }

  const funcionAdicionalEmail = (event) => {
    if (event.target.value != '')
    {
      // setErrorEmail(false);
    }
  }

  const funcionAdicionalTelefono = (event) => {
    if (event.target.value != '')
    {
      // setErrorTelefono(false);
    }
  }

  const funcionAdicionalMonedaIngreso = (event) => {
    if (event.target.value != '')
    {
      // setErrorMoneda(false);
    }
  }

  const funcionAdicionalMontoIngreso = (event) => {
    if (event.target.value != '')
    {
      // setErrorMontoIngreso(false);
    }
  }

  const funcionAdicionalIngreso = (event) => {
    if (event.target.value != '')
    {
      // setErrorIngreso(false);
      tipoIngreso.current = event.target.value;
      if (event.target.value == 'Empleado (trabajador dependiente)')
      {
        mostrarCampoSueldo();
      }
      else
      {
        ocultarCampoSueldo(event.target.value);
      }
    }
  }

  const funcionAdicionalSueldo = (event) => {
    if (event.target.value != '')
    {
      // setErrorSueldo(false);
      setSueldoSeleccionado(vectorOpcionesAseguradoras[state.aseguradora+' Tipo sueldo '+tipoIngreso.current+' '+event.target.value]);
    }
  }

  const mostrarCampoSueldo = () => {
    setMostrarSueldo(true);
    setSueldoSeleccionado(t("Recibos de sueldo"));
  };

  const ocultarCampoSueldo = (tipoIngreso) => {
    setMostrarSueldo(false);
    setValue('sueldo', null);
    unregister('sueldo');
    setSueldoSeleccionado(vectorOpcionesAseguradoras[state.aseguradora+' Tipo ingreso '+tipoIngreso]);
  }
  
  const actualizarMensajeErrorIdentidad = (mensaje) => {
    setErrorIdentidad(mensaje);
  };

  const actualizarMensajeErrorRecSueldo = (mensaje) => {
    setErrorRecSueldo(mensaje);
  };

  const actualizarMensajeErrorCertIngMod = (mensaje) => {
    setErrorCertIngMod(mensaje);
  };
  
  const actualizarMensajeErrorDgi = (mensaje) => {
    setErrorDgi(mensaje);
  };

  const actualizarMensajeErrorCertDgiCaja = (mensaje) => {
    setErrorCertDgiCaja(mensaje);
  };

  const actualizarMensajeErrorBalance = (mensaje) => {
    setErrorBalance(mensaje);
  };

  const actualizarMensajeErrorRut = (mensaje) => {
    setErrorRut(mensaje);
  };

  const actualizarMensajeErrorContratoSocial = (mensaje) => {
    setErrorContratoSocial(mensaje);
  };

  const actualizarMensajeErrorCertUni = (mensaje) => {
    setErrorCertUni(mensaje);
  };

  const calcularLimitePago = (personas) => {
    let limitePersona = 0;
    let limitePago = 0;
    for (let i = 0; i < state.personas.length; i++) 
    {
      if (personas[i].monto_ingreso > 0)
      {
        let porcentajeIngresos = 0;
        if (vectorOpcionesAseguradoras[state.aseguradora+' Porcentaje de ingresos '+personas[i].tipo_persona])
        {
          porcentajeIngresos = vectorOpcionesAseguradoras[state.aseguradora+' Porcentaje de ingresos '+personas[i].tipo_persona];
        }
        limitePersona = parseInt(personas[i].monto_ingreso * porcentajeIngresos);
                
        limitePago = limitePago + limitePersona;
      }
    }
    return limitePago;
  }

  const editarPersona = async (persona) => {
    let personasEdicion = state.personas;
    await setState({...state, ...persona, agregando_persona : false, editando_persona : true, personas : personasEdicion });
    navigate('/datos-arrendatario/9999999999');   
  }

  const eliminarPersona = async (idPersona) => {     
    try {  
        const respuesta = await axios.post(state.endpoint+'/personas/destroy/'+idPersona, {}, { headers: { 'Authorization': `Bearer ${state.token_laravel}`, "Content-Type": "application/json", "Accept" :  "application/json"} 
      });
      setGifEspere('');
      if (respuesta.data.codigoRetorno == 0)
      {
        let eliminarPersonas = state.personas;
        let posicionElemento = 0;
        for (let i = 0; i < eliminarPersonas.length; i++) 
        {
          if (eliminarPersonas[i].id == idPersona)
          {
            posicionElemento = i;
            break;
          }
        }
        eliminarPersonas.splice(posicionElemento, 1);
        
        if (eliminarPersonas.length == 1)
        {
          agregarCosolicitante('eliminarPersona');
        }
        else
        {
          let ultimaPersona = eliminarPersonas.length -1;
          if (eliminarPersonas[ultimaPersona].tipo_persona == null)
          {
            await setState({ ...state, ...eliminarPersonas[ultimaPersona], tipo_persona : '', persona_eliminada : true, personas : eliminarPersonas });
          }
          else
          {
            await setState({ ...state, ...eliminarPersonas[ultimaPersona], persona_eliminada : true, personas : eliminarPersonas });
          }
          navigate('/datos-arrendatario/9999999999'); 
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

  const agregarCosolicitante = async (origen) => {
    setGifEspere(<GifEspere />);
    let agregandoPersona = false;
    let personaEliminada = false;   
    if (origen == 'agregarCodeudor')
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
      if (state.personas[i].tipo_arrendatario == 'Cosolicitante' && state.personas[i].tipo_persona == null && state.personas[i].nombres_arrendatario == '' && state.personas[i].apellidos_arrendatario == '' && state.personas[i].empresa == '' && state.personas[i].monto_ingreso == 0)
      {
        registroNulo = 1;
        posicionRegistroNulo = i;
      }
    }
    if (registroNulo == 0)
    {
      let datosCreacionCosolicitante = {...datosInicioPersona, garantia_id : state.garantia_id};
      try {  
        const respuesta = await axios.post(state.endpoint+'/personas/store', datosCreacionCosolicitante, {
          headers: {
            'Authorization': `Bearer ${state.token_laravel}`
          }
        });
        setGifEspere('');
        if (respuesta.data.codigoRetorno == 0)
        {
          if (paginaActual.current == 'personas-adicionales')
          {           
              var personasPreparadas = prepararCamposPersonas(respuesta.data.personas);
              let ultimaPersona = personasPreparadas.length -1;
              setState({...state, ...personasPreparadas[ultimaPersona], tipo_persona : '', agregando_persona : agregandoPersona, editando_persona : false, persona_eliminada : personaEliminada, personas : personasPreparadas });
              navigate('/datos-arrendatario/9999999999');     
          }         
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
      setState({ ...state, ...state.personas[posicionRegistroNulo], tipo_persona : '', agregando_persona : agregandoPersona, editando_persona : false, persona_eliminada : personaEliminada });
      navigate('/datos-arrendatario/9999999999');     
    }
  }

  const cambiarMostrarDatosFormulario = (mostrar) => {
    setMostrarDatosFormulario(mostrar);
  }

  const recargarPagina = async () => {
    if (state.persona_eliminada == true)
    {
      let limitePago = calcularLimitePago(state.personas);
      let faltante = state.costo_alquiler - limitePago; 
      let indicadorModalIngresosSuficientes = false;
      if (faltante <= 0)
      {
        indicadorModalIngresosSuficientes = true;
      } 
      await setState({...state, persona_eliminada : false, limite_pago : limitePago, faltante : faltante, mostrar_modal_ingresos_suficientes : indicadorModalIngresosSuficientes});
    } 
    navigate('/datos-arrendatario/9999999999'); 
  }

  const modalPersonaAgregada = () => {
    setTituloModalBasico('');
    accionModalBasico.current = recargarPagina;
    setContenidoModalBasico(t('texto_149'));
    setModalBasico(true);
  }

  const modalPersonaEditada = () => {
    setTituloModalBasico('');
    accionModalBasico.current = recargarPagina;
    setContenidoModalBasico(t('texto_150'));
    setModalBasico(true);
  }

  const modalPersonaEliminada = () => {
    setTituloModalBasico('');
    accionModalBasico.current = recargarPagina;
    setContenidoModalBasico(t('texto_146'));
    setModalBasico(true);
  }

  const saveData = async (data) => {
    let indicadorErrores = 0;
    setErrorTipoPersona(false);
    setErrorTipoDocumentoIdentidad(false);
    setErrorNroIdentArrend(false);
    setErrorNombres(false);
    setErrorApellidos(false);
    setErrorNroIdentEmp(false);
    setErrorEmpresa(false);
    setErrorCargoEmpresa(false);
    setErrorEmail(false);
    setErrorTelefono(false);
    setErrorMoneda(false);
    setErrorMontoIngreso(false);
    setErrorIngreso(false);
    setErrorSueldo(false);
    setErrorIdentidad('');
    setErrorRecSueldo('');
    setErrorCertIngMod('');
    setErrorDgi('');
    setErrorCertDgiCaja('');
    setErrorBalance('');
    setErrorRut('');
    setErrorContratoSocial('');
    setErrorCertUni('');

    let operacionesPersonas = state.personas;
    let datosActualizados = {};
    let limitePago = 0;
    let faltante = 0;
    var indicePersonaActual = 0;

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

    if (mostrarCargoEmpresa == true)
    {
      if (data.cargo_empresa == null || data.cargo_empresa == '')
      {
        setErrorCargoEmpresa(true);
        indicadorErrores = 1;
      }
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
    if (mostrarMonedaIngreso == true)
    {
      if (data.moneda_ingreso == null || data.moneda_ingreso == '')
      {
        setErrorMoneda(true);
        indicadorErrores = 1;
      }
    }
    if (mostrarMontoIngreso == true)
    {
      if (data.monto_ingreso == null || data.monto_ingreso == '' || data.monto_ingreso == '0' || data.monto_ingreso == 0)
      {
        setErrorMontoIngreso(true);
        indicadorErrores = 1;
      }
    }
    if (mostrarIngreso == true)
    {
      if (data.ingreso == null || data.ingreso == '')
      {
        setErrorIngreso(true);
        indicadorErrores = 1;
      }
    }
    if (mostrarSueldo == true)
    {
      if (data.sueldo == null || data.sueldo == '')
      {
        setErrorSueldo(true);
        indicadorErrores = 1;
      }
    }
    if (mostrarIdentidad == true && contadorIdentidad.current == 0)
    {
      actualizarMensajeErrorIdentidad(<MensajeError mensaje={'La imagen del documento de identidad es requerida'} />);
      indicadorErrores = 1;
    }

    if (mostrarRecSueldo == true && contadorRecSueldo.current == 0)
    {
        actualizarMensajeErrorRecSueldo(<MensajeError mensaje={'Los archivos de los recibos de sueldo son requeridos'} />);
        indicadorErrores = 1;
    }

    if (mostrarCertIngMod == true && contadorCertIngMod.current == 0)
    {
        if (vectorOpcionesAseguradoras[state.aseguradora+' CertIngMod error '+data.tipo_persona])
        {
          actualizarMensajeErrorCertIngMod(<MensajeError mensaje={vectorOpcionesAseguradoras[state.aseguradora+' CertIngMod error '+data.tipo_persona]} />);
          indicadorErrores = 1;
        } 
    }

    if (mostrarDgi == true && contadorDgi.current == 0)
    {
        actualizarMensajeErrorDgi(<MensajeError mensaje={t("Los archivos de la DGI son requeridos")} />);
        indicadorErrores = 1;
    }

    if (mostrarCertDgiCaja == true && contadorCertDgiCaja.current == 0)
    {
      actualizarMensajeErrorCertDgiCaja(<MensajeError mensaje={t("Certificado(s) requerido(s)")} />);
      indicadorErrores = 1;
    }

    if (mostrarBalance == true && contadorBalance.current == 0)
    {
      if (vectorOpcionesAseguradoras[state.aseguradora+' Balance error '+data.tipo_persona])
      {
        actualizarMensajeErrorBalance(<MensajeError mensaje={vectorOpcionesAseguradoras[state.aseguradora+' Balance error '+data.tipo_persona]} />);
      }
      else
      {
        actualizarMensajeErrorBalance(<MensajeError mensaje={t("Balance(s) requerido(s)")} />);
      }
      indicadorErrores = 1;
    }

    if (mostrarRut == true && contadorRut.current == 0)
    {
      actualizarMensajeErrorRut(<MensajeError mensaje={t("La tarjeta RUT es requerida")} />);
      indicadorErrores = 1;
    }

    if (mostrarContratoSocial == true && contadorContratoSocial.current == 0)
    {
      if (vectorOpcionesAseguradoras[state.aseguradora+' ContratoSocial error '+data.tipo_persona])
      {
        actualizarMensajeErrorContratoSocial(<MensajeError mensaje={vectorOpcionesAseguradoras[state.aseguradora+' ContratoSocial error '+data.tipo_persona]} />);
      }
      else
      {
        actualizarMensajeErrorContratoSocial(<MensajeError mensaje={t("El contrato es requerido")} />);
      }
      indicadorErrores = 1;
    }

    if (mostrarCertUni == true && contadorCertUni.current == 0)
    {
      if (vectorOpcionesAseguradoras[state.aseguradora+' CertUni error '+data.tipo_persona])
      {
        actualizarMensajeErrorCertUni(<MensajeError mensaje={vectorOpcionesAseguradoras[state.aseguradora+' CertUni error '+data.tipo_persona]} />);
      }
      indicadorErrores = 1;
    }

    if (indicadorErrores == 0)
    {
      setGifEspere(<GifEspere />);
      let monedaIngresoActual = '';
      let montoIngresoActual = 0;
      if (data.aseguradora == 'Porto' && data.tipo_persona == 'Universitario')
      {
          monedaIngresoActual = vectorOpcionesAseguradoras[data.aseguradora+' Moneda ingreso '+data.tipo_persona];
          montoIngresoActual = vectorOpcionesAseguradoras[data.aseguradora+' Monto ingreso '+data.tipo_persona];
      }
      else
      {
        monedaIngresoActual = data.moneda_ingreso;
        montoIngresoActual = data.monto_ingreso;
      }

      datosActualizados = 
      {
        ...state, 
        sueldo : null, 
        ...data, 
        moneda_ingreso : monedaIngresoActual,
        monto_ingreso : montoIngresoActual, 
        identidad : 'identidad',
        etiqueta_identidad : t('texto_62'),
        rec_sueldo : 'rec_sueldo', 
        etiqueta_rec_sueldo : t("Recibos de sueldo o de cobro de jubilación o pensión *"),
        cert_ing_mod : 'cert_ing_mod',
        etiqueta_cert_ing_mod : etiquetaCertIngMod, 
        dgi : 'dgi', 
        etiqueta_dgi : t("Última declaración jurada ante DGI o (IRPF / IRAE / IPAT / ICOSA / IVA, etc) presentada en el último año *"),
        cert_dgi_caja : 'cert_dgi_caja',
        etiqueta_cert_dgi_caja : t("Certificados vigentes de BPS y DGI *"),
        balance : 'balance',
        etiqueta_balance : etiquetaBalance,
        rut : 'rut',
        etiqueta_rut : t("Tarjeta RUT *"),
        contrato_social : 'contrato_social',
        etiqueta_contrato_social : etiquetaContratoSocial,
        cert_uni : 'cert_uni',  
        etiqueta_cert_uni : etiquetaCertUni,  
        personas : null 
      };

      if (paginaActual.current == 'personas-adicionales')
      {
        for (let i = 0; i < state.personas.length; i++) 
        {
          if (state.personas[i].id == state.id)
          {
            indicePersonaActual = i;
            break;
          }
        }
      }

      operacionesPersonas[indicePersonaActual] = 
        {
          ...operacionesPersonas[indicePersonaActual], 
          sueldo : null, 
          ...data, 
          moneda_ingreso : monedaIngresoActual,
          monto_ingreso : montoIngresoActual
        } 

      limitePago = calcularLimitePago(operacionesPersonas);
      faltante = state.costo_alquiler - limitePago; 

      if (paginaActual.current == 'datos-arrendatario')
      {
        datosActualizados = 
          {
            ...datosActualizados,
            estatus_garantia : t('texto_345')
          };
      }
      else
      {
        if (faltante > 0)
        {
          datosActualizados = 
          {
            ...datosActualizados,
            estatus_garantia : t("Paso 4, Borrador, ingresos insuficientes")
          };
        }
        else
        {
          datosActualizados = 
          {
            ...datosActualizados,
            estatus_garantia : t("Paso 5, Enviado")
          };
        }
      }

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
      // console.log('Arrendatario, formulario', [...formulario]);
      
      try {  
        const respuesta = await axios.post(state.endpoint+'/personas/update/'+state.id, formulario, { headers: { 'Authorization': `Bearer ${state.token_laravel}`, "Content-Type": "multipart/form-data" } });
        setGifEspere('');
        if (respuesta.data.codigoRetorno == 0)
        {  
          var personasPreparadas = prepararCamposPersonas(respuesta.data.personas);
          let indicadorModalIngresosSuficientes = false;
          if (faltante <= 0)
          {
            indicadorModalIngresosSuficientes = true;
          } 
          if (paginaActual.current == 'datos-arrendatario')
          {
            let ultimaPersona = personasPreparadas.length -1;
            if (personasPreparadas[ultimaPersona].tipo_persona == null)
            {
              await setState({...datosActualizados, titulo_formulario : 'Personas adicionales', ...personasPreparadas[ultimaPersona], tipo_persona : '', limite_pago : limitePago, faltante : faltante, mostrar_modal_ingresos_suficientes : indicadorModalIngresosSuficientes, personas : personasPreparadas });
            }
            else
            {
              await setState({...datosActualizados, titulo_formulario : 'Personas adicionales', ...personasPreparadas[ultimaPersona], limite_pago : limitePago, faltante : faltante, mostrar_modal_ingresos_suficientes : indicadorModalIngresosSuficientes, personas : personasPreparadas });
            }
            navigate('/personas-adicionales/'+respuesta.data.personas[ultimaPersona].id);  
          }
          else
          {
            for (let i = 0; i < respuesta.data.personas.length; i++) 
            {
              if (respuesta.data.personas[i].id == state.id)
              {
                indicePersonaActual = i;
                break;
              }
            }
            if (existenCosolicitantes == false)
            {
              setExistenCosolicitantes(true);
            }  
            let agregandoPersona = state.agregando_persona;
            let editandoPersona = state.editando_persona;
            console.log('Arrendatario, faltante', faltante);
            await setState({...state, ...personasPreparadas[indicePersonaActual], agregando_persona : false, editando_persona : false, personas : personasPreparadas, limite_pago : limitePago, faltante : faltante, mostrar_modal_ingresos_suficientes : indicadorModalIngresosSuficientes});
            setMostrarDatosFormulario(false);
            if (agregandoPersona == true)
            {
              modalPersonaAgregada();
            }
            else if (editandoPersona == true)
            {
              modalPersonaEditada();
            }
          }          
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

  console.log("Arrendatario, state", state);

  const Cosolicitantes = () => {
    const encabezados = ['Codeudor', 'Tipo de persona', 'Ingresos', 'Acciones'];

    const BasicMenu = ({persona, codeudor}) => {
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
            <MenuItem onClick={() => { modalEliminarPersona(persona, codeudor) }}>Eliminar</MenuItem>
          </Menu>
        </div>
      );
    }

    const modalEliminarPersona = (persona, codeudor) => {
      accionModalDialogoBasico.current = cerrarModalDialogoBasico;
      setTituloModalDialogoBasico(t('texto_144'));
      setContenidoModalDialogoBasico(t('texto_145', {codeudor : codeudor}));
      setTextoAccion1DialogoBasico(t('texto_113'));
      accion1DialogoBasico.current = eliminarPersona;
      setParametrosAccion1DialogoBasico(persona.id);
      setTextoAccion2DialogoBasico(t('texto_114'));
      accion2DialogoBasico.current = cerrarModalDialogoBasico;
      setParametrosAccion2DialogoBasico('');
      setModalDialogoBasico(true);
    } 

    return (
      <>
        <h3>{t("Personas adicionales (codeudores)")}</h3>
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
                      if (persona.tipo_arrendatario == 'Cosolicitante' && persona.tipo_persona != null) 
                      {
                        if (persona.nombres_arrendatario != null || persona.empresa != null)
                        {
                          let codeudor = '';
                          if (persona.tipo_persona == 'Empresa')
                          {
                            codeudor = persona.empresa;
                          }
                          else
                          {
                            codeudor = persona.nombres_arrendatario+' '+persona.apellidos_arrendatario;
                          }
                          let montoIngreso = new Intl.NumberFormat("es-UY").format(parseInt(persona.monto_ingreso));
                          return (
                            <TableRow
                              key={persona.id}
                              sx={{ '&:last-child td, &:last-child th': { border: 0 } }}
                            >
                              <TableCell align="left">{codeudor}</TableCell>
                              <TableCell align="left">{persona.tipo_persona}</TableCell>
                              <TableCell align="left">{montoIngreso}</TableCell>
                              <TableCell align="left">
                                <BasicMenu persona={persona} codeudor={codeudor} />
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
                if (persona.tipo_arrendatario == 'Cosolicitante' && persona.tipo_persona != null) 
                {
                  if (persona.nombres_arrendatario != null || persona.empresa != null)
                  {
                    let codeudor = '';
                    if (persona.tipo_persona == 'Empresa')
                    {
                      codeudor = persona.empresa;
                    }
                    else
                    {
                      codeudor = persona.nombres_arrendatario+' '+persona.apellidos_arrendatario;
                    }
                    let montoIngreso = new Intl.NumberFormat("es-UY").format(parseInt(persona.monto_ingreso));
                    return (
                      <Box key={persona.id} component={Paper} elevation={12} sx={{ p : 2, marginBottom : 2, borderRadius : 3}}>
                        <Typography variant="h3" sx={{marginBottom : '0.5rem'}}>{codeudor}</Typography>
                        <div className='ra_flex_tabla_movil'>
                          <div className='ra_flex_simple'>
                            {persona.tipo_persona}
                          </div>
                        </div>
                        <div className='ra_flex_tabla_movil'>
                          <div className='ra_flex_doble'>
                            {montoIngreso}
                          </div>
                          <div className='ra_flex_doble'>
                            <BasicMenu persona={persona} codeudor={codeudor}/>
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

  const FormularioArrendatario = ({ mostrarDatosFormulario, cambiarMostrarDatosFormulario }) => {
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
      if (paginaActual.current == 'personas-adicionales')
      {
        setcontenidoLineaTiempo({...contenidoLineaTiempo, paso3 : <><div className="ra_tilde glyphicon glyphicon-ok"></div><span numero-paso="" titulo-paso="Propiedad"></span></> })
        if (state.faltante <= 0)
        {
          /*
          Se comentó para permitir agregar más codeudores aunque no sean necesarios
          if (state.tipo_persona == '')
          {
            cambiarMostrarDatosFormulario(false);
          }
          */
          if (state.mostrar_modal_ingresos_suficientes == true)
          {
            modalIngresosSuficientes();
          }
        }
        else
        {
          setMostrarMensajeFaltante(true);
        }
      }
    })();},[]);

    const actualizarMontoIngreso = (event) => {
      setState({...state, monto_ingreso : event.target.value.replace(/\./g, '')});
    }

    const agregarCodeudor = () => {
      if (mostrarDatosFormulario == true && state.editando_persona == false)
      {
        setMostrarDatosFormulario(false);
        setState({...state, agregando_persona : false});
      }
      else
      {
        let cantidadAcumuladaPersonasAdicionales = 0;
        for (let i = 0; i < state.personas.length; i++) 
        {
          if (state.personas[i].tipo_arrendatario == 'Cosolicitante' && state.personas[i].tipo_persona != null)
          {
            cantidadAcumuladaPersonasAdicionales++;
          }
        }

        if (state.cantidad_personas_adicionales == cantidadAcumuladaPersonasAdicionales)
        {
          modalLimitePersonasAdicionales();
        }
        else
        {
          agregarCosolicitante('agregarCodeudor');
        }
      }
    }

    const modalLimitePersonasAdicionales = () => {
      setTituloModalBasico(t("Límite Personas adicionales"));
      accionModalBasico.current = cerrarModalBasico;
      setContenidoModalBasico(t("Estimado usuario usted ya alcanzó el límite para agregar personas adicionales"));
      setModalBasico(true);
    }

    const modalIngresosSuficientes = () => {
      setTituloModalBasico(t("Ingresos suficientes"));
      accionModalBasico.current = cerrarModalIngresosSuficientes;
      setContenidoModalBasico(t("Los ingresos registrados son suficientes para contratar la garantía, no requiere personas adicionales"));
      setTipoAlertaModalBasico("Satisfactorio");
      setModalBasico(true);
    }

    const cerrarModalIngresosSuficientes = () => {
      setState({...state, mostrar_modal_ingresos_suficientes : false});
      cerrarModalBasico();
    }

    const modalFaltanArchivos = () => {  
      accionModalDialogoBasico.current = cerrarModalDialogoBasico;
      setTituloModalDialogoBasico(t('texto_288'));
      setContenidoModalDialogoBasico(t('texto_289'));
      setTextoAccion1DialogoBasico(t('texto_291'));
      accion1DialogoBasico.current = cerrarModalDialogoBasico;
      setParametrosAccion1DialogoBasico('');
      setTextoAccion2DialogoBasico(t('texto_214'));
      accion2DialogoBasico.current = irAlIndice;
      setParametrosAccion2DialogoBasico('');
      setModalDialogoBasico(true);
    } 

    const regresar = (evento) => {
      evento.preventDefault();
      if (paginaActual.current == 'personas-adicionales')
      {
        let personasActuales = state.personas;
        setState({ ...state, ...state.personas[0], personas : personasActuales, titulo_formulario : 'Datos del arrendatario (inquilino)' });
      }
      navigate(state.paso_anterior);
    }
      
    const verificarGarantia = async () => {
      var indicadorTipoPersonaAseguradora = true;
      for (let i = 0; i < state.personas.length; i++) 
      {
        if (state.personas[i].tipo_arrendatario != 'Propietario' && state.personas[i].tipo_persona != null && state.personas[i].tipo_persona != ' ' && state.personas[i].tipo_persona != '')
        {
          var indicadorTipoPersonaEncontrado = false;
          for (let indice = 0; indice < vectorOpcionesInputs['aseguradoras_tipos_personas '+state.aseguradora].length; indice++) 
          {
            if (vectorOpcionesInputs['aseguradoras_tipos_personas '+state.aseguradora][indice].valor == state.personas[i].tipo_persona)
            {
              indicadorTipoPersonaEncontrado = true;
            }
          }
          if (indicadorTipoPersonaEncontrado == false)
          {
            indicadorTipoPersonaAseguradora = false;
          }
        }
      }
      if (indicadorTipoPersonaAseguradora == false)
      {
        modalTipoPersonaNoPermitada();
      }
      else
      {
        let limitePago = calcularLimitePago(state.personas);
        let faltante = state.costo_alquiler - limitePago; 
        if (faltante > 0)
        {
          let cantidadAcumuladaPersonasAdicionales = 0;
          for (let i = 0; i < state.personas.length; i++) 
          {
            if (state.personas[i].tipo_arrendatario == 'Cosolicitante' && state.personas[i].tipo_persona != null)
            {
              cantidadAcumuladaPersonasAdicionales++;
            }
          }

          if (state.cantidad_personas_adicionales == cantidadAcumuladaPersonasAdicionales)
          {
            modalLimitePersonasIngresos();
          }
          else
          {
            modalIngresosInsuficientes();
          }
        }
        else
        {
          let indicadorArchivos = verificarArchivos();
          if (indicadorArchivos == 0)
          {
            let guardarDatos = { ...state, estatus_garantia : t("Paso 5, Enviado"), personas : null };
            const formulario = new FormData();
            formulario.append("datos", JSON.stringify(guardarDatos));
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
          else
          {
            modalFaltanArchivos();
          }
        }
      }
    }
   
    const verificarArchivos = () => {
      var indicadorArchivos = 0;
      let tipoPersona = '';
      for (let i = 0; i < state.personas.length; i++) 
      {
        if (state.personas[i].tipo_arrendatario == 'Solicitante' || state.personas[i].tipo_arrendatario == 'Cosolicitante')
        {
          tipoPersona = state.personas[i].tipo_persona;
          if (inputsAseguradoras[state.aseguradora+' '+tipoPersona+' identidad'] == true && state.personas[i].contador_identidad == 0)
          {
            indicadorArchivos = 1;
          }
    
          if (inputsAseguradoras[state.aseguradora+' '+tipoPersona+' recSueldo'] == true && state.personas[i].contador_rec_sueldo == 0)
          {
            indicadorArchivos = 1;
          }
    
          if (inputsAseguradoras[state.aseguradora+' '+tipoPersona+' certIngMod'] == true && state.personas[i].contador_cert_ing_mod == 0)
          {
            indicadorArchivos = 1;
          }
    
          if (inputsAseguradoras[state.aseguradora+' '+tipoPersona+' dgi'] == true && state.personas[i].contador_dgi == 0)
          {
            indicadorArchivos = 1;
          }
    
          if (inputsAseguradoras[state.aseguradora+' '+tipoPersona+' certDgiCaja'] == true && state.personas[i].contador_cert_dgi_caja == 0)
          {
            indicadorArchivos = 1;
          }
    
          if (inputsAseguradoras[state.aseguradora+' '+tipoPersona+' balance'] == true && state.personas[i].contador_balance == 0)
          {
            indicadorArchivos = 1;
          }
    
          if (inputsAseguradoras[state.aseguradora+' '+tipoPersona+' rut'] == true && state.personas[i].contador_rut == 0)
          {
            indicadorArchivos = 1;
          }
    
          if (inputsAseguradoras[state.aseguradora+' '+tipoPersona+' contratoSocial'] == true && state.personas[i].contador_contrato_social == 0)
          {
            indicadorArchivos = 1;
          }
    
          if (inputsAseguradoras[state.aseguradora+' '+tipoPersona+' certUni'] == true && state.personas[i].contador_cert_uni == 0)
          {
            indicadorArchivos = 1;
          }    
        }
      }
      return indicadorArchivos;
    }

    const irAlIndice = () => {
      if (modalBasico == true)
      {
        cerrarModalBasico();
      }
      if (modalDialogoBasico == true)
      {
        cerrarModalDialogoBasico();
      }
      setState(datosInicio);   
      navigate(state.paso_siguiente);
    }

    const modalLimitePersonasIngresos = () => {
      let costoAlquiler = new Intl.NumberFormat("es-UY").format(parseInt(state.costo_alquiler));
      let limitePago = new Intl.NumberFormat("es-UY").format(parseInt(state.limite_pago));
      let faltante = new Intl.NumberFormat("es-UY").format(parseInt(state.faltante));
  
      accionModalDialogoBasico.current = cerrarModalDialogoBasico;
      setTituloModalDialogoBasico(t('texto_156'));
      setContenidoModalDialogoBasico(t('texto_159', { costoAlquiler : costoAlquiler, monedaPropiedad : state.moneda_propiedad, limitePago : limitePago, faltante : faltante }));
      setTextoAccion1DialogoBasico(t("Ok"));
      accion1DialogoBasico.current = cerrarModalDialogoBasico;
      setParametrosAccion1DialogoBasico('');
      setTextoAccion2DialogoBasico(t("Agregarlo más tarde"));
      accion2DialogoBasico.current = irAlIndice;
      setParametrosAccion2DialogoBasico('');
      setModalDialogoBasico(true);
    } 

    const modalIngresosInsuficientes = () => {
      let costoAlquiler = new Intl.NumberFormat("es-UY").format(parseInt(state.costo_alquiler));
      let limitePago = new Intl.NumberFormat("es-UY").format(parseInt(state.limite_pago));
      let faltante = new Intl.NumberFormat("es-UY").format(parseInt(state.faltante));
  
      accionModalDialogoBasico.current = cerrarModalDialogoBasico;
      setTituloModalDialogoBasico(t('texto_156'));
      setContenidoModalDialogoBasico(t("Estimado usuario el costo del alquiler de la propiedad es de: costoAlquiler  monedaPropiedad, la sumatoria del porcentaje de los ingresos del arrendatario y el (los) codeudor(es) es de limitePago y existe un faltante de faltante. Por favor agregue uno o más codeudores", { costoAlquiler : costoAlquiler, monedaPropiedad : state.moneda_propiedad, limitePago : limitePago, faltante : faltante }));
      setTextoAccion1DialogoBasico(t("Agregar codeudor"));
      accion1DialogoBasico.current = agregarCodeudor;
      setParametrosAccion1DialogoBasico('');
      setTextoAccion2DialogoBasico(t("Agregarlo más tarde"));
      accion2DialogoBasico.current = irAlIndice;
      setParametrosAccion2DialogoBasico('');
      setModalDialogoBasico(true);
    } 

    const modalTipoPersonaNoPermitada = () => {
      setTituloModalBasico(t('Tipo de codeudor no permitido'));
      accionModalBasico.current = cerrarModalBasico;
      setContenidoModalBasico(t('Estimado usuario uno de los tipos de codeudores no está permitido por la aseguradora, por favor cámbielo por otro'));
      setModalBasico(true);
    }
  
    const BotonesGuardarNavegacion = () => {
      return (
            <>
              {
                paginaActual.current == 'personas-adicionales' &&
                  <>
                    <br />
                    <Grid container>
                      <Grid key={'1'} size={{ xs : 12, sm : 12, md : 12, lg : 12, xl : 12 }} sx={{textAlign : 'center'}}>
                        <Button variant="outlined" sx={{ fontSize : 16, borderRadius : 1 }} type='submit'>
                          {t('texto_151')}
                        </Button>
                      </Grid>
                    </Grid>
                  </>
              }
              <div className='botones_navegacion_fijos'>
                {
                  paginaActual.current == 'datos-arrendatario' &&   
                    <>
                      <div className='ra_nav_anterior'>
                        <Fab variant="extended" color="secondary" sx={{ fontSize : 12, borderRadius : 1}} onClick={regresar} >
                          <KeyboardArrowLeftIcon />
                          Anterior
                        </Fab>
                      </div>
                      <div className='ra_nav_siguiente'>
                        <Fab variant="extended" color="primary" sx={{ fontSize : 12, borderRadius : 1 }} type='submit'>
                          {t('texto_152')}
                          <KeyboardArrowRightIcon />
                        </Fab>
                      </div>
                    </>
                }
              </div>
            </>
      );
    }

    const BotonesNavegacion = () => {
      return (
            <>
              <div className='botones_navegacion_fijos'>
                <div className='ra_nav_anterior'>
                  <Fab variant="extended" color="secondary" sx={{ fontSize : 12, borderRadius : 1}} onClick={regresar} >
                    <KeyboardArrowLeftIcon />
                    Anterior
                  </Fab>
                </div>
                <div className='ra_nav_siguiente'>
                  <Fab variant="extended" color="primary" sx={{ fontSize : 12, borderRadius : 1 }} onClick={ () => { verificarGarantia() }} >
                    {t("Registrar garantía")}
                  </Fab>
                </div>
              </div>
            </>
      );
    }
  
    let costoAlquiler = new Intl.NumberFormat("es-UY").format(parseInt(state.costo_alquiler));
    let limitePago = new Intl.NumberFormat("es-UY").format(parseInt(state.limite_pago));
    let faltante = new Intl.NumberFormat("es-UY").format(parseInt(state.faltante));

    return (
      <>
        {inicioPantalla}
        <Box component={Paper} elevation={12} sx={{ marginTop : '14rem', p : 2, borderRadius : 3 }}>
          <Stack sx={{width : '100%'}}>
            <PasoAPaso rutaPaso={''} />
          </Stack>
          <br />
          <div className='ra_escritorio'>
            <Grid container>
              <Grid key={'1'} size={{ xs : 6, sm : 6, md : 9, lg : 9, xl : 9 }}>
                <Typography variant="h4">{state.titulo_formulario}</Typography>
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
              <Typography variant="h4" sx={{marginTop : '1rem', marginBottom : '1rem'}}>{state.titulo_formulario}</Typography>
              <img src={imagenAseguradora} alt="Logo" width="30%"></img>
              <Typography variant='h5' sx={{marginTop : '0.5rem'}}>{state.aseguradora+' '+t("Aseguradora")+' '+t('texto_110')}</Typography>
            </Stack>
          </div>
          <br />
          {
            mensajesEncabezado == true &&
              <Stack>
                <Box>
                  {mensajesUsuarioEncabezado}  
                </Box>
                <Box sx={{ lineHeight: '3rem', p : 2, marginTop : 2, marginBottom : 2, backgroundColor : '#E7E7E7', borderRadius : 2 }}>
                  {t("El inquilino No puede estar en el Clearing ni Seguro de Paro para solicitar esta garantía. Si el inquilino estuvo en seguro de paro parcial o total, debe tener un (1) mes completo trabajado fuera del seguro de paro y presentar además los recibos de cobro emitidos por BPS, éstos deben ir adjuntos en el mismo campo de adjuntar los recibos de sueldo.")}
                </Box>              
                { mostrarMensajeFaltante &&
                  <>
                    <Box sx={{ lineHeight: '3rem', p : 2, marginTop : 2, backgroundColor : '#FFB76C', borderRadius : 2 }}>
                      {t('texto_136', {cantidadPersonasAdicionales : state.cantidad_personas_adicionales})}
                    </Box>
                    <Box sx={{ p : 2, marginTop : 2, marginBottom : 2, border : 'solid 1px #6D6D6D', borderRadius : 2 }}>
                      <AcordionFaltante faltante={faltante} limitePago={limitePago} costoAlquiler={costoAlquiler} />
                    </Box>
                  </>
                }
              </Stack>
          }
          {
            paginaActual.current == 'personas-adicionales' && 
              <>
                {subTituloFormulario}
                <Button 
                  size="large" 
                  variant="contained" 
                  onClick={() => { agregarCodeudor() }}
                  startIcon={mostrarDatosFormulario ? <KeyboardArrowLeftIcon /> : <AddIcon />}
                >
                  {mostrarDatosFormulario ? t("Volver") : t("Agregar codeudor")} 
                </Button>
              </>
          }
          <br /><br />
          <Form onSubmit={handleSubmit(saveData)}>
            {
              mostrarDatosFormulario &&
                <> 
                  <Box sx={{ border : 'solid 1px', p : 2, borderRadius : 3 }}>
                    <fieldset>
                      <Grid container spacing={{ xs : 2, sm : 2, md : 3, lg : 3, xl : 3 }}>
                        <Grid key={'1'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                          <InputSelectRHF nombre={'tipo_persona'} control={control} etiqueta={t('texto_122')} opcionesInputs={vectorOpcionesInputs['aseguradoras_tipos_personas '+state.aseguradora]} textoAdicional={''} funcionAdicional={funcionAdicionalTipoPersona} textoError={t('texto_123')} errorInput={errorTipoPersona} />            
                        </Grid>
                        {
                          mostrarTipoDocumentoIdentidad && 
                            <Grid key={'2'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                              <InputSelectRHF nombre={'tipo_documento_identidad'} control={control} etiqueta={t('texto_270')} opcionesInputs={vectorOpcionesInputs['tipo_documento_identidad']} textoAdicional={''} funcionAdicional={funcionAdicionalTipoDocumentoIdentidad} textoError={t('texto_271')} errorInput={errorTipoDocumentoIdentidad} />
                            </Grid>
                        }
                        {
                          mostrarNroIdentArrend && 
                            <Grid key={'3'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                              <InputFormControlRHF nombre={'numero_identidad_arrendatario'} control={control} etiqueta={t("Número de cédula *")} textoAdicional={''} funcionAdicional={funcionAdicionalNroIdentArrend} textoError={t("El número de cédula es requerido")} errorInput={errorNroIdentArrend} />
                            </Grid>
                        }
                        {
                          mostrarNombres && 
                            <Grid key={'4'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                              <InputFormControlRHF nombre={'nombres_arrendatario'} control={control} etiqueta={pasoFormulario.current == 'Arrendatario' ? t('texto_51') : t('texto_140')} textoAdicional={''} funcionAdicional={funcionAdicionalNombres} textoError={t("Los nombres son requeridos")} errorInput={errorNombres} />
                            </Grid>
                        }
                        {
                          mostrarApellidos && 
                            <Grid key={'5'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                              <InputFormControlRHF nombre={'apellidos_arrendatario'} control={control} etiqueta={pasoFormulario.current == 'Arrendatario' ? t('texto_52') : t('texto_141') } textoAdicional={''} funcionAdicional={funcionAdicionalApellidos} textoError={t("Los apellidos son requeridos")} errorInput={errorApellidos} />
                            </Grid>
                        }
                        {
                          mostrarNroIdentEmp && 
                            <Grid key={'6'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                              <InputFormControlRHF nombre={'numero_identidad_empresa'} control={control} etiqueta={t('texto_53')} textoAdicional={''} funcionAdicional={funcionAdicionalNroIdentEmp} textoError={t("El RUT de la empresa es requerido")} errorInput={errorNroIdentEmp} />
                            </Grid>
                        }
                        {
                          mostrarEmpresa && 
                            <Grid key={'7'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                              <InputFormControlRHF nombre={'empresa'} control={control} etiqueta={t('texto_54')} textoAdicional={''} funcionAdicional={funcionAdicionalEmpresa} textoError={t("El nombre de la empresa es requerido")} errorInput={errorEmpresa} />
                            </Grid>
                        }
                        {
                          mostrarCargoEmpresa &&
                            <Grid key={'8'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                              <InputRadioRHF nombre={'cargo_empresa'} control={control} etiqueta={t('texto_83')} opcionesInputs={vectorOpcionesInputs['cargo_empresa']} textoAdicional={''} funcionAdicional={funcionAdicionalCargoEmpresa} textoError={t('texto_88')} errorInput={errorCargoEmpresa} />            
                            </Grid>
                        }

                        <Grid key={'9'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                          <InputFormControlRHF nombre={'email_arrendatario'} control={control} etiqueta={pasoFormulario.current == 'Arrendatario' ? t('texto_55') : t('texto_142') } textoAdicional={''} funcionAdicional={funcionAdicionalEmail} textoError={t('texto_46')} errorInput={errorEmail} />
                        </Grid>

                        <Grid key={'10'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                          <InputFormControlRHF nombre={'telefono_arrendatario'} control={control} etiqueta={pasoFormulario.current == 'Arrendatario' ? t('texto_56') : t('texto_143')} textoAdicional={''} funcionAdicional={funcionAdicionalTelefono} textoError={t("El número de teléfono es requerido")} errorInput={errorTelefono} />
                        </Grid>
                        {
                          mostrarMonedaIngreso &&
                            <Grid key={'11'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                              <InputSelectRHF nombre={'moneda_ingreso'} control={control} etiqueta={t('texto_57')} opcionesInputs={vectorOpcionesInputs['moneda']} textoAdicional={''} funcionAdicional={funcionAdicionalMonedaIngreso} textoError={t("La moneda del ingreso es requerida")} errorInput={errorMoneda} />            
                            </Grid>
                        }
                        {
                          mostrarMontoIngreso &&
                            <Grid key={'12'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                              <InputNumericFormatRHF nombre={'monto_ingreso'} control={control} etiqueta={t('texto_58')} textoAdicional={''} funcionAdicional={funcionAdicionalMontoIngreso} textoError={t("El monto de los ingresos es requerido")} errorInput={errorMontoIngreso} />    
                            </Grid>
                        }
                        {
                          mostrarIngreso &&
                            <Grid key={'13'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                              <InputSelectRHF nombre={'ingreso'} control={control} etiqueta={t('texto_59')} opcionesInputs={vectorOpcionesInputs['ingreso']} textoAdicional={''} funcionAdicional={funcionAdicionalIngreso} textoError={t('texto_124')} errorInput={errorIngreso} />            
                            </Grid>
                        }
                        {
                          mostrarSueldo &&
                            <Grid key={'14'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                              <InputRadioRHF nombre={'sueldo'} control={control} etiqueta={t('texto_125')} opcionesInputs={vectorOpcionesInputs['sueldo']} textoAdicional={''} funcionAdicional={funcionAdicionalSueldo} textoError={t('texto_126')} errorInput={errorSueldo} />            
                            </Grid>
                        }
                      </Grid>
                      <br />
                      <Grid container spacing={{ xs : 2, sm : 2, md : 3, lg : 3, xl : 3 }}>
                        {
                          mostrarIdentidad && 
                            <Grid key={'1'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                              <CargarArchivosServidor control={control} multiplesArchivos={false} tipoArchivos='image/png, image/jpg, image/jpeg, .pdf' ubicacionesRequeridas={ubicacionIdentidadRef} subDirectorio={state.id} tabla='personas' nombreCampo='identidad' campoUbicaciones='ubicacion_identidad' campoContador='contador_identidad' id={state.id} contadorArchivos={contadorIdentidad} actualizarMensajeError={actualizarMensajeErrorIdentidad} etiqueta={t('texto_62')} etiqueta2={t('texto_127')} />
                              {errorIdentidad}
                            </Grid>
                        }
                        {
                          mostrarRecSueldo && 
                            <Grid key={'2'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                              <CargarArchivosServidor control={control} multiplesArchivos={true} tipoArchivos='image/png, image/jpg, image/jpeg, .pdf' ubicacionesRequeridas={ubicacionesRecSueldoRef} subDirectorio={state.id} tabla='personas' nombreCampo='rec_sueldo' campoUbicaciones='ubicaciones_rec_sueldo' campoContador='contador_rec_sueldo' id={state.id} contadorArchivos={contadorRecSueldo} actualizarMensajeError={actualizarMensajeErrorRecSueldo} etiqueta={sueldoSeleccionado} etiqueta2={t('texto_130')} />
                              {errorRecSueldo}
                            </Grid>
                        }
                        {
                          mostrarCertIngMod &&
                            <Grid key={'3'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                              <CargarArchivosServidor control={control} multiplesArchivos={true} tipoArchivos='image/png, image/jpg, image/jpeg, .pdf' ubicacionesRequeridas={ubicacionesCertIngModRef} subDirectorio={state.id} tabla='personas' nombreCampo='cert_ing_mod' campoUbicaciones='ubicaciones_cert_ing_mod' campoContador='contador_cert_ing_mod' id={state.id} contadorArchivos={contadorCertIngMod} actualizarMensajeError={actualizarMensajeErrorCertIngMod} etiqueta={etiquetaCertIngMod} etiqueta2={etiquetaCertIngMod2} />
                              {errorCertIngMod}
                              {
                                vectorOpcionesAseguradoras[state.aseguradora+' Modelo certificacion ingresos'] && 
                                <div>
                                  <a href={vectorOpcionesAseguradoras[state.aseguradora+' Modelo certificacion ingresos']} download target="_blank">{t('texto_80')}</a>
                                </div>
                              }
                              <br />
                            </Grid>
                        }
                        {
                          mostrarDgi && 
                            <Grid key={'4'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                              <CargarArchivosServidor control={control} multiplesArchivos={true} tipoArchivos='image/png, image/jpg, image/jpeg, .pdf' ubicacionesRequeridas={ubicacionesDgiRef} subDirectorio={state.id} tabla='personas' nombreCampo='dgi' campoUbicaciones='ubicaciones_dgi' campoContador='contador_dgi' id={state.id} contadorArchivos={contadorDgi} actualizarMensajeError={actualizarMensajeErrorDgi} etiqueta={t("Última declaración jurada ante DGI o (IRPF / IRAE / IPAT / ICOSA / IVA, etc) presentada en el último año *")} etiqueta2={t('texto_129')} />
                              {errorDgi}
                            </Grid>
                        }
                        {
                          mostrarCertDgiCaja && 
                            <Grid key={'5'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                              <CargarArchivosServidor control={control} multiplesArchivos={true} tipoArchivos='image/png, image/jpg, image/jpeg, .pdf' ubicacionesRequeridas={ubicacionesCertDgiCajaRef} subDirectorio={state.id} tabla='personas' nombreCampo='cert_dgi_caja' campoUbicaciones='ubicaciones_cert_dgi_caja' campoContador='contador_cert_dgi_caja' id={state.id} contadorArchivos={contadorCertDgiCaja} actualizarMensajeError={actualizarMensajeErrorCertDgiCaja} etiqueta={t("Certificados vigentes de BPS y DGI *")} etiqueta2={t('texto_131')} />
                              {errorCertDgiCaja}
                            </Grid>
                        }
                        {
                          mostrarBalance && 
                            <Grid key={'6'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                              <CargarArchivosServidor control={control} multiplesArchivos={true} tipoArchivos='image/png, image/jpg, image/jpeg, .pdf' ubicacionesRequeridas={ubicacionesBalanceRef} subDirectorio={state.id} tabla='personas' nombreCampo='balance' campoUbicaciones='ubicaciones_balance' campoContador='contador_balance' id={state.id} contadorArchivos={contadorBalance} actualizarMensajeError={actualizarMensajeErrorBalance} etiqueta={etiquetaBalance} etiqueta2={etiquetaBalance2} />
                              {errorBalance}
                            </Grid>
                        }
                        {
                          mostrarRut && 
                            <Grid key={'7'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                              <CargarArchivosServidor control={control} multiplesArchivos={false} tipoArchivos='image/png, image/jpg, image/jpeg, .pdf' ubicacionesRequeridas={ubicacionesRutRef} subDirectorio={state.id} tabla='personas' nombreCampo='rut' campoUbicaciones='ubicaciones_rut' campoContador='contador_rut' id={state.id} contadorArchivos={contadorRut} actualizarMensajeError={actualizarMensajeErrorRut} etiqueta={t("Tarjeta RUT *")} etiqueta2={t('texto_128')} />
                              {errorRut}
                            </Grid>
                        }
                        {
                          mostrarContratoSocial && 
                            <Grid key={'8'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                              <CargarArchivosServidor control={control} multiplesArchivos={true} tipoArchivos='image/png, image/jpg, image/jpeg, .pdf' ubicacionesRequeridas={ubicacionesContratoSocialRef} subDirectorio={state.id} tabla='personas' nombreCampo='contrato_social' campoUbicaciones='ubicaciones_contrato_social' campoContador='contador_contrato_social' id={state.id} contadorArchivos={contadorContratoSocial} actualizarMensajeError={actualizarMensajeErrorContratoSocial} etiqueta={etiquetaContratoSocial} etiqueta2={etiquetaContratoSocial2} />
                              {errorContratoSocial}
                            </Grid>
                        }
                        {
                          mostrarCertUni && 
                            <Grid key={'9'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
                              <CargarArchivosServidor control={control} multiplesArchivos={true} tipoArchivos='image/png, image/jpg, image/jpeg, .pdf' ubicacionesRequeridas={ubicacionesCertUniRef} subDirectorio={state.id} tabla='personas' nombreCampo='cert_uni' campoUbicaciones='ubicaciones_cert_uni' campoContador='contador_cert_uni' id={state.id} contadorArchivos={contadorCertUni} actualizarMensajeError={actualizarMensajeErrorCertUni} etiqueta={etiquetaCertUni} etiqueta2={etiquetaCertUni} />
                              {errorCertUni}
                            </Grid>
                        }
                      </Grid>
                    </fieldset>
                    <BotonesGuardarNavegacion modalIngresosInsuficientes={modalIngresosInsuficientes} />
                  </Box>
                  <br />
                </>
            }
          </Form>
          {
            mostrarDatosFormulario == false &&
              <>
                <Cosolicitantes />
                <BotonesNavegacion modalIngresosInsuficientes={modalIngresosInsuficientes} />
              </>
          }
          {
            mensajesEncabezado == false &&
              <Stack>
                { mostrarMensajeFaltante &&
                  <>
                    <Box sx={{ lineHeight: '3rem', p : 2, marginTop : 2, backgroundColor : '#FFB76C', borderRadius : 2 }}>
                      {t('texto_136', {cantidadPersonasAdicionales : state.cantidad_personas_adicionales})}
                    </Box>
                    <Box sx={{ p : 2, marginTop : 2, marginBottom : 2, border : 'solid 1px #6D6D6D', borderRadius : 2 }}>
                      <AcordionFaltante faltante={faltante} limitePago={limitePago} costoAlquiler={costoAlquiler} />
                    </Box>
                  </>
                }
              </Stack>
          }
          <br /><br />
                    
          <ModalBasico open={modalBasico} handleClose={accionModalBasico.current} tituloModal={tituloModalBasico} contenidoModal={contenidoModalBasico} tipoAlerta={tipoAlertaModalBasico} />
          
          <ModalDialogoBasico open={modalDialogoBasico} handleClose={accionModalDialogoBasico.current} tituloModal={tituloModalDialogoBasico} contenidoModal={contenidoModalDialogoBasico} textoAccion1={textoAccion1DialogoBasico} accion1={accion1DialogoBasico.current} parametrosAccion1={parametrosAccion1DialogoBasico} textoAccion2={textoAccion2DialogoBasico} accion2={accion2DialogoBasico.current} parametrosAccion2={parametrosAccion2DialogoBasico} />

          {gifEspere}
          <div className='ra_alerta_fija'>
            {alertaFija}
          </div>
        </Box>
      </>
    );
  }

  return state.id > 0 ? <FormularioArrendatario mostrarDatosFormulario={mostrarDatosFormulario} cambiarMostrarDatosFormulario={cambiarMostrarDatosFormulario} /> : <GifEspere /> 
};