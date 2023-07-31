import xlsxwriter
import sys

# Create Workbook an add worksheet.

workbook = xlsxwriter.Workbook('/var/www/html.xlsx')
worksheet = workbook.add_worksheet()

data = (
    ['Name', 'Zeitstempel', 'NFC-UID'],
    ['Leonard Dettmann', '14:15 25-07-2023', 987654321098],
    ['Leonard Dettmann', '08:00 26-07-2023', 987654321098],
    ['Leonard Dettmann', '10:00 27-07-2023', 987654321098],
    ['Leonard Dettmann', '15:45 29-07-2023', 987654321098],
    ['Leonard Dettmann', '08:00 05-08-2023', 987654321098],
    ['Leonard Dettmann', '13:30 10-08-2023', 987654321098],
)

row = 0
col = 0

for name, zeitstempel, nfc_uid in (data):
    worksheet.write(row, col, name)
    worksheet.write(row, col + 1, zeitstempel)
    worksheet.write(row, col + 2, nfc_uid)
    row += 1

workbook.close();