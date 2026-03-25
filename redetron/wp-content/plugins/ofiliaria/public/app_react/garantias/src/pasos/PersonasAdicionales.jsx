import { useEffect } from 'react';
import { useAppState } from "../state";
import { Arrendatario } from "../formularios";

export const PersonasAdicionales = () => {
  const [state] = useAppState();

  useEffect(() => {( async () => {
    //
  })();},[]);

  console.log('PersonasAdicionales, state', state);

  return (
    <>
      <Arrendatario />
    </>
  );
};
