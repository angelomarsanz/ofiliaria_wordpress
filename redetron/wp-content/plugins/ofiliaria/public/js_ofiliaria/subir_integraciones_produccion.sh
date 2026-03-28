#!/bin/bash
# Script para subir Integraciones a PRODUCCIÓN con Respaldo (Ruta Relativa)

GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m'

# 1. Cargar configuración
ENV_FILE="/home/devofilya/.env.sh"
if [ -f "$ENV_FILE" ]; then
    source "$ENV_FILE"
else
    echo -e "${RED}Error: No se pudo leer $ENV_FILE${NC}"
    exit 1
fi

# 2. Limpieza de variables
FTP_HOST=$(echo $PROD_FRONTEND_FTP_HOST | tr -d '\r')
FTP_USER=$(echo $PROD_FRONTEND_FTP_USER | tr -d '\r')
FTP_PASS=$(echo $PROD_FRONTEND_FTP_PASS | tr -d '\r')

TIMESTAMP=$(date +"%Y%m%d%H%M")
LOCAL_DIST="./dist"

# AJUSTE CRUCIAL: Definimos la ruta relativa desde la entrada del FTP
# Si el FTP te deja en public_html, la ruta empieza desde ahí.
REMOTE_PATH="redetron/wp-content/plugins/ofiliaria/public/js_ofiliaria/dist"

echo -e "${YELLOW}--- DESPLEGANDO INTEGRACIONES A PRODUCCIÓN ($TIMESTAMP) ---${NC}"

lftp -c "
set ftp:ssl-allow no;
open -u $FTP_USER,$FTP_PASS $FTP_HOST;
# mkdir -p crea la estructura si no existe
mkdir -p $REMOTE_PATH; 
cd $REMOTE_PATH;
echo 'Respaldando archivos actuales...';
mv js_ofiliaria-main-script.js js_ofiliaria-main-script-$TIMESTAMP.js || echo 'Sin script previo';
mv js_ofiliaria-main-style.css js_ofiliaria-main-style-$TIMESTAMP.css || echo 'Sin style previo';
echo 'Subiendo archivos nuevos desde $LOCAL_DIST...';
put -O . $LOCAL_DIST/js_ofiliaria-main-script.js;
put -O . $LOCAL_DIST/js_ofiliaria-main-style.css;
bye;
"

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ Integraciones subidas y respaldadas correctamente.${NC}"
else
    echo -e "${RED}❌ Error en la transferencia. Verifica la ruta remota.${NC}"
fi