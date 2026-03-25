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

# --- 1. SELECCIÓN DE AMBIENTE ---
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

# --- 2. COMPILACIÓN Y SUBIDA DE APP GARANTIAS (React) ---
read -p "¿Desea compilar y subir la aplicación de GARANTÍAS? (S/N): " COMPILAR_GARANTIAS

if [[ "$COMPILAR_GARANTIAS" =~ ^[sS]$ ]]; then
    echo -e "${YELLOW}Compilando la aplicación de Garantías...${NC}"
    GARANTIAS_APP_DIR="wordpress/wp-content/plugins/ofiliaria/public/app_react/garantias"
    (cd $GARANTIAS_APP_DIR && npm run build)
    if [ $? -ne 0 ]; then
        echo -e "${RED}Error durante la compilación de Garantías con 'npm run build'. Abortando.${NC}"
        exit 1
    fi
    echo -e "${GREEN}Compilación de Garantías finalizada.${NC}"

    echo -e "${YELLOW}Subiendo aplicación de Garantías...${NC}"
    lftp -c "set ftp:ssl-allow no; open -u $FRONTEND_FTP_USER,$FRONTEND_FTP_PASS $FRONTEND_FTP_HOST; \
             mkdir -p ${REMOTE_BACKUP_DIR}; \
             mv ${REMOTE_GARANTIAS_DIR}/main-script.js ${REMOTE_BACKUP_DIR}/garantias_main-script.js; \
             mv ${REMOTE_GARANTIAS_DIR}/main-style.css ${REMOTE_BACKUP_DIR}/garantias_main-style.css; \
             put -O ${REMOTE_GARANTIAS_DIR}/ ${GARANTIAS_APP_DIR}/dist/main-script.js; \
             put -O ${REMOTE_GARANTIAS_DIR}/ ${GARANTIAS_APP_DIR}/dist/main-style.css;"

    if [ $? -eq 0 ]; then
        echo -e "${GREEN}Aplicación de Garantías subida correctamente.${NC}"
    else
        echo -e "${RED}Error al subir la aplicación de Garantías.${NC}"
        exit 1
    fi
fi

# --- 3. COMPILACIÓN Y SUBIDA DE JS_OFILIARIA (JS/jQuery) ---
read -p "¿Desea compilar y subir js_ofiliaria? (S/N): " COMPILAR_JSOFILIARIA

if [[ "$COMPILAR_JSOFILIARIA" =~ ^[sS]$ ]]; then
    echo -e "${YELLOW}Compilando js_ofiliaria...${NC}"
    JSOFILIARIA_DIR="wordpress/wp-content/plugins/ofiliaria/public/js_ofiliaria"
    (cd $JSOFILIARIA_DIR && npm run build)
    if [ $? -ne 0 ]; then
        echo -e "${RED}Error durante la compilación de js_ofiliaria. Abortando.${NC}"
        exit 1
    fi    
    echo -e "${GREEN}Compilación de js_ofiliaria finalizada.${NC}"

    echo -e "${YELLOW}Subiendo js_ofiliaria...${NC}"
    lftp -c "set ftp:ssl-allow no; open -u $FRONTEND_FTP_USER,$FRONTEND_FTP_PASS $FRONTEND_FTP_HOST; \
             mkdir -p ${REMOTE_BACKUP_DIR}; \
             mv ${REMOTE_JSOFILIARIA_DIR}/js_ofiliaria-main-script.js ${REMOTE_BACKUP_DIR}/js_ofiliaria-main-script.js; \
             mv ${REMOTE_JSOFILIARIA_DIR}/js_ofiliaria-main-style.css ${REMOTE_BACKUP_DIR}/js_ofiliaria-main-style.css; \
             put -O ${REMOTE_JSOFILIARIA_DIR}/ ${JSOFILIARIA_DIR}/dist/js_ofiliaria-main-script.js; \
             put -O ${REMOTE_JSOFILIARIA_DIR}/ ${JSOFILIARIA_DIR}/dist/js_ofiliaria-main-style.css;"

    if [ $? -eq 0 ]; then
        echo -e "${GREEN}js_ofiliaria subido correctamente.${NC}"
    else
        echo -e "${RED}Error al subir js_ofiliaria.${NC}"
        exit 1
    fi
fi

# --- 4. SUBIDA DE ARCHIVOS PHP DE WORDPRESS ---

# Carga la lista de archivos de WordPress y Laravel
source ./lista_archivos.sh


if [[ ${#ARCHIVOS_WORDPRESS[@]} -gt 0 && "${ARCHIVOS_WORDPRESS[0]}" != "Ninguno" ]]; then
    echo -e "${YELLOW}Subiendo archivos de WordPress...${NC}"
    lftp_commands="set ftp:ssl-allow no; open -u $FRONTEND_FTP_USER,$FRONTEND_FTP_PASS $FRONTEND_FTP_HOST;"

    for archivo_local in "${ARCHIVOS_WORDPRESS[@]}"; do
        archivo_remoto=${archivo_local/wordpress/redetron}
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