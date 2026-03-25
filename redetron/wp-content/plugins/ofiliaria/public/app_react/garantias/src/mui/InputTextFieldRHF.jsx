import { Controller } from "react-hook-form";
import { TextField } from '@mui/material';

export const InputTextFieldRHF = ({ nombre, control, etiqueta, textoAdicional, textoError, errorInput }) => {
  return (
    <Controller
      name={nombre}
      control={control}
      render={({
        field: { onChange, value }
      }) => (
        <>
          <label htmlFor={nombre}>{etiqueta}</label>
          <TextField
            id={nombre}
            fullWidth
            onChange={onChange}
            value={value}
            error={!!errorInput}
            helperText={errorInput ? textoError : textoAdicional}
            sx={{
                "& .MuiInputBase-root" : {
                    // 
                  },
                "& .MuiOutlinedInput-notchedOutline": {
                  //   
                  },         
            }}
          />
        </>
      )}
    />
  );
};
