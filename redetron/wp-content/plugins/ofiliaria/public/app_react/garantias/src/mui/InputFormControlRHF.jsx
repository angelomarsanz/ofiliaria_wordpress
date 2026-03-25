import { Controller } from "react-hook-form";
import { 
    FormControl,  
    OutlinedInput,
    FormHelperText
  } from '@mui/material';

export const InputFormControlRHF = ({ nombre, control, etiqueta, textoAdicional, funcionAdicional, textoError, errorInput }) => {
  return (
    <Controller
      name={nombre}
      control={control}
      render={({
        field: { onChange, value }
      }) => (
        <FormControl fullWidth>
          <label htmlFor={nombre}>{etiqueta}</label>
          <OutlinedInput 
            id={nombre}
            placeholder=""
            onChange={ event => { funcionAdicional(event); onChange(event); }}
            value={value}
            error={!!errorInput}
            sx={{
              fontSize : 16,
              "& .MuiInputBase-root" : {
                //
                },
              "& .MuiOutlinedInput-notchedOutline": {
                //    
                },         
            }}
          />
          <FormHelperText>{errorInput ? <span className='error'>{textoError}</span> : <span className='ra_fuente_14'>{textoAdicional}</span> }</FormHelperText>
        </FormControl>
      )}
    />  
  );
};
