import { useTranslation } from 'react-i18next';

export const colores = () => {
    const { t } = useTranslation();
    const colores = [];

    // Colores estatus garantía
    colores['Color Paso 1'] = '#666666'; // Seleccionar garantía
    colores['Color Paso 2'] = '#666666'; // Datos propiedad
    colores['Color Paso 3'] = '#666666'; // Datos arrendatario
    colores['Color Paso 4'] = '#666666'; // Personas adicionales
    colores['Color Paso 5'] = '#00B3FF'; // Garantía enviada
    colores['Color Paso 6'] = '#9666E0'; // Revisión garantía
    colores['Color Paso 7.1'] = '#47d147'; // Esperando datos contrato
    colores['Color Paso 7.2'] = '#FF3F3F'; // Rechazada
    colores['Color Paso 8'] = '#FF913F'; // Contrato garantía
    colores['Color Paso 9'] = '#FF913F'; // Inventario garantía
    colores['Color Paso 10'] = '#FF913F'; // Firma contrato
    colores['Color Paso 11'] = '#FF913F'; // Pago contrato
    colores['paletaTemaMui'] = {
      primary: {
        main: '#9127ff',
        light: '#9127ff',
        dark: '#9127ff',
        contrastText: '#ffffff'
      },
      secondary: {
        main: '#686868',
        light: '#686868',
        dark: '#686868',
        contrastText: '#ffffff'
      }
    }; 

    return colores;
}