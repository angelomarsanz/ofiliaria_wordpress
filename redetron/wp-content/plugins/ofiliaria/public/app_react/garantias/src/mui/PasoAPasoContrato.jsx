import * as React from 'react';
import Box from '@mui/material/Box';
import Stepper from '@mui/material/Stepper';
import Step from '@mui/material/Step';
import StepLabel from '@mui/material/StepLabel';
import { styled } from '@mui/material/styles';
import StepConnector, { stepConnectorClasses } from '@mui/material/StepConnector';
import { useLocation } from "react-router-dom";

const steps = ['Enviada', 'En Revision', 'Datos Contrato', 'Inventario', 'Firma', 'Pago'];

const pasosNavegacion = 
  {
    'garantia-enviada' : 0,
    'revision-garantia' : 1,
    'contrato-garantia' : 2,
    'inventario-garantia' : 3,
    'firma-contrato' : 4,
    'pago-garantia' : 5
  };

export const PasoAPasoContrato = ({rutaPaso}) => {
  var pasoActual = '';
  
  if (rutaPaso != '')
  {
    pasoActual = pasosNavegacion[rutaPaso];
  }
  else
  {
    let location = useLocation();
    let vectorRuta = location.pathname.split('/')[1];
    pasoActual = pasosNavegacion[vectorRuta];
  }

  const QontoConnector = styled(StepConnector)(({ theme }) => ({
    [`&.${stepConnectorClasses.alternativeLabel}`]: {
      top: 10,
      left: 'calc(-50% + 16px)',
      right: 'calc(50% + 16px)',
    },
    [`&.${stepConnectorClasses.active}`]: {
      [`& .${stepConnectorClasses.line}`]: {
        borderColor: '#784af4',
      },
    },
    [`&.${stepConnectorClasses.completed}`]: {
      [`& .${stepConnectorClasses.line}`]: {
        borderColor: '#784af4',
      },
    },
    [`& .${stepConnectorClasses.line}`]: {
      borderColor: '#eaeaf0',
      borderTopWidth: 3,
      borderRadius: 1,
      ...theme.applyStyles('dark', {
        borderColor: theme.palette.grey[800],
      }),
    },
  }));

  return (
    <Box sx={{ width: '100%' }}>
      <Stepper activeStep={pasoActual} alternativeLabel connector={<QontoConnector />}>
        {steps.map((label) => {
          return (
            <Step key={label}>
              <StepLabel>{label}</StepLabel>
            </Step>
          );
        })}
      </Stepper>
    </Box>
  );
}
