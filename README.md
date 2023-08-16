# zeitstempeluhr
This is a self created timestamp clock which creates an entry in a database with the saved key on an rfid-chip, whenever someone holds their chip to the rfid-reader. When installing their is an standard account called "_admin_" with the password "_rDeYVwBzds_" created. With this username and password you can login into the webinterface. The admin account can create, edit, delete timestamps manually. He is also able to change the key of an rfid-chip. The key should be the name of the person. If an card is registered and the nfc-uid already exists but the key doesn´t match the one in the database it gets overwritten. So if you have an new chip you can hold it onto the rfid-reader and an new user will get created. Now you can change the key with the admin account to a name and the next time the chip will get overwritten with the ne key. The admin also can change the password of every user. He is also able to create excel files for each person with the timestamps. You can choose an timespan in which all timestamps will be saved to an excel file. If you create an excel file for the same person in the same timespan the already existing file gets overwritten. When an excel file is created you can download it. Every normal user can also login and see their timestamps but he can´t edit any entrys.


## Things needed:<br>
- Raspberry Pi 3<br>
- RFIO-RC522<br>
- 16x2 LCD Display 1602A<br>
- green led<br>
- red led<br>
- 7.8k Ω resistor<br>
- 2.4k Ω resistor<br>
- 2x 220 Ω resistor<br>

## How to connect them together:<br>
For both LED´s you need the 220 Ω resistors. And for the LCD display you need the<br>
7.8k Ω resistor which is connected to 5V and the 2.4k Ω resistor which is connected to<br>
GND. Both of those resistors need to be connected to the contrast pin on the LCD display.<br>
The rest you can see on the sketch below.<br>
<br>
<img src="https://github.com/l3pic/zeitstempeluhr/assets/43809826/3239bce0-c845-47a5-8cd6-17c99981fa6d" height="400px">
<img src="https://github.com/l3pic/zeitstempeluhr/assets/43809826/a2cc2858-8749-4952-968d-76d5a2dd40de" height="400px">

## How to install:<br>
First download the “_[setup.sh](https://github.com/l3pic/zeitstempeluhr/blob/6ad1e21299b0d6f92adeb337b7bd7ac15bc547a1/setup.sh)_” file. This script installs all required services, libraries and
other files.<br>
The file needs to copied onto the Raspberry Pi. For that SSH needs to be enabled on the
Raspberry Pi. [Here](https://www.elektronik-kompendium.de/sites/raspberry-pi/1906281.htm) you can see how you do that.<br>
Now you need to open the CMD (_Windows + R --> “cmd”_) and change the directory to
where you have put your “setup.sh” file. Now you can type
“_scp .\setup.sh [user]@[host]:/home/[user]_” to copy the file in the home directory of
the _[user]_. For _[user]_ you can write “pi” because that is a standard user which should
always exist if you have installed the Raspberry OS. _[host]_ is the IP-Address of your
Raspberry Pi.<br>
When the file was successfully copied onto the Raspberry Pi you need to change some
rights to be able to execute it. To do so type “_chmod +x /[pathtofile]/setup.sh_”.
Now if you are in the directory where your “setup.sh” file is located you can execute it with
“_./setup.sh_”.
