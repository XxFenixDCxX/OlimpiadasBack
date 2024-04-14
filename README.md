# README - Backend para la Página Web de Compra de Entradas para las Olimpiadas de París 2024

¡Bienvenido al backend de la página web para comprar entradas a las Olimpiadas de 2024 en París! Este proyecto proporciona una API construida con Symfony y utiliza Auth0 para la autenticación de usuarios. Además, para la gestión de tareas, hemos utilizado Trello para organizar nuestro trabajo.

## Configuración del Proyecto

Antes de comenzar, asegúrese de tener instalado:

- PHP
- Symfony
- Composer
- MySQL

## Instalación y Ejecución

1. Clona este repositorio en tu máquina local.
2. Navega hasta la carpeta del proyecto.
3. Ejecuta `composer install` para instalar las dependencias.
4. Configura las credenciales de acceso a tu MySQL en el archivo `.env`.
5. Elimina el contenido de la carpeta `migrations`, ¡IMPORTANTE! solamente eliminar el contenido y no la carpeta
6. Ejecuta `php bin/console doctrine:database:create` para crear la base de datos.
7. Ejecuta `php bin/console make:migration` para realizar la migracion para luego llevarla a la base de datos.
8. Ejecuta `php bin/console doctrine:migrations:migrate` para migrar los datos a la base de datos.
10. Si la fecha de ejecucion es mas tarde que la fecha del sorteo(30-03-2024) agrega tu usuario en el Data Foxturies o modifica la fecha de fin del sorteo en la parte del front para poderte registrar(explicado como hacer en el readme de la parte de front).
9. Ejectua `php bin/console doctrine:fixtures:load` para cargar los datos por defecto de la base de datos.
11. Ejecuta `php bin/console messenger:consume -v scheduler_defaultd` para cargar las zonas a los usuarios registrados si la fecha del sorteo ha pasado ya
12. Ejecuta `symfony server:start` para iniciar el servidor.

## Funcionalidades Principales

- **Autenticación de Usuarios:** Utilizamos Auth0 para gestionar la autenticación de los usuarios, lo que proporciona una ex
- **Gestión de Tareas:** Hemos utilizado Trello para organizar nuestras tareas y colaborar de manera efectiva en el desarrollo del proyecto.

## Documentación

- En la carpeta `maquetado`, encontrarás un enlace al Swagger de la API para una referencia detallada de los endpoints.
- También hemos incluido una colección de llamadas de ejemplo para importar a Postman, que se encuentra en la carpeta `maquetado`.

## Contacto

Si tienes alguna pregunta o sugerencia, no dudes en ponerte en contacto con el equipo de desarrollo:

¡Gracias por utilizar nuestro backend para la página web de compra de entradas para las Olimpiadas de París 2024! 🎉🏅
