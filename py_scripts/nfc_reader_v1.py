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

sql = "INSERT INTO zeiten (datetime, nfc_uid, nfc_tag, int_datetime) VALUES (%s, %s, %s, %s)"


reader = SimpleMFRC522()
while reading:
        try:
                id, text = reader.read()
                print(id)
                print(text)
                now = datetime.now()
                dt_string = now.strftime("%H:%M %d-%m-%Y")
                dt_int = int(now.strftime("%Y%m%d%H%M"))
                print(dt_string)
                print(dt_int)
                if id and text:
                        val = (dt_string, id, text, dt_int)
                        mycursor.execute(sql, val)
                        mydb.commit()
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