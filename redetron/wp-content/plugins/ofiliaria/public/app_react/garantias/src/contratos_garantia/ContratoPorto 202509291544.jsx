import { useState, useRef, useEffect } from 'react';

export const ContratoPorto = ({ datosContrato }) => {
  return (
      <>
        <h3>CONTRATO DE ARRENDAMIENTO</h3>
        
        <p>En {datosContrato.ciudad_firma}, a los {datosContrato.fecha_inicio_alquiler_desglosada.diaLetras} días del mes de {datosContrato.fecha_inicio_alquiler_desglosada.mesLetras} de {datosContrato.fecha_inicio_alquiler_desglosada.anio}, POR UNA PARTE {datosContrato.nombres_apellidos_propietario_1}, titular del(la) {datosContrato.tipo_documento_identidad_propietario_1} nro. {datosContrato.numero_documento_identidad_propietario_1} en su calidad de arrendador, con domicilio constituido en {datosContrato.domicilio_propietario_1} y, POR OTRA PARTE: {datosContrato.nombres_apellidos_solicitante}, titular de la cédula de identidad nro. {datosContrato.numero_documento_identidad_solicitante}, en su calidad de arrendatario, con domicilio constituido en la finca arrendada sita en {datosContrato.direccion_propiedad}, CONVIENEN LO SIGUIENTE:</p>
        
        <p>PRIMERO: {datosContrato.nombres_apellidos_propietario_1} en su calidad de arrendador, da en arriendo a {datosContrato.nombres_apellidos_solicitante}, la finca sita en {datosContrato.direccion_propiedad}.</p>
        
        <p>SEGUNDO: El destino del arriendo es de casa habitación para él y su núcleo familiar directo. Dicho destino no podrá cambiarse sin previa autorización por escrito del arrendador y de Porto Seguro - Seguros del Uruguay S.A.</p> 
        
        <p>TERCERO: El precio del arrendamiento será de {datosContrato.costo_alquiler+' '+datosContrato.moneda_propiedad} mensuales. Dichos alquileres deberán ser abonados por {datosContrato.tipo_pago_alquiler}. Al finalizar el primer año, el precio del arrendamiento será reajustado por IPC. El arrendatario abonará los alquileres por deposito en el Banco {datosContrato.banco}, cuenta {datosContrato.numero_cuenta}, a nombre de {datosContrato.nombres_titular_cuenta+' '+datosContrato.apellidos_titular_cuenta}, antes de los diez primeros días del mes y el boleto de depósito será válido cómo recibo de pago de alquiler, siempre que éste sea abonado dentro del plazo estipulado. El arrendatario abonará además los gastos comunes que correspondan al uso y goce del bien, y los convenidos con el arrendador, según los importes que resulten de las resoluciones y liquidaciones de los órganos y autoridades de la co-propiedad, en la fecha y lugar por ésta designado.</p> 
        
        <p>CUARTO: El plazo computa a partir del día de la firma del presente contrato, y será de un año con opción a un año más a favor del inquilino. En caso de no tomar el segundo año de opción el arrendatario se compromete a comunicarlo al arrendador con un pre-aviso de 30 días corridos, por telegrama colacionado. De lo contrario el contrato se extenderá por un año más. Durante todo el plazo el arrendamiento deberá permitir – previo aviso – realizar visitas para una posible oferta de venta o arrendamiento.</p> 
        
        <p>QUINTO: Las partes acuerdan la garantía de Porto Seguro - Seguros del Uruguay S.A. en las condiciones del seguro establecido entre las mismas y la referida aseguradora</p> 
        
        <p>SEXTO: La entrega de llaves se hará efectiva a partir de que el arrendatario presente ante la administradora la póliza correspondiente y el comprobante de pago de la primera cuota del seguro.</p>
        
        <p>SÉPTIMO: Son de conocimiento del Arrendador y Arrendatario/s las Condiciones Generales del seguro Porto Alquiler</p>
        
        <p>OCTAVO: El arrendatario no podrá subarrendar total o parcialmente el arriendo ni cederlo en todo o en parte sin autorización escrita del arrendador y de Porto Seguro - Seguros del Uruguay S.A. - Seguros del Uruguay S.A. No podrá conceder su uso a terceros ni aún a título gratuito. Tampoco podrá efectuar reformas o mejoras sin el consentimiento escrito del arrendador y las que hiciere quedaran a beneficio de la propiedad sin derecho a indemnización alguna.</p> 
        
        <p>NOVENO: Los consumos de luz, gas y agua etc. e impuestos municipales o nacionales (vigentes o por crearse y que sean de cargo del inquilino), incluso los del mes hasta el día en que se desocupe la finca, serán de exclusiva cuenta del arrendatario debiendo al desocupar la finca, presentar al arrendador los recibos correspondientes que quedarán en poder de éste.</p> 
        
        <p>DÉCIMO: El estado del bien surge del inventario que acompaña al presente contrato y que forma uno solo con el mismo, y deberá ser firmado por las partes.</p>
        
        <p>DECIMO PRIMERO: Al tiempo de desocupar la finca el inquilino dará cuenta de esto al arrendador con una anticipación no menor de treinta días en forma escrita. El arrendador designará una persona que en presencia del inquilino reciba la finca previo inventario de la misma que firmarán ambos. Al no procederse por el inquilino en la forma indicada, el inventario será realizado por el arrendador, obligándose el arrendatario a subsanar o a abonar los desperfectos que resultaron del mismo.</p> 
        
        <p>DÉCIMO SEGUNDO: El propietario se reserva el derecho de enajenar esta propiedad sin incurrir en ninguna clase de responsabilidad.</p> 
        
        <p>DÉCIMO TERCERO: Si durante el plazo contractual el arrendador promoviere desalojo por mora del inquilino, ello no le impedirá reclamar del mismo el importe de los alquileres que restan hasta la expiración de dicho plazo contractual, además de los ya devengados.</p> 
        
        <p>DÉCIMO CUARTO: En caso de incumplimiento de la parte arrendataria en el pago de alquileres y accesorios que correspondan a este contrato, la parte arrendadora concede la subrogación a favor de Porto Seguro - Seguros del Uruguay S.A. (art. 669 del Código de Comercio y art.42 ley 19.678). La arrendadora se obliga a mantener en custodia una vía original de contrato de arrendamiento e inventario firmados y relevamiento fotográfico del inmueble para ser entregados a Porto Seguro - Seguros del Uruguay S.A. en caso de siniestro o cuando ésta lo solicite.</p>
        
        <p>DÉCIMO QUINTO: Al entregar la finca el inquilino deberá presentar los recibos que acrediten estar al día con los rubros a que se refiere la cláusula sexta. De no ser así depositará en manos de la arrendadora y/o de Porto Seguro - Seguros del Uruguay S.A., la suma que ésta fije con cargo a devolución de lo que corresponda.</p> 
        
        <p>DÉCIMO SEXTO: El arrendatario se compromete en un plazo de diez días a traspasar todos los servicios, ejemplo el servicio de energía eléctrica.</p>
        
        <p>DÉCIMO SÉPTIMO: El/los Arrendatario/s devolverá/n el inmueble totalmente desocupado de personas y cosas y en el mismo estado en que lo recibe/n del Arrendador, haciendo entrega de las llaves contra recibo escrito de éste último, previa realización de inspección ocular e inventario para constatar el estado de la finca y los desperfectos que tuviere</p>
        
        <p>DÉCIMO OCTAVO: Las partes convienen expresamente que, si al momento de realizarse el lanzamiento de la finca arrendada existieren dentro de la misma bienes muebles y/o inmuebles por accesión, los mismos se considerarán irrevocablemente abandonados a favor del arrendador, quien podrá ejercer cualquiera de las facultades establecidas en el artículo 487 del Código Civil, sin responsabilidad de especie alguna.</p>
        
        <p>DÉCIMO NOVENO: Las partes acuerdan firmar la rescisión del presente contrato, aun cuando ésta se realice al final del plazo contractual, y enviarla a Porto Seguro - Seguros del Uruguay S.A. mediante mail a la casilla</p>
        
        <p>VIGÉSIMO: El arrendatario se obliga a respetar el reglamento de co-propiedad que rige el condominio del edificio y las reglamentaciones internas dictadas o que puedan dictarse siendo de su cargo cualquier sanción originada en infracción o incumplimiento de los mismos.</p> 
        
        <p>VIGÉSIMO PRIMERO: El arrendatario caerá en mora de pleno derecho, sin necesidad de interpelación judicial y/o extrajudicial alguna, por la sola realización u omisión de cualquier acto o hecho que consta en hacer algo contratario o no hacer algo ordenado en este contrato o la ley.</p>
        
        {
          datosContrato.regimen_ajuste_alquiler == 'Contrato regido por ley 14.219 (permiso de construcción anterior al 02/06/68)' ?
          <p>VIGÉSIMO SEGUNDO: La finca tiene permiso de construcción anterior a 1968, por ende, se rige por la ley 14.219</p> :
          <p>VIGÉSIMO SEGUNDO: La finca tiene permiso de construcción posterior a 1968, por ende, se rige por el régimen de libre contratación.</p> 
        } 
        
        <p>Previa lectura que las partes hace de este documento lo ratifican y firman en lugar y fecha arriba indicados. Extendiéndose tres ejemplares uno para cada parte.</p>
      </>
  );
}