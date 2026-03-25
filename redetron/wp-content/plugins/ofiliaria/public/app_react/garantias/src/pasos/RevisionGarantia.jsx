import { useState, useEffect, useRef } from 'react';
import { useAppState } from "../state";
import { useTranslation } from 'react-i18next';
import axios from 'axios';
import { useParams, useNavigate, Link } from "react-router-dom";
import { GifEspere, AlertPelSC, AlertPelFij } from "../varios";
import {
  Container,
  Paper,
  Stack,
  Box,
  Typography,
  Button,
} from '@mui/material';
import Grid from '@mui/material/Grid2';
import { DatosGarantia } from '../formularios';

export const RevisionGarantia = () => {
  const [state, setState] = useAppState();
  const { t } = useTranslation();
  const [gifEspere, setGifEspere] = useState('');
  const [alertaFija, setAlertaFija] = useState('');
  const { idGarantia } = useParams();

  useEffect(() => {( async () => {
    if (idGarantia == 9999999999)
    {
      navigate('/contrato-garantia/'+state.garantia_id); 
    }
  })();},[]);

  const navigate = useNavigate();

  console.log('DetalleGarantia, state', state);

  return (
    <>
      {
        idGarantia != 9999999999 &&
          <Box component={Paper} elevation={12} sx={{ marginTop : '14rem', p : 2, borderRadius : 3 }}>
            <DatosGarantia idGarantia={idGarantia} origen={'RevisionGarantia'} tituloVista={t('texto_185')} />
            {gifEspere}
            {alertaFija} 
            <br /><br /><br />
          </Box>
      }
    </>
  );
};