import i18n from 'i18next';
import { initReactI18next } from 'react-i18next';
// Importa directamente tu archivo de traducción.
// La ruta debe ser relativa al archivo i18n.js, dentro de la carpeta src.
import translationES from './i18n/es/general.json';

i18n
    .use(initReactI18next)
    .init({
        fallbackLng: 'es',
        lng: 'es',
        ns: ['general'],
        defaultNS: 'general', 
        interpolation:{
            escapeValue: false
        },
        resources: {
            es: {
                general: translationES
            }
        }
    });

export default i18n;