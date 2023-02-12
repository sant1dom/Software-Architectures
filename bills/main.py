from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
from faker import Faker
import random
import sqlite3

fake = Faker('it_IT')
app = FastAPI()

origins = [
    "http://localhost",
    "http://localhost:8080",
    "http://localhost:8081"
]

app.add_middleware(
    CORSMiddleware,
    allow_origins=origins,
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

def row_to_bill(array):
    return {
        "billid": array[0],
        "houseid": array[1],
        "userid": array[2],
        "energy_production": array[3],
        "energy_consumption": array[4],
        "date": array[5],
        "total": array[6],
        "paid": array[7],
        "address": array[8],
    }

db = sqlite3.connect("bills.db")

def init_db():
    #1) Users
    query = "CREATE TABLE IF NOT EXISTS bills(" \
            "billid INTEGER PRIMARY KEY, " \
            "houseid, " \
            "userid, " \
            "energy_production, " \
            "energy_consumption, " \
            "date, " \
            "total, "\
            "paid, " \
            "address )"
    print(query)
    db.execute(query)

    query = f"SELECT billid FROM bills LIMIT 1"
    print(query)
    response = db.execute(query)
    bills = response.fetchall()
    if len(bills):
        return

    dates = [
        "Jan 2022",
        "Feb 2022",
        "Mar 2022",
        "Apr 2022",
        "May 2022",
        "Jun 2022",
        "Jul 2022",
        "Aug 2022",
        "Sep 2022",
        "Oct 2022",
        "Nov 2022",
        "Dec 2022"
    ]

    for userid in range(1, 10):
        for houseid in range(140, 145):
            address = fake.address().replace("\n", "").replace("'", "")
            for i in range(12):
                date = dates[i]
                energy_production = random.uniform(250, 350)
                energy_consumption = random.uniform(250, 350)
                total = random.uniform(100, 400)
                paid = random.choice([True, False])

                query = f"INSERT INTO bills(houseid, userid, energy_production, energy_consumption, date, total, address, paid) VALUES(" \
                        f"'{houseid}'," \
                        f"'{userid}'," \
                        f"'{energy_production}',"\
                        f"'{energy_consumption}'," \
                        f"'{date}'," \
                        f"'{total}'," \
                        f"'{address}'," \
                        f"'{paid}')"
                print(query)
                db.execute(query)

init_db()

@app.get("/getAll")
async def getAll(userid: int):
    query = f"SELECT * FROM bills where userid = '{userid}'"
    print(query)
    response = db.execute(query)
    rows = response.fetchall()

    bills = []
    for row in rows:
        bills.append(row_to_bill(row))
    return bills


@app.get("/getId")
async def getId(userid: int, billid: int):
    query = f"SELECT * FROM bills where userid = '{userid} and billid = '{billid}' LIMIT 1"
    print(query)
    response = db.execute(query)
    rows = response.fetchall()

    for row in rows:
        return row_to_bill(row)

    return []