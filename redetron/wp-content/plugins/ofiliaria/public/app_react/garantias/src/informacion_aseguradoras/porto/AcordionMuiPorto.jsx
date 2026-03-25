import { useState
  }
  from 'react';
import { styled } from '@mui/material/styles';
import ArrowForwardIosSharpIcon from '@mui/icons-material/ArrowForwardIosSharp';
import MuiAccordion from '@mui/material/Accordion';
import MuiAccordionSummary from '@mui/material/AccordionSummary';
import MuiAccordionDetails from '@mui/material/AccordionDetails';
import Typography from '@mui/material/Typography';

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
    expandIcon={<ArrowForwardIosSharpIcon sx={{ fontSize: '0.9rem' }} />}
    {...props}
  />
))(({ theme }) => ({
  backgroundColor: 'rgba(0, 0, 0, .03)',
  flexDirection: 'row-reverse',
  '& .MuiAccordionSummary-expandIconWrapper.Mui-expanded': {
    transform: 'rotate(90deg)',
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
  borderTop: '1px solid rgba(0, 0, 0, .125)',
}));

export default function AcordionMuiSura() {
  const [expanded, setExpanded] = useState('panel1');

  const handleChange = (panel) => (event, newExpanded) => {
    setExpanded(newExpanded ? panel : false);
  };

  return (
    <div>
      <Accordion expanded={expanded === 'panel1'} onChange={handleChange('panel1')}>
        <AccordionSummary aria-controls="panel1d-content" id="panel1d-header">
          <Typography>Empleado (Trabajador Dependiente)</Typography>
        </AccordionSummary>
        <AccordionDetails>
          <ul>
            <li><Typography><strong style={{fontWeight : 600}}>Antigüedad laboral mínima:</strong></Typography>
              <ul className='ra_ul_3'>
                <li><Typography><strong style={{fontWeight : 600}}>- Sueldo fijo:</strong> 3 meses</Typography></li>
                <li><Typography><strong style={{fontWeight : 600}}>- Sueldo variable:</strong> 6 Meses</Typography></li>
              </ul>
            </li>
            <li><Typography>Últimos 3 recibos de sueldo (sueldo fijo) o últimos 6 (sueldo variable).</Typography></li>
            <li><Typography>Foto de cédula vigente.</Typography></li>
            <li><Typography>Dirección de e-mail.</Typography></li>
          </ul>
          <Typography sx={{fontWeight : 600}}><img alt="Aviso" src="https://s.w.org/images/core/emoji/14.0.0/svg/26a0.svg" style={{width : 10, marginRight : '0.5rem'}}/>Importante: No estar en el Clearing</Typography>
        </AccordionDetails>
      </Accordion>
      <Accordion expanded={expanded === 'panel2'} onChange={handleChange('panel2')}>
        <AccordionSummary aria-controls="panel2d-content" id="panel2d-header">
          <Typography>Jubilado o pensionista</Typography>
        </AccordionSummary>
        <AccordionDetails>
          <ul>
            <li><Typography>Último recibo de cobro emitido por la caja oficial correspondiente.</Typography></li>
            <li><Typography>Foto de cédula vigente.</Typography></li>
            <li><Typography>Dirección de e-mail.</Typography></li>
          </ul>
          <Typography sx={{fontWeight : 600}}><img alt="Aviso" src="https://s.w.org/images/core/emoji/14.0.0/svg/26a0.svg" style={{width : 10, marginRight : '0.5rem'}}/>Importante: No estar en el Clearing</Typography>
        </AccordionDetails>
      </Accordion>
      <Accordion expanded={expanded === 'panel3'} onChange={handleChange('panel3')}>
        <AccordionSummary aria-controls="panel3d-content" id="panel3d-header">
          <Typography>Personas con rentas de alquileres</Typography>
        </AccordionSummary>
        <AccordionDetails>
          <ul>
            <li><Typography>Contrato de arrendamiento.</Typography></li>
            <li><Typography>Recibo de alquiler del último mes o estado de cuenta bancaria donde lo percibe (la misma debe estar a nombre del solicitante).</Typography></li>
            <li><Typography>Foto de cédula vigente.</Typography></li>
            <li><Typography>Dirección de e-mail.</Typography></li>
          </ul>
          <Typography sx={{fontWeight : 600}}><img alt="Aviso" src="https://s.w.org/images/core/emoji/14.0.0/svg/26a0.svg" style={{width : 10, marginRight : '0.5rem'}}/>Importante: No estar en el Clearing</Typography>
        </AccordionDetails>
      </Accordion>
      <Accordion expanded={expanded === 'panel4'} onChange={handleChange('panel4')}>
        <AccordionSummary aria-controls="panel4d-content" id="panel4d-header">
          <Typography>Universitarios</Typography>
        </AccordionSummary>
        <AccordionDetails>
          <ul>
            <li><Typography>Certificado de universidad emitido oficialmente por la universidad.</Typography></li>
            <li><Typography>Foto de cédula vigente.</Typography></li>
            <li><Typography>Dirección de e-mail.</Typography></li>
          </ul>
          <Typography sx={{fontWeight : 600}}><img alt="Aviso" src="https://s.w.org/images/core/emoji/14.0.0/svg/26a0.svg" style={{width : 10, marginRight : '0.5rem'}}/>Importante: No estar en el Clearing</Typography>
        </AccordionDetails>
      </Accordion>
      <Accordion expanded={expanded === 'panel5'} onChange={handleChange('panel5')}>
        <AccordionSummary aria-controls="panel5d-content" id="panel5d-header">
          <Typography>Profesional independiente / Unipersonal / Micro-empresario</Typography>
        </AccordionSummary>
        <AccordionDetails>
          <ul>
            <li><Typography><strong style={{fontWeight : 600}}>Antigüedad comercial mínima: 12 meses.</strong></Typography></li>
            <li><Typography>Informe de ingresos por contador público.</Typography></li>
            <li><Typography>Última declaración jurada ante DGI o (IRPF / IRAE / IPAT / ICOSA / IVA, etc) presentada en el último año.</Typography></li>
            <li><Typography>Certificados vigentes de BPS y DGI.</Typography></li>
            <li><Typography>Foto de la cédula vigente.</Typography></li>
            <li><Typography>Dirección de e-mail.</Typography></li>
          </ul>
          <Typography sx={{fontWeight : 600}}><img alt="Aviso" src="https://s.w.org/images/core/emoji/14.0.0/svg/26a0.svg" style={{width : 10, marginRight : '0.5rem'}}/>Importante: No estar en el Clearing</Typography>
        </AccordionDetails>
      </Accordion>
      <Accordion expanded={expanded === 'panel6'} onChange={handleChange('panel6')}>
        <AccordionSummary aria-controls="panel6d-content" id="panel6d-header">
          <Typography>Empresa</Typography>
        </AccordionSummary>
        <AccordionDetails>
          <ul>
            <li><Typography><strong style={{fontWeight : 600}}>Antigüedad comercial mínima: 24 meses.</strong></Typography></li>
            <li><Typography>Última declaración jurada ante DGI o (IRPF / IRAE / IPAT / ICOSA / IVA, etc) presentada en el último año.</Typography></li>
            <li><Typography>Certificados vigentes de BPS y DGI.</Typography></li>
            <li><Typography>Último balance con informe de compilación.</Typography></li>
            <li><Typography>Foto de la cédula de los socios vigente.</Typography></li>
            <li><Typography>Dirección de e-mail.</Typography></li>
          </ul>
          <Typography sx={{fontWeight : 600}}><img alt="Aviso" src="https://s.w.org/images/core/emoji/14.0.0/svg/26a0.svg" style={{width : 10, marginRight : '0.5rem'}}/>Importante: No estar en el Clearing</Typography>
        </AccordionDetails>
      </Accordion>
    </div>
  );
}