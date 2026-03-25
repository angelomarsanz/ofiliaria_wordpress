import { defineConfig } from 'vite';
// Si no usas React en este proyecto, puedes eliminar esta importación.
// import react from '@vitejs/plugin-react'; 
import {resolve} from 'path';

// https://vitejs.dev/config/
export default defineConfig({
  // Si no usas React en este proyecto, puedes eliminar el plugin react().
  // plugins: [react()], 
  build: {
    manifest: true,
    rollupOptions: {
      input: {
          // Asegúrate de que este sea el archivo de entrada correcto para tu JS/jQuery
          'main-script': resolve(__dirname, 'src/main.js'), // Cambiado de main.jsx a main.js
          'main-style': resolve(__dirname, 'src/index.css')
      },
      output: {
          // Cambiamos el nombre del archivo JavaScript de salida
          entryFileNames: 'js_ofiliaria-[name].js', // Ahora será 'ofiliaria-main-script.js'
          assetFileNames: (assetInfo) => { 
              // Si el asset es un archivo CSS, lo nombramos explícitamente 'ofiliaria-main-style.css'.
              if (assetInfo.type === 'asset' && assetInfo.name.endsWith('.css')) {
                  return 'js_ofiliaria-main-style.css'; // Ahora será 'ofiliaria-main-style.css'
              }
              // Para otros tipos de assets (imágenes, fuentes, etc.), mantenemos su nombre y extensión originales.
              return '[name].[ext]';
          },
      },
    },
    root: 'src',
    chunkSizeWarningLimit: 10000,
  }
})
