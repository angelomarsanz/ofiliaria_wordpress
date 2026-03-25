import * as React from 'react';
import Alert from '@mui/material/Alert';
import CheckIcon from '@mui/icons-material/Check';

export const AlertaSatisfactorio = ({texto}) => {
  return (
    <Alert sx={{ fontSize : 16 }} severity="success">
      {texto}
    </Alert>
  );
}