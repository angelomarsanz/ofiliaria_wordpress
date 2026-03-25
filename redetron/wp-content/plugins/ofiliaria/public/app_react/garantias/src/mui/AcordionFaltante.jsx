import { useState
  }
  from 'react';
import { styled } from '@mui/material/styles';
import MuiAccordion from '@mui/material/Accordion';
import AccordionSummary from '@mui/material/AccordionSummary';
import MuiAccordionDetails from '@mui/material/AccordionDetails';
import Typography from '@mui/material/Typography';
import { useTranslation } from 'react-i18next';
import ExpandMoreIcon from '@mui/icons-material/ExpandMore';
import {
  Stack
  } from '@mui/material';

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

const AccordionDetails = styled(MuiAccordionDetails)(({ theme }) => ({
  padding: theme.spacing(2),
  borderTop: '1px solid rgba(0, 0, 0, .125)'
}));

export const AcordionFaltante = ({faltante, limitePago, costoAlquiler}) => {
  const { t } = useTranslation();
  const [expanded, setExpanded] = useState('');

  const handleChange = (panel) => (event, newExpanded) => {
    setExpanded(newExpanded ? panel : false);
  };

  return (
    <div>
      <Accordion expanded={expanded === 'panel1'} onChange={handleChange('panel1')}>
        <AccordionSummary
          expandIcon={<ExpandMoreIcon />}
          aria-controls="panel1-content"
          id="panel1-header"
        > 
          <Typography sx={{ fontSize : 16 }}>
            <img alt="Aviso" src="https://s.w.org/images/core/emoji/14.0.0/svg/26a0.svg" style={{width : 15, marginRight : '0.5rem'}} />{t('texto_137')}
          </Typography>
          <Typography sx={{ fontSize : 16, fontWeight : 700 }}>
            &nbsp;{'UYU $'+faltante}
          </Typography>
        </AccordionSummary>
        <AccordionDetails>
          <Typography sx={{ fontSize : 16 }}>{t('texto_138')+limitePago}</Typography>
          <br />
          <Typography sx={{ fontSize : 16 }}>{t('texto_139')+costoAlquiler}</Typography>
        </AccordionDetails>
      </Accordion>
    </div>
  );
}