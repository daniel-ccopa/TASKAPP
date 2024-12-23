# TaskApp

![TaskApp Banner](https://via.placeholder.com/1200x300.png?text=TaskApp+-+Organiza+tu+día+como+un+profesional!)

TaskApp es una aplicación web desarrollada con *CodeIgniter* para gestionar tareas, integrar consultas a una API de ChatGPT y realizar consultas de DNI. Diseñada con una interfaz moderna y amigable, TaskApp es ideal para gestionar proyectos y tareas diarias de manera eficiente.

---

## 🚀 Características

- *Gestión de Usuarios:*
  - Registro e inicio de sesión.
  - Roles de usuario: Administrador y Usuario.

- *Gestión de Tareas:*
  - Crear, editar y eliminar tareas.
  - Visualización de tareas pendientes y completadas.

- *Integración con ChatGPT:*
  - Responde preguntas en tiempo real mediante OpenAI.

- *Consulta de DNI:*
  - Realiza consultas rápidas a una API externa para obtener información personal básica.

- *Panel de Administración:*
  - Gestión completa de usuarios.

---

## 📸 Capturas de Pantalla

### Página de Inicio de Sesión
![Login](https://via.placeholder.com/1200x600.png?text=Pantalla+de+Inicio+de+Sesión)

### Panel de Tareas
![Dashboard](https://via.placeholder.com/1200x600.png?text=Panel+de+Tareas)

### Chat con GPT
![ChatGPT](https://via.placeholder.com/1200x600.png?text=Chat+con+GPT)

### Consulta de DNI
![Consulta DNI](https://via.placeholder.com/1200x600.png?text=Consulta+DNI)

### Panel de Administración
![Admin Panel](https://via.placeholder.com/1200x600.png?text=Panel+de+Administración)

---

## 🛠 Tecnologías Utilizadas

- *Framework:* CodeIgniter 4
- *Lenguaje:* PHP 8
- *Base de Datos:* MySQL
- *Frontend:* HTML5, CSS3 (Bootstrap 5)
- *Integración de APIs:*
  - OpenAI GPT-3.5 Turbo
  - API de DNI Perú

---

## 📖 Manual de Usuario

### Instalación

1. *Clonar el Repositorio:*
   bash
   git clone https://github.com/tu_usuario/taskapp.git
   cd taskapp
   

2. *Configurar el Entorno:*
   - Renombra el archivo .env.example a .env.
   - Configura los datos de tu base de datos:
     
     database.default.hostname = localhost
     database.default.database = taskapp
     database.default.username = tu_usuario
     database.default.password = tu_contraseña
     database.default.DBDriver = MySQLi
     

3. *Instalar Dependencias:*
   bash
   composer install
   

4. *Migrar la Base de Datos:*
   bash
   php spark migrate
   php spark db:seed UserSeeder
   

5. *Configurar el Servidor:*
   bash
   php spark serve
   

   Accede a la aplicación en [http://localhost:8080](http://localhost:8080).

---

### Uso Básico

#### *Registro de Usuario*
- Accede a la página de registro.
- Ingresa un nombre de usuario, correo y contraseña.

#### *Inicio de Sesión*
- Ingresa tus credenciales para acceder al panel de tareas.

#### *Gestión de Tareas*
1. Crear tareas desde el panel principal.
2. Editar o eliminar tareas desde el listado.

#### *Consulta de DNI*
- Ingresa un número de DNI válido para obtener información básica.

#### *Chat con GPT*
- Realiza consultas en tiempo real mediante la integración con OpenAI.

#### *Panel de Administración*
- Los administradores pueden gestionar usuarios, editar roles y eliminar cuentas.

---

## 🌟 Contribución

¡Toda ayuda es bienvenida! Sigue estos pasos para contribuir:

1. Haz un fork del repositorio.
2. Crea una rama con tu nueva funcionalidad.
   bash
   git checkout -b nueva-funcionalidad
   
3. Realiza los cambios necesarios y haz commit.
   bash
   git commit -m "Añadida nueva funcionalidad"
   
4. Haz push a tu rama.
   bash
   git push origin nueva-funcionalidad
   
5. Abre un pull request en GitHub.

---

## 👩‍💻👨‍💻 Desarrolladores

- *Cristian Daniel Ccopa Acero*
  - Correo: [cccopa@est.unap.edu.pe](mailto:cccopa@est.unap.edu.pe)

- *Edith Enma Ortega Condori*
  - Correo: [eortega@est.unap.edu.pe](mailto:eortega@est.unap.edu.pe)

---

## 📜 Licencia

Este proyecto está bajo la licencia MIT. Consulta el archivo LICENSE para más información.

---

## 🙌 Agradecimientos

Agradecemos a:
- *Universidad Nacional del Altiplano* por el soporte académico.
- *OpenAI* por proporcionar la tecnología detrás de GPT.
- *API de DNI Perú* por facilitar la integración de datos locales.
