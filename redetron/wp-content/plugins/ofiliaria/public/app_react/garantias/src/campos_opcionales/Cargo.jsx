import { useEffect, useRef } from 'react';
import { useAppState } from "../state.jsx";
import { Controller } from "react-hook-form";
import { useTranslation } from 'react-i18next';

export const Cargo = ({control, actualizarCargo}) => {
  const [state, setState] = useAppState();
  const { t } = useTranslation();
  
  useEffect(() => {

  },[]);
    
  return (
      <>
        <Controller
          control={control}
          name="cargo_empresa"
          rules={{required : true}}
          render={({ field }) => {
            return (
              <>
                <p><b>{t('texto_83')}</b></p>
                <label className="radio-inline">
                  <input type="radio" {...field} value='Administrador' checked={field.value === 'Administrador'} onChange={ event  => {field.onChange(event); actualizarCargo('Administrador')}} />
                  {t('texto_84')}
                </label>
                <label className="radio-inline">
                  <input type="radio" {...field} value='Apoderado' checked={field.value === 'Apoderado'} onChange={ event => {field.onChange(event); actualizarCargo('Apoderado')}} />
                  {t('texto_85')}
                </label>
                <label className="radio-inline">
                  <input type="radio" {...field} value='Propietario' checked={field.value === 'Propietario'} onChange={ event => {field.onChange(event); actualizarCargo('Propietario')}} />
                  {t("Propietario")}
                </label>
                <label className="radio-inline">
                  <input type="radio" {...field} value='Socio' checked={field.value === 'Socio'} onChange={ event => {field.onChange(event); actualizarCargo('Socio')}} />
                  {t('texto_87')}
                </label>
                <br /><br />
              </>
          )}}
        />
      </>
  );
};