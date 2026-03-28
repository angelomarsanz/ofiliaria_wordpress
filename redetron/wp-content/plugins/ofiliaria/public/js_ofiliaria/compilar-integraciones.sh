#!/bin/bash
# Script de producción para el módulo de Integraciones (JS/jQuery)

YELLOW='\033[1;33m'
GREEN='\033[0;32m'
NC='\033[0m'

echo -e "${YELLOW}--- COMPILANDO INTEGRACIONES (SERVIDOR VESTA) ---${NC}"

# Obtenemos la ruta donde está el script
DIR_ACTUAL=$(dirname "$(readlink -f "$0")")
cd "$DIR_ACTUAL"

echo -e "${YELLOW}Ejecutando en: $DIR_ACTUAL${NC}"

# Ejecutar como el usuario del dominio
sudo -u devofilya npm run prod

echo -e "${GREEN}✅ Archivos minificados generados en la carpeta /dist${NC}"