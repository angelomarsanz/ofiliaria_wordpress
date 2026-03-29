#!/bin/bash
# Script de Compilación Especial y Subida a PRODUCCIÓN

GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m'

# 1. Cargar configuración
ENV_FILE="/home/devofilya/.env.sh"
[ -f "$ENV_FILE" ] && source "$ENV_FILE" || { echo -e "${RED}Error: .env.sh no encontrado${NC}"; exit 1; }

# 2. Variables
TIMESTAMP=$(date +"%Y%m%d%H%M")
LOCAL_DIST="./dist"
LOCAL_OLD="./old"
REMOTE_PATH="redetron/wp-content/plugins/ofiliaria/public/app_react/garantias/dist"

# Limpieza de variables FTP
FTP_HOST=$(echo $PROD_FRONTEND_FTP_HOST | tr -d '\r')
FTP_USER=$(echo $PROD_FRONTEND_FTP_USER | tr -d '\r')
FTP_PASS=$(echo $PROD_FRONTEND_FTP_PASS | tr -d '\r')

echo -e "${YELLOW}--- 1. COMPILANDO PARA PRODUCCIÓN (SIN AFECTAR DEV) ---${NC}"
# Ejecutamos npm pasando una variable especial que leerá webpack.mix.js
sudo -u devofilya CROSS_ENV_NODE_ENV=production BUILD_TARGET=prod_deploy npm run prod

# Verificar si se crearon los archivos de producción
if [[ ! -f "$LOCAL_DIST/main-script-produccion.js" ]]; then
    echo -e "${RED}❌ Error: La compilación de producción falló.${NC}"
    exit 1
fi

echo -e "${YELLOW}--- 3. SUBIENDO A PRODUCCIÓN Y RENOMBRANDO ---${NC}"

lftp -c "
set ftp:ssl-allow no;
open -u $FTP_USER,$FTP_PASS $FTP_HOST;
cd $REMOTE_PATH;
echo 'Respaldando en servidor remoto...';
mv main-script.js main-script-$TIMESTAMP.js || echo 'Nuevo script';
mv main-style.css main-style-$TIMESTAMP.css || echo 'Nuevo style';
echo 'Subiendo archivos de producción...';
# Subimos el archivo local '-produccion' pero lo guardamos en el remoto como 'main-script.js'
put -O . $LOCAL_DIST/main-script-produccion.js -o main-script.js;
put -O . $LOCAL_DIST/main-style-produccion.css -o main-style.css;
bye;
"

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ Proceso completado. Los archivos de DEV en /dist siguen intactos.${NC}"
    # Opcional: borrar los archivos temporales de producción local
    # rm $LOCAL_DIST/*-produccion.*
else
    echo -e "${RED}❌ Error en la transferencia.${NC}"
fi