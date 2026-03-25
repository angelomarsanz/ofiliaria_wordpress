import { useLocation } from "react-router-dom";

const Stepper = ( {contenidoLineaTiempo }) => {
  const location = useLocation();
  const vectorRuta = location.pathname.split('/')[1];

  const getLinkClass = (path) => {
    let clasePaso = "input_ofiliaria ";
    if (path == vectorRuta)
    {
      clasePaso += "active_ofiliaria";  
    }      
    return clasePaso;
  };

  return (
    <>
      <div className="row">
        <div className="col-xs-12 col-sm-12 col-md-12 col-lg-12 wpestate_dash_coluns">
          <div className="flex_parent_ofiliaria">
            <div className="input_flex_container_ofiliaria">
              <div className={getLinkClass("seleccionar-aseguradora")}>
                {contenidoLineaTiempo.paso1}
              </div>
              <div className={getLinkClass("datos-propiedad")}>
                {contenidoLineaTiempo.paso2}
              </div>
              <div className={getLinkClass("datos-arrendatario")}>
                {contenidoLineaTiempo.paso3}
              </div>
              <div className={getLinkClass("personas-adicionales")}>
                {contenidoLineaTiempo.paso4}
              </div>
            </div>
          </div>
        </div>
      </div>
    </>
  )
};

export default Stepper;
