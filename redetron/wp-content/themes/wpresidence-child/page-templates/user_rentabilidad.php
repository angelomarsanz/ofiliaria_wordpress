<?php
/** MILLDONE
 * Template Name: Mapa de rentabilidad
 * src: page-templates\user_rentabilidad.php
 * Este archivo es parte de las plantillas personalizadas de ofiliaria y muestra los valores de cierre.
 *
 * @package WpResidence
 * @subpackage UserDashboard
 * @since WpResidence 1.0
 */

// Verificar permisos del usuario
wpestate_dashboard_header_permissions();

get_header();
?>
<style>
  .ofi-select-barrios {
    background: hsla(0, 0%, 89%, .5);
    border-radius: 8px;
    color: rgba(17, 20, 45, .5);
    font-size: 14px;
    height: 56px;
    margin-bottom: 15px;
    padding: 0 9px;
    width: 100%;
  }

  /* Ajustes de select2 */
  .select2-container--default .select2-selection--single {
    background: hsla(0, 0%, 89%, .5);
    border-radius: 8px;
    border: none;
    height: 56px;
    padding: 10px 9px;
    font-size: 14px;
    color: rgba(17, 20, 45, .5);
  }

  .select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 36px;
  }

  .select2-container--default .select2-selection--single .select2-selection__arrow {
    top: 12px;
    right: 10px;
  }
  
        .thermometer {
            display: flex;
            height: 50px;
            border-radius: 25px;
            overflow: hidden;
            margin-bottom: 10px;
            box-shadow: inset 0 1px 3px rgba(0,0,0,0.2);
            position: relative;
        }
        
        .thermometer-segment {
            flex: 1;
            position: relative;
        }
        
        .percentage-label {
            position: absolute;
            font-weight: bold;
            color: white;
            text-shadow: 0 1px 2px rgba(0,0,0,0.5);
            z-index: 2;
            font-size: 14px;
        }
        
        .left-label {
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
        }
        
        .right-label {
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
        }
        
        .labels {
            display: flex;
            justify-content: space-between;
            margin-top: 5px;
            font-weight: bold;
        }
        
        .description {
            margin-top: 20px;
            padding: 15px;
            background: #e8f4fc;
            border-radius: 5px;
            font-size: 16px;
            line-height: 1.5;
        }
        
        @media (max-width: 600px) {
            h2 {
                font-size: 1.3rem;
            }
            
            .thermometer {
                height: 40px;
            }
            
            .percentage-label {
                font-size: 12px;
            }
            
            .description {
                font-size: 13px;
                padding: 10px;
            }
        }
</style>

<div class="row row_user_dashboard">

    <?php get_template_part('templates/dashboard-templates/dashboard-left-col'); ?>

    <div class="col-md-9 dashboard-margin">
        <?php wpestate_show_dashboard_title(get_the_title()); ?>

        <div class="col-md-12 wpestate_dash_coluns">
            <div class="wpestate_dashboard_content_wrapper">
                <a href="/valores-de-cierre/">Valores de cierre</a> | <a href="#" class="tab-valores-cierre"><strong>Rentabilidad por valorización</strong></a>
                <hr>
              <div class="legend-container">
        <h2>Rentabilidad del Mercado Inmobiliario</h2>
        
        <div class="thermometer">
            <div class="thermometer-segment" style="background-color: #6bae8d;">
                <span class="percentage-label left-label">+9.0%</span>
            </div>
            <div class="thermometer-segment" style="background-color: #98c36c;"></div>
            <div class="thermometer-segment" style="background-color: #fce154;"></div>
            <div class="thermometer-segment" style="background-color: #f8bc5b;"></div>
            <div class="thermometer-segment" style="background-color: #ec8954;"></div>
            <div class="thermometer-segment" style="background-color: #c4523d;"></div>
            <div class="thermometer-segment" style="background-color: #ae6a7f;">
                <span class="percentage-label right-label">4.5% o menos</span>
            </div>
        </div>
        
        <div class="labels">
            <div>Más rentable</div>
            <div>Menos rentable</div>
        </div>
        
        <div class="description">
            <p>Tocá o hacé clic en el mapa sobre la zona que querés consultar. Usá el buscador para encontrar rápido la zona que estás buscando.<br>Esta escala de colores representa el rango de rentabilidad anual promedio en el mercado inmobiliario por zonas. Las áreas verdes indican mayor rentabilidad (hasta 9.0%).</p>
        </div>
    </div>
    <br>
                <!-- Mapa con selector de barrios -->
                <div id="mi-mapa" style="width: 100%; height: 500px; margin-bottom: 20px;"></div>

                <div style="margin-bottom: 20px;">
  <label for="selector-barrios" style="font-weight: bold;">Selecciona un barrio:</label>
  <select id="selector-barrios" class="ofi-select-barrios" onchange="irABarrio(this.value)">
    <option value="">-- Elegir --</option>
    <option value="aires-puros">Aires Puros</option>
    <option value="aguada">Aguada</option>
    <option value="atahualpa">Atahualpa</option>
    <option value="arroyo-seco">Arroyo Seco</option>
    <option value="barrio-sur">Barrio Sur</option>
    <option value="barra-de-carrasco">Barra de Carrasco</option>
    <option value="bella-vista">Bella Vista</option>
    <option value="belvedere">Belvedere</option>
    <option value="bolivar">Bolivar</option>
    <option value="brazo-oriental">Brazo Oriental</option>
    <option value="buceo">Buceo</option>
    <option value="capurro">Capurro</option>
    <option value="carrasco">Carrasco</option>
    <option value="carrasco-norte">Carrasco Norte</option>
    <option value="cerrito">Cerrito</option>
    <option value="cerro">Cerro</option>
    <option value="ciudad-vieja">Ciudad Vieja</option>
    <option value="colón">Colón</option>
    <option value="cordón">Cordón</option>
    <option value="centro">Centro</option>
    <option value="city-golf">City Golf</option>
    <option value="fortin-santa-rosa">Fortín Santa Rosa</option>
    <option value="goes">Goes</option>
    <option value="jacinto-vera">Jacinto Vera</option>
    <option value="jardines-del-hipodromo">Jardines del Hipódromo</option>
    <option value="la-blanqueada">La Blanqueada</option>
    <option value="la-comercial">La Comercial</option>
    <option value="la-figurita">La Figurita</option>
    <option value="la-teja">La Teja</option>
    <option value="larrañaga">Larrañaga</option>
    <option value="lezica">Lezica</option>
    <option value="malvin">Malvín</option>
    <option value="malvin-norte">Malvín Norte</option>
    <option value="maroñas">Maroñas</option>
    <option value="nuevo-centro">Nuevo Centro</option>
    <option value="nuevo-paris">Nuevo París</option>
    <option value="palermo">Palermo</option>
    <option value="parque-batlle">Parque Batlle</option>
    <option value="parque-rodo">Parque Rodó</option>
    <option value="paso-de-la-arena">Paso de la Arena</option>
    <option value="paso-molino">Paso Molino</option>
    <option value="peñarol">Peñarol</option>
    <option value="perez-castellanos">Pérez Castellanos</option>
    <option value="piedras-blancas">Piedras Blancas</option>
    <option value="pocitos">Pocitos</option>
    <option value="pocitos-nuevo">Pocitos Nuevo</option>
    <option value="puerto-buceo">Puerto Buceo</option>
    <option value="punta-carretas">Punta Carretas</option>
    <option value="punta-gorda">Punta Gorda</option>
    <option value="punta-rieles">Punta Rieles</option>
    <option value="reducto">Reducto</option>
    <option value="sayago">Sayago</option>
    <option value="tres-cruces">Tres Cruces</option>
    <option value="union">Unión</option>
    <option value="villa-argentina">Villa Argentina</option>
    <option value="villa-biarrtiz">Villa Biarritz</option>
    <option value="villa-dolores">Villa Dolores</option>
    <option value="villa-espanola">Villa Española</option>
    <option value="villa-munoz">Villa Muñoz</option>
  </select>
  <script>
  jQuery(document).ready(function($) {
    $('#selector-barrios').select2({
      placeholder: "Selecciona un barrio",
      allowClear: true,
      width: 'resolve',
      language: {
        noResults: function() {
          return "No se encontraron barrios";
        }
      }
    });
  });
</script>

</div>


                <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyArbvNg78zOBIeBJcRiWCLDAfjPOSPoYxE"></script>
                <script>
                  let mapa;

                  const barrios = {
  "aires-puros": { lat: -34.8519, lng: -56.1883, zoom: 15 },
  "aguada": { lat: -34.8931, lng: -56.1894, zoom: 15 },
  "atahualpa": { lat: -34.8647, lng: -56.1917, zoom: 15 },
  "arroyo-seco": { lat: -34.881622, lng: -56.194169, zoom: 15 },
  "barrio-sur": { lat: -34.9108, lng: -56.1908, zoom: 15 },
  "barra-de-carrasco": { lat: -34.871352, lng: -56.027486, zoom: 15 },
  "bella-vista": { lat: -34.8833, lng: -56.2000, zoom: 15 },
  "belvedere": { lat: -34.8500, lng: -56.2167, zoom: 15 },
  "bolivar": { lat: -34.8733, lng: -56.1833, zoom: 15 },
  "brazo-oriental": { lat: -34.8647, lng: -56.1792, zoom: 15 },
  "buceo": { lat: -34.9000, lng: -56.1333, zoom: 15 },
  "capurro": { lat: -34.869813, lng: -56.214134, zoom: 15 },
  "carrasco": { lat: -34.8853, lng: -56.0606, zoom: 15 },
  "carrasco-norte": { lat: -34.8800, lng: -56.0500, zoom: 15 },
  "cerrito": { lat: -34.854285, lng: -56.171572, zoom: 15 },
  "cerro": { lat: -34.883961, lng: -56.254356, zoom: 15 },
  "ciudad-vieja": { lat: -34.9083, lng: -56.2083, zoom: 15 },
  "colón": { lat: -34.8000, lng: -56.2000, zoom: 15 },
  "cordón": { lat: -34.9000, lng: -56.1667, zoom: 15 },
  "centro": { lat: -34.9059, lng: -56.1914, zoom: 15 },
  "city-golf": { lat: -34.759209, lng: -55.772292, zoom: 15 },
  "fortin-santa-rosa": { lat: -34.771651, lng: -55.806316, zoom: 15 },
  "goes": { lat: -34.879699, lng: -56.180514, zoom: 15 },
  "jacinto-vera": { lat: -34.8756, lng: -56.1703, zoom: 15 },
  "jardines-del-hipodromo": { lat: -34.8372, lng: -56.1319, zoom: 15 },
  "la-blanqueada": { lat: -34.880929, lng: -56.155930, zoom: 15 },
  "la-comercial": { lat: -34.8900, lng: -56.1667, zoom: 15 },
  "la-figurita": { lat: -34.8833, lng: -56.1833, zoom: 15 },
  "la-teja": { lat: -34.8667, lng: -56.2333, zoom: 15 },
  "larrañaga": { lat: -34.8803, lng: -56.1611, zoom: 15 },
  "lezica": { lat: -34.7783, lng: -56.2767, zoom: 15 },
  "malvin": { lat: -34.8911, lng: -56.0994, zoom: 15 },
  "malvin-norte": { lat: -34.8833, lng: -56.0833, zoom: 15 },
  "maroñas": { lat: -34.8500, lng: -56.1167, zoom: 15 },
  "nuevo-centro": { lat: -34.8667, lng: -56.1667, zoom: 15 },
  "nuevo-paris": { lat: -34.8500, lng: -56.2333, zoom: 15 },
  "palermo": { lat: -34.9122, lng: -56.1814, zoom: 15 },
  "parque-batlle": { lat: -34.8950, lng: -56.1544, zoom: 15 },
  "parque-rodo": { lat: -34.9094, lng: -56.1683, zoom: 15 },
  "paso-de-la-arena": { lat: -34.8200, lng: -56.3108, zoom: 15 },
  "paso-molino": { lat: -34.8569, lng: -56.2192, zoom: 15 },
  "peñarol": { lat: -34.8167, lng: -56.1833, zoom: 15 },
  "perez-castellanos": { lat: -34.858042, lng: -56.159073, zoom: 15 },
  "piedras-blancas": { lat: -34.8286, lng: -56.1394, zoom: 15 },
  "pocitos": { lat: -34.9130, lng: -56.1600, zoom: 15 },
  "pocitos-nuevo": { lat: -34.9100, lng: -56.1500, zoom: 15 },
  "puerto-buceo": { lat: -34.9090, lng: -56.1460, zoom: 15 },
  "punta-carretas": { lat: -34.924212, lng: -56.157689, zoom: 15 },
  "punta-gorda": { lat: -34.890250, lng: -56.083564, zoom: 15 },
  "punta-rieles": { lat: -34.8167, lng: -56.1000, zoom: 15 },
  "reducto": { lat: -34.8833, lng: -56.1833, zoom: 15 },
  "sayago": { lat: -34.8333, lng: -56.2000, zoom: 15 },
  "tres-cruces": { lat: -34.9000, lng: -56.1667, zoom: 15 },
  "union": { lat: -34.8667, lng: -56.1333, zoom: 15 },
  "villa-argentina": { lat: -34.865279, lng: -56.144804, zoom: 15 },
  "villa-biarrtiz": { lat: -34.9240, lng: -56.1530, zoom: 15 },
  "villa-dolores": { lat: -34.9060, lng: -56.1540, zoom: 15 },
  "villa-espanola": { lat: -34.865279, lng: -56.144804, zoom: 15 },
  "villa-munoz": { lat: -34.8833, lng: -56.1833, zoom: 15 }
};


                  function initMap() {
                    mapa = new google.maps.Map(document.getElementById("mi-mapa"), {
                      zoom: 13,
                      center: { lat: -34.9011, lng: -56.1645 }
                    });

                    const kmlLayer = new google.maps.KmlLayer({
                      url: 'https://ofiliaria.com.uy/assets/rentabilidad-ofimap.kml',
                      map: mapa,
                      preserveViewport: true
                    });
                  }

                  function irABarrio(nombre) {
                    const barrio = barrios[nombre];
                    if (barrio) {
                      mapa.setCenter({ lat: barrio.lat, lng: barrio.lng });
                      mapa.setZoom(barrio.zoom);
                    }
                  }

                  window.onload = initMap;
                </script>

            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
