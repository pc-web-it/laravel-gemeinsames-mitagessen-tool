# Github Readme Vorlage

Link zur Projektdoku im Outline

# Verwendetes System

Laravel 9, Inertia, Svelte

# Dev-Environment aufsetzen

`cp .env.example .env`

`shell app composer install`

`shell app php artisan key:generate`

`shell app php artisan migrate --seed`

Admin User: admin

PW: env INITIAL_ADMIN_PASSWORD

# Deployment

## Live

`dep deploy production`

# Overrides am Grundsystem/ an externen Plugins (mögliche Probleme beim Updaten)

Alle Änderungen, Erweiterungen welche den Kern des verwendeten Frameworks beinflussen und durch Updates des Frameworks eventuell Fehler verursachen können.


\

