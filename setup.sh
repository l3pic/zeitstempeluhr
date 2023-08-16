#!/bin/bash
BLUE='\033[0;34m'
NC='\033[0m'
apt-get update
apt-get upgrade -y
printf "${BLUE}Enabling SPI interface\n${NC}"
raspi-config nonint do_spi 0
printf "${BLUE}Changing timezone to Europe/Berlin\n${NC}"
timedatectl set-timezone Europe/Berlin
printf "${BLUE}Installing Apache2\n${NC}"
apt-get install apache2 -y
printf "${BLUE}Installing PHP7.4\n${NC}"
apt-get install php7.4 -y 
printf "${BLUE}Installing mariadb-server\n${NC}"
apt-get install mariadb-server -y
printf "${BLUE}Installing Python3\n${NC}"
apt-get install python3 -y
printf "${BLUE}Installing pip\n${NC}"
apt-get install pip -y
printf "${BLUE}Installing git\n${NC}"
apt-get install git -y
printf "${BLUE}Installing php-mysql\n${NC}"
apt-get install php-mysql -y

printf "${BLUE}Cloning and setting up files for the NFC-Reader and the Webinterface\n${NC}"
mkdir /var/py
git clone https://github.com/l3pic/zeitstempeluhr
mv ./zeitstempeluhr/nfc_reader.py /var/py/nfc_reader.py
mv ./zeitstempeluhr/create_excel.py /var/py/create_excel.py
mv ./zeitstempeluhr/MFRC522.py /var/py/MFRC522.py
rm /var/www/html/index.html
rm ./zeitstempeluhr/README.md
rm ./zeitstempeluhr/setup.sh
mv ./zeitstempeluhr/* /var/www/html
rm -rf ./zeitstempeluhr

mkdir /var/www/html/excel
chmod +x /var/py/
chown -R www-data:www-data /var/www/html/excel/
chmod -R 755 /var/www/html/excel/

printf "${BLUE}Installing Python libraries\n${NC}"
pip3 install RPi.GPIO
pip3 install mysql-connector-python
pip3 install xlsxwriter

git clone https://github.com/pimylifeup/Adafruit_Python_CharLCD.git
python3 ./Adafruit_Python_CharLCD/setup.py install
mv /home/pi/Adafruit_Python_CharLCD/Adafruit_CharLCD/Adafruit_CharLCD.py /var/py/

printf "${BLUE}Creating a new service for the nfc-modul\n${NC}"
cat > /lib/systemd/system/nfc_reader.service << ENDOFFILE
 [Unit]
 Description=NFC-Reader
 After=multi-user.target

 [Service]
 Type=idle
 ExecStart=/usr/bin/python3 /var/py/nfc_reader.py

 [Install]
 WantedBy=multi-user.target
ENDOFFILE

printf "${BLUE}Enabling required services\n${NC}"
chmod 644 /lib/systemd/system/nfc_reader.service
systemctl daemon-reload
systemctl enable nfc_reader.service
systemctl enable apache2
systemctl enable mysql

printf "${BLUE}Setting up the database\n${NC}"
mysql -e "CREATE USER 'pi'@'localhost' IDENTIFIED BY 'asperin'"
mysql -e "GRANT SELECT, INSERT, UPDATE, DELETE ON * . * TO 'pi'@'localhost'"
mysql -e "CREATE DATABASE zeitstempeluhr"
mysql --database=zeitstempeluhr -u root -e 'CREATE TABLE `zeiten` (`id` INT unsigned NOT NULL AUTO_INCREMENT, `datetime` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci, `nfc_uid` BIGINT, `nfc_tag` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci, `int_datetime` BIGINT, PRIMARY KEY (`id`))'
mysql --database=zeitstempeluhr -u root -e 'CREATE TABLE `user` (`id` INT unsigned NOT NULL AUTO_INCREMENT, `username` VARCHAR(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci, `passwd` VARCHAR(58) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci, `sec_lvl` INT, `nfc_uid` BIGINT, PRIMARY KEY (`id`))'
mysql --database=zeitstempeluhr -u root -e 'INSERT INTO `user` (`id`, `username`, `passwd`, `sec_lvl`, `nfc_uid`) VALUES (NULL, "admin", "rDeYVwBzds", "0", "0")'
reboot
