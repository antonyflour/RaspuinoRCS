# RaspuinoRCS
Remote Control System for home automation based on Raspberry-Arduino interactions.

<h3>Overview</h3>
RaspuinoRCS allows you to create your home automation system in easy way.
You can add any Arduino Shields to control objects or devices in your home. Thanks to Raspberry Pi server you can monitor from everywhere all your devices using an only web page.

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
10. Change permission to <code>var/www</code> folder on Raspberry:  <code> sudo chmod -R 777 www</code>
11. Copy all folders and files of RaspuinoRCS-master into <code>/var/www/html</code> using FileZilla or another sftp client.<br>
12. Using an http client to establish connection to your Raspberry Pi: <code>http://{raspberry-ip}:{port}/init/create_tables.php</code><br>
13. Since this moment you can use your RaspuinoRCS by connect to <code>http://{raspberry-ip}:{port}</code><br>

<h3> Info around login system into RaspuinoRCS</h3>
In this system there are only two type of user that can use the RaspuinoRCS:<br>
1. admin (default password: 'admin') : can add Arduino Shield for control objects, define input/output mode and settings, change pin's name and other.<br>
2. user (default password: 'user') : only can view the Arduino Shields connected, read input from this shields and switch their output.<br>
You can change the password for both users but you can't add or remove users.

<h3> Add an Arduino Shield to your RaspuinoRCS</h3>
You can add all the Arduino Shields are able to connect to Internet (Arduino Uno + Ethernet Shield, or Arduino Ethernet ecc...).<br>
For Wifi Shield you can edit the Arduino Sketch by including the right libraries. <br>
It's important that you don't modify the REST API exposed by Arduino sketch used for the communication with Raspberry. <br>
The API is the following:<br>
<code>/mac</code>  return the Arduino Shield's mac<br>
<code>/input_pin</code> return an array of input pins<br>
<code>/output_pin</code> return an array of output pins<br>
<code>/input_status</code> return an array of 1 or 0 that indicate the status of the input pins<br>
<code>/output_status</code> return an array of 1 or 0 that indicate the status of the output pins<br>
<code>/setout?PIN{number}={0|1}</code> set the specified pin to the indicate state<br>
<code>/toggle?PIN{number}</code> switch the specified pin using toggle mode (HIGH for 2 seconds)<br><br>
To add an Arduino Shield to RaspuinoRCS:<br>
1. Edit <code>sketch_raspuino</code> contained in RaspuinoRCS/Arduino_files (you must insert the shield's MAC, the IP and other info).<br>
2. Load the sketch into your Arduino Shield using Arduino IDE.<br>
3. Connect the shield to your LAN.<br>
4. Go to <code>http://{raspberry-ip}:{port}</code> and login as 'admin'.<br>
5. Click on 'Add new shield' button.<br>
6. Insert the IP and PORT of the Arduino shield that you want to add and confirm.



