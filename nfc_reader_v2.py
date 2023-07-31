#!/usr/bin/env python3
import RPi.GPIO as GPIO
from mfrc522 import SimpleMFRC522
import mysql.connector
from datetime import datetime
import time

GPIO.setwarnings(False)
reading = bool(True)

green_led = 17
red_led = 27
GPIO.setmode(GPIO.BCM)
GPIO.setup(green_led, GPIO.OUT)
GPIO.setup(red_led, GPIO.OUT)
GPIO.output(green_led, GPIO.HIGH)
GPIO.output(red_led, GPIO.LOW)

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
                            print("Neuer Nutzer angelegt!")
                            GPIO.output(green_led, GPIO.LOW)
                            time.sleep(3)
                            GPIO.output(green_led, GPIO.HIGH)
                            time.sleep(1)
                        else:
                            if db_tag == text:
                                val_insert_zeiten = (dt_string, id, text, dt_int)
                                mycursor.execute(sql_insert_zeiten, val_insert_zeiten)
                                mydb.commit()
                                GPIO.output(green_led, GPIO.LOW)
                                time.sleep(3)
                                GPIO.output(green_led, GPIO.HIGH)
                                time.sleep(1)
                            else:
                                reader.write(db_tag)
                                print("Tagname wurde geändert!")
                                GPIO.output(green_led, GPIO.LOW)
                                time.sleep(3)
                                GPIO.output(green_led, GPIO.HIGH)
                                time.sleep(1)
                else:
                        GPIO.output(red_led, GPIO.HIGH)
                        time.sleep(2)
                        GPIO.output(red_led, GPIO.LOW)
        finally:
                GPIO.cleanup()
                GPIO.setmode(GPIO.BCM)
                GPIO.setup(green_led, GPIO.OUT)
                GPIO.setup(red_led, GPIO.OUT)