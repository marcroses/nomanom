# El proyecto "Nom a nom"

La toponimia es la forma en que, durante generaciones, hemos localizado los elementos del territorio. Sirve para mejorar la comunicación entre las personas. ¿Cómo explicaríamos, sin topónimos, dónde hemos ido y por dónde hemos pasado? Necesitamos los topónimos para una comunicación eficiente.

La información geográfica circula hoy y se comparte más que nunca gracias a las **Infraestructuras de Datos Espaciales**. Una normativa europea (**[Directiva Inspire](https://inspire.ec.europa.eu/)**) sienta las bases para que esto sea posible y, además, señala la toponimia como una de las informaciones estratégicas básicas de referencia, así cómo la forma en qué debe ser recogida y tratada.

Muchos topónimos ya sólo se conservan en la memoria de las personas mayores que vivieron y trabajaron en el campo o en el mar. Estas personas vivieron completamente conectadas con el territorio y, para ellos, los nombres geográficos tienen un significado especial.

Los pescadores los empleaban para las señas de pesca y marcar los peligros. La gente del campo para organizar los cultivos y los pastos. Y, para todos ellos, además, cada topónimo es a menudo como un hilo del que, si se estira, aparece una hazaña o una historia.

La idea de este proyecto es preservar esta memoria viva a través de un proyecto abierto, dirigido a las personas que se interesan por la cultura y la geografía y que quieran colaborar en la recogida de esta ingente cantidad de información que, aunque todavía se conserva, estamos perdiendo a un ritmo demasiado acelerado.


## Cómo? ##

Mediante una aplicación web que permita georeferenciar sobre el territorio la información toponímica según establece la **[Directiva Europea INSPIRE](https://inspire.ec.europa.eu/documents/Data_Specifications/INSPIRE_DataSpecification_GN_v3.0.pdf)** en relación a los nombres geográficos.

La aplicación consta de dos Módulos:

**Módulo Administrador**:

Permite especificar los siguientes aspectos del proyecto:

- Idioma, título y descripción
- Zona o extensión geográfica
- Capas de fondo y capas sobrepuestas
- Usuarios (públicos o restringidos)
- Logo, fotografía de la página principal y color principal
- Campos de la ficha del topónimo que se quiere editar

Todoso estos parámetros se almacenan un una base de datos para su posterior consulta.

**Módulo Cliente**:

Consulta los parámetros gestionados por el Módulo Administrador para mostrar, en primer lugar, una página de bienvendia con logo, fotografía y color definidos anteriormente. Muestra también el texto de bienvendia así como un dashboard con del número usuarios registrados y el número de topónimos aportados.

En segundo lugar muestra el visor general de la aplicació, dónde aparece el mapa de la zona de trabajo, los topónimos ubicados y la posibildad de interactuar con ellos:

- Cambiar mapas de fondo y capas sobrepuestas
- Ocultar y mostrar topónimos según su tipología a través de la leyenda
- Navegar por el mapa
- Consultar la información de un topónimo
- Buscar topónimos por palabra clave
- Exportar el mapa a PDF

**Acceder como usuarios**

En caso que se haya determinado en el módulo administrador que los usuarios sean restringidos, el módulo cliente permite que los usuarios creados puedan acreditarse y añadir nuevos toónimos o editar los topónimos existentes (sólo aquellos que hayan entrado ellos mismos o bien cualquier topónimo en caso que el usuario sea de tipo Administrador).

En cammbio, en caso que se haya determinado en el módulo administrador que los usuarios sean públicos, el módulo cliente además de permitir a los usuarios creados que se acredten, también permite que usuarios anónimos se den de alta. Se trata entonces de un proyecto de participación ciudadana.


## Tecnología ##

El proyecto se basa en los siguientes aspectos tecnológicos:

- **Lenguaje de programación**: PHP
- **Base de datos**: MySQL
- **JS WebMapping**: OpenLayers
- **CSS**: BootStrap 4


## Requeriminentos ##

La aplicación de un servidor web, tener instalado PHP y el motor de bases de datos MySQL. Es decir, la configuración mínima estándar para el desarrollo de cualquier proyecto web básico. Su puede tener un entorno XAMPP en un PC local o bien desplegarlo en un entorno cloud con estas caracterícticas.


## Instalación ##

Para la instalación hay que seguir los siguientes pasos:

1.- Descargar fichero .ZIP del proyecto 
2.- Descomprimir el fichero en una carpeta del directorio del servidor web (normalmente "htdocs"). Por ejemplo "c:\xampp\htdocs\nomanom\girona"
3.- Crear una nueva base de datos MySQL (por ejemplo con PhpMyAdmin)
4.- Editar el fichero "connectdb.php" y adpatar los datos de connexión a la base de datos con los de la base de datos creada en el punto 3:

```
<?php
	$server = "localhost";
	$user =	"root";
	$pass =	"1234";
	$dbase ="nomanom_mallorca";
	...
?>
```
Ya está lista la aplicación para ser ejecutada.

## Ejecución ##

Vamos primero con el módulo Administrador.

Para la instalación hay que seguir los siguientes pasos:

1.- Abrir un navegador web y introducir la URL **"http:/localhost/CAPERTAPROYECTO/administrador"**, dónde carpeta proyecto es el nombre del directorio de la carpeta "htdocs" dónde ha descomprido el proyecto. Por ejemplo **"http:/localhost/nomanom/girona/administrador"**. Aparecerá la siguiente pantalla:



