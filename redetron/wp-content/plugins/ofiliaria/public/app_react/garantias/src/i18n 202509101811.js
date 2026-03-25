import i18n from 'i18next';
import { initReactI18next } from 'react-i18next';
// Importa directamente tu archivo de traducción.
// Asegúrate de que la ruta sea correcta desde i18n.js
import translationES from '../dist/i18n/es/general_v082.json';

i18n
    .use(initReactI18next)
    .init({
        fallbackLng: 'es',
        lng: 'es',
        ns: ['general_v082'],
        defaultNS: 'general_v082', 
        interpolation:{
            escapeValue: false
        },
        resources: {
            es: {
                general_v082: translationES
            }
        }
    });

export default i18n;