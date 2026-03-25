import * as React from 'react';
import Alert from '@mui/material/Alert';

export const AlertaAviso = ({texto}) => {
  return (
    <Alert sx={{ fontSize : 16 }} severity="warning">
      {texto}
    </Alert>
  );
}