#!/bin/bash
# Script de producción para el módulo de Garantías (React)

YELLOW='\033[1;33m'
GREEN='\033[0;32m'
NC='\033[0m'

echo -e "${YELLOW}--- COMPILANDO GARANTÍAS (SERVIDOR VESTA) ---${NC}"

# Obtenemos la ruta donde está el script
DIR_ACTUAL=$(dirname "$(readlink -f "$0")")
cd "$DIR_ACTUAL"

echo -e "${YELLOW}Ejecutando en: $DIR_ACTUAL${NC}"

# Ejecutamos 'dev' o 'development' en lugar de 'prod'
# Esto asegura que process.env.NODE_ENV no sea 'production'
sudo -u devofilya npm run dev

echo -e "${GREEN}✅ Archivos minificados generados en la carpeta /dist${NC}"