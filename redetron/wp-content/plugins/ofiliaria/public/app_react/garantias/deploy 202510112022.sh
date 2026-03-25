#!/bin/bash

# --- deploy.sh ---
# Este script compila la aplicación de React y la sube al ambiente seleccionado.

# Colores para una mejor visualización en la terminal
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # Sin Color

# --- Variables de Configuración ---
# Archivos a subir
JS_FILE="dist/main-script.js"
CSS_FILE="dist/main-style.css"

# --- Ambiente de Desarrollo ---
DEV_HOST="ftp://149.255.39.232"
DEV_USER="devofilya_garantias"
DEV_PASS="Angel2703$"

# --- Ambiente de Producción ---
PROD_HOST="ftp://178.236.183.217"
PROD_USER="ofilya_garantias"
PROD_PASS="Angel2703$"

# 1. Preguntar al usuario por el ambiente
echo -e "${YELLOW}¿A qué ambiente deseas desplegar?${NC}"
select ENV in "Desarrollo" "Producción" "Cancelar"; do
    case $ENV in
        "Desarrollo" )
            FTP_HOST=$DEV_HOST
            FTP_USER=$DEV_USER
            FTP_PASS=$DEV_PASS
            echo -e "${GREEN}Desplegando a Desarrollo...${NC}"
            break
            ;;
        "Producción" )
            FTP_HOST=$PROD_HOST
            FTP_USER=$PROD_USER
            FTP_PASS=$PROD_PASS
            echo -e "${GREEN}Desplegando a Producción...${NC}"
            break
            ;;
        "Cancelar" )
            echo -e "${RED}Despliegue cancelado.${NC}"
            exit 0
            ;;
    esac
done

# 2. Compilar el proyecto
echo -e "\n${YELLOW}Paso 1: Compilando el proyecto con Vite...${NC}"
npm run build

# 3. Subir los archivos compilados vía FTP
echo -e "\n${YELLOW}Paso 2: Subiendo archivos al servidor FTP...${NC}"
curl -T $JS_FILE -u ${FTP_USER}:${FTP_PASS} ${FTP_HOST}/main-script.js
curl -T $CSS_FILE -u ${FTP_USER}:${FTP_PASS} ${FTP_HOST}/main-style.css

echo -e "\n${GREEN}¡Despliegue completado!${NC}"
