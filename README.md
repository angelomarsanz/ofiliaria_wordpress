# Proyecto Ofiliaria

Sistema híbrido de gestión inmobiliaria y garantías.

## Estructura del Proyecto

Este repositorio contiene dos componentes principales:

1. **Backend (API Rest):** Ubicado en `/backend_ofiliaria`. Desarrollado con **Laravel**, encargado de la lógica de negocio, base de datos y servicios de garantías.
2. **Frontend & CMS:** Ubicado en `/redetron`. Un sitio **WordPress** que utiliza un tema hijo (`wpresidence-child`) y un **Plugin personalizado** (`ofiliaria`) desarrollado con React y jQuery para la integración con la API.

## Requisitos de Instalación Locales (LAMPP)

- PHP 8.x
- MySQL / MariaDB
- Apache (vía XAMPP/LAMPP en `/opt/lampp`)

## Notas de Desarrollo
- El núcleo de WordPress y temas originales están excluidos del repositorio para mantener la ligereza.
- Los scripts de automatización `subir.sh` y `lista_archivos.sh` se encuentran en la raíz.