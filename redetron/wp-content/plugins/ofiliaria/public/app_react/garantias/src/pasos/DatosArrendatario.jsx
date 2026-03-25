import { useState, useRef, useEffect } from 'react';
import { useAppState } from "../state.jsx";
import { Arrendatario } from "../formularios";
import { GifEspere } from "../varios";
import { useParams, useNavigate } from "react-router-dom";

export const DatosArrendatario = () => {
  const [state, setState] = useAppState();
  const { idPersona } = useParams();
  const navigate = useNavigate();
  const [formArrendatario, setFormArrendatario] = useState(<GifEspere />)
  
  useEffect(() => {( async () => {
    if (idPersona == 9999999999)
    {
      navigate('/personas-adicionales/'+state.id);
    }
    else
    {
      setFormArrendatario(<Arrendatario />);
    }
  })();},[]);

  return (<>{formArrendatario}</>); 
}