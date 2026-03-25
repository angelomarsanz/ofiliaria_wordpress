import { useEffect, useRef } from 'react';
import { useAppState } from "../state.jsx";
import { Controller } from "react-hook-form";
import { useTranslation } from 'react-i18next';

export const Ingreso = ({control, tipoIngreso, mostrarCampoSueldo, ocultarCampoSueldo}) => {
  const [state, setState] = useAppState();
  const { t } = useTranslation();
  
  useEffect(() => {

  },[]);
    
  const actualizarIngreso = (event) => {
    if (event.target.value != '')
    {
      tipoIngreso.current = event.target.value;
      if (event.target.value == 'Empleado (trabajador dependiente)')
      {
        mostrarCampoSueldo();
      }
      else
      {
        ocultarCampoSueldo(event.target.value);
      }
    }
  };

  return (
      <>
        <Controller
          control={control}
          name="ingreso"
          rules={{required : true}}
          render={({ field: { value, onChange}}) => (
            <div className="form-group">
              <label htmlFor="ingreso">{t('texto_59')}</label>
              <select className="form-control" id="ingreso" value={value} onChange={ event => { actualizarIngreso(event); onChange(event); }} >
                <option value=""></option>
                <option value="Empleado (trabajador dependiente)">{t('texto_60')}</option>
                <option value="Jubilado o pensionista">{t('texto_61')}</option>
              </select>
            </div>
          )}
        />
      </>
  );
};