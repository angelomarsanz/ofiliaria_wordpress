export const AlertInfSC = ({ mensaje }) => {
  return (
    <div className="alert alert-info" role="alert">
      <p>
        <a className="close" data-dismiss="alert" aria-label="close">×</a>
        {mensaje}
      </p>
    </div>
  );
};