# zeitstempeluhr
Things needed:<br>
- Raspberry Pi 3<br>
- RFIO-RC522<br>
- 16x2 LCD Display 1602A<br>
- green led<br>
- red led<br>
- 7.8k Ω resistor<br>
- 2.4k Ω resistor<br>
- 2x 220 Ω resistor<br>
<br>
## How to connect them together:<br>
For both LED´s you need the 220 Ω resistors. And for the LCD display you need the<br>
7.8k Ω resistor which is connected to 5V and the 2.4k Ω resistor which is connected to<br>
GND. Both of those resistors need to be connected to the contrast pin on the LCD display.<br>
The rest you can see on the sketch below.<br>
<br>
<img src="https://github.com/l3pic/zeitstempeluhr/assets/43809826/3239bce0-c845-47a5-8cd6-17c99981fa6d" height="400px">
<img src="https://github.com/l3pic/zeitstempeluhr/assets/43809826/a2cc2858-8749-4952-968d-76d5a2dd40de" height="400px">

## How to install:<br>
First download the “_setup.sh_” file. This script installs all required services, libraries and
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
