import sqlite3
import csv

conn = sqlite3.connect(DBFILE)
c = conn.cursor()

columns = ''

createStatement = 'CREATE TABLE metadata_items ('
for row in c.execute('PRAGMA table_info(metadata_items)'):
    columns = columns + '`' +  row[1] + '`, '
    if (row[2].lower() == 'integer') or ('integer' in row[2].lower()):
        createStatement = createStatement + '`' +  row[1] + '`' + ' INT,'
    else:
        if row[2].lower() == 'float':
            createStatement = createStatement + '`' +  row[1] + '`' + ' float,'
        else:
            createStatement = createStatement + '`' +  row[1] + '`' + ' varchar(255),'
createStatement = createStatement[:-1] + ')'
columns = columns[:-2]
#print createStatement

selectStatement = 'SELECT ' + columns + ' from metadata_items'
insertStatement = 'INSERT INTO metadata_items (' + columns + ') VALUES '
for row in c.execute(selectStatement):
    insertStatement = insertStatement + '('
    for column in row:
        if column is not None:
            print(column)
            insertStatement = insertStatement + '\'' + str(column) + '\', '
        else:
            insertStatement = insertStatement + '\'\', '
    insertStatement = insertStatement[:-2]
    insertStatement = insertStatement + '),'

insertStatement = insertStatement[:-1]

print insertStatement
