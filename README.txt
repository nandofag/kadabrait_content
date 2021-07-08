CONTENIDOS
---------------------

 * Introducción
 * Requerimientos
 * Instalación
 * Configuración
 * Preguntas y Respuestas del test


 INTRODUCCION.

 Este módulo se desarrollo como parte de la prueba técnica para Kadabra it.
 Funcionalidades desarrolladas:
 - Crea una página que lista los últimos 10 contenidos creados por el usuario
   logueado (solo los usuarios logueados tienen permiso de ver esta página)
 - Crea un bloque que muestra los tres últimos contenidos creados por el usuario
   logueado, al instalarse el módulo dicho bloque se coloca en la home en el 
   lateral izquierdo.

 REQUERIMIENTOS.

 Se requiere una instalación de drupal con el tema bartik instalado.

 INSTALACIÓN.

 Se instala como cualquier modulo custom de drupal.

 CONFIGURACIÓN.

 No requiere configuración.

 PREGUNTAS Y RESPUESTAS DEL TEST.

 1. ¿Se te ocurre una alternativa para implementar esta misma lógica mediante
    Site Building?
    Descríbela por favor.
 2. El módulo anterior será desplegado por otro equipo sin conocimiento de
    drupal, describe los pasos que ellos deberán seguir para su despliegue.

 1. Para implementar la misma funcionalidad mediante site building se deben
    seguir los siguientes pasos:
    1. Ir a admin -> structure -> views y hacer click en add view.
    2. En la pagina de crear vista nueva completar los siquientes campos:
       2.1. View name (ej: List User Content) si se desea agregar una 
            descripción.
       2.2. En la sección view settings seleccionar: 
            Show: Content.
            of type: All.
            sorted by: Newest first. 
       2.3. Seleccionar el checkbox "Create a page", configurar el path.
             En Page Display Settings seleccionar 
             display format: Unformatted list of teasers.
             Finalmente setear el campo Items to display con el valor 10.
       2.4. En block settings hacer click en el check box "create a block".
            Nuevamente en display settings seleccionar:
            Unformatted list of teasers.
            El campo items per block setearlo con el valor 3.
       2.5. Hacer click en el bootón save and edit.
    3. En la pagina de configuración de la vista debemos agregar un filtro 
       contextual.
       3.1 En la seccion advanced buscamos contextual filters y hacemos click
           en el botón add.
       3.2 En el pop up que se desplega selecionamos el check "Authored by" y
           hacemos click en "Apply (all displays)"
       3.3 En el siguiente paso seleccionamos la opción "provide default value"
           y en el select llamado type elegimos "User ID from logged in user".
           Luego hacemos click en apply (all displays)
    4. En page setigs en la parte access seleccionamos "rol" y luego 
       "Authenticated user".
    5. Click en el boton save

    Con esto tenemos la página y el bloque creados. Nos Falta posicionar el
    bloque en la home, para eso realizamos los siguientes pasos:

    1. Vamos a admin -> structure -> block layout (admin/structure/block)
    2. Buscamos la región sidebar first y hacemos click en "place block"
    3. Filtramos por el nombre del bloque y hacemos click en "place block".
    4. En la pestaña page verificamos que este selecionado 
       "Show for the listed pages" y en el text area escribimos <front>
    5. En la pestaña roles seleccionamos Authenticated user.
    6. Click en save block para terminar.

    Borramos caché y ya deberíamos poder ver el bloque y la página.   

 2. Para desplegar el modulo en producción primero se debe hacer el deploy del
    mismo en el sitio de la forma usual.
    Luego en una consola ejecutar los siguientes comandos drush:
    drush en kadabrait_content (para habilitar e instalar el módulo)
    drupal cr (limpiar caché de drupal).
