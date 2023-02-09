from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
import random

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

@app.get("/getConsumption")
def getConsumption(userid):
    return {
        "name": "Consumption",
        "info1": random.uniform(1, 100),
        "info2": random.uniform(1, 100),
    }

@app.get("/getProduction")
def getProduction(userid):
    return {
        "name": "Production",
        "info1": random.uniform(1, 100),
        "info2": random.uniform(1, 100),
    }


@app.get("/getFuture")
def getFuture(userid):
    return {
        "name": "Future",
        "info1": random.uniform(1, 100),
        "info2": random.uniform(1, 100),
    }
