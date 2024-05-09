
# Hermes

Tool that allows for the automation of the data entry of list equipment to any CurrentRMS job, among other features related to CurrentRMS.


## Authors

- [MPH Australia](https://mphaus.com/)


## Development Stack

The [Tall stack](https://tallstack.dev/) is being used for the development of Hermes, that is:

- [TailwindCSS](https://tailwindcss.com/)
- [AlpineJS](https://alpinejs.dev/)
- [Laravel](https://laravel.com/)
- [Livewire](https://livewire.laravel.com/)
## Project Dependencies

The following dependencies must be installed in order to develop Hermes:

- [NodeJS](https://nodejs.org/en) (latest LTS version).
- [Docker Desktop](https://www.docker.com/products/docker-desktop/)

When using Windows, [WSL2](https://learn.microsoft.com/en-au/windows/wsl/install) (Windows Subsystem for Linux 2) must also be installed as it is the preferred way to develop Laravel applications.
## Environment Variables

Apart from the environment variables that come with a Laravel 11 installation, to run this project locally the following variables must set in the .env file

`APP_TIMEZONE` = Australia/Melbourne

`MPH_TEST_OPPORTUNITY_ID` = 3132 (when running Hermes locally, all the data from CSV files will be uploaded to Opportunity 3132)

`RECAPTCHA_V3_SITE_KEY`

`RECAPTCHA_V3_SECRET_KEY`

`CURRENT_RMS_SUBDOMAIN` = mphaustralia

`CURRENT_RMS_AUTH_KEY` (ask the product owners for a CurrentRMS API key)

`CURRENT_RMS_HOST` = https://api.current-rms.com/api/v1/

`DB_CONNECTION` = mysql

`DB_HOST` = mysql

`DB_PORT` = 3306

`DB_DATABASE` = hermes

`DB_USERNAME` = sail

`DB_PASSWORD` = (whatever the developer chooses for local development)


## Run Locally

After having installed the project dependencies clone the project using any of the following methods:

Via HTTPS

```bash
  git clone https://github.com/mphaus/hermes.git
```

Via SSH

```bash
  git clone git@github.com:mphaus/hermes.git
```

Via GitHub CLI

```bash
  git clone gh repo clone mphaus/hermes
```

Go to the project directory (assuming the folder is named *hermes*)

```bash
  cd hermes
```

Start the server (it will take a while when it's done for the first time). If the *sail* command does not work follow the instructions indicated [here](https://laravel.com/docs/11.x/sail#configuring-a-shell-alias).

```bash
  sail up
```

Install the development dependencies

```bash
  sail npm install
```

Watch for file changes

```bash
  sail npm run dev
```



## Deployment

Deployment is made through [Laravel Forge](https://forge.laravel.com/).

Credentials for Laravel Forge must be provided by the product owners.

There are two (2) sites on the Hermes server:

- The **default** site is for the Staging environment.
- The **hermes.mphaus.com** site is for the Production environment.

According to the type of deployment being made (testing features or releasing features) the corresponding site must be selected.
