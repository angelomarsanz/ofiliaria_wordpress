import * as React from 'react';
import Alert from '@mui/material/Alert';
import CheckIcon from '@mui/icons-material/Check';

export const AlertaError = ({texto}) => {
  return (
    <Alert sx={{ fontSize : 16 }} severity="error">
      {texto}
    </Alert>
  );
}