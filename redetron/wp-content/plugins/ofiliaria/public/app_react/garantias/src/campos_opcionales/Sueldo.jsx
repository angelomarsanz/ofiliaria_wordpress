import { useEffect, useRef } from 'react';
import { useAppState } from "../state.jsx";
import { Controller } from "react-hook-form";
import { useTranslation } from 'react-i18next';

export const Sueldo = ({control, actualizarSueldo}) => {
  const [state, setState] = useAppState();
  const { t } = useTranslation();
  
  useEffect(() => {

  },[]);
    
  return (
      <>
        <Controller
          control={control}
          name="sueldo"
          rules={{required : true}}
          render={({ field }) => {
            return (
              <>
                <p><b>Tipo de sueldo</b></p>
                <br />
                <label className="radio-inline">
                  <input type="radio" {...field} value='Fijo' checked={field.value === 'Fijo'} onChange={ event  => {field.onChange(event); actualizarSueldo('Fijo')}} />
                  {t('texto_81')}
                </label>
                <label className="radio-inline">
                  <input type="radio" {...field} value='Variable' checked={field.value === 'Variable'} onChange={ event => {field.onChange(event); actualizarSueldo('Variable')}} />
                  {t('texto_82')}
                </label>
                <br />
              </>
          )}}
        />
      </>
  );
};