import { useEffect } from 'react';
import { useAppState } from "../state";
import { Contrato } from "../formularios";

export const DatosContrato = () => {
  const [state] = useAppState();

  useEffect(() => {( async () => {
    //
  })();},[]);

  console.log('DatosContrato, state', state);

  return (
    <>
      <Contrato />
    </>
  );
};
