import xlsxwriter
import sys
import mysql.connector

mydb = mysql.connector.connect(
    host="localhost",
    user="pi",
    password="asperin",
    database="zeitstempeluhr"
)

data = []

mycursor = mydb.cursor()

sql_get_username = "SELECT username FROM user WHERE nfc_uid = %s"
val_get_username = (sys.argv[1], )

mycursor.execute(sql_get_username, val_get_username)
result = mycursor.fetchall()
for row in result:
    username = row[0]



if (sys.argv[2] == '0000' and sys.argv[3] == '2359'):
    sql_get_data = "SELECT datetime FROM zeiten WHERE nfc_uid = %s"
    val_get_data = (sys.argv[1], )
    file_name_from = 'all'
    file_name_to = 'all'
elif (sys.argv[2] == '0000'):
    sql_get_data = "SELECT datetime FROM zeiten WHERE nfc_uid = %s AND int_datetime <= %s"
    val_get_data = (sys.argv[1], sys.argv[3], )
    file_name_from = 'all'
    file_name_to = sys.argv[5]
elif (sys.argv[3] == '2359'):
    sql_get_data = "SELECT datetime FROM zeiten WHERE nfc_uid = %s AND int_datetime >= %s"
    val_get_data = (sys.argv[1], sys.argv[2], )
    file_name_from = sys.argv[4]
    file_name_to = 'all'
else:
    sql_get_data = "SELECT datetime FROM zeiten WHERE nfc_uid = %s AND int_datetime >= %s AND int_datetime <= %s"
    val_get_data = (sys.argv[1], sys.argv[2], sys.argv[3], )
    file_name_from = sys.argv[4]
    file_name_to = sys.argv[5]


workbook = xlsxwriter.Workbook('/var/www/html/excel/' + username + ' ' + file_name_from + ' bis ' + file_name_to + '.xlsx')
worksheet = workbook.add_worksheet()

mycursor.execute(sql_get_data, val_get_data)
result = mycursor.fetchall()
for row in result:
    data.append(row[0])

row = 0
col = 0

for zeitstempel in (data):
    worksheet.write(row, col, zeitstempel)
    row += 1

workbook.close();
