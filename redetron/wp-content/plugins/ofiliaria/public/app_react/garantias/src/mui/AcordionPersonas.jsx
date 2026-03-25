import { useState, useEffect, useRef } from 'react';
import { styled } from '@mui/material/styles';
import ArrowForwardIosSharpIcon from '@mui/icons-material/ArrowForwardIosSharp';
import MuiAccordion from '@mui/material/Accordion';
import MuiAccordionSummary from '@mui/material/AccordionSummary';
import MuiAccordionDetails from '@mui/material/AccordionDetails';
import {
  Container,
  Paper,
  Stack,
  Box,
  Typography,
  Button,
} from '@mui/material';
import {
    inputsAseguradoras, 
    opcionesAseguradoras, 
  } from "../vectores_objetos";
import Grid from '@mui/material/Grid2';
import { useTranslation } from 'react-i18next';

const Accordion = styled((props) => (
  <MuiAccordion disableGutters elevation={0} square {...props} />
))(({ theme }) => ({
  '&:not(:last-child)': {
    borderBottom: 0,
  },
  '&::before': {
    display: 'none',
  },
}));

const AccordionSummary = styled((props) => (
  <MuiAccordionSummary
    expandIcon={<ArrowForwardIosSharpIcon sx={{ fontSize: '0.9rem' }} />}
    {...props}
  />
))(({ theme }) => ({
  backgroundColor: 'rgba(0, 0, 0, .03)',
  flexDirection: 'row-reverse',
  '& .MuiAccordionSummary-expandIconWrapper.Mui-expanded': {
    transform: 'rotate(90deg)',
  },
  '& .MuiAccordionSummary-content': {
    marginLeft: theme.spacing(1),
  },
  ...theme.applyStyles('dark', {
    backgroundColor: 'rgba(255, 255, 255, .05)',
  }),
}));

const AccordionDetails = styled(MuiAccordionDetails)(({ theme }) => ({
  padding: theme.spacing(2),
  borderTop: '1px solid rgba(0, 0, 0, .125)'
}));

export const AcordionPersonas = ({ambiente, aseguradora, personas, urlAlmacenamiento}) => {
  const [expanded, setExpanded] = useState('panel0');
  const { t } = useTranslation();

  useEffect(() => {( async () => {
    // 
  })();},[]);
  
  const handleChange = (panel) => (event, newExpanded) => {
    setExpanded(newExpanded ? panel : false);
  };

  const DatosArchivosPersona = ({ambiente, aseguradora, persona, urlAlmacenamiento}) => {
    const vectorOpcionesAseguradoras = opcionesAseguradoras();

    useEffect(() => {( async () => {
      //
    })();},[]);
    
    let etiquetaCertIngMod = vectorOpcionesAseguradoras[aseguradora+' CertIngMod etiqueta '+persona.tipo_persona] ? 
      vectorOpcionesAseguradoras[aseguradora+' CertIngMod etiqueta '+persona.tipo_persona] : '';

    let etiquetaBalance = vectorOpcionesAseguradoras[aseguradora+' Balance etiqueta '+persona.tipo_persona] ? 
      vectorOpcionesAseguradoras[aseguradora+' Balance etiqueta '+persona.tipo_persona] : '';
    
    let etiquetaContratoSocial = vectorOpcionesAseguradoras[aseguradora+' ContratoSocial etiqueta '+persona.tipo_persona] ? 
      vectorOpcionesAseguradoras[aseguradora+' ContratoSocial etiqueta '+persona.tipo_persona] : '';

    let etiquetaCertUni = vectorOpcionesAseguradoras[aseguradora+' CertUni etiqueta '+persona.tipo_persona] ?
      vectorOpcionesAseguradoras[aseguradora+' CertUni etiqueta '+persona.tipo_persona] : '';

    const NombreArchivo = ({ambiente, rutaArchivo}) => {
      
      let vectorRutaArchivo = rutaArchivo.split('/');
      let nombreArchivo = '';
      if (ambiente == 'Desarrollo')
      {
        nombreArchivo = vectorRutaArchivo[1];
      }
      else
      {
        nombreArchivo = vectorRutaArchivo[3];
      }
      
      return (<>{nombreArchivo}</>);
    }

    const PrepararImagen = ({ubicacion}) => {
      let vectorUbicacion = ubicacion.split('.');
      let ultimoElemento = vectorUbicacion.length - 1;
      let urlImagen = '';
      if (vectorUbicacion[ultimoElemento] == 'pdf')
      {
        urlImagen = 'https://dev-backend.ofiliaria.com/public/imagenes/pdf.png';
      } 
      else
      {
        urlImagen = urlAlmacenamiento+ubicacion;
      }
      return (<img src={urlImagen} className="img-thumbnail" width="100" />);
    }

    return (
        <>
          <Box sx={{ p : 2 }}>
            <Grid container spacing={{ xs : 2, sm : 2, md : 3, lg : 3, xl : 3 }}>
              <Grid key={'1'} size={{ xs : 12, sm : 6, md : 6, lg : 6, xl : 6 }}>
                <Typography sx={{ fontSize : 16 }} ><strong>{t("Tipo de persona:")}</strong> {persona.tipo_persona}</Typography>
              </Grid>
              {
                inputsAseguradoras[aseguradora+' '+persona.tipo_persona+' numeroIdentidadArrendatario'] == true &&
                  <Grid key={'2'} size={{ xs : 12, sm : 6, md : 6, lg : 6, xl : 6 }}>
                    <Typography sx={{ fontSize : 16 }} ><strong>{t('texto_65')}</strong> {persona.numero_identidad_arrendatario}</Typography>
                  </Grid>
              }
              {
                inputsAseguradoras[aseguradora+' '+persona.tipo_persona+' nombres'] == true &&
                  <Grid key={'3'} size={{ xs : 12, sm : 6, md : 6, lg : 6, xl : 6 }}>
                    <Typography sx={{ fontSize : 16 }} ><strong>{t('texto_79')}</strong> {persona.nombres_arrendatario}</Typography>
                  </Grid>
              }
              {
                inputsAseguradoras[aseguradora+' '+persona.tipo_persona+' apellidos'] == true &&
                  <Grid key={'4'} size={{ xs : 12, sm : 6, md : 6, lg : 6, xl : 6 }}>
                    <Typography sx={{ fontSize : 16 }} ><strong>{t('texto_133')}</strong> {persona.apellidos_arrendatario}</Typography>
                  </Grid>
              }
              {
                inputsAseguradoras[aseguradora+' '+persona.tipo_persona+' monedaIngreso'] == true &&
                  <Grid key={'5'} size={{ xs : 12, sm : 6, md : 6, lg : 6, xl : 6 }}>
                    <Typography sx={{ fontSize : 16 }} ><strong>{t('texto_168')}</strong> {persona.moneda_ingreso}</Typography>
                  </Grid>
              }
              {
                inputsAseguradoras[aseguradora+' '+persona.tipo_persona+' montoIngreso'] == true &&
                  <Grid key={'6'} size={{ xs : 12, sm : 6, md : 6, lg : 6, xl : 6 }}>
                    <Typography sx={{ fontSize : 16 }} ><strong>{t('texto_169')}</strong> {persona.monto_ingreso}</Typography>
                  </Grid>
              }
              {
                inputsAseguradoras[aseguradora+' '+persona.tipo_persona+' numeroIdentidadEmpresa'] == true &&
                  <Grid key={'7'} size={{ xs : 12, sm : 6, md : 6, lg : 6, xl : 6 }}>
                    <Typography sx={{ fontSize : 16 }} ><strong>{t('texto_170')}</strong> {persona.numero_identidad_empresa}</Typography>
                  </Grid>
              }
              {
                inputsAseguradoras[aseguradora+' '+persona.tipo_persona+' empresa'] == true &&
                  <Grid key={'8'} size={{ xs : 12, sm : 6, md : 6, lg : 6, xl : 6 }}>
                    <Typography sx={{ fontSize : 16 }} ><strong>{t('texto_171')}</strong> {persona.empresa}</Typography>
                  </Grid>
              }
              {
                inputsAseguradoras[aseguradora+' '+persona.tipo_persona+' cargoEmpresa'] == true &&
                  <Grid key={'9'} size={{ xs : 12, sm : 6, md : 6, lg : 6, xl : 6 }}>
                    <Typography sx={{ fontSize : 16 }} ><strong>{t('texto_172')}</strong> {persona.cargo_empresa}</Typography>
                  </Grid>
              }
              {
                inputsAseguradoras[aseguradora+' '+persona.tipo_persona+' ingreso'] == true &&
                  <Grid key={'10'} size={{ xs : 12, sm : 6, md : 6, lg : 6, xl : 6 }}>
                    <Typography sx={{ fontSize : 16 }} ><strong>{t('texto_173')}</strong> {persona.ingreso}</Typography>
                  </Grid>
              }
              {
                inputsAseguradoras[aseguradora+' '+persona.tipo_persona+' sueldo'] == true &&
                  <Grid key={'11'} size={{ xs : 12, sm : 6, md : 6, lg : 6, xl : 6 }}>
                    <Typography sx={{ fontSize : 16 }} ><strong>{t('texto_174')}</strong> {persona.sueldo}</Typography>
                  </Grid>
              }
            </Grid>
            <br />
            <Grid container spacing={{ xs : 2, sm : 2, md : 3, lg : 3, xl : 3 }}>
              {
                inputsAseguradoras[aseguradora+' '+persona.tipo_persona+' identidad'] == true &&
                  <Grid key={'1'} size={{ xs : 12, sm : 6, md : 6, lg : 6, xl : 6 }}>
                    <Typography sx={{  fontSize : 16, marginTop: 1, marginBottom : 1 }} ><strong>{t('texto_175')}</strong></Typography>
                    <div className="ra_flex_imagenes">  
                      {
                        persona.ubicacion_identidad.map( (ubicacion, indice) => {
                            return (
                              <div key={indice}>
                                <a href={urlAlmacenamiento+ubicacion} target="_blank"><PrepararImagen ubicacion={ubicacion} /></a>
                                <br />
                              </div>
                            );
                          }
                        )
                      }
                    </div>
                  </Grid>
              }
              {
                inputsAseguradoras[aseguradora+' '+persona.tipo_persona+' recSueldo'] == true &&
                  <Grid key={'2'} size={{ xs : 12, sm : 6, md : 6, lg : 6, xl : 6 }}>
                    <Typography sx={{  fontSize : 16, marginTop: 1, marginBottom : 1 }} ><strong>{t('texto_176')}</strong></Typography>
                    <div className="ra_flex_imagenes">  
                      {
                        persona.ubicaciones_rec_sueldo.map( (ubicacion, indice) => {
                            return (
                              <div key={indice}>
                                <a href={urlAlmacenamiento+ubicacion} target="_blank"><PrepararImagen ubicacion={ubicacion} /></a>
                                <br />
                              </div>
                            );
                          }
                        )
                      }
                    </div>
                  </Grid>
              }
              {
                inputsAseguradoras[aseguradora+' '+persona.tipo_persona+' certIngMod'] == true &&
                  <Grid key={'3'} size={{ xs : 12, sm : 6, md : 6, lg : 6, xl : 6 }}>
                    <Typography sx={{  fontSize : 16, marginTop: 1, marginBottom : 1 }} ><strong>{etiquetaCertIngMod}</strong></Typography>
                    <div className="ra_flex_imagenes">  
                      {
                        persona.ubicaciones_cert_ing_mod.map( (ubicacion, indice) => {
                            return (
                              <div key={indice}>
                                <a href={urlAlmacenamiento+ubicacion} target="_blank"><PrepararImagen ubicacion={ubicacion} /></a>
                                <br />
                              </div>
                            );
                          }
                        )
                      }
                    </div>

                  </Grid>
              }
              {
                inputsAseguradoras[aseguradora+' '+persona.tipo_persona+' dgi'] == true &&
                  <Grid key={'4'} size={{ xs : 12, sm : 6, md : 6, lg : 6, xl : 6 }}>
                    <Typography sx={{  fontSize : 16, marginTop: 1, marginBottom : 1 }} ><strong>{t('texto_177')}</strong></Typography>
                    <div className="ra_flex_imagenes">  
                      {
                        persona.ubicaciones_dgi.map( (ubicacion, indice) => {
                            return (
                              <div key={indice}>
                                <a href={urlAlmacenamiento+ubicacion} target="_blank"><PrepararImagen ubicacion={ubicacion} /></a>
                                <br />
                              </div>
                            );
                          }
                        )
                      }
                    </div>
                  </Grid>
              }
              {
                inputsAseguradoras[aseguradora+' '+persona.tipo_persona+' certDgiCaja'] == true &&
                  <Grid key={'5'} size={{ xs : 12, sm : 6, md : 6, lg : 6, xl : 6 }}>
                    <Typography sx={{  fontSize : 16, marginTop: 1, marginBottom : 1 }} ><strong>{t('texto_178')}</strong></Typography>
                    <div className="ra_flex_imagenes">  
                      {
                        persona.ubicaciones_cert_dgi_caja.map( (ubicacion, indice) => {
                            return (
                              <div key={indice}>
                                <a href={urlAlmacenamiento+ubicacion} target="_blank"><PrepararImagen ubicacion={ubicacion} /></a>
                                <br />
                              </div>
                            );
                          }
                        )
                      }
                    </div>
                  </Grid>
              }
              {
                inputsAseguradoras[aseguradora+' '+persona.tipo_persona+' balance'] == true &&
                  <Grid key={'6'} size={{ xs : 12, sm : 6, md : 6, lg : 6, xl : 6 }}>
                    <Typography sx={{  fontSize : 16, marginTop: 1, marginBottom : 1 }} ><strong>{etiquetaBalance}</strong></Typography>
                    <div className="ra_flex_imagenes">  
                      {
                        persona.ubicaciones_balance.map( (ubicacion, indice) => {
                            return (
                              <div key={indice}>
                                <a href={urlAlmacenamiento+ubicacion} target="_blank"><PrepararImagen ubicacion={ubicacion} /></a>
                                <br />
                              </div>
                            );
                          }
                        )
                      }
                    </div>
                  </Grid>
              }
              {
                inputsAseguradoras[aseguradora+' '+persona.tipo_persona+' rut'] == true &&
                  <Grid key={'7'} size={{ xs : 12, sm : 6, md : 6, lg : 6, xl : 6 }}>
                    <Typography sx={{  fontSize : 16, marginTop: 1, marginBottom : 1 }} ><strong>{t('texto_179')}</strong></Typography>
                    <div className="ra_flex_imagenes">  
                      {
                        persona.ubicaciones_rut.map( (ubicacion, indice) => {
                            return (
                              <div key={indice}>
                                <a href={urlAlmacenamiento+ubicacion} target="_blank"><PrepararImagen ubicacion={ubicacion} /></a>
                                <br />
                              </div>
                            );
                          }
                        )
                      }
                    </div>
                  </Grid>
              }
              {
                inputsAseguradoras[aseguradora+' '+persona.tipo_persona+' contratoSocial'] == true &&
                  <Grid key={'8'} size={{ xs : 12, sm : 6, md : 6, lg : 6, xl : 6 }}>
                    <Typography sx={{  fontSize : 16, marginTop: 1, marginBottom : 1 }} ><strong>{etiquetaContratoSocial}</strong></Typography>
                    <div className="ra_flex_imagenes">  
                      {
                        persona.ubicaciones_contrato_social.map( (ubicacion, indice) => {
                            return (
                              <div key={indice}>
                                <a href={urlAlmacenamiento+ubicacion} target="_blank"><PrepararImagen ubicacion={ubicacion} /></a>
                                <br />
                              </div>
                            );
                          }
                        )
                      }
                    </div>
                  </Grid>
              }
              {
                inputsAseguradoras[aseguradora+' '+persona.tipo_persona+' certUni'] == true &&
                  <Grid key={'9'} size={{ xs : 12, sm : 6, md : 6, lg : 6, xl : 6 }}>
                    <Typography sx={{  fontSize : 16, marginTop: 1, marginBottom : 1 }} ><strong>{etiquetaCertUni}</strong></Typography>
                    <div className="ra_flex_imagenes">  
                      {
                        persona.ubicaciones_cert_uni.map( (ubicacion, indice) => {
                            return (
                              <div key={indice}>
                                <a href={urlAlmacenamiento+ubicacion} target="_blank"><PrepararImagen ubicacion={ubicacion} /></a>
                                <br />
                              </div>
                            );
                          }
                        )
                      }
                    </div>

                  </Grid>
              }
            </Grid>
          </Box>
        </>
      );
  }

  return (
    <div>
      {
        personas.map( (persona, indice) => {
            if (persona.tipo_persona != null && persona.tipo_persona != '' && persona.tipo_persona != ' ')
            {
              let nombrePanel = 'panel'+indice;
              let tituloAcordion = '';
              if (persona.tipo_arrendatario == 'Solicitante')
              {
                tituloAcordion = 'Solicitante';
              }
              else
              {
                tituloAcordion = 'Persona adicional '+indice;
              }
              return (
                <Accordion key={indice} expanded={expanded === nombrePanel} onChange={handleChange(nombrePanel)}>
                  <AccordionSummary aria-controls={nombrePanel+"d-content"} id={nombrePanel+"d-header"}>
                    <Typography sx={{ fontSize : 16 }}>{tituloAcordion}</Typography>
                  </AccordionSummary>
                  <AccordionDetails>
                    <DatosArchivosPersona ambiente={ambiente} aseguradora={aseguradora} persona={persona} urlAlmacenamiento={urlAlmacenamiento} />
                  </AccordionDetails>
                </Accordion>
              );
            }
          }
        )
      }
    </div>
  );
}