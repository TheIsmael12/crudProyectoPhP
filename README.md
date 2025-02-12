# Proyecto de Gestión de Clientes

Este proyecto tiene como objetivo gestionar la información de clientes, permitiendo realizar operaciones de **visualización**, **edición**, **eliminación** y garantizando la **seguridad** en el acceso a la aplicación.

## Requisitos

- **PHP** (con soporte para bases de datos)
- **MySQL**
- **JavaScript**

### Librerías y APIs Externas

- **RoboHash**: Para generar imágenes predeterminadas.
- **IP-API**: Para obtener información geográfica a partir de la IP.
- **Flagpedia**: Para mostrar las banderas de los países.
- **GoogleMapsApi**: Para geolocalización del cliente.

## Funcionalidades

### 1. **Navegación y Ordenación de Clientes**

- Se implementará un sistema de navegación para visualizar los clientes con opciones de **"Siguiente"** y **"Anterior"**.
- La lista se podrá ordenar por los siguientes criterios:
  - **Nombre**
  - **Apellido**
  - **Correo electrónico**
  - **Género**
  - **IP**
- Los resultados se mostrarán **paginados**, limitando el número de registros por página.

### 2. **Validación al Crear o Modificar Clientes**

- Durante las operaciones de **"Nuevo"** y **"Modificar"** se validarán los datos ingresados:
  - **Correo electrónico**: Verificar que no esté repetido.
  - **IP**: Validar que la IP sea correcta.
  - **Teléfono**: Asegurarse de que el formato sea `999-999-9999`.

### 3. **Imagen Asociada al Cliente**

- Se mostrará una imagen asociada a cada cliente almacenada en la carpeta `uploads`, o, si no existe, se generará una imagen aleatoria utilizando **RoboHash**.
- Las imágenes deben seguir el formato: `00000XXX.jpg`, donde `XXX` es el ID del cliente.

### 4. **Subir o Cambiar Foto del Cliente**

- En las operaciones de **"Nuevo"** y **"Modificar"**, se permitirá subir o cambiar la foto del cliente.
  - El archivo debe ser una imagen en formato **JPG** o **PNG**.
  - El tamaño máximo del archivo será **500 KB**.
  - La foto no es obligatoria.

### 5. **Bandera del País según la IP**

- En los detalles del cliente, se mostrará la **bandera del país** asociada a la IP utilizando la API **IP-API** y **Flagpedia**.

### 6. **Lista de Clientes con Múltiples Opciones de Ordenación**

- Los usuarios podrán ver una lista de clientes que se podrá ordenar según los siguientes criterios:
  - **Nombre**
  - **Apellido**
  - **Correo electrónico**
  - **Género**
  - **IP**
- También se podrán navegar por los registros utilizando las opciones de **"Siguiente"** y **"Anterior"**.

### 7. **Generación de PDF de los Detalles del Cliente**

- Se añadirá una funcionalidad para **generar un archivo PDF** con todos los detalles de un cliente.
- Habrá un botón para **imprimir** el PDF generado.

### 8. **Gestión de Usuarios de la Aplicación**

- Se creará una nueva tabla en la base de datos para gestionar usuarios (`User`), con los siguientes campos:
  - `login`: Nombre de usuario.
  - `password`: Contraseña encriptada.
  - `rol`: Rol del usuario (0: acceso solo a visualización, 1: acceso completo a modificación y eliminación).

- El acceso a la aplicación se controlará de la siguiente manera:
  - El usuario debe introducir correctamente su **login** y **contraseña**.
  - Si se realizan más de tres intentos fallidos, se solicitará que **reinicie el navegador**.

### 9. **Control de Acceso por Rol**

- El acceso a las funcionalidades de la aplicación dependerá del rol del usuario:
  - **Rol 0**: Sólo podrá **visualizar** los datos (lista y detalles).
  - **Rol 1**: Además de visualizar, podrá **modificar**, **eliminar** y **gestionar usuarios**.

### 10. **Geolocalización de Clientes en un Mapa**

- Utilizando la API **GeoIP** y una librería como **OpenLayers**, se mostrará la **localización geográfica** del cliente en un mapa, basándose en la IP del mismo.

---

## Instalación

1. Clona este repositorio en tu máquina local:

   ```bash
   git clone https://github.com/tuusuario/gestion-clientes.git
