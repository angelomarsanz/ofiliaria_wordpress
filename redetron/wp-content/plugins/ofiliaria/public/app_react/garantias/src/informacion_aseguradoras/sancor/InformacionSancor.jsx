import AcordionMuiSancor from "./AcordionMuiSancor.jsx";
import { BsCheckLg } from "react-icons/bs";
import Grid from '@mui/material/Grid2';

const InformacionSura = () => {
  return (
    <>
      <br />
      <Grid container>
        <Grid key={'1'} display="flex" justifyContent="center" size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
          <div className="ra_informacion ra_package">
            <div className="ra_p2"><div className="ra_big">SANCOR</div></div>
            <h2>Beneficios</h2>
            <div className="ra_price">Comisión por cada garantía emitida</div>
            <ul className="ra_ul">
              <li key="1" className="ra_li"><span className='ra_icono'><BsCheckLg /></span>Protección de incumplimiento de pago.</li>
              <li key="2" className="ra_li"><span className='ra_icono'><BsCheckLg /></span>Servicios de Plomería.</li>
              <li key="3" className="ra_li"><span className='ra_icono'><BsCheckLg /></span>Servicio de reparación estructural.</li>
              <li key="4" className="ra_li"><span className='ra_icono'><BsCheckLg /></span>Servicio de Mantenimiento mensual.</li>
              <li key="5" className="ra_li"><span className='ra_icono'><BsCheckLg /></span>Protección contra incendios</li>
              <li key="6" className="ra_li"><span className='ra_icono'><BsCheckLg /></span>Hasta 3 personas pueden sumar sus ingresos para una misma garantía de alquiler</li>
            </ul>
            <div className="ra_p3">Ésta información fue extraída del sitio oficial de la aseguradora, visite el sitio oficial para más información.</div>
          </div>
          <br /><br/>
        </Grid>
        <Grid key={'2'} display="flex" justifyContent="center" size={{ xs : 12, sm : 12, md : 6, lg : 6, xl : 6 }}>
          <div className="ra_informacion ra_package ra_package_gold">
            <div className="ra_p4"><div className="ra_big">Requisitos</div></div>
            <AcordionMuiSancor />   
          </div>
          <br /><br/>
        </Grid>
      </Grid>
    </>
  );
}

export default InformacionSura;