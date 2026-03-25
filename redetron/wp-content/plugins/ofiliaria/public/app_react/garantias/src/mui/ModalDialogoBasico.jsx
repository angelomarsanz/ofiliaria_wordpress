import * as React from 'react';
import Button from '@mui/material/Button';
import Dialog from '@mui/material/Dialog';
import DialogActions from '@mui/material/DialogActions';
import DialogContent from '@mui/material/DialogContent';
import DialogContentText from '@mui/material/DialogContentText';
import DialogTitle from '@mui/material/DialogTitle';

export const ModalDialogoBasico = ({open, handleClose, tituloModal, contenidoModal, textoAccion1, accion1, parametrosAccion1, textoAccion2, accion2, parametrosAccion2}) => {
  return (
    <React.Fragment>
      <Dialog
        open={open}
        onClose={handleClose}
        aria-labelledby="alert-dialog-title"
        aria-describedby="alert-dialog-description"
      >
        <DialogTitle id="alert-dialog-title" variant={'h4'}>
          {tituloModal}
        </DialogTitle>
        <DialogContent>
          <DialogContentText id="alert-dialog-description" sx={{fontSize : 16}}>
            {contenidoModal}
          </DialogContentText>
        </DialogContent>
        <DialogActions>
          <Button variant="contained" onClick={() => {accion1(parametrosAccion1)}} autoFocus>{textoAccion1}</Button>
          <Button variant="contained" color="secondary" onClick={() => {accion2(parametrosAccion2)}}>
            {textoAccion2}
          </Button>
        </DialogActions>
      </Dialog>
    </React.Fragment>
  );
}
