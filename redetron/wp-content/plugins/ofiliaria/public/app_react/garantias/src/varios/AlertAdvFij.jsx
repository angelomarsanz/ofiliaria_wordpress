export const AlertAdvFij = ({ mensaje }) => {
  return (
    <div className="ra_alerta_fija alert alert-warning" role="alert">
      <p>
        <a className="close" data-dismiss="alert" aria-label="close">×</a>
        {mensaje}
      </p>
    </div>
  );
}