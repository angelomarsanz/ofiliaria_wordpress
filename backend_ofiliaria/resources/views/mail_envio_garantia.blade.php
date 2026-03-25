<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mail Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #f2f2f2;
            padding: 20px;
        }
        h1 {
            color: #444;
        }
    </style>
</head>
<body>
    @php 
        $contadorCodeudor = 1; 
        $inputsAseguradoras = (Array) $datos->inputs_aseguradoras;
        $aseguradora = $datos->aseguradora;
        $urlAlmacenamiento = $datos->url_almacenamiento;
    @endphp

    <div class="container">
        <h1>Solicitud de Revisión de Garantia</h1>
        <p>{{ 'Estimados señores: '.$aseguradora }}</p>
        <p>{{ 'El presente es para solicitar la revisión de la siguiente solicitud de garantía:' }}</p>
        <p>Matrícula del corredor de seguros: </p>
        <p>{{ 'Nombre de la propiedad: '.$datos->nombre_propiedad }}</p>
        <p>{{ 'Número de identidad de la propiedad: '.$datos->numero_identidad_propiedad }}</p>
        <p>{{ 'Tipo de propiedad: '.$datos->tipo_propiedad }}</p>
        <p>{{ 'Dirección de la propiedad: '.$datos->direccion_propiedad }}</p>
        <p>{{ 'Costo de la propiedad: '.$datos->numero_identidad_propiedad }}</p>
        @foreach ($datos->personas as $persona)
            @if ($persona->tipo_persona != null && $persona->tipo_persona != '' && $persona->tipo_persona != ' ')
                @if ($persona->tipo_arrendatario != 'Propietario')
                    @if ($persona->tipo_arrendatario == 'Solicitante')
                        <h3>Solicitante</h3>
                    @else
                        <h3>{{ 'Codeudor '.$contadorCodeudor}}</h3>
                        @php $contadorCodeudor++; @endphp
                    @endif

                    @if ($inputsAseguradoras[$aseguradora.' '.$persona->tipo_persona.' numeroIdentidadArrendatario'] == true)
                        <p>{{ 'Número de identidad: '.$persona->numero_identidad_arrendatario }}</p>         
                    @endif

                    @if ($inputsAseguradoras[$aseguradora.' '.$persona->tipo_persona.' nombres'] == true)
                        <p>{{ 'Nombres: '.$persona->nombres_arrendatario }}</p> 
                    @endif

                    @if ($inputsAseguradoras[$aseguradora.' '.$persona->tipo_persona.' apellidos'] == true)
                        <p>{{ 'Apellidos: '.$persona->apellidos_arrendatario }}</p> 
                    @endif

                    @if ($inputsAseguradoras[$aseguradora.' '.$persona->tipo_persona.' monedaIngreso'] == true)
                        <p>{{ 'Moneda ingreso: '.$persona->moneda_ingreso }}</p> 
                    @endif

                    @if ($inputsAseguradoras[$aseguradora.' '.$persona->tipo_persona.' montoIngreso'] == true)
                        <p>{{ 'Monto ingreso: '.$persona->monto_ingreso }}</p> 
                    @endif

                    @if ($inputsAseguradoras[$aseguradora.' '.$persona->tipo_persona.' numeroIdentidadEmpresa'] == true)
                        <p>{{ 'Número de RUT: '.$persona->numero_identidad_empresa }}</p> 
                    @endif

                    @if ($inputsAseguradoras[$aseguradora.' '.$persona->tipo_persona.' empresa'] == true)
                        <p>{{ 'Nombre de la empresa: '.$persona->empresa }}</p> 
                    @endif

                    @if ($inputsAseguradoras[$aseguradora.' '.$persona->tipo_persona.' cargoEmpresa'] == true)
                        <p>{{ 'Cargo que ocupa en la empresa: '.$persona->cargo_empresa }}</p> 
                    @endif

                    @if ($inputsAseguradoras[$aseguradora.' '.$persona->tipo_persona.' ingreso'] == true)
                        <p>{{ 'Tipo de ingreso: '.$persona->ingreso }}</p> 
                    @endif

                    @if ($inputsAseguradoras[$aseguradora.' '.$persona->tipo_persona.' sueldo'] == true)
                        <p>{{ 'Tipo de sueldo: '.$persona->sueldo }}</p> 
                    @endif    

                    @if ($inputsAseguradoras[$aseguradora.' '.$persona->tipo_persona.' identidad'] == true)
                        @php $vectorEtiqueta = explode("*", $persona->etiqueta_identidad); @endphp    
                        <p>{{ $vectorEtiqueta[0] }}</p> 
                        @foreach ($persona->ubicacion_identidad as $ubicacion)
                            <p><a href="<?php echo $urlAlmacenamiento.$ubicacion ?>" target="_blank"><?php echo $urlAlmacenamiento.$ubicacion ?></a></p>
                        @endforeach
                    @endif    

                    @if ($inputsAseguradoras[$aseguradora.' '.$persona->tipo_persona.' recSueldo'] == true)
                        @php $vectorEtiqueta = explode("*", $persona->etiqueta_rec_sueldo); @endphp    
                        <p>{{ $vectorEtiqueta[0] }}</p> 
                        @foreach ($persona->ubicaciones_rec_sueldo as $ubicacion)
                            <p><a href="<?php echo $urlAlmacenamiento.$ubicacion ?>" target="_blank"><?php echo $urlAlmacenamiento.$ubicacion ?></a></p>
                        @endforeach
                    @endif 
                    
                    @if ($inputsAseguradoras[$aseguradora.' '.$persona->tipo_persona.' certIngMod'] == true)
                        @php $vectorEtiqueta = explode("*", $persona->etiqueta_cert_ing_mod); @endphp    
                        <p>{{ $vectorEtiqueta[0] }}</p> 
                        @foreach ($persona->ubicaciones_cert_ing_mod as $ubicacion)
                            <p><a href="<?php echo $urlAlmacenamiento.$ubicacion ?>" target="_blank"><?php echo $urlAlmacenamiento.$ubicacion ?></a></p>
                        @endforeach
                    @endif  
                    
                    @if ($inputsAseguradoras[$aseguradora.' '.$persona->tipo_persona.' dgi'] == true)
                        @php $vectorEtiqueta = explode("*", $persona->etiqueta_dgi); @endphp    
                        <p>{{ $vectorEtiqueta[0] }}</p> 
                        @foreach ($persona->ubicaciones_dgi as $ubicacion)
                            <p><a href="<?php echo $urlAlmacenamiento.$ubicacion ?>" target="_blank"><?php echo $urlAlmacenamiento.$ubicacion ?></a></p>
                        @endforeach
                    @endif    

                    @if ($inputsAseguradoras[$aseguradora.' '.$persona->tipo_persona.' certDgiCaja'] == true)
                        @php $vectorEtiqueta = explode("*", $persona->etiqueta_cert_dgi_caja); @endphp    
                        <p>{{ $vectorEtiqueta[0] }}</p> 
                        @foreach ($persona->ubicaciones_cert_dgi_caja as $ubicacion)
                            <p><a href="<?php echo $urlAlmacenamiento.$ubicacion ?>" target="_blank"><?php echo $urlAlmacenamiento.$ubicacion ?></a></p>
                        @endforeach
                    @endif 
                    
                    @if ($inputsAseguradoras[$aseguradora.' '.$persona->tipo_persona.' balance'] == true)
                        @php $vectorEtiqueta = explode("*", $persona->etiqueta_balance); @endphp    
                        <p>{{ $vectorEtiqueta[0] }}</p> 
                        @foreach ($persona->ubicaciones_balance as $ubicacion)
                            <p><a href="<?php echo $urlAlmacenamiento.$ubicacion ?>" target="_blank"><?php echo $urlAlmacenamiento.$ubicacion ?></a></p>
                        @endforeach
                    @endif   

                    @if ($inputsAseguradoras[$aseguradora.' '.$persona->tipo_persona.' rut'] == true)
                        @php $vectorEtiqueta = explode("*", $persona->etiqueta_rut); @endphp    
                        <p>{{ $vectorEtiqueta[0] }}</p> 
                        @foreach ($persona->ubicaciones_rut as $ubicacion)
                            <p><a href="<?php echo $urlAlmacenamiento.$ubicacion ?>" target="_blank"><?php echo $urlAlmacenamiento.$ubicacion ?></a></p>
                        @endforeach
                    @endif  
                    
                    @if ($inputsAseguradoras[$aseguradora.' '.$persona->tipo_persona.' contratoSocial'] == true)
                        @php $vectorEtiqueta = explode("*", $persona->etiqueta_contrato_social); @endphp    
                        <p>{{ $vectorEtiqueta[0] }}</p> 
                        @foreach ($persona->ubicaciones_contrato_social as $ubicacion)
                            <p><a href="<?php echo $urlAlmacenamiento.$ubicacion ?>" target="_blank"><?php echo $urlAlmacenamiento.$ubicacion ?></a></p>
                        @endforeach
                    @endif   

                    @if ($inputsAseguradoras[$aseguradora.' '.$persona->tipo_persona.' certUni'] == true)
                        @php $vectorEtiqueta = explode("*", $persona->etiqueta_cert_uni); @endphp    
                        <p>{{ $vectorEtiqueta[0] }}</p> 
                        @foreach ($persona->ubicaciones_cert_uni as $ubicacion)
                            <p><a href="<?php echo $urlAlmacenamiento.$ubicacion ?>" target="_blank"><?php echo $urlAlmacenamiento.$ubicacion ?></a></p>
                        @endforeach
                    @endif
                @endif   
            @endif
        @endforeach
    </div>
</body>
</html>
