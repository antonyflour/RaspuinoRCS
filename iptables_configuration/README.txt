configure iptables on raspberry to block ssh brute force attack

1. install iptables:

		sudo apt-get install iptables

2. install iptables-persistent:

		sudo apt-get install iptables-persistent

3. install ipset:

		sudo apt-get install ipset

4. copy the file /ipset-persistent/ipset-persistent on the raspberry

5. follow the ipset-persistent/readme.txt instructions

6. open file /etc/rc.local:
	
		sudo nano /etc/rc.local

7. add the following line:
	
		sudo iptables-restore < /etc/iptables/rules.v4

8. exit and save the file

9. execute the following commands (rules for iptables: block every ip which want to establish more than 4 connections in 60 secs):
	
		sudo ipset -N BLOCKED iphash
		sudo iptables -A INPUT -p tcp --dport 22 -i eth0 -m conntrack --ctstate NEW -m set --match-set BLOCKED src -j DROP 
		sudo iptables -A INPUT -p tcp --dport 22 -i eth0 -m conntrack --ctstate NEW -m recent --set
		sudo iptables -A INPUT -p tcp --dport 22 -i eth0 -m conntrack --ctstate NEW -m recent --update --seconds 60 --hitcount 4 -j SET --add-set BLOCKED src

10. save the rules:
		sudo /etc/init.d/ipset-persistent save		
		su		
		iptables-save > /etc/iptables/rules.v4

