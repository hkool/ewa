# Ewa-Haaglanden
-------------------------------------------------------
INSTALLATION + USAGE BEGIN

Use composer install to get the packages

Use yarn install to get the dependencies

Use php bin/console server:run to start the local webserver

Use yarn run encore dev --watch to view the website

INSTALLATION + USAGE END
-------------------------------------------------------
DATABASE BEGIN

php bin/console doctrine:database:create

php bin/console doctrine:migrations:diff

php bin/console doctrine:migrations:migrate

DATABASE END
-------------------------------------------------------
LOGIN BEGIN

username: admin
password: admin

change this in the database

LOGIN END
-------------------------------------------------------
NEWS SUBSCRIPTION BEGIN

Change e-mail data in .env to match desired username + password
Enable less secure apps in the google acount at security options
Change setTo value in ContactController.php to e-mail address name.

If everything's been done correctly, users should now be able to send messages to the e-mail account.
The subject will be the e-mail name and the body will be the message. 

You can view subscribed e-mail accounts in the admin dashboard under the e-mail tab.

NEWS SUBSCRIPTION END
-------------------------------------------------------