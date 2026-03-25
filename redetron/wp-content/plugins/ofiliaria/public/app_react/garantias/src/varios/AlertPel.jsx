export const AlertPel = ({ mensaje }) => {
  return (
    <div className="ra_alerta_opacidad_75 alert alert-danger" role="alert">
      <p>
        <a className="close" data-dismiss="alert" aria-label="close">×</a>
        {mensaje}
      </p>
    </div>
  );
}