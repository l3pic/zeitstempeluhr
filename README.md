# zeitstempeluhr
This is a self-created timestamp clock designed to generate entries in a database when an RFID chip is presented to the RFID reader. During installation, a default account named "_admin_" is established, with the password "_rDeYVwBzds_". Using these credentials, the admin can access the web interface. The admin account holds the authority to manually create, modify, and delete timestamps. Additionally, the admin can update the key associated with an RFID chip, with the key being set as the person's name. If a registered card's NFC UID already exists in the system but the key doesn't match the database record, the key on the card itself is overwritten with the database's key value. Therefore, when a new chip is introduced and scanned by the RFID reader, a new user entry is generated. The admin can subsequently modify the key to a specified name, prompting subsequent chip interactions to overwrite the card's key with the new value.<br>
<br>
Furthermore, the admin possesses the capability to reset passwords for all users. This admin account also has the ability to generate individual Excel files containing timestamp records for each person. A chosen timeframe dictates which timestamps are compiled into the Excel file. If a file for the same individual and timeframe is generated again, the existing file is replaced. Once an Excel file is generated, it becomes available for download. Normal users can log in and view their timestamps, but they lack the permissions to modify any entries.


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
You will require 220 Ω resistors for both LEDs. As for the LCD display, you'll need a 7.8k Ω resistor connected to the 5V source, and a 2.4k Ω resistor connected to the ground (GND). Both of these resistors should be linked to the contrast pin on the LCD display. Additional details are illustrated in the provided diagram below.<br>
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




Begin by downloading the “_[setup.sh](https://github.com/l3pic/zeitstempeluhr/blob/6ad1e21299b0d6f92adeb337b7bd7ac15bc547a1/setup.sh)_” file. This script is designed to facilitate the installation of all necessary services, libraries, and other essential files.<br>
<br>
To proceed, copy the downloaded file onto the Raspberry Pi device. To achieve this, you'll need to enable SSH on the Raspberry Pi. You can find instructions on how to enable SSH [here](https://www.elektronik-kompendium.de/sites/raspberry-pi/1906281.htm).<br>
<br>
Once SSH is enabled, you can follow these steps:<br>
<br>
- Open the Command Prompt (_Windows + R_, then type "_cmd_") and navigate to the directory where you have saved the "_setup.sh_" file.
- Using the command:
```cmd
scp .\setup.sh [user]@[host]:/home/[user]
```
Copy the file to the home directory of the specified _[user]_ on the Raspberry Pi. Replace _[user]_ with "pi" if you're using the standard Raspberry OS user. _[host]_ should be replaced with the IP address of your Raspberry Pi. To do this you need to be in the directory where the "_setup.sh_" file is located.
- Once the file is successfully copied to the Raspberry Pi, you'll need to adjust permissions to enable execution. Enter the following command: 
```cmd
ssh [user]@[host]
```
```cmd
chmod +x /[pathtofile]/setup.sh
```
Replace [pathtofile] with the actual path to the "setup.sh" file.
- If you're already in the directory containing the "setup.sh" file, execute it using:<br>
```cmd
./setup.sh
```
Be prepared for this process to take some time. The Raspberry Pi will automatically restart once the installation is complete.


## Additional
Additionally you can add an powerswitch which is recommended. For that you will need an NO-switch (normally open switch). It needs to be connected to the GPIO3 (Pin5) and to GND (Pin6) as shown in the picture below. <br>
<img src="https://github.com/l3pic/zeitstempeluhr/assets/43809826/3732424e-04ef-4d1d-9158-3a97a83978b5" height="400px">
