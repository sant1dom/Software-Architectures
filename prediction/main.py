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
    return {"Consumption": random.uniform(1, 100)}

@app.get("/getProduction")
def getProduction(userid):
    return {"Production": random.uniform(101, 200)}

@app.get("/getFuture")
def getFuture(userid):
    return {"Future": random.uniform(201, 300)}
