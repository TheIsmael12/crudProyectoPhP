Proyecto de Gestión de Clientes
Este proyecto se encarga de gestionar la información de clientes, permitiendo realizar operaciones de visualización, edición, eliminación, y seguridad en el acceso.

Requisitos
PHP (con soporte para bases de datos)
MySQL
JavaScript
Librerías y APIs externas:
RoboHash para imágenes predeterminadas
IP-API para obtener información de la IP
Flagpedia para mostrar banderas
OpenLayers o similar para geolocalización
Funcionalidades
1. Mostrar y Modificar Opciones de Siguiente y Anterior
Se implementará la navegación por la lista de clientes con opciones de "Siguiente" y "Anterior". La lista se podrá ordenar por diferentes criterios como nombre, apellido, correo electrónico, género o IP.

La navegación permitirá desplazarse por los resultados según el orden seleccionado, limitando el número de registros mostrados por página.

2. Mejoras en Operaciones de Nuevo y Modificar
Se mejorarán las operaciones de "Nuevo" y "Modificar" para validar los datos ingresados:

Correo Electrónico: Verificar que el correo electrónico no esté repetido.
IP: Verificar que la IP sea válida.
Teléfono: Validar que el formato del teléfono siga el patrón 999-999-9999.
3. Mostrar Imagen Asociada al Cliente
Se mostrará una imagen asociada al cliente que esté almacenada previamente en la carpeta uploads o, en su defecto, se generará una imagen predeterminada aleatoria utilizando RoboHash. El nombre de las fotos debe seguir el formato 00000XXX.jpg, donde XXX es el ID del cliente.

4. Subir o Cambiar Foto del Cliente
Durante las operaciones de "Nuevo" y "Modificar", se permitirá subir o cambiar la foto del cliente. Se controlará lo siguiente:

El archivo debe ser una imagen en formato JPG o PNG.
El tamaño del archivo debe ser inferior a 500 KB.
La imagen no es obligatoria.
5. Mostrar Bandera del País Asociado a la IP
En los detalles del cliente, se mostrará la bandera del país asociada a la IP utilizando la API de IP-API y Flagpedia.

6. Lista de Clientes con Distintos Modos de Ordenación
Se mostrará una lista de clientes que se podrá ordenar según diversos criterios (nombre, apellido, correo electrónico, género o IP). Además, se podrá navegar por la lista utilizando las opciones de "Siguiente" y "Anterior" según el criterio de ordenación seleccionado.

7. Generar PDF con los Detalles de un Cliente
Se añadirá una funcionalidad para generar un archivo PDF con todos los detalles de un cliente. También se incluirá un botón para imprimir el PDF generado.

8. Gestión de Usuarios de la Aplicación
Se creará una nueva tabla en la base de datos de usuarios (User) con los siguientes campos:

login: Nombre de usuario.
password: Contraseña (encriptada).
rol: Rol del usuario (0: solo acceso a visualización, 1: acceso completo a modificación y eliminación).
Se definirán varios usuarios con distintos roles, y el acceso a la aplicación se controlará de la siguiente forma:

El usuario debe introducir su login y contraseña correctamente.
Si se realizan más de tres intentos fallidos, se solicitará que se reinicie el navegador.
9. Control de Acceso por Rol
El acceso a las funcionalidades de la aplicación dependerá del rol del usuario:

Rol 0: Sólo podrá visualizar los datos (lista y detalles).
Rol 1: Además de visualizar, podrá modificar, eliminar y gestionar usuarios.
10. Geolocalización de Cliente en un Mapa
Utilizando la API de GeoIP y una librería como OpenLayers, se mostrará la localización geográfica del cliente en un mapa, basándose en la IP del mismo.
