# RaspuinoRCS
Remote Control System for home automation based on Raspberry-Arduino interactions.

<h3> Instructions to run server-side component of RaspuinoRCS on Raspberry Pi</h3>
On Raspberry Pi: <br>
1. Install NGINX server: <code>sudo apt-get install nginx</code><br>
2. Start NGINX: <code>sudo /etc/init.d/nginx start</code><br>
3. Install PHP: <code>sudo apt-get install php5-fpm</code><br>
4. Enable PHP on NGINX: view https://www.raspberrypi.org/documentation/remote-access/web-server/nginx.md <br>
5. Install CURL module:  <code>sudo apt-get install php5-curl</code><br>
6. Install MySql: <code>sudo apt-get install mysql-server</code><br>
7. Install php5-mysql module: <code>sudo apt-get install php5-mysql</code><br>
8. Create new database using mysql console.<br>
9. Modify <code>connectionConfig.php</code> file by entering your credentials and name of created database.<br>
10. Copy all folders and files of RaspuinoRCS-master into <code>/var/www/html</code> using FileZilla or another sftp client.<br>
11. Using an http client to establish connection to your Raspberry Pi: <code>http://{raspberry-ip}:{port}/init/create_tables.php</code><br>
12. Since this moment you can use your RaspuinoRCS by connect to <code>http://{raspberry-ip}:{port}</code><br>

<h3> Info around login system into RaspuinoRCS</h3>
In this system there are only two type of user that can use the RaspuinoRCS:<br>
1. admin (default password: 'admin') : can add Arduino Shield for control objects, define input/output mode and settings, change pin's name and other.<br>
2. user (default password: 'user') : only can view the Arduino Shields connected, read input from this shields and switch their output.<br>
You can change the password for both users but you can't add or remove users.

<h3> Add an Arduino Shield to your RaspuinoRCS</h3>
