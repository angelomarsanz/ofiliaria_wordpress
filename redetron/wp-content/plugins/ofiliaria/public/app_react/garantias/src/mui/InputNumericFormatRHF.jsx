import { forwardRef } from 'react';
import { Controller } from "react-hook-form";
import { 
    FormControl,  
    TextField,
    OutlinedInput,
    FormHelperText
  } from '@mui/material';
import { NumericFormat } from 'react-number-format';
import PropTypes from 'prop-types';

export const InputNumericFormatRHF = ({ nombre, control, etiqueta, textoAdicional, textoError, errorInput }) => {
  const NumericFormatCustom = forwardRef(
    function NumericFormatCustom(props, ref) {
      const { onChange, ...other } = props;
  
      return (
        <NumericFormat
          {...other}
          getInputRef={ref}
          onValueChange={(values) => {
            onChange({
              target: {
                name: props.name,
                value: values.value,
              },
            });
          }}
          valueIsNumericString
          allowLeadingZeros 
          thousandSeparator='.' 
          decimalSeparator=","
        />
      );
    },
  );
  
  NumericFormatCustom.propTypes = {
    name: PropTypes.string.isRequired,
    onChange: PropTypes.func.isRequired,
  };

  return (
    <Controller
      name={nombre}
      control={control}
      render={({
        field: { onChange, value }
      }) => (
        <FormControl fullWidth>
          <label htmlFor={nombre}>{etiqueta}</label>
          <TextField
            name={nombre}
            id={nombre}
            placeholder=""
            onChange={onChange}
            value={value}
            error={!!errorInput}
            slotProps={{
              input: {
                inputComponent: NumericFormatCustom,
                sx : {fontSize : 16,}
              }
            }}
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
