import { useState, useEffect, useRef } from 'react';
import { useAppState } from "../state";
import { datosInicio, colores } from "../vectores_objetos";
import axios from 'axios';
import { GifEspere, prepararCamposPersonas } from "../varios";
import { convertirArchivosBase64, convertirOtrosArchivosBase64 } from "../varios";
import { useTranslation } from 'react-i18next';
import { useParams, useNavigate } from "react-router-dom";
import {
  Container,
  Paper,
  Stack,
  Box,
  Typography,
  Menu,
  MenuItem,
  Button,
  Table,
  TableContainer,
  TableHead,
  TableBody,
  TableRow,
  TableCell,
  Pagination,
  Select,
  InputLabel,
  FormControl
} from '@mui/material';
import Grid from '@mui/material/Grid2';
import SquareRoundedIcon from '@mui/icons-material/SquareRounded';
import KeyboardArrowDownIcon from '@mui/icons-material/KeyboardArrowDown';
import FilterListIcon from '@mui/icons-material/FilterList';

import { 
  ModalBasico,
  ModalDialogoBasico,
  AlertaSatisfactorio,
  AlertaAviso,
  AlertaError
} from '../mui';
import { Dialog, DialogTitle, DialogContent, DialogActions, TextField, Autocomplete } from '@mui/material';

const FiltroModal = ({ open, onClose, onApply, filtrosDisponibles, filtrosSeleccionados, setFiltrosSeleccionados, filtroBtnRef }) => {
  const { t } = useTranslation();
  const [localFiltros, setLocalFiltros] = useState(filtrosSeleccionados);

  useEffect(() => {
    setLocalFiltros(filtrosSeleccionados);
  }, [filtrosSeleccionados]);

  const handleFiltroChange = (filterName, value) => {
    setLocalFiltros(prev => ({ ...prev, [filterName]: value }));
  };

  const handleApply = () => {
    setFiltrosSeleccionados(localFiltros);
    onApply();
  };

  const handleClose = () => {
    onClose();
    if (filtroBtnRef.current) {
      filtroBtnRef.current.focus();
    }
  };

  const estatusOptions = [
    { value: 'Todos', label: 'Todos' },
    { value: 'Borrador', label: 'Borrador' },
    { value: 'Paso 5', label: 'Enviado' },
    { value: 'Paso 6', label: 'En revisión' },
    { value: 'Paso 7.1', label: 'Esperando datos del contrato' },
    { value: 'Paso 7.2', label: 'Rechazada' },
    { value: 'Paso 8', label: 'Esperando carga del inventario' },
    { value: 'Paso 9', label: 'Esperando firma del contrato' },
    { value: 'Paso 10', label: 'Esperando pago' },
    { value: 'Paso 11', label: 'Proceso finalizado' },
  ];

  return (
    <Dialog open={open} onClose={handleClose} fullWidth maxWidth="sm">
      <DialogTitle>Filtros de Búsqueda</DialogTitle>
      <DialogContent>
        <Stack spacing={2} sx={{ mt: 2 }}>
          <TextField
            id="filtro-id-garantia"
            label={t("ID de la Garantía")}
            type="number"
            value={localFiltros.id}
            onChange={(e) => handleFiltroChange('id', e.target.value)}
            fullWidth
            InputLabelProps={{
              shrink: true,
            }}
          />
          <Autocomplete
            id="filtro-agencia-agente"
            value={localFiltros.agencia_agente}
            onChange={(event, newValue) => {
              handleFiltroChange('agencia_agente', newValue || 'Todos');
            }}
            options={['Todos', ...filtrosDisponibles.agencias_agentes]}
            fullWidth
            renderInput={(params) => <TextField {...params} label={t("Agencia/Agente")} />}
          />
          <Autocomplete
            id="filtro-arrendatario"
            value={localFiltros.arrendatario}
            onChange={(event, newValue) => {
              handleFiltroChange('arrendatario', newValue || 'Todos');
            }}
            options={['Todos', ...filtrosDisponibles.arrendatarios]}
            fullWidth
            renderInput={(params) => <TextField {...params} label={t("Arrendatario")} />}
          />
          <Autocomplete
            id="filtro-propietario"
            value={localFiltros.propietario}
            onChange={(event, newValue) => {
              handleFiltroChange('propietario', newValue || 'Todos');
            }}
            options={['Todos', ...filtrosDisponibles.propietarios]}
            fullWidth
            renderInput={(params) => <TextField {...params} label={t("Propietario")} />}
          />
          <Autocomplete
            id="filtro-aseguradora"
            value={localFiltros.aseguradora}
            onChange={(event, newValue) => {
              handleFiltroChange('aseguradora', newValue || 'Todos');
            }}
            options={['Todos', ...filtrosDisponibles.aseguradoras]}
            fullWidth
            renderInput={(params) => <TextField {...params} label={t("Aseguradora")} />}
          />
          <FormControl fullWidth>
            <InputLabel id="estatus-select-label-modal">{t("Estatus")}</InputLabel>
            <Select
              labelId="estatus-select-label-modal"
              value={localFiltros.estatus}
              label={t("Estatus")}
              onChange={(e) => handleFiltroChange('estatus', e.target.value)}
            >
              {estatusOptions.map((option) => (
                <MenuItem key={option.value} value={option.value}>
                  {option.label}
                </MenuItem>
              ))}
            </Select>
          </FormControl>
        </Stack>
      </DialogContent>
      <DialogActions>
        <Button onClick={handleClose}>{t("Cancelar")}</Button>
        <Button onClick={handleApply} variant="contained">{t("Aplicar Filtros")}</Button>
      </DialogActions>
    </Dialog>
  );
};

export const Indice = () => {
  const { t } = useTranslation();
  const [state, setState] = useAppState();
  const [inicioPantalla, setInicioPantalla] = useState('');
  const [formulario, setFormulario ] = useState('');
  const [gifEspere, setGifEspere] = useState(<GifEspere />);
  const [alertaFija, setAlertaFija] = useState('');
  const navigate = useNavigate();
  const { origen } = useParams();
  const [mensajesUsuario, setMensajesUsuario] = useState('');

  const [modalBasico, setModalBasico] = useState(false);
  const accionModalBasico = useRef();
  const [tituloModalBasico, setTituloModalBasico] = useState(false);
  const [contenidoModalBasico, setContenidoModalBasico] = useState(false);

  const [modalDialogoBasico, setModalDialogoBasico] = useState(false);
  const accionModalDialogo = useRef();
  const [tituloModalDialogo, setTituloModalDialogo] = useState('');
  const [contenidoModalDialogo, setContenidoModalDialogo] = useState('');
  const [textoAccion1Dialogo, setTextoAccion1Dialogo] = useState('');
  const accion1Dialogo = useRef('');
  const [parametrosAccion1Dialogo, setParametrosAccion1Dialogo] = useState('');
  const [textoAccion2Dialogo, setTextoAccion2Dialogo] = useState('');
  const accion2Dialogo = useRef('');
  const [parametrosAccion2Dialogo, setParametrosAccion2Dialogo] = useState('');

  // Estados para la paginación
  const [garantias, setGarantias] = useState([]);
  const [metaPaginacion, setMetaPaginacion] = useState(null);
  const [currentPage, setCurrentPage] = useState(1);
  const [perPage, setPerPage] = useState(20);

  // Estados para los filtros
  const [modalFiltroOpen, setModalFiltroOpen] = useState(false);
  const [filtrosDisponibles, setFiltrosDisponibles] = useState({ agencias_agentes: [], arrendatarios: [], propietarios: [], aseguradoras: [] });
  const [filtrosSeleccionados, setFiltrosSeleccionados] = useState({
    id: '',
    estatus: 'Todos',
    agencia_agente: 'Todos',
    arrendatario: 'Todos',
    propietario: 'Todos',
    aseguradora: 'Todos',
  });

  // Variables de Ref
  const usuarioAdministrador = useRef('Sí');
  const agenciaId = useRef(2);
  const agenteId = useRef(2);
  const rolUsuarioConectado = useRef(3);
  const tokenLaravel = useRef('');
  const archivoObjeto = useRef('');
  const personasArchivosRef = useRef('');
  const archivosInventarioObjeto = useRef('');
  const archivosInventarioRef = useRef('');
  const archivosContratoFirmadoObjeto = useRef('');
  const archivosContratoFirmadoRef = useRef('');
  const personas = useRef({});
  const urlAlmacenamiento = useRef('http://localhost/ofiliaria/backend_ofiliaria/public/storage/');


  const filtroBtnRef = useRef(null);

  // Declaración de la función `nuevaGarantia`
  const nuevaGarantia = async () => {
    await setState({
      ...state,
      token_laravel : tokenLaravel.current,
      usuario_administrador : usuarioAdministrador.current,
      agencia_id : agenciaId.current,
      agente_id : agenteId.current,
      rol_usuario_conectado : rolUsuarioConectado.current,
      url_almacenamiento : urlAlmacenamiento.current
    });
    navigate('/seleccionar-aseguradora/0');
  }

  useEffect(() => {( async () => {
    if (state.aseguradora !== '')
    {
      setState(datosInicio);
    }
    if (state.ambiente === 'Producción')
    {
      verificarUsuarioConectado();
    }
    else
    {
      console.log('Indice, desarrollo');
      if (state.login_desarrollo === true)
      {
        await obtenerTokenDesarrollo();
      }
      else
      {
        tokenLaravel.current = state.token_laravel;
        await obtenerGarantias(currentPage, perPage, origen ? origen : 99);
      }
      setInicioPantalla(window.scrollTo(0,0));
    }
  })();},[currentPage, perPage, origen, state.ambiente, state.login_desarrollo, state.token_laravel, filtrosSeleccionados]);


  const obtenerTokenDesarrollo = async () => {
    let email = state.email_desarrollo;
    let password = state.password_desarrollo;
    try {
      setGifEspere(<GifEspere />);
      const respuesta = await axios.post(state.endpoint+'/login', {},
        {
          auth: {
            username: email,
            password: password
          }
        }
      );
      setGifEspere('');
      if (respuesta.data.codigo_respuesta === 0)
      {
        tokenLaravel.current = respuesta.data.token;
        await obtenerGarantias(currentPage, perPage, origen ? origen : 99);
        setAlertaFija(<AlertaSatisfactorio texto={t('texto_153')} />);
        setTimeout(() => {
          setAlertaFija('');
        }, 10000);
      }
      else
      {
        setAlertaFija(<AlertaError texto={t('texto_154')} />);
        setTimeout(() => {
          setAlertaFija('');
        }, 10000);
      }
    } catch (error) {
      setGifEspere('');
      setAlertaFija(<AlertaError texto={t('texto_155')} />);
      setTimeout(() => {
        setAlertaFija('');
      }, 10000);
      console.error('Error en el servidor al obtener token:', error);
    }
  }

  const verificarUsuarioConectado = async () => {
    console.log('verificarUsuarioConectado, inicio de la función');
    const ajaxUrlReact = typeof variables_php_javascript !== 'undefined' ? variables_php_javascript.ajax_url : '/wp-admin/admin-ajax.php';
    var params = new URLSearchParams();
    params.append('action', 'verificar_usuario_conectado');
    try {
      setGifEspere(<GifEspere />);
      const respuesta = await axios.post(ajaxUrlReact, params);
      setGifEspere('');
      if (respuesta.data.codigo_retorno === 0)
      {
        usuarioAdministrador.current = respuesta.data.usuario_administrador;
        agenciaId.current = respuesta.data.id_usuario_agencia;
        agenteId.current = respuesta.data.id_usuario_conectado;
        rolUsuarioConectado.current = respuesta.data.rol_usuario_conectado;
        tokenLaravel.current = respuesta.data.token_laravel;
        console.log('verificarUsuarioConectado, respuesta.data', respuesta.data);

        if (agenteId.current < 1 || rolUsuarioConectado.current < 2)
        {
          modalPermisosInsuficientes();
        }
        else
        {
          await obtenerGarantias(currentPage, perPage, origen ? origen : 99);
          setInicioPantalla(window.scrollTo(0,0));
        }
      }
      else if (respuesta.data.codigo_retorno === 2)
      {
        modalEmailExistente(respuesta.data.email_existente);
      }
      else
      {
        modalLogin();
      }
    } catch (error) {
      modalAcceso();
      console.error('Error al verificar usuario conectado:', error);
    };
  }

  const obtenerGarantias = async (page = 1, per_page = 20, desde = 0) => {
    console.log('obtenerGarantias, inicio de la función');
    if (tokenLaravel.current === '') {
      setGarantias([]);
      setMetaPaginacion(null);
      setFormulario(<ListadoGarantias garantias={[]} meta={null} onPageChange={handlePageChange} nuevaGarantia={nuevaGarantia} />);
      return;
    }

    try {
      setGifEspere(<GifEspere />);
      
      let queryParams = `?usuarioAdministrador=${usuarioAdministrador.current}&agenciaId=${agenciaId.current}&agenteId=${agenteId.current}&rolUsuarioConectado=${rolUsuarioConectado.current}&page=${page}&per_page=${per_page}`;
      
      Object.entries(filtrosSeleccionados).forEach(([key, value]) => {
        if (value && value !== 'Todos') {
          queryParams += `&${key}=${encodeURIComponent(value)}`;
        }
      });

      const respuesta = await axios.get(
        `${state.endpoint}/garantias${queryParams}`,
        {
          headers: {
            'Authorization': `Bearer ${tokenLaravel.current}`
          }
        }
      );

      console.log(respuesta.data);
      setGifEspere('');

      if (state.ambiente === 'Producción') {
        urlAlmacenamiento.current = respuesta.data.urlBaseAWS;
      }

      if (respuesta.data.codigoRetorno === 0) {
        setGarantias(respuesta.data.garantias);
        setMetaPaginacion(respuesta.data.meta);
        setCurrentPage(respuesta.data.meta.current_page);
        if(respuesta.data.filtros) {
          setFiltrosDisponibles(respuesta.data.filtros);
        }

        setFormulario(
          <ListadoGarantias
            garantias={respuesta.data.garantias}
            meta={respuesta.data.meta}
            onPageChange={handlePageChange}
            nuevaGarantia={nuevaGarantia}
            openFiltroModal={() => setModalFiltroOpen(true)}
          />
        );

        if (desde === 0) {
          setAlertaFija(<AlertaSatisfactorio texto={t("Los datos de la garantía se registraron exitosamente")} />);
          setTimeout(() => {
            setAlertaFija('');
          }, 10000);
        } else if (desde === 1) {
          setAlertaFija(<AlertaAviso texto={t("Los datos de la garantía se registraron exitosamente, pero más tarde debe agregar uno o más codeudores")} />);
          setTimeout(() => {
            setAlertaFija('');
          }, 10000);
        }
      } else {
        setGarantias([]);
        setMetaPaginacion(null);
        if(respuesta.data.filtros) {
          setFiltrosDisponibles(respuesta.data.filtros);
        }
        setFormulario(<ListadoGarantias garantias={[]} meta={null} onPageChange={handlePageChange} nuevaGarantia={nuevaGarantia} openFiltroModal={() => setModalFiltroOpen(true)} />);
        if (desde === 3) {
          setTimeout(() => {
            setAlertaFija(<AlertaError texto={t('No se encontraron garantías')} />);
          }, 1000);
          setTimeout(() => {
            setAlertaFija('');
          }, 11000);
        } else {
          setAlertaFija(<AlertaError texto={t('No se encontraron garantías')} />);
          setTimeout(() => {
            setAlertaFija('');
          }, 10000);
        }
      }

    } catch (error) {
      setGifEspere('');
      setGarantias([]);
      setMetaPaginacion(null);
      setFormulario(<ListadoGarantias garantias={[]} meta={null} onPageChange={handlePageChange} nuevaGarantia={nuevaGarantia} openFiltroModal={() => setModalFiltroOpen(true)} />);
      setAlertaFija(<AlertaError texto={t("Hubo un error en el servidor")} />);
      setTimeout(() => {
        setAlertaFija('');
      }, 10000);
      console.error('Error en el servidor al obtener garantías:', error);
    }
  };

  const handlePageChange = (event, value) => {
    setCurrentPage(value);
  };

  const handleApplyFiltros = () => {
    setCurrentPage(1); // Resetea a la primera página al aplicar filtros
    setModalFiltroOpen(false);
    // El useEffect se encargará de volver a llamar a obtenerGarantias
  };


  const obtenerLaGarantia = async (idGarantia) => {
    setGifEspere(<GifEspere />);
    try {
      const respuesta = await axios.get(state.endpoint+'/garantias/show/'+idGarantia, {
        headers: {
          'Authorization': `Bearer ${tokenLaravel.current}`
        }
      });
      setGifEspere('');
      if (respuesta.data.codigoRetorno === 0)
      {
        console.log('obtenerLaGarantia, respuesta.data', respuesta.data);
        let propiedadRegistrada = '';
        if (respuesta.data.garantia.propiedad_id > 0)
        {
          propiedadRegistrada = 'si_registrada';
        }
        else
        {
          propiedadRegistrada = 'no_registrada';
        }

        let enRevision = false;
        let aprobacionGarantia = '';

        if (respuesta.data.garantia.nombre_propiedad === null)
        {
          respuesta.data.garantia.nombre_propiedad = '';
        }

        if (respuesta.data.garantia.numero_identidad_propiedad === null)
        {
          respuesta.data.garantia.numero_identidad_propiedad = '';
        }

        if (respuesta.data.garantia.tipo_propiedad === null)
        {
          respuesta.data.garantia.tipo_propiedad = '';
        }

        if (respuesta.data.garantia.direccion_propiedad === null)
        {
          respuesta.data.garantia.direccion_propiedad = '';
        }

        if (respuesta.data.garantia.moneda_propiedad === null)
        {
          respuesta.data.garantia.moneda_propiedad = '';
        }

        if (respuesta.data.garantia.tipo_contrato === null)
        {
          respuesta.data.garantia.tipo_contrato = '';
        }

        if (respuesta.data.garantia.fecha_inicio_alquiler === null)
        {
          respuesta.data.garantia.fecha_inicio_alquiler = '';
        }

        if (respuesta.data.garantia.plazo_alquiler === null)
        {
          respuesta.data.garantia.plazo_alquiler = '';
        }

        if (respuesta.data.garantia.tipo_plazo_alquiler === null)
        {
          respuesta.data.garantia.tipo_plazo_alquiler = '';
        }

        if (respuesta.data.garantia.tipo_pago_alquiler === null)
        {
          respuesta.data.garantia.tipo_pago_alquiler = '';
        }

        if (respuesta.data.garantia.regimen_ajuste_alquiler === null)
        {
          respuesta.data.garantia.regimen_ajuste_alquiler = '';
        }

        if (respuesta.data.garantia.departamento_firma === null)
        {
          respuesta.data.garantia.departamento_firma = '';
        }

        if (respuesta.data.garantia.ciudad_firma === null)
        {
          respuesta.data.garantia.ciudad_firma = '';
        }

        if (respuesta.data.garantia.terminos_condiciones === null)
        {
          respuesta.data.garantia.terminos_condiciones = '';
        }

        if (respuesta.data.garantia.banco === null)
        {
          respuesta.data.garantia.banco = '';
        }

        if (respuesta.data.garantia.numero_sucursal_banco === null)
        {
          respuesta.data.garantia.numero_sucursal_banco = '';
        }

        if (respuesta.data.garantia.nombres_titular_cuenta === null)
        {
          respuesta.data.garantia.nombres_titular_cuenta = '';
        }

        if (respuesta.data.garantia.apellidos_titular_cuenta === null)
        {
          respuesta.data.garantia.apellidos_titular_cuenta = '';
        }

        if (respuesta.data.garantia.moneda === null)
        {
          respuesta.data.garantia.moneda = '';
        }

        if (respuesta.data.garantia.numero_cuenta === null)
        {
          respuesta.data.garantia.numero_cuenta = '';
        }

        if (respuesta.data.garantia.tipo_cuenta === null)
        {
          respuesta.data.garantia.tipo_cuenta = '';
        }

        if (respuesta.data.garantia.notas_garantia === null)
        {
          respuesta.data.garantia.notas_garantia = '';
        }

        if (respuesta.data.garantia.tipo_inventario === null)
        {
          respuesta.data.garantia.tipo_inventario = '';
        }

        if (respuesta.data.garantia.descripcion_inventario === null)
        {
          respuesta.data.garantia.descripcion_inventario = '';
        }

        if (respuesta.data.garantia.observaciones_inventario === null)
        {
          respuesta.data.garantia.observaciones_inventario = '';
        }

        let personasPreparadas = prepararCamposPersonas(respuesta.data.personas);
        respuesta.data.personas = personasPreparadas;

        await setState({
          ...state,
          ...respuesta.data.garantia,
          propiedad_registrada : propiedadRegistrada,
          costo_alquiler : parseInt(respuesta.data.garantia.costo_alquiler),
          ...respuesta.data.personas[0],
          edicion_garantia : true,
          url_almacenamiento : urlAlmacenamiento.current,
          usuario_administrador : usuarioAdministrador.current,
          agencia_id : agenciaId.current,
          agente_id : agenteId.current,
          rol_usuario_conectado : rolUsuarioConectado.current,
          token_laravel : tokenLaravel.current,
          en_revision : enRevision,
          aprobacion_garantia : aprobacionGarantia,
          conversion_archivos: true,
          personas : respuesta.data.personas
        });
      }
      else
      {
        setAlertaFija(<AlertaError texto={t('texto_165')} />);
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
      console.error('Error en el servidor al obtener una garantía específica:', error);
    }
  };

  const irAlInicio = () => {
    navigate('/');
  }

  const eliminarGarantia = async (id) => {
    setGifEspere(<GifEspere />);
    try {
      const respuesta = await axios.post(state.endpoint+'/garantias/destroy/'+id, {}, { headers: { 'Authorization': `Bearer ${tokenLaravel.current}`, "Content-Type": "application/json", "Accept" :  "application/json"} });

      setGifEspere('');
      if (respuesta.data.codigoRetorno === 0)
      {
        setAlertaFija(<AlertaSatisfactorio texto={t("La garantía fue eliminada exitosamente")} />);
        setTimeout(() => {
          setAlertaFija('');
        }, 10000);
        await obtenerGarantias(currentPage, perPage, origen ? origen : 99);
      }
      else
      {
        setAlertaFija(<AlertaError texto={t("No se pudo eliminar la garantía")} />);
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
      console.error('Error en el servidor al eliminar garantía:', error);
    }
    cerrarModalDialogoBasico();
  }

  const cerrarModalBasico = () => {
    setModalBasico(false);
  }

  const cerrarModalDialogoBasico = () => {
    setModalDialogoBasico(false);
  }

  const modalEliminarGarantia = (id) => {
    const garantia = garantias.find(g => g.id === id);
    
    console.log("Indice, validando que exista el nombre");

    // 1. Validamos si existen los datos del arrendatario
    // .trim() elimina espacios en blanco accidentales
    const nombreCompleto = (garantia?.nombres_arrendatario || '').trim() + ' ' + (garantia?.apellidos_arrendatario || '').trim();
    
    // 2. Si el resultado es un string vacío, usamos el valor por defecto
    const nombreArrendatario = nombreCompleto.trim() 
      ? nombreCompleto 
      : t("Arrendatario aún no registrado");
  
    accionModalDialogo.current = cerrarModalDialogoBasico;
    setTituloModalDialogo(t("Eliminar Garantía"));
    
    // 3. Pasamos la variable ya procesada
    setContenidoModalDialogo(
      t("¿Está seguro de que desea eliminar la garantía de {{arrendatario}}?", { arrendatario: nombreArrendatario })
    );
  
    setTextoAccion1Dialogo(t('texto_113'));
    accion1Dialogo.current = eliminarGarantia;
    setParametrosAccion1Dialogo(id);
    
    setTextoAccion2Dialogo(t('texto_114'));
    accion2Dialogo.current = cerrarModalDialogoBasico;
    setParametrosAccion2Dialogo(id);
    
    setModalDialogoBasico(true);
  };  

  const modalLogin = () => {
    setTituloModalBasico(t('texto_115'));
    accionModalBasico.current = irAlInicio;
    setContenidoModalBasico(t('texto_121'));
    setModalBasico(true);
    setGifEspere('');
  }

  const modalAcceso = () => {
    setTituloModalBasico(t('texto_115'));
    accionModalBasico.current = irAlInicio;
    setContenidoModalBasico(t('texto_116'));
    setModalBasico(true);
    setGifEspere('');
  }

  const modalPermisosInsuficientes = () => {
    setTituloModalBasico(t('texto_118'));
    accionModalBasico.current = irAlInicio;
    setContenidoModalBasico(t('texto_119'));
    setModalBasico(true);
  }

  const modalPermisosTramitacion = () => {
    setTituloModalBasico(t('texto_118'));
    accionModalBasico.current = cerrarModalBasico;
    setContenidoModalBasico(t('texto_191'));
    setModalBasico(true);
  }

  const modalGarantiaNoEnviada = () => {
    setTituloModalBasico(t('texto_189'));
    accionModalBasico.current = cerrarModalBasico;
    setContenidoModalBasico(t('texto_190'));
    setModalBasico(true);
  }

  const irAlPerfil = () => {
    const origin = window.location.origin;
    let urlPerfil = '';
    
    if (origin === 'https://ofiliaria.com.uy') {
        urlPerfil = 'https://ofiliaria.com.uy/dashboard-perfil/';
    } 
    else if (origin === 'https://dev.ofiliaria.com') {
        urlPerfil = 'https://dev.ofiliaria.com/dashboard-perfil/';
    } 
    else {
        urlPerfil = `${origin}/ofiliaria/wordpress/dashboard-perfil/`;
    }
    window.location.href = urlPerfil;
  }

  const modalGarantiaRechazada = (garantia) => {
    setTituloModalBasico(t('texto_217'));
    accionModalBasico.current = cerrarModalBasico;
    setContenidoModalBasico(t('texto_218', {motivoRechazoGarantia : garantia.notas_garantia }));
    setModalBasico(true);
  }

  const modalEmailExistente = (email) => {
    setTituloModalBasico(t('texto_354'));
    accionModalBasico.current = irAlPerfil;
    setContenidoModalBasico(<Typography variant="subtitle1" sx={{ fontSize: '16px' }}>{t('texto_355', { email: email })}</Typography>);
    setModalBasico(true);
    setGifEspere('');
  }

  const detalleGarantia = async (idGarantia) => {
    await obtenerLaGarantia(idGarantia);
    navigate('/detalle-garantia/'+idGarantia);
  }

  const editarGarantia = async (idGarantia) => {
    await obtenerLaGarantia(idGarantia);
    navigate('/seleccionar-aseguradora/'+idGarantia)
  }

  const tramitar = async (garantia) => {
    let vectorPasos = garantia.estatus_garantia.split(',');
    let pasoActual = vectorPasos[0];
    const id = garantia.id;
    switch (pasoActual) {
      case 'Paso 1':
      case 'Paso 2':
      case 'Paso 3':
      case 'Paso 4':
        modalGarantiaNoEnviada();
        break;
      case 'Paso 5':
        await obtenerLaGarantia(id);
        navigate('/garantia-enviada/'+id)
        break;
      case 'Paso 6':
        await obtenerLaGarantia(id);
        navigate('/revision-garantia/'+id)
        break;
      case 'Paso 7.1':
        await obtenerLaGarantia(id);
        navigate('/contrato-garantia/'+id);
        break;
      case 'Paso 7.2':
        modalGarantiaRechazada(garantia);
        break;
      case 'Paso 8':
        await obtenerLaGarantia(id);
        navigate('/inventario-garantia/'+id)
        break;
      case 'Paso 9':
        await obtenerLaGarantia(id);
        navigate('/firma-contrato/'+id)
        break;
      case 'Paso 10':
        await obtenerLaGarantia(id);
        navigate('/pago-garantia/'+id)
        break;
      case 'Paso 11':
        await obtenerLaGarantia(id);
        navigate('/pago-garantia/'+id)
        break;
    }
  }

  const BasicMenu = ({garantia}) => {
    const [anchorEl, setAnchorEl] = useState(null);
    const open = Boolean(anchorEl);
    const handleClick = (event) => {
      setAnchorEl(event.currentTarget);
    };
    const handleClose = () => {
      setAnchorEl(null);
    };

    let accesoEdicion = false;
    if (usuarioAdministrador.current === 'Sí')
    {
      accesoEdicion = true;
    }
    else
    {
      let vectorEstatusGarantia = garantia.estatus_garantia.split(',');
      if (vectorEstatusGarantia[0] === 'Paso 1' || vectorEstatusGarantia[0] === 'Paso 2' || vectorEstatusGarantia[0] === 'Paso 3' || vectorEstatusGarantia[0] === 'Paso 4' || vectorEstatusGarantia[0] === 'Paso 7.2')
      {
        accesoEdicion = true;
      }
    }

    let accesoTramitacion = false;
    if (usuarioAdministrador.current === 'Sí')
    {
      accesoTramitacion = true;
    }
    else
    {
      let vectorEstatusGarantia = garantia.estatus_garantia.split(',');
      if (vectorEstatusGarantia[0] === 'Paso 7.1' || vectorEstatusGarantia[0] === 'Paso 8' || vectorEstatusGarantia[0] === 'Paso 9' || vectorEstatusGarantia[0] === 'Paso 10')
      {
        accesoTramitacion = true;
      }
    }

    let accesoEliminar = false;
    if (usuarioAdministrador.current === 'Sí')
    {
      accesoEliminar = true;
    }
    else
    {
      let vectorEstatusGarantia = garantia.estatus_garantia.split(',');
      if (vectorEstatusGarantia[0] === 'Paso 1' || vectorEstatusGarantia[0] === 'Paso 2' || vectorEstatusGarantia[0] === 'Paso 3' || vectorEstatusGarantia[0] === 'Paso 4' || vectorEstatusGarantia[0] === 'Paso 7.2')
      {
        accesoEliminar = true;
      }
    }

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
          <MenuItem onClick={() => { detalleGarantia(garantia.id) }}>{t('texto_162')}</MenuItem>
          {
            accesoEdicion &&
              <MenuItem onClick={() => { editarGarantia(garantia.id) }}>{t('texto_161')}</MenuItem>
          }
          {
            accesoTramitacion &&
              <MenuItem onClick={() => { tramitar(garantia) }}>{t('texto_166')}</MenuItem>
          }
          {
            accesoEliminar &&
              <MenuItem onClick={() => { modalEliminarGarantia(garantia.id) }}>{t('texto_163')}</MenuItem>
          }
        </Menu>
      </div>
    );
  }

  const ListadoGarantias = ({ garantias, meta, onPageChange, nuevaGarantia, openFiltroModal }) => {
    const prepararColumnaNombre = (garantia) => {
      if (garantia.tipo_persona === null)
      {
        return 'Por completar';
      }
      else
      {
        if (garantia.tipo_persona === 'Empresa')
        {
          return garantia.empresa === null ? 'Por completar' : garantia.empresa;
        }
        else
        {
          return garantia.nombres_arrendatario === null ? 'Por completar' : garantia.nombres_arrendatario+' '+garantia.apellidos_arrendatario
        }
      }
    }

    // --- CAMBIO CLAVE: Agregamos "ID" al inicio de los encabezados
    const encabezados = [t("ID"), t("Agencia/ agente"), t("Arrendatario/ Propietario"), t("Propiedad"), t("Aseguradora"), t("Monto"), t("Estado"), t("Acciones")];

    const vectorColores = colores();

    console.log('Indice, state', state);

    return (
      <Box component={Paper} elevation={12} sx={{ p : 2, borderRadius : 3 }}>
        <Grid container sx={{width : '100%'}}>
          <Grid key={'1'} size={{ xs : 12, sm : 12, md : 12, lg : 12, xl : 12 }}>
            <Typography>{state.version}</Typography>
          </Grid>
          <Grid key={'2'} size={{ xs : 12, sm : 12, md : 12, lg : 12, xl : 12 }} sx={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', flexWrap: 'wrap' }}>
            <Button size="large" variant="contained" onClick={nuevaGarantia}>{t("Nueva garantía")}</Button>
            <Button size="large" variant="outlined" startIcon={<FilterListIcon />} onClick={openFiltroModal} ref={filtroBtnRef}>
              {t("Filtrar")}
            </Button>
          </Grid>
        </Grid>
        <div className='ra_tabla_escritorio'>
          <br />
          <TableContainer>
            <Table sx={{ minWidth: 650 }} aria-label="simple table">
              <TableHead>
                <TableRow>
                  {encabezados.map((encabezado, indice) => (
                    <TableCell 
                      key={indice} 
                      align="left"
                      sx={{}}
                    >
                      {encabezado}
                    </TableCell>
                  ))}
                </TableRow>
              </TableHead>
              <TableBody>
                {
                  garantias.map((garantia) => {
                    let nombreArrendatario = prepararColumnaNombre(garantia);
                    let costoAlquiler = new Intl.NumberFormat("es-UY").format(parseInt(garantia.costo_alquiler));
                    let vectorEstatusGarantia = garantia.estatus_garantia.split(',');
                    let colorEstatus = vectorColores['Color '+vectorEstatusGarantia[0]];
                    return (
                      <TableRow
                        key={garantia.id}
                        sx={{ '&:last-child td, &:last-child th': { border: 0 } }}
                      >
                        <TableCell align="left">{garantia.id}</TableCell>
                        <TableCell align="left">{garantia.agencia_agente_nombre || 'N/A'}</TableCell>
                        <TableCell align="left">{nombreArrendatario}{garantia.nombre_propietario ? `/ ${garantia.nombre_propietario}` : ''}</TableCell>
                        <TableCell align="left">{garantia.nombre_propiedad === null ? 'Por completar' : garantia.nombre_propiedad}</TableCell>
                        <TableCell align="left">{garantia.aseguradora}</TableCell>
                        <TableCell align="left">{costoAlquiler}</TableCell>
                        <TableCell align="left"><div style={{display : 'flex', alignItems : 'center'}}><SquareRoundedIcon sx={{color : colorEstatus}}/>{vectorEstatusGarantia[1]}</div></TableCell>
                        <TableCell align="left">
                          <BasicMenu garantia={garantia}/>
                        </TableCell>
                      </TableRow>
                    );
                  })
                }
              </TableBody>
            </Table>
          </TableContainer>
          {meta && meta.last_page > 1 && (
            <Box sx={{ display: 'flex', justifyContent: 'center', mt: 3, mb: 2 }}>
              <Pagination
                count={meta.last_page}
                page={meta.current_page}
                onChange={onPageChange}
                color="primary"
                showFirstButton
                showLastButton
              />
            </Box>
          )}
        </div>
        <div className="ra_tabla_movil">
          <br />
          {
            garantias.map((garantia) => {
              let nombreArrendatario = prepararColumnaNombre(garantia);
              let costoAlquiler = new Intl.NumberFormat("es-UY").format(parseInt(garantia.costo_alquiler));
              let vectorEstatusGarantia = garantia.estatus_garantia.split(',');
              let colorEstatus = vectorColores['Color ' + vectorEstatusGarantia[0]] || 'grey';
              return (
                <Box key={garantia.id} component={Paper} elevation={12} sx={{ p : 2, marginBottom : 2, borderRadius : 3}}>
                  <Typography variant="h3" sx={{marginBottom : '0.5rem'}}>{nombreArrendatario}{garantia.nombre_propietario ? `/ ${garantia.nombre_propietario}` : ''}</Typography>
                  <Typography variant="body2" color="text.secondary">
                    **Agencia/Agente:** {garantia.agencia_agente_nombre || 'N/A'}
                  </Typography>
                  <div className='ra_flex_tabla_movil'>
                    <div className='ra_flex_simple'>
                      {garantia.nombre_propiedad === null ? 'Por completar' : garantia.nombre_propiedad}
                    </div>
                  </div>
                  <div className='ra_flex_tabla_movil'>
                    <div className='ra_flex_doble'>
                      {garantia.aseguradora}
                    </div>
                    <div className='ra_flex_doble'>
                      {costoAlquiler}
                    </div>
                  </div>
                  <div className='ra_flex_tabla_movil'>
                    <div className='ra_flex_doble'>
                      <div style={{display : 'flex', alignItems : 'center'}}>
                        <SquareRoundedIcon sx={{color : colorEstatus}}/>{vectorEstatusGarantia[1]}
                      </div>
                    </div>
                    {/* --- AÑADIDO: ID de la garantía en la vista móvil --- */}
                    <div className='ra_flex_doble'>
                        **ID:** {garantia.id}
                    </div>
                    {/* ------------------------------------------------ */}
                  </div>
                  <div className='ra_flex_tabla_movil'>
                    <div className='ra_flex_simple'>
                      <BasicMenu garantia={garantia}/>
                    </div>
                  </div>
                </Box>
              );
            })
          }
          {meta && meta.last_page > 1 && (
            <Box sx={{ display: 'flex', justifyContent: 'center', mt: 3, mb: 2 }}>
              <Pagination
                count={meta.last_page}
                page={meta.current_page}
                onChange={onPageChange}
                color="primary"
                showFirstButton
                showLastButton
              />
            </Box>
          )}
        </div>
      </Box>
    );
  }

  return(
    <>
      {inicioPantalla}
      <Box sx={{ marginTop : '1rem'}} >
        {mensajesUsuario}
      </Box>
      {formulario}
      <FiltroModal 
        open={modalFiltroOpen} 
        onClose={() => setModalFiltroOpen(false)} 
        onApply={handleApplyFiltros}
        filtrosDisponibles={filtrosDisponibles}
        filtrosSeleccionados={filtrosSeleccionados}
        setFiltrosSeleccionados={setFiltrosSeleccionados}
        filtroBtnRef={filtroBtnRef}
      />
      <ModalBasico open={modalBasico} handleClose={accionModalBasico.current} tituloModal={tituloModalBasico} contenidoModal={contenidoModalBasico} />
      <ModalDialogoBasico open={modalDialogoBasico} handleClose={accionModalDialogo.current} tituloModal={tituloModalDialogo} contenidoModal={contenidoModalDialogo} textoAccion1={textoAccion1Dialogo} accion1={accion1Dialogo.current} parametrosAccion1={parametrosAccion1Dialogo} textoAccion2={textoAccion2Dialogo} accion2={accion2Dialogo.current} parametrosAccion2={parametrosAccion2Dialogo} />
      {gifEspere}
      <div className='ra_alerta_fija'>
        {alertaFija}
      </div>
    </>
  );
}
