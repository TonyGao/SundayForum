# SundayForum

## Project Target

Creating a useful web application to communication.

## Technology stack

* PHP (Symfony framework)
* ORM: Doctrine
* Frontend: Semantic UI + jQuery (yes, it's old fashion, but I love it so much)

## .env configuration

.env file is very useful configuration file, which contains a large number of basic configuration parameters as follows:

* APP_ENV: The framework environment for development and production.
* APP_SECRET: The framework secret code.
* DATABASE_URL: Database config
* SUPER_ADMIN_NAME: The super admin user name for the application.
* SUPER_ADMIN_PASSWORD: The password for the super admin of the application.
* USER_IDENTIFIER: Field used to verify the uniqueness of the user.There are three types for user identifier so far. At least contain one choice.
  1. username
  2. emails
  3. phone
  