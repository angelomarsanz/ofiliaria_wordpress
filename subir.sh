#!/bin/bash

# Colores para una mejor legibilidad
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# --- Carga de Configuración Segura ---
if [ -f .env.sh ]; then
    source .env.sh
else
    echo -e "${RED}Error: Archivo de configuración .env.sh no encontrado.${NC}"
    echo "Por favor, asegúrate de que el archivo .env.sh exista en la misma carpeta que este script."
    exit 1
fi

# SELECCIÓN DE AMBIENTE ---
echo -e "${YELLOW}¿A qué ambiente desea subir los archivos?${NC}"
read -p "Escriba 'P' para Producción o 'D' para Desarrollo: " AMBIENTE

case $AMBIENTE in
    [pP])
        FRONTEND_FTP_HOST=$PROD_FRONTEND_FTP_HOST
        FRONTEND_FTP_USER=$PROD_FRONTEND_FTP_USER
        FRONTEND_FTP_PASS=$PROD_FRONTEND_FTP_PASS
        BACKEND_FTP_HOST=$PROD_BACKEND_FTP_HOST
        BACKEND_FTP_USER=$PROD_BACKEND_FTP_USER
        BACKEND_FTP_PASS=$PROD_BACKEND_FTP_PASS
        echo -e "${GREEN}--- Desplegando en el servidor de PRODUCCIÓN ---${NC}"
        ;;
    [dD])
        FRONTEND_FTP_HOST=$DEV_FRONTEND_FTP_HOST
        FRONTEND_FTP_USER=$DEV_FRONTEND_FTP_USER
        FRONTEND_FTP_PASS=$DEV_FRONTEND_FTP_PASS
        BACKEND_FTP_HOST=$DEV_BACKEND_FTP_HOST
        BACKEND_FTP_USER=$DEV_BACKEND_FTP_USER
        BACKEND_FTP_PASS=$DEV_BACKEND_FTP_PASS
        echo -e "${GREEN}--- Desplegando en el servidor de DESARROLLO ---${NC}"
        ;;
    *)
        echo -e "${RED}Opción no válida. Abortando despliegue.${NC}"
        exit 1
        ;;
esac

# --- SUBIDA DE ARCHIVOS DE WORDPRESS ---
source ./lista_archivos.sh

if [[ ${#ARCHIVOS_WORDPRESS[@]} -gt 0 && "${ARCHIVOS_WORDPRESS[0]}" != "Ninguno" ]]; then
    echo -e "${YELLOW}Subiendo archivos de WordPress...${NC}"
    lftp_commands="set ftp:ssl-allow no; open -u $FRONTEND_FTP_USER,$FRONTEND_FTP_PASS $FRONTEND_FTP_HOST;"

    for archivo_local in "${ARCHIVOS_WORDPRESS[@]}"; do
        # ELIMINAMOS LA TRADUCCIÓN: ahora archivo_remoto es igual a archivo_local
        archivo_remoto=$archivo_local 
        directorio_remoto=$(dirname "$archivo_remoto")
        nombre_archivo=$(basename "$archivo_remoto")

        lftp_commands+="mkdir -p ${REMOTE_BACKUP_DIR}; mv ${archivo_remoto} ${REMOTE_BACKUP_DIR}/${nombre_archivo}; mkdir -p ${directorio_remoto}; put -O ${directorio_remoto}/ ${archivo_local};"
        echo " -> Preparando para subir (WP): $archivo_local"
    done

    lftp -c "$lftp_commands"
    if [ $? -eq 0 ]; then
        echo -e "${GREEN}Archivos de WordPress subidos correctamente.${NC}"
    else
        echo -e "${RED}Error al subir archivos de WordPress.${NC}"
    fi
else
    echo "No se especificaron archivos de WordPress para subir."
fi

# --- 5. SUBIDA DE ARCHIVOS PHP DE LARAVEL (BACKEND) ---

if [[ ${#ARCHIVOS_LARAVEL[@]} -gt 0 && "${ARCHIVOS_LARAVEL[0]}" != "Ninguno" ]]; then
    echo -e "${YELLOW}Subiendo archivos de Laravel...${NC}"
    lftp_commands="set ftp:ssl-allow no; open -u $BACKEND_FTP_USER,$BACKEND_FTP_PASS $BACKEND_FTP_HOST;"

    for archivo_local in "${ARCHIVOS_LARAVEL[@]}"; do
        archivo_remoto=${archivo_local#backend_ofiliaria/}
        directorio_remoto=$(dirname "$archivo_remoto")
        nombre_archivo=$(basename "$archivo_remoto")

        lftp_commands+="mkdir -p ${REMOTE_BACKUP_DIR}; mv ${archivo_remoto} ${REMOTE_BACKUP_DIR}/${nombre_archivo}; mkdir -p ${directorio_remoto}; put -O ${directorio_remoto}/ ${archivo_local};"
        echo " -> Preparando para subir (Laravel): $archivo_local"
    done

    lftp -c "$lftp_commands"
    if [ $? -eq 0 ]; then
        echo -e "${GREEN}Archivos de Laravel subidos correctamente.${NC}"
    else
        echo -e "${RED}Error al subir archivos de Laravel.${NC}"
    fi
else
    echo "No se especificaron archivos de Laravel para subir."
fi

echo -e "${GREEN}--- Proceso de despliegue finalizado ---${NC}"