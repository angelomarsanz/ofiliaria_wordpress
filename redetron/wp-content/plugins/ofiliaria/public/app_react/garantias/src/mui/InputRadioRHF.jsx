import { Controller } from "react-hook-form";
import {
  FormControl,
  FormControlLabel,
  Radio,
  RadioGroup,
  FormHelperText
} from "@mui/material";

export const InputRadioRHF = ({
  nombre,
  control,
  etiqueta,
  opcionesInputs,
  textoAdicional, 
  funcionAdicional,
  textoError, 
  errorInput
}) => {
  const generarOpcionesRadio = () => {
    return opcionesInputs.map((opcion, indice) => (
      <FormControlLabel
        key={indice}
        value={opcion.valor}
        label={opcion.etiqueta}
        control={<Radio />}
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
              <RadioGroup row value={value} onChange={ event => { funcionAdicional(event); onChange(event); }} >
                {generarOpcionesRadio()}
              </RadioGroup>
              <FormHelperText>
                {errorInput ? <span className='error'>{textoError}</span> : <span className='ra_fuente_14'>{textoAdicional}</span> }
              </FormHelperText>
            </FormControl>
          </>
        )}
      />
  );
};