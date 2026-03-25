export const AlertPelFij = ({ mensaje }) => {
  return (
    <div className="ra_alerta_fija alert alert-danger" role="alert">
      <p>
        <a className="close" data-dismiss="alert" aria-label="close">×</a>
        {mensaje}
      </p>
    </div>
  );
}