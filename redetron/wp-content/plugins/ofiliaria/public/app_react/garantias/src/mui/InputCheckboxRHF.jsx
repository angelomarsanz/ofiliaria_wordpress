import { Controller } from "react-hook-form";
import {
  FormControl,
  FormControlLabel,
  Checkbox,
  FormGroup,
  FormHelperText
} from "@mui/material";

export const InputCheckboxRHF = ({
  nombre,
  control,
  etiqueta,
  opcionesInputs,
  textoAdicional, 
  funcionAdicional,
  textoError, 
  errorInput,
  valorActual
}) => {
  const generarOpcionesCheckbox = () => {
    return opcionesInputs.map((opcion, indice) => (
      <FormControlLabel
        key={indice}
        value={opcion.valor}
        label={opcion.etiqueta}
        control={valorActual ? <Checkbox defaultChecked /> : <Checkbox />}
      />
    ));
  };
  return (
      <Controller
        name={nombre}
        control={control}
        render={({
          field: { onChange, value }
        }) => (
          <>
            <FormControl 
              fullWidth 
              error={!!errorInput}
            >
              <label htmlFor={nombre}>{etiqueta}</label>
              <FormGroup row value={value} onChange={ event => { funcionAdicional(event); onChange(event); }} >
                {generarOpcionesCheckbox()}
              </FormGroup>
              <FormHelperText>
                {errorInput ? <span className='error'>{textoError}</span> : <span className='ra_fuente_14'>{textoAdicional}</span> }
              </FormHelperText>
            </FormControl>
          </>
        )}
      />
  );
};