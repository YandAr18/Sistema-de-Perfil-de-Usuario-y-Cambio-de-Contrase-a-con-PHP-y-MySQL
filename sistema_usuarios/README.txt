Sistema de Perfil de Usuario y Cambio de Contraseña con PHP y MySQL

Esta aplicación web se creo para familiarizarnos con los conceptos de autenticación, manejo de sesiones y actualización segura de datos de usuario en PHP, almacenando los datos en una base de datos, y así permitiendo modificar varios datos como el nombre y el correo, encriptando datos como la contraseña, para que no sean tan vulnerables a cualquier intrusión en la base de datos.
 
En esta aplicación también se usaron varias tecnologías para que la interfaz sea amigable con los usuarios y sea intuitiva.

Para ejecutar esta aplicación en los navegadores se hizo uso del siguiente enlace: http://localhost/sistema_usuarios/logueo.php
1_ Para poder probar la aplicación primero se instalo el "XAMPP", se lo ejecuta y se inicia los servidores de apache y MySQL. 
2_ Usamos "phpmyandim" para crear la base de datos
3_ Intalamos "Visual Studio Code" para poder crear y modificar el código fuente.


SISTEMA USUARIOS
•	conexion.php # Conexión a BD (PDO) e inicio de sesión 
•	logueo.php # Formulario de acceso 
•	registro.php # Formulario de creación de cuenta 
•	perfil.php # Zona privada y edición de datos 
•	cambiar_password.php # Módulo de seguridad 
•	logout.php # Cierre de sesión y limpieza de datos 

 Características
•	Autenticación Segura: Inicio y cierre de sesión utilizando sesiones nativas de PHP.
•	Registro de Usuarios: Validación de correos duplicados y almacenamiento seguro de datos.
•	Zona Privada: Acceso restringido mediante middleware de sesión a la página de perfil.
•	Gestión de Perfil: Actualización de datos básicos (nombre y correo).
•	Cifrado: Las contraseñas nunca se almacenan en texto plano.
•	Protección de Rutas: Si un usuario intenta acceder a perfil.php sin haber iniciado sesión, es redirigido automáticamente al logueo.
•	Seguridad Avanzada:
o	Cambio de contraseña con verificación de la clave actual.
o	Uso de password_hash() y password_verify().
•	Diseño Responsive: Interfaz moderna y adaptable a dispositivos móviles utilizando Bootstrap 5.

 Aplicaciones usadas
o  XAMPP Version: 8.2.12 (es una herramienta para montar servidores locales y probar aplicaciones web antes de publicarlas en un hosting)
https://www.apachefriends.org/es/index.html

o  phpmyadmin (es una herramienta de creación y administración de bases de datos MySQL ampliamente utilizada en entornos de desarrollo web)
http://localhost/phpmyadmin

o  visual studio code (es un editor de código fuente gratuito y multiplataforma)
https://code.visualstudio.com/
