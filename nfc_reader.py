#!/usr/bin/env python3
import sys
sys.path.append('/var/py/')

import RPi.GPIO as GPIO
from mfrc522 import SimpleMFRC522
import mysql.connector
from datetime import datetime
import time
import Adafruit_CharLCD as LCD


GPIO.setwarnings(False)
reading = bool(True)

green_led = 17
red_led = 27
GPIO.setmode(GPIO.BCM)
GPIO.setup(green_led, GPIO.OUT)
GPIO.setup(red_led, GPIO.OUT)
GPIO.output(green_led, GPIO.HIGH)
GPIO.output(red_led, GPIO.LOW)

lcd_rs = 21
lcd_en = 20
lcd_d4 = 16
lcd_d5 = 26
lcd_d6 = 19
lcd_d7 = 13
lcd_backlight = 4
lcd_columns = 16
lcd_rows = 2

lcd = LCD.Adafruit_CharLCD(lcd_rs, lcd_en, lcd_d4, lcd_d5, lcd_d6, lcd_d7, lcd_columns, lcd_rows, lcd_backlight)
lcd.show_cursor(False)

mydb = mysql.connector.connect(
        host="localhost",
        user="pi",
        password="asperin",
        database="zeitstempeluhr"
)

mycursor = mydb.cursor()

sql_insert_zeiten = "INSERT INTO zeiten (datetime, nfc_uid, nfc_tag, int_datetime) VALUES (%s, %s, %s, %s)"
sql_check_uid = "SELECT * FROM user WHERE nfc_uid = %s"
sql_create_user = "INSERT INTO user (username, passwd, sec_lvl, nfc_uid) VALUES(%s, %s, %s, %s)"

reader = SimpleMFRC522()
while reading:
        try:
                id, text = reader.read()
                print(id)
                text = text.rstrip()
                print(text)
                now = datetime.now()
                dt_string = now.strftime("%H:%M %d-%m-%Y")
                dt_int = int(now.strftime("%Y%m%d%H%M"))
                print(dt_string)
                print(dt_int)
                if id and text:
                        val_check_uid = (id, )
                        mycursor.execute(sql_check_uid, val_check_uid)
                        result = mycursor.fetchall()
                        for row in result:
                            db_tag = row[1]

                        if len(result) == 0:
                            val_create_user = (text, "", 1, id)
                            mycursor.execute(sql_create_user, val_create_user)
                            mydb.commit()
                            lcd.message('Neuer Chip\nwurde erkannt!')
                            GPIO.output(green_led, GPIO.LOW)
                            time.sleep(3)
                            GPIO.output(green_led, GPIO.HIGH)
                            lcd.clear()
                            time.sleep(1)
                        else:
                            if db_tag == text:
                                val_insert_zeiten = (dt_string, id, text, dt_int)
                                mycursor.execute(sql_insert_zeiten, val_insert_zeiten)
                                mydb.commit()
                                lcd.message('Eintrag erstellt\n%s' % (dt_string))
                                GPIO.output(green_led, GPIO.LOW)
                                time.sleep(3)
                                GPIO.output(green_led, GPIO.HIGH)
                                lcd.clear()
                                time.sleep(1)
                            else:
                                reader.write(db_tag)
                                lcd.message('Tag erfolgreich\nueberschrieben')
                                GPIO.output(green_led, GPIO.LOW)
                                time.sleep(3)
                                GPIO.output(green_led, GPIO.HIGH)
                                lcd.clear()
                                time.sleep(1)
                else:
                        lcd.message('Fehler bitte\nerneut versuchen')
                        GPIO.output(red_led, GPIO.HIGH)
                        time.sleep(2)
                        lcd.clear()
                        GPIO.output(red_led, GPIO.LOW)
        finally:
            print("")