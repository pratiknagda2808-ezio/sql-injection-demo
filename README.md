SQL Injection Demo Project - How It Was Created
This document outlines step-by-step how the SQL Injection vulnerable and protected login pages were created, deployed, and tested on an AWS Ubuntu EC2 instance with IP 3.6.93.109, accessed with user ubuntu.

1. EC2 Setup and Access
    • Launched an Ubuntu 22.04 LTS EC2 instance on AWS.
    • Connected via SSH from PuTTY using:
      
      ssh -i my-key.pem ubuntu@3.6.93.109

2. Installing Required Software
Updated the package list and installed Apache, PHP, MySQL, and ModSecurity:

sudo apt update
sudo apt install apache2 php libapache2-mod-php mysql-server libapache2-mod-security2 -y
Started the web and database services:

sudo systemctl start apache2
sudo systemctl start mysql

3. Database Configuration
Secured MySQL:

sudo mysql_secure_installation
Logged into MySQL CLI:

sudo mysql -u root -p
Created database and user table for login:
sql
CREATE DATABASE login_demo;
USE login_demo;
CREATE TABLE users (id INT AUTO_INCREMENT PRIMARY KEY, username VARCHAR(50), password VARCHAR(100));
INSERT INTO users (username, password) VALUES ('admin', 'admin123');
EXIT;

4. Web Application Setup
Prepared web root and placed files:
    • Vulnerable login form and PHP in /var/www/html/vuln
    • Protected login form and PHP in /var/www/html
Managed correct permissions:

sudo chown -R ubuntu:ubuntu /var/www/html

5. ModSecurity Configuration
Disabled WAF on /vuln path to allow SQLi exploitation on vulnerable page:
Created Apache config file /etc/apache2/conf-available/disable-waf.conf with content:

Alias /vuln /var/www/html/vuln

<LocationMatch "^/vuln/">
    SecRuleEngine Off
</LocationMatch>
Enabled config and restarted Apache:

sudo a2enconf disable-waf
sudo systemctl restart apache2

6. Testing and Verification
    • Accessed vulnerable page at:
      
      http://3.6.93.109/vuln/page1.html
      Confirmed SQL injection is exploitable.
    • Accessed secure page at:
      
      http://3.6.93.109/page2.html
      Confirmed SQL injection attempts are blocked by ModSecurity.

Notes
    • The setup uses the same Apache server and port for both vulnerable and secure pages.
    • WAF is selectively disabled only for /vuln/* paths.
    • The project clearly demonstrates the impact of ModSecurity WAF on SQL injection protections.

This project is ready for deployment validation and submission with URLs:
    • EXPOITABLE: http://3.6.93.109/vuln/page1.html
    • PROTECTED: http://3.6.93.109/page2.html

screenshots:
<img width="1915" height="617" alt="image" src="https://github.com/user-attachments/assets/c62729fa-56c7-4a3c-a608-aebca2c8c5e0" />
<img width="1917" height="510" alt="image" src="https://github.com/user-attachments/assets/6a56c28b-6779-463c-af37-978d25787d93" />
<img width="1912" height="487" alt="image" src="https://github.com/user-attachments/assets/ddcd7340-f166-455b-a699-00057c09e7e6" />
<img width="1918" height="540" alt="image" src="https://github.com/user-attachments/assets/db9f82b7-1c47-4402-9738-492a243cab34" />
<img width="1908" height="463" alt="image" src="https://github.com/user-attachments/assets/593c0cbb-7cee-4d2c-849f-a6fc279c0cff" />
<img width="1917" height="562" alt="image" src="https://github.com/user-attachments/assets/41ac0a2c-a7ad-4420-ac29-df7c29a3bd04" />








