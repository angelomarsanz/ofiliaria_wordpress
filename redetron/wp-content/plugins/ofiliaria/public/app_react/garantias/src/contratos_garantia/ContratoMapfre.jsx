import { useState, useRef, useEffect } from 'react';
import { generarClausulaAdicional } from './contratoUtils';

export const ContratoMapfre = ({ datosContrato }) => {

  const numeroALetras = (num) => {
    const unidades = ["", "un", "dos", "tres", "cuatro", "cinco", "seis", "siete", "ocho", "nueve"];
    if (num >= 1 && num <= 9) {
      return unidades[num];
    }
    return num;
  };

  const clausulaAdicional = generarClausulaAdicional(datosContrato.terminos_condiciones, 18);

  return (
      <>
        <h3>CONTRATO DE ARRENDAMIENTO</h3>
        
        <p>En {datosContrato.ciudad_firma}, a los {datosContrato.fecha_inicio_alquiler_desglosada.diaLetras} días del mes de {datosContrato.fecha_inicio_alquiler_desglosada.mesLetras} de {datosContrato.fecha_inicio_alquiler_desglosada.anio}, POR UNA PARTE: {datosContrato.texto_arrendador}, en su calidad de arrendador(es), y, POR OTRA PARTE: {datosContrato.texto_arrendatario}, en su calidad de arrendatario(s), con domicilio constituido en la finca arrendada sita en {datosContrato.direccion_propiedad}, CONVIENEN LO SIGUIENTE:</p>
        
        <p>PRIMERO: El (los) arrendador(es) da(n) en arriendo a el (los) arrendatario(s), la finca sita en {datosContrato.direccion_propiedad}.</p>
        
        <p>SEGUNDO: El destino del arriendo es de casa habitación para el (los) arrendatario(s) y su núcleo familiar directo. Dicho destino no podrá cambiarse sin previa autorización por escrito del (los) arrendador(es) y de MAPFRE</p> 
        
        <p>TERCERO: El precio del arrendamiento será de {datosContrato.costo_alquiler+' '+datosContrato.moneda_propiedad} mensuales. Dichos alquileres deberán ser abonados por {datosContrato.tipo_pago_alquiler}. Al finalizar el primer año, el precio del arrendamiento será reajustado por IPC. El arrendatario abonará los alquileres por deposito en el Banco {datosContrato.banco}, cuenta {datosContrato.numero_cuenta}, a nombre de {datosContrato.nombres_titular_cuenta+' '+datosContrato.apellidos_titular_cuenta}, antes de los diez primeros días del mes y el boleto de depósito será válido cómo recibo de pago de alquiler, siempre que éste sea abonado dentro del plazo estipulado. El arrendatario abonará además los gastos comunes que correspondan al uso y goce del bien, y los convenidos con el arrendador, según los importes que resulten de las resoluciones y liquidaciones de los órganos y autoridades de la co-propiedad, en la fecha y lugar por ésta designado.</p> 
        
        <p>
          CUARTO: El plazo computa a partir del día de la firma del presente contrato, y será de {numeroALetras(datosContrato.plazo_alquiler)} {datosContrato.plazo_alquiler > 1 ? datosContrato.tipo_plazo_alquiler : datosContrato.tipo_plazo_alquiler.slice(0, -1)} con opción a {numeroALetras(datosContrato.plazo_alquiler)} {datosContrato.plazo_alquiler > 1 ? datosContrato.tipo_plazo_alquiler : datosContrato.tipo_plazo_alquiler.slice(0, -1)} más a favor del inquilino. 
          En caso de no tomar la opción de renovación, el arrendatario se compromete a comunicarlo al arrendador con un pre-aviso de 30 días corridos, por telegrama colacionado. 
          De lo contrario el contrato se extenderá por {numeroALetras(datosContrato.plazo_alquiler)} {datosContrato.plazo_alquiler > 1 ? datosContrato.tipo_plazo_alquiler : datosContrato.tipo_plazo_alquiler.slice(0, -1)} más. 
          Durante todo el plazo el arrendamiento deberá permitir - previo aviso - realizar visitas para una posible oferta de venta o arrendamiento.
        </p>
        
        <p>QUINTO: El arrendatario se obliga a contratar una póliza de garantía de alquiler de MAPFRE URUGUAY SEGUROS S.A. y que el pago del premio del seguro es de su cargo. El asegurado será el arrendador.</p> 
        
        <p>SÉXTO: El arrendatario no podrá subarrendar total o parcialmente el arriendo ni cederlo en todo o en parte sin autorización escrita del arrendador y de MAPFRE No podrá conceder su uso a terceros ni aún a título gratuito. Tampoco podrá efectuar reformas o mejoras sin el consentimiento escrito del arrendador y las que hiciere quedaran a beneficio de la propiedad sin derecho a indemnización alguna.</p> 
        
        <p>SÉPTIMO: Los consumos de luz, gas y agua etc. e impuestos municipales o nacionales (vigentes o por crearse y que sean de cargo del inquilino), incluso los del mes hasta el día en que se desocupe la finca, serán de exclusiva cuenta del arrendatario debiendo al desocupar la finca, presentar al arrendador los recibos correspondientes que quedarán en poder de éste.</p> 
        
        <p>OCTAVO: El estado del bien surge del inventario que acompaña al presente contrato y que forma uno solo con el mismo, y deberá ser firmado por las partes.</p>
        
        <p>NOVENO: Al tiempo de desocupar la finca el inquilino dará cuenta de esto al arrendador con una anticipación no menor de treinta días en forma escrita. El arrendador designará una persona que en presencia del inquilino reciba la finca previo inventario de la misma que firmarán ambos. Al no procederse por el inquilino en la forma indicada, el inventario será realizado por el arrendador, obligándose el arrendatario a subsanar o a abonar los desperfectos que resultaron del mismo.</p> 
        
        <p>DÉCIMO: El propietario se reserva el derecho de enajenar esta propiedad sin incurrir en ninguna clase de responsabilidad.</p> 
        
        <p>DÉCIMO PRIMERO: Si durante el plazo contractual el arrendador promoviere desalojo por mora del inquilino, ello no le impedirá reclamar del mismo el importe de los alquileres que restan hasta la expiración de dicho plazo contractual, además de los ya devengados.</p> 
        
        <p>DÉCIMO SEGUNDO: Toda vez que el arrendatario incurra en mora en el pago de alquileres o accesorios el arrendador tendrá derecho a reclamarlos del mismo con más el máximo interés legal, siguiendo lo previsto por las leyes vigentes.</p>
        
        <p>DÉCIMO TERCERO: Al entregar la finca el inquilino deberá presentar los recibos que acrediten estar al día con los rubros a que se refiere la cláusula sexta. De no ser así depositará en manos de la arrendadora y/o de MAPFRE, la suma que ésta fije con cargo a devolución de lo que corresponda.</p> 
        
        <p>DÉCIMO CUARTO: El arrendatario se compromete en un plazo de diez días a traspasar todos los servicios, ejemplo el servicio de energía eléctrica.</p>
        
        <p>DÉCIMO QUINTO: El arrendatario se obliga a respetar el reglamento de co-propiedad que rige el condominio del edificio y las reglamentaciones internas dictadas o que puedan dictarse siendo de su cargo cualquier sanción originada en infracción o incumplimiento de los mismos.</p> 
        
        <p>DÉCIMO SEXTO: El arrendatario caerá en mora de pleno derecho, sin necesidad de interpelación judicial y/o extrajudicial alguna, por la sola realización u omisión de cualquier acto o hecho que consta en hacer algo contratario o no hacer algo ordenado en este contrato o la ley.</p>
        
        {
          datosContrato.regimen_ajuste_alquiler == 'Contrato regido por ley 14.219 (permiso de construcción anterior al 02/06/68)' ?
          <p>DÉCIMO SÉPTIMO: La finca tiene permiso de construcción anterior a 1968, por ende, se rige por la ley 14.219</p> :
          <p>DÉCIMO SEPTIMO: La finca tiene permiso de construcción posterior a 1968, por ende, se rige por el régimen de libre contratación.</p> 
        } 
        
        <div dangerouslySetInnerHTML={{ __html: clausulaAdicional }} />

        <p>Previa lectura que las partes hace de este documento lo ratifican y firman en lugar y fecha arriba indicados. Extendiéndose tres ejemplares uno para cada parte.</p>
      </>
  );
}