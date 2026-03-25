export const AlertPelSC = ({ mensaje }) => {
  return (
    <div className="ra_alerta_opacidad_75 alert alert-danger" role="alert">
      <p>
        {mensaje}
      </p>
    </div>
  );
};