import { useEffect, useRef } from 'react';
import { useFieldArray, Controller } from "react-hook-form";
import { useTranslation } from 'react-i18next';
import Button from '@mui/material/Button';
import CloudUploadIcon from '@mui/icons-material/CloudUpload';
import Grid from '@mui/material/Grid2';

export const Dgi = ({control, contadorArchivos, actualizarMensajeError}) => {
  const ocultarInput = useRef(null);
  const { t } = useTranslation();
  
  useEffect(() => {
  },[]);
  
  const { fields, append, remove } = useFieldArray({
    control,
    name: "dgi",
  });

  const adjuntarArchivos = (e) => {
    e.preventDefault();
    ocultarInput.current.click();
  };

  const manejoArchivos = (event) => {
    const archivosCargados = Array.from(event.target.files);
    let cantidadElementos = archivosCargados.length;
    contadorArchivos.current += cantidadElementos;

    const archivos = archivosCargados.map((file) => ({
      file
    }));
    append(archivos);
    actualizarMensajeError('');
  };
  
  return (
      <>
        <label htmlFor="dgi">{t("Última declaración jurada ante DGI o (IRPF / IRAE / IPAT / ICOSA / IVA, etc) presentada en el último año *")}</label>
        <br />
        <Button
            component="label"
            role={undefined}
            variant="outlined"
            tabIndex={-1}
            startIcon={<CloudUploadIcon />}
            onClick={adjuntarArchivos}
            sx={{ fontSize : 12}}
        >
          {t('texto_129')}
        </Button>
        <br /><br />
        <input
          type="file"
          multiple
          onChange={manejoArchivos}
          id='dgi'
          ref={ocultarInput}
          style={{display: 'none'}}
        />
        <div style={{ width: 300 }}>
          {fields.map((field, index) => (
            <div key={field.id}>
              <Controller
                control={control}
                name={`dgi.${index}`}
                render={() => (
                  <>
                    <Grid container spacing={{ xs : 2, sm : 2, md : 3, lg : 3, xl : 3 }}>
                      <Grid key={'1'} size={{ xs : 2, sm : 2, md : 2, lg : 2, xl : 2 }}>
                        <a href={URL.createObjectURL(field.file)} target="_blank"><span className="glyphicon glyphicon-eye-open "></span></a>
                      </Grid>
                      <Grid key={'2'} size={{ xs : 2, sm : 2, md : 2, lg : 2, xl : 2 }}>
                        <a href="#" onClick={(e) => {e.preventDefault(); remove(index); contadorArchivos.current--; }}><span className="glyphicon glyphicon-trash"></span></a>
                      </Grid>
                      <Grid key={'3'} size={{ xs : 8, sm : 8, md : 8, lg : 8, xl : 8 }}>
                        {field.file.name}
                      </Grid>
                    </Grid>
                    <br />
                  </>
                )}
              />
            </div>
          ))}
        </div>
        <br />
      </>
  );
};