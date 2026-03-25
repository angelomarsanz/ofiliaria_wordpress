import { Controller } from "react-hook-form";
import { 
  FormControl, 
  InputLabel, 
  MenuItem, 
  Select,
  FormHelperText } from "@mui/material";

export const InputSelectRHF = ({
  nombre,
  control,
  etiqueta,
  opcionesInputs,
  textoAdicional, 
  funcionAdicional,
  textoError, 
  errorInput

}) => {
  const generarOpciones = () => {
    return opcionesInputs.map((opcion, indice) => {
      return (
        <MenuItem key={indice} value={opcion.valor}>
          {opcion.etiqueta}
        </MenuItem>
      );
    });
  };

  return (
      <Controller
        name={nombre}
        control={control}
        render={({ field: { onChange, value } }) => (
          <>
            <FormControl 
              fullWidth 
              error={!!errorInput}
              sx={{
                  "& .MuiInputBase-root" : {
                      height : '4.5rem'
                    },
                  "& .MuiOutlinedInput-notchedOutline": {
                      // 
                    }          
            }}>
              <label htmlFor={nombre}>{etiqueta}</label>
              <Select id={nombre} onChange={ event => { funcionAdicional(event); onChange(event); }} value={value} sx={{fontSize : 16}}>
                {generarOpciones()}
              </Select>
              <FormHelperText>{errorInput ? <span className='error'>{textoError}</span> : <span className='ra_fuente_14'>{textoAdicional}</span> }</FormHelperText>
            </FormControl>
          </>
        )}
      />
  );
};