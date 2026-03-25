import { useState, useRef, useEffect } from 'react';
import { styled } from '@mui/material/styles';
import ExpandMoreIcon from '@mui/icons-material/ExpandMore';
import MuiAccordion from '@mui/material/Accordion';
import MuiAccordionSummary from '@mui/material/AccordionSummary';
import MuiAccordionDetails from '@mui/material/AccordionDetails';
import { useTranslation } from 'react-i18next';
import {
  Typography,
  Button,
  Stack
  } from '@mui/material';
import Grid from '@mui/material/Grid2';
import PictureAsPdfIcon from '@mui/icons-material/PictureAsPdf';
import { useAppState } from "../state";
import { 
  ModalBasico, 
  ModalDialogoBasico,
  AlertaSatisfactorio,
  AlertaAviso,
  AlertaError
} from '../mui';
import { GifEspere } from "../varios";
import axios from 'axios';

const Accordion = styled((props) => (
  <MuiAccordion disableGutters elevation={0} square {...props} />
))(({ theme }) => ({
  '&:not(:last-child)': {
    borderBottom: 0,
  },
  '&::before': {
    display: 'none',
  },
}));

const AccordionSummary = styled((props) => (
  <MuiAccordionSummary
    expandIcon={<ExpandMoreIcon sx={{ fontSize: '0.9rem' }} />}
    {...props}
  />
))(({ theme }) => ({
  backgroundColor: 'rgba(0, 0, 0, .03)',
  flexDirection: 'row-reverse',
  '& .MuiAccordionSummary-expandIconWrapper.Mui-expanded': {
    transform: 'rotate(180deg)',
  },
  '& .MuiAccordionSummary-content': {
    marginLeft: theme.spacing(1),
  },
  ...theme.applyStyles('dark', {
    backgroundColor: 'rgba(255, 255, 255, .05)',
  }),
}));


const AccordionDetails = styled(MuiAccordionDetails)(({ theme }) => ({
  padding: theme.spacing(2),
  borderTop: '1px solid rgba(0, 0, 0, .125)'
}));

export const AcordionContrato = ({estatusGarantia, ambiente, indicadorAmbienteDev, aseguradora, idGarantia, regresar, regresar2}) => {
  const [expanded, setExpanded] = useState('');
  const [modalBasico, setModalBasico] = useState(false);
  const accionModalBasico = useRef();
  const [tituloModalBasico, setTituloModalBasico] = useState(false);
  const [contenidoModalBasico, setContenidoModalBasico] = useState(false);
  const [state, setState] = useAppState();
  const [gifEspere, setGifEspere] = useState('');
  const [alertaFija, setAlertaFija] = useState('');
  const { t } = useTranslation();
  const handleChange = (panel) => (event, newExpanded) => {
    setExpanded(newExpanded ? panel : false);
  };
  let vectorPasos = estatusGarantia.split(','); 
  let pasoActual = vectorPasos[0];

  let rutaFormularioInventario = '';
  if (aseguradora == 'Sura')
  {
    rutaFormularioInventario = "https://s3.sa-east-1.amazonaws.com/cdn.ofiliaria.com.uy/garantias-uy/formularios_inventario/formulario_inventario_sura.pdf";
  }
  else if (aseguradora == 'Sancor')
  {
    rutaFormularioInventario = "https://s3.sa-east-1.amazonaws.com/cdn.ofiliaria.com.uy/garantias-uy/formularios_inventario/formulario_inventario_sancor.pdf";
  }

  let rutaContratoPdf = ''
  if (ambiente == 'Desarrollo')
  {
    rutaContratoPdf = `http://localhost/ofiliaria/backend_ofiliaria/public/storage/garantias/${idGarantia}-contrato.pdf`;
  }
  else
  {
    if (indicadorAmbienteDev == 1)
    {
      rutaContratoPdf = `https://s3.sa-east-1.amazonaws.com/cdn.ofiliaria.com.uy/garantias-uy/${idGarantia}/contrato/${idGarantia}-contrato.pdf`;
    }
    else
    {
      rutaContratoPdf = `https://s3.sa-east-1.amazonaws.com/cdn.ofiliaria.com.uy/garantias-uy/produccion/${idGarantia}/contrato/${idGarantia}-contrato.pdf`;
    }
  }

  let rutaFotoInventarioPdf = ''
  if (pasoActual == 'Paso 9')
  {
    if (ambiente == 'Desarrollo')
    {
      rutaFotoInventarioPdf = `http://localhost/ofiliaria/backend_ofiliaria/public/storage/garantias/${idGarantia}-foto-inventario.pdf`;
    }
    else
    {
      if (indicadorAmbienteDev == 1)
      {
        rutaFotoInventarioPdf = `https://s3.sa-east-1.amazonaws.com/cdn.ofiliaria.com.uy/garantias-uy/${idGarantia}/inventario/${idGarantia}-foto-inventario.pdf`;
      }
      else
      {
        rutaFotoInventarioPdf = `https://s3.sa-east-1.amazonaws.com/cdn.ofiliaria.com.uy/garantias-uy/produccion/${idGarantia}/inventario/${idGarantia}-foto-inventario.pdf`;        
      }
    }
  }

  const cerrarModalBasico = () => {
    setModalBasico(false);
  }

  const modalPdfNoGenerado = () => {
    setTituloModalBasico(t(''));
    accionModalBasico.current = cerrarModalBasico;
    setContenidoModalBasico(t('texto_343'));
    setModalBasico(true);
  }

  const obtenerFotoInventario = async () => {
    const formulario = new FormData();
    formulario.append("datos", JSON.stringify({}));
    setGifEspere(<GifEspere />);
    try {
      const respuesta = await axios.post(state.endpoint+'/garantias/obtenerFotoInventario/'+state.garantia_id, formulario, { headers: { 'Authorization': `Bearer ${state.token_laravel}`, "Content-Type": "multipart/form-data" } });
      setGifEspere('');
      if (respuesta.data.codigoRetorno == 0)
      {
        if (respuesta.data.garantia.foto_inventario == null)
        {
          modalPdfNoGenerado();
        }
        else
        {
          window.open(rutaFotoInventarioPdf, '_blank');
        }
      }
      else
      {
        setAlertaFija(<AlertaError texto={t('texto_344')} />);
        setTimeout(() => {
          setAlertaFija('');
        }, 10000)
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

  return (
    <div>
      <Accordion expanded={expanded === 'panel1'} onChange={handleChange('panel1')}>
        <AccordionSummary aria-controls="panel1d-content" id="panel1d-header">
        <Typography variant="h5" sx={{ fontSize : 16 }}>{t('¿Querés editar/descargar algún dato?')}</Typography>
        </AccordionSummary>
        <AccordionDetails>
          <Grid container>
            {
              rutaFormularioInventario != '' &&
                <Grid key={'1'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }} >
                  <Button variant="text" startIcon={<PictureAsPdfIcon />} href={rutaFormularioInventario} download target="_blank" >{t('Descargar formulario')}</Button>
                </Grid>
            }
            <Grid key={'2'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }} >
              <Button variant="text" startIcon={<PictureAsPdfIcon />} onClick={ event => {regresar(event) }} >{t('Editar contrato')}</Button>            
            </Grid>
            <Grid key={'3'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }} >
              <Button variant="text" startIcon={<PictureAsPdfIcon />} href={rutaContratoPdf} download target="_blank" >{t('texto_309')}</Button>
            </Grid>
            {
              pasoActual == 'Paso 9' &&
                <Grid key={'4'} size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }} >
                  <Button variant="text" startIcon={<PictureAsPdfIcon />} onClick={ () => { obtenerFotoInventario() }} >{t('texto_334')}</Button>
                </Grid>
            }
          </Grid>
        </AccordionDetails>
      </Accordion>
      <ModalBasico open={modalBasico} handleClose={accionModalBasico.current} tituloModal={tituloModalBasico} contenidoModal={contenidoModalBasico} />
      {gifEspere}
      <div className='ra_alerta_fija'>
        {alertaFija}
      </div>
    </div>
  );
}