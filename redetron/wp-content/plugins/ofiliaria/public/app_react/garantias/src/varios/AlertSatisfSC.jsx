export const AlertSatisfSC = ({ mensaje }) => {
  return (
    <div className="ra_alerta_opacidad_75 alert alert-success" role="alert">
      <p>
        {mensaje}
      </p>
    </div>
  );
}