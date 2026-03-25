import { generarClausulaAdicional } from './contratoUtils';

export const ContratoSbi = ({ datosContrato }) => {

  const numeroALetras = (num) => {
    const unidades = ["", "un", "dos", "tres", "cuatro", "cinco", "seis", "siete", "ocho", "nueve"];
    if (num >= 1 && num <= 9) {
      return unidades[num];
    }
    return num;
  };

  const clausulaAdicional = generarClausulaAdicional(datosContrato.terminos_condiciones, 20);

  return (
      <>
        <h3>CONTRATO DE ARRENDAMIENTO</h3>
        
        <p>En {datosContrato.ciudad_firma}, a los {datosContrato.fecha_inicio_alquiler_desglosada.diaLetras} días del mes de {datosContrato.fecha_inicio_alquiler_desglosada.mesLetras} de {datosContrato.fecha_inicio_alquiler_desglosada.anio}, POR UNA PARTE: {datosContrato.texto_arrendador}, en su calidad de arrendador(es), y POR OTRA PARTE: {datosContrato.texto_arrendatario}, en su calidad de arrendatario(s), con domicilio constituido en la finca arrendada sita en {datosContrato.direccion_propiedad}, CONVIENEN LO SIGUIENTE:</p>

        <p>PRIMERO- INMUEBLE ARRENDADO: El (los) arrendador(es) da(n) en arriendo a el (los) arrendatario(s), la finca sita ubicada en {datosContrato.direccion_propiedad}.</p>

        <p>SEGUNDO- DESTINO DEL INMUEBLE: El destino del arriendo es de casa habitación para el (los) arrendatario(s) y su núcleo familiar directo en forma personal, permanente, exclusiva y efectiva. Dicho destino no podrá cambiarse sin previa autorización por escrito del (los) arrendador(es) y de SBI Seguros Uruguay, S.A. (en lo sucesivo “SBI”).</p>

        <p>TERCERO- PRECIO: El precio del arrendamiento será de {datosContrato.costo_alquiler+' '+datosContrato.moneda_propiedad} mensuales. Dichos alquileres deberán ser abonados por por {datosContrato.tipo_pago_alquiler}. Al finalizar el primer año, contado a partir de la suscripción del presente contrato, el precio del arrendamiento será reajustado por IPC, aplicando el coeficiente correspondiente al mes inmediato anterior a dicha vigencia.</p>

        <p>El arrendatario abonará los alquileres por deposito o transferencia en el Banco {datosContrato.banco}, cuenta {datosContrato.numero_cuenta}, a nombre de {datosContrato.nombres_titular_cuenta+' '+datosContrato.apellidos_titular_cuenta}, antes de los diez (10) primeros días del mes y el boleto de depósito será válido cómo recibo de pago de alquiler, siempre que éste sea abonado dentro del plazo estipulado. Si durante el plazo de ejecución del contrato, la arrendadora modificara la cuenta bancaria, esta quedará obligada a notificar dicho cambio a la arrendataria de forma fehaciente, sin que ello implique una modificación del contrato.</p>

        <p>
          CUARTO- PLAZO: El plazo computa a partir del día de la firma del presente contrato, y será de {numeroALetras(datosContrato.plazo_alquiler)} ({datosContrato.plazo_alquiler}) {datosContrato.plazo_alquiler > 1 ? datosContrato.tipo_plazo_alquiler : datosContrato.tipo_plazo_alquiler.slice(0, -1)} con opción a {numeroALetras(datosContrato.plazo_alquiler)} ({datosContrato.plazo_alquiler}) {datosContrato.plazo_alquiler > 1 ? datosContrato.tipo_plazo_alquiler : datosContrato.tipo_plazo_alquiler.slice(0, -1)} más a favor del arrendatario.
        </p>
        
        <p>
          En caso de no tomar la opción de renovación, el arrendatario se compromete a comunicarlo al arrendador con un pre-aviso de 30 días corridos, por telegrama colacionado. 
          De lo contrario el contrato se extenderá por {numeroALetras(datosContrato.plazo_alquiler)} {datosContrato.plazo_alquiler > 1 ? datosContrato.tipo_plazo_alquiler : datosContrato.tipo_plazo_alquiler.slice(0, -1)} más. 
          Durante todo el plazo el arrendamiento deberá permitir - previo aviso - realizar visitas para una posible oferta de venta o arrendamiento.
        </p>

        <p>QUINTO- GARANTÍA: Las partes acuerdan la contratación de la garantía de SBI, en las condiciones del seguro establecido entre las mismas y la referida Aseguradora. El Asegurado será el arrendador. La entrega de la llave se hará efectiva a partir de que el Arrendatario presente la póliza correspondiente y comprobante de pago de la primera cuota del seguro o el pago del premio por entero. Son de conocimiento del Arrendador y Arrendatario/s las Condiciones Generales del seguro se obliga a contratar una póliza de garantía de alquiler de inmueble de SBI y que el pago del premio del seguro en tiempo y forma es una obligación principal de este contrato que está a su cargo. El asegurado será el arrendador.</p>

        <p>SEXTO- SUBARRENDAMIENTO: El arrendatario no podrá subarrendar total o parcialmente el arriendo ni cederlo en todo o en parte sin autorización escrita del arrendador y de SBI. No podrá conceder su uso a terceros ni aún a título gratuito. Tampoco podrá efectuar reformas o mejoras sin el consentimiento escrito del arrendador y las que hiciere quedaran a beneficio de la propiedad sin derecho a indemnización alguna.</p>

        <p>SÉPTIMO- GASTOS COMUNES Y CONSUMOS GENERALES: a) Serán de exclusivo cargo del arrendatario el pago de los consumos de aguas corrientes, electricidad, gas, calefacción y cualquier otro suministro que se realice al inmueble, así como los gastos comunes, consumos generales y cualquier otro servicio, correspondientes a la finca que se arrienda o que se originen por el uso u ocupación de la misma, incluso los del mes de desocupación y entrega del bien, debiendo al retirarse presentar al Arrendador los recibos correspondientes, que quedarán en poder de éste, bajo recibo, si se reclamare. También serán de cargo del arrendatario el pago de los impuestos y demás tributos, presentes o futuros, que tengan como presupuesto de hecho dicho uso u ocupación del inmueble o cuyo sujeto pasivo no sea el propietario o administrador, o que las leyes o decretos no prohíban repetir, siendo de su cargo cualquier aumento porcentual o de escala que sufrieran, ya sea por ley o por modificación del precio del alquiler. En caso que fueran abonados por el propietario o arrendador cualquiera de los rubros de este artículo, el inquilino realizará el reembolso en forma inmediata, conjunta e indivisible con el primer pago del alquiler que deba realizar. Si la recaudación no fuere mensual, el inquilino los reembolsará con el alquiler del primer mes siguiente a aquél en el que se hizo el pago del consumo o tributo. b) El arrendatario se obliga a que los servicios y consumos se encuentren registrados a su nombre y en dicha calidad, sustituyéndolos en su caso a su costo, previo a ocupar la finca. c) Cuando el servicio de medidores fuere contratado por el arrendador, el pago de los consumos mensuales y el del alquiler de los contadores, se hará conjuntamente con la renta, en forma indivisible. Se conviene que todo reclamo relacionado con defecto o error en los controles correspondientes, el inquilino solamente los dirigirá contra la empresa contratada, y recién cuando ésta los rectifique, podrá solicitar y obtener las devoluciones que correspondieren. d) El mismo régimen se aplicará al precio de los servicios de limpieza periódica de cañerías e instalaciones y aparatos sanitarios que se contratare. e) Cuando el consumo o gasto abarquen más de una finca, la liquidación a abonar por el inquilino se realizará en la forma y proporción establecidas por la ley No. 10.751 de 25.6.1946 para las unidades de propiedad horizontal, y por el decreto 990/974 de 5.12.1974 en caso de edificios de renta, con sus modificativas. f) En caso de existir pozo negro o cámara séptica, la limpieza y desagote será de cuenta exclusiva del arrendatario, quien deberá entregarlos vacíos y limpios al devolver la finca. g) Serán de cargo del propietario de la finca el pago de la Contribución Inmobiliaria y el Impuesto de Primaria</p>

        <p>OCTAVO- CONSERVACIÓN DEL INMUEBLE: El estado del bien surge del inventario que acompaña al presente contrato y que forma uno solo con el mismo, y deberá ser firmado por las partes. Comprimiéndose el Arrendatario a devolverlo en igual estado, salvo por el deterioro causado por el uso y goce legítimo, la acción del tiempo, etc., en un todo de acuerdo con lo dispuesto en los artículos 1.818 y 1.819 y 1.820 y concordantes del Código Civil</p>

        <p>NOVENO- ENTREGA DE LA FINCA: Al tiempo de desocupar la finca el arrendatario dará cuenta de esto al arrendador con una anticipación no menor de treinta días en forma escrita. A) El arrendatario devolverá el inmueble totalmente desocupado de personas y cosas y en el mismo estado en que lo recibió, haciendo entrega de las llaves contra recibo escrito de la arrendadora, previa realización de inspección e inventario para constatar el estado de la finca y los desperfectos que tuviere. El acta será firmada por el arrendatario o su representante, y en la misma se dejará constancia si se adeudan alquileres, tributos, consumos, desperfectos, y si se han entregado los correspondientes recibos que acreditan los pagos o si se deberán acreditar posteriormente. B) La entrega de las llaves del inmueble se realizará en la misma finca o en el domicilio de la arrendadora, previo aviso, para que la arrendadora concurra a la realización de la inspección e inventario. C) Si por cualquier causa no concurriera el inquilino o su representante, o se frustrara la diligencia por causa imputable al inquilino, desde ya el arrendatario da comisión expresa a la arrendadora para que realice por sus técnicos el inventario y evaluación de los desperfectos que se constataren, los que se tendrán por firmes y por suma líquida, y que el arrendatario deberá y pagará a la arrendadora.- D) La recepción de la finca se realizará sin perjuicio de la reclamación posterior de los daños y perjuicios que se hubieran causado o se causen como consecuencia del estado de la finca y la demora en entregarla. E) La parte arrendataria acuerda no eximirse unilateralmente del pago, ni proponer otro arrendatario que lo sustituya (art. 1823 inciso segundo del Código Civil).</p>

        <p>DÉCIMO- USO Y GOCE: El arrendador se obliga a asegurar el uso y goce del bien arrendado, no pudiendo, -sin consentimiento escrito del arrendatario-, mudar la forma de la cosa arrendada, ni hacer en ella obras o trabajos que puedan perturbar el goce, sin perjuicio de las excepciones establecidas en el artículo 1.799 del Código Civil.</p>

        <p>DÉCIMO PRIMERO- RESERVA DE ENAJENACIÓN: La arrendadora se reserva el derecho de enajenar la finca objeto del arriendo, sin responder por daños y perjuicios que pudiera generar dicha venta. En tal sentido, el inquilino se obliga a permitir el acceso al inmueble al arrendador y los eventuales compradores en un horario a convenir por las partes.</p>

        <p>DÉCIMO SEGUNDO- MORA Y CONDICIÓN RESOLUTORIA:  A) El inquilino caerá en mora de pleno derecho sin necesidad de intimación judicial ni extrajudicial alguna, por el sólo vencimiento de los plazos establecidos, por hacer algo contrario a lo acordado o que corresponda por derecho, u omitir lo que se obligó. Si durante el plazo contractual el arrendador promoviere desalojo por mora del arrendatario, ello no le impedirá reclamar del mismo el importe de los alquileres que restan hasta la expiración de dicho plazo contractual, además de los ya devengados. Toda vez que el arrendatario incurra en mora en el pago de alquileres o accesorios el arrendador tendrá derecho a reclamarlos del mismo con más el máximo interés legal, siguiendo lo previsto por las leyes vigentes; B) Se exceptúa el régimen de mora establecido por el decreto Ley Nº 14.219 para el pago del precio del alquiler y demás rubros indivisibles; C) En caso de incumplimiento de cualquiera de las obligaciones o prohibiciones establecidas por este contrato o por la ley, se pacta la condición resolutoria expresa.</p>

        <p>DÉCIMO CUARTO: Al entregar la finca el arrendatario deberá presentar los recibos que acrediten estar al día con los rubros a que se refieren el presente contrato. De no ser así depositará en manos de la arrendadora y/o de SBI, la suma que ésta fije con cargo a devolución de lo que corresponda.</p>

        <p>DÉCIMO QUINTO- TRASPASO DE SERVICIOS: El arrendatario se compromete en un plazo de diez (10) días a traspasar todos los servicios, ejemplo el servicio de energía eléctrica.</p>

        <p>DÉCIMO SEXTO- REGLAMENTO DE COPROPIETARIO: El arrendatario se obliga a respetar el reglamento de co-propiedad que rige el condominio del edificio y las reglamentaciones internas dictadas o que puedan dictarse siendo de su cargo cualquier sanción originada en infracción o incumplimiento de los mismos.</p>

        {
          datosContrato.regimen_ajuste_alquiler == 'Contrato regido por ley 14.219 (permiso de construcción anterior al 02/06/68)' ?
          <p>DÉCIMO OCTAVO: La finca tiene permiso de construcción anterior a 1968, por ende, se rige por la ley 14.219</p> :
          <p>DÉCIMO OCTAVO: La finca tiene permiso de construcción posterior a 1968, por ende, se rige por el régimen de libre contratación.</p> 
        } 

        <p>DÉCIMO NOVENO- DOMICILIO: Para todos los efectos judiciales o extrajudiciales a que diere lugar ese contrato, las partes fijan como domicilios especiales, los indicados como suyos en este instrumento.</p>

        <div dangerouslySetInnerHTML={{ __html: clausulaAdicional }} />

        <p>Previa lectura que las partes hace de este documento lo ratifican y firman en lugar y fecha arriba indicados. Extendiéndose tres ejemplares, uno para cada parte y una para la Aseguradora libre de cargos.</p>
      </>
  );
}