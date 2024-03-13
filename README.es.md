[![en](https://img.shields.io/badge/lang-en-blue.svg)](https://github.com/pmdavid/nutritional-planning-example/blob/master/README.md)
[![es](https://img.shields.io/badge/lang-es-red.svg)](https://github.com/pmdavid/nutritional-planning-example/blob/master/README.es.md)

# Explicación de las implementaciones

Repositorio personal a modo de ejemplo para visualizar la implementación de varias features concretas que se van a explicar a continuación, **en base a una Arquitectura Hexagonal**. 

El código se ha simplificado eliminando procesos/comprobaciones comunes, para dejar solo la parte técnica interesante.

## Feature 1: Proceso BULK para eficiencia en conexiones a DDBB


```bash
 api/menuPlanning/Infraestructure/MenuPlanningController.php -> VarietyModeSwitcher.php -> RecipeRecalculatorService.php
```

Ejemplo de un endpoint que se encarga de aplicar un cambio de recetas variadas, asociadas al concepto de **block** (comida) y **planning** (dieta) existente en el código.
La idea de esto es **resaltar el proceso de iteración de estructuras y el proceso BULK** para volcar los datos en DDBB en un solo INSERT, evitando así llamadas a base de datos por cada iteración de un bucle.

Otros aspectos destacables:

- Gestión de excepciones y respuestas a través de un Trait donde se define la estructura base del JSON de respuesta de los endpoints.
- Gestión de excepciones custom con el try-catch del Controller.

## Feature 2: Integración con API de terceros | Ejemplo de deauthorization conectando con API externa

Aquí podemos ver:

- Una implementación de un endpoint que actua como **webhook para recibir callbacks/eventos de la API de Strava**, en concreto para recibir un evento de deauthorization de un usuario, que ha realizado la deauth desde la plataforma de Strava.

```bash
 api/strava/infraestructure/StravaWebhookController.php -> StravaWebhookHandler.php -> StravaDeauthorizationService.php
```

- Una implementación de otro endpoint que realiza esa misma deauthorization pero lanzada por el usuario desde nuestro sistema, para mostrar el **proceso de la llamada a la API de Strava** que hace efectiva la deauth en Strava.

```bash
 api/strava/infraestructure/StravaDeauthorizationController.php -> StravaDeauthorizationService.php
```


## Feature 3: Evento | Ejemplo de lanzamiento de un evento vía EventBus

Ejemplo de publicación de evento para actualizar una propiedad (No se ha implementado el procesador de dicho evento)

```bash
 VarietyModeApplicatorService.php -> publishMenuPlanningUpdatedEvent()
```

## Validator | Ejemplo de validator para validar tipos de campos, etc..

- Validación de distintos campos usando lib externa
- Filtrado de caracteres/emojis con un helper XssSecurity

```bash
 api/validators/v3/ExampleValidator.php
```
