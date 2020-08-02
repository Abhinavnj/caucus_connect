import mysql.connector

config = {
    'host': 'localhost',
    'database': 'id14296502_people',
    'user': 'id14296502_ccroot',
    'password': 'Secaucus!2345'
}

db = mysql.connector.connect(**config)
cursor = db.cursor()
