import {
  Typography,
  } from '@mui/material';

export const MensajeError = ({ mensaje }) => {
  return (
    <Typography sx={{ fontSize : 14, color : '#d32f2f'}}>
        {mensaje}
    </Typography>
  );
};