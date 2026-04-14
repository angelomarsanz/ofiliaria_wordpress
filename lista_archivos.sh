#!/bin/bash

# --- ARCHIVOS A SUBIR ---

# --- 4. SUBIDA DE ARCHIVOS PHP DE WORDPRESS ---
ARCHIVOS_WORDPRESS=(
    # Ejemplos:
    # "Ninguno"
    # "wordpress/wp-content/plugins/ofiliaria/public/class-ofiliaria-public.php"
    #
    # Archivos a subir:
    #"Ninguno"   
    "redetron/wp-content/themes/wpresidence-child/templates/submit_templates/ofiliaria_publicar_meli.php"
    "redetron/wp-content/plugins/ofiliaria/public/js_ofiliaria/src/vistas/AniadirNuevaPropiedad/indexAniadirNuevaPropiedad.js"
    "redetron/wp-content/plugins/ofiliaria/public/js_ofiliaria/src/funciones_globales/verificarTokenMeli.js"
    "redetron/wp-content/plugins/ofiliaria/public/class-ofiliaria-public.php"
)

# --- 5. SUBIDA DE ARCHIVOS PHP DE LARAVEL (BACKEND) ---
ARCHIVOS_LARAVEL=(
    # Ejemplos:
    #"Ninguno"
    #"backend_ofiliaria/app/Http/Controllers/api/v1/NotificacionController.php"
    #
    # Archivos a subir:
    #"Ninguno"
)