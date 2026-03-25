import i18n from 'i18next';
import i18nBackend from "i18next-http-backend";
import { initReactI18next } from 'react-i18next';
import { datosInicio } from './vectores_objetos';

var getCurrentHost = '';

if (import.meta.env.MODE === 'development')
{
    getCurrentHost = 'http://localhost:5173';
}
else
{
    if (datosInicio.indicador_ambiente_dev == 1)
    {
        getCurrentHost = 'https://dev.ofiliaria.com/redetron';
    }
    else
    {
        getCurrentHost = 'https://ofiliaria.com.uy/redetron';
    }
}

/* 
Descomentar cuando se actualizan los archivos .json de las traducciones, compilar, ejecutar la aplicación y luego volver a comentar. El asunto es que no reconoce esa propiedad
*/
// i18n.reloadResources();

i18n
    .use(i18nBackend)
    .use(initReactI18next)
    .init({
        fallbackLng: 'es',
        lng: 'es',
        ns: ['general_v083'],
        defaultNS: 'general_v083', 
        interpolation:{
            escapeValue: false
        },
        backend: {
            loadPath: `${getCurrentHost}/i18n/{{lng}}/{{ns}}.json`,
        }
    });

export default i18n;