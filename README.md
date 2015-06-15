# Team Manager #

Thanks for your interest in my softball management web app! This project doesn't
have a real name yet, so for the purposes of copyright and what-not, I'll just
call it Team Manager.

--------------------------------------------------------------------------------

Features:

* TBD 

Author: Mark Ross

Contact: <krazkidd@gmail.com>

License: GNU AGPLv3 (see COPYING)

Project hosted at: 
  <https://github.com/krazkidd/softball-team-manager>

Requirements:

* PHP >= 5.5 (or PHP >= 5.3.7 if you install the password compatibility library
  from https://github.com/ircmaxell/password_compat)
  - just drop the lib/password.php file from that project in the lib/ directory
* MariaDB/MySQL (MySQL is currently used in development)
* a web server and whatever necessary PHP module
* enable mysqli in php.ini

Installation:

1. Create a database and a user with all privileges on that database.
2. Copy config/local-config.php.example to config/local-config.php and change
   the DB credentials to the ones you just configured. 
3. Run db/create.sql (from DB shell or PHPMyAdmin) to install necessary tables.
   - Run db/populate-sample.sql if only testing sample data.
4. You should be live now.

