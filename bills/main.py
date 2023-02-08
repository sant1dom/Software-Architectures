from fastapi import FastAPI, HTTPException
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel
from secrets import compare_digest
from copy import deepcopy
import uuid
import hashlib
from faker import Faker
import random

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


class Bill(BaseModel):
    billid: uuid.UUID = uuid.uuid4()
    userid: int
    energy_production: float
    energy_consumption: float
    date: str
    total: float
    paid: bool = False
    address: str = fake.address()

bills = []

@app.get("/makeRandom")
def makeRandom(userid):
    if len(bills) > 0:
        return;

    address = fake.address()
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
    for i in range(12):

        bill = Bill(
            userid=userid,
            energy_production=random.uniform(250, 350),
            energy_consumption=random.uniform(250, 350),
            date=dates[i],
            total=0,
            address=address,
            paid=random.choice([True, False])
        )

        bills[bill.billid] = bill

@app.get("/getAll")
def getAll(userid: str):

    mybills = []
    for bill in bills:
        if bill.userid == userid:
            mybills.append(bill)

    return bills

@app.get("/getId")
def getId(userid: str, billid: str):

    bill = bills[billid]

    if bill.userid == userid:
        return bill
    else:
        return []