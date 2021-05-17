The purpose of this project is to serve as an example of using Symfony forms with Vue.js forms.

## Requirements
- PHP 7.4
- MariaDB 10.2+ (MySQL should work too. 
PostgreSQL should work as well since that the project uses an ORM but it's not tested.)
- NGINX
- Node.js 12+
- Docker and Docker Compose (Optional)

## Setup Instructions (using Docker)
- Clone the repository using `Git`:
```
git clone https://github.com/akai-z/symfony-vue-form.git
```
- Make sure that you are currently inside the cloned project directory.
```
cd <path-to-project-directory>/symfony-vue-form
```
- Run the project Docker images with the following command:
```
docker-compose up -d --build
```
(MySQL might take some time to boot up after running its Docker image. So it might initially be not responsive.)
- Obtain Docker bridge network default gateway IP on your system (e.g. `172.17.0.1`).  
You could use the following command to find the details of the bridge network:
```
docker network inspect bridge
```
- Configure Symfony DB connection in Symfony `.env` file.  
For example:
```
DATABASE_URL="mysql://user:pass@172.17.0.1:3306/booking?serverVersion=mariadb-10.5.10"
```
(Where the IP `172.17.0.1` is the Docker bridge network gateway IP.)
- Configure Mailhog connection in Symfony `.env` file.  
For example:
```
MAILER_DSN=smtp://172.17.0.1:1025
```
(Where the IP `172.17.0.1` is the Docker bridge network gateway IP.)
- Access Docker PHP image with the following command:
```
docker-compose exec php sh
```
- Install Composer packages:
```
composer install
```
- Create the DB tables and add their data using the following commands:
```
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
```
- Exit Docker PHP image with the `exit` command.
- Access Docker Node.js image with the following command:
```
docker-compose exec node sh
```
- Install Yarn packages:
```
yarn install
```
- Compile assets:
```
yarn encore dev
```
- Exit Docker Node.js image with the `exit` command.
- The application is now ready.

## Usage Instructions
- Open the following URL to access the Vue.js form page:
```
http://localhost:8080/booking
```
- You could check the emails sent by the form on Mailhog:
```
http://localhost:8025/
```
- You could view the submitted form requests details in phpMyAdmin:
```
http://localhost:8181/
```
(Username: `user` | Password: `pass`)  
Where the DB name is `booking`, and the name of the table that stores form requests is also `booking`.

## Notes
- Since that a combination of Symfony forms and Vue.js forms is used in the project,  
I opted to build the form from scratch using Vue.js (HTML/JS) on the frontend side  
with Symfony forms being used on the backend side.  
That way, I could leverage the full potential of Vue.js (features) on the frontend,  
(Instead of fetching the form HTML from Symfony forms using AJAX and use it on Vue.js)  
while at the same time being able to use Symfony forms on the backend to validate and submit forms data.

## Todo
- `vue-datetime` component is used for the form date picking fields .  
There were issues with loading the component's CSS file in Symfony, possibly due to the webpack.  
As a temporary workaround I added the CSS file to the `public` directory and loaded it using a `twig` template.

- Implement some advanced validation features for `Date of Arrival` form field, such as  
allowing dates that are in the future only and if a user already submitted a request then it can only submit another  
one after 3 days of the current request `Date of Arrival`.

- `Vuelidate` library has an issue related to validating dates that should always be in the future,  
where there is a trick to submit a form by waiting for the selected time to become in the past.

- Add a loading indicator to the form AJAX submit action.
