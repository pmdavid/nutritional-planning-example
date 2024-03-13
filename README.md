[![en](https://img.shields.io/badge/lang-en-blue.svg)](https://github.com/pmdavid/nutritional-planning-example/blob/master/README.md)
[![es](https://img.shields.io/badge/lang-es-red.svg)](https://github.com/pmdavid/nutritional-planning-example/blob/master/README.es.md)

# Features explanation

Personal repository as an example to visualize the implementation of several specific features that will be explained below, based on a Hexagonal Architecture.

The code has been simplified by removing common processes/checks, to leave only the interesting technical part.

## Feature 1: BULK process for DDBB connection efficiency

```bash
  api/menuPlanning/Infraestructure/MenuPlanningController.php -> VarietyModeSwitcher.php -> RecipeRecalculatorService.php
```

Example of an endpoint that is responsible for applying a change of various recipes, associated with the concept of **block** (meal) and **planning** (diet) existing in the code. The idea of this is to highlight the structure iteration process and the BULK process to dump data into DDBB in a single INSERT, thus **avoiding database calls for each iteration of a loop.**

Other highlights:

- Exception and response management through a Trait where the base structure of the endpoint response JSON is defined.
- Custom exception management with the Controller's try-catch.

## Feature 2: Integration with third-party APIs | Example of deauthorization with Strava platform API

Here we can see:

- An implementation of an endpoint that works as a **webhook to receive callbacks from the Strava API**, specifically to receive a deauthorization event from a user, who has deauthed from the Strava platform.

```bash
  api/strava/Infraestructure/StravaWebhookController.php -> StravaWebhookHandler.php -> StravaDeauthorizationService.php
```

- An example of a function in the Service, which performs the same deauthorization but launched from our platform, to show the **Strava API call process** that makes the deauth effective on Strava.

```bash
  api/strava/Infraestructure/StravaDeauthorizationController.php -> StravaDeauthorizationService.php
```

## Feature 3: Evento | Ejemplo de lanzamiento de un evento vía EventBus

Ejemplo de publicación de evento para actualizar una propiedad (No se ha implementado el procesador de dicho evento)

```bash
 VarietyModeApplicatorService.php -> publishMenuPlanningUpdatedEvent()
```


## Validator: Example of fields validator

- Validation of different fields using lib Ratkit
- Character/emoji filtering with an XssSecurity helper

```bash
 api/validators/v3/ExampleValidator.php
```


