import React from "react";
import { AlertPelSC } from "../varios";

export const Field = ({ children, label, error }) => {
  const id = getChildId(children);
  let mensajeError = '';
  if (error)
  {
    mensajeError = <AlertPelSC mensaje={error.message} />;
  }

  return (
    <div className="form-group">
      <label htmlFor={id}>
        {label}
      </label>
      {children}
      {mensajeError}
    </div>
  );
};

// Get id prop from a child element
export const getChildId = (children) => {
  const child = React.Children.only(children);

  if ("id" in child?.props) {
    return child.props.id;
  }
};
