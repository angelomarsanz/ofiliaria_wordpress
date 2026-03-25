export const AlertAdvSC = ({ mensaje }) => {
  return (
    <div className="ra_alerta_opacidad_75 alert alert-warning" role="alert">
      <p>
        {mensaje}
      </p>
    </div>
  );
}