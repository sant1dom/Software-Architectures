from fastapi import FastAPI, HTTPException
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel
from secrets import compare_digest
from copy import deepcopy
import uuid

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


class User(BaseModel):
    username: str
    password: str
    name: str
    surname: str
    email: str
    phone: str
    role: str = "user"
    id: uuid.UUID = uuid.uuid4()


class RegisterUser(BaseModel):
    username: str
    password: str
    name: str
    surname: str
    email: str
    phone: str


users = {
    "admin": {
        "username": "admin",
        "password": "admin",
        "name": "Harley",
        "surname": "Davidson",
        "email": "admin@energy.org",
        "phone": "123456789",
        "role": "admin",
        "id": uuid.uuid4()
    }
}


@app.post("/register")
async def register(user: RegisterUser):
    user = User(**user.dict())
    if user.username in users:
        raise HTTPException(status_code=400, detail="Username already exists")
    users[user.username] = user
    retuser = deepcopy(user)
    retuser["password"] = ""
    return {"message": "Registration successful", "user": retuser}


@app.post("/login")
async def login(username: str, password: str):
    if username not in users or not compare_digest(users[username]["password"], password):
        raise HTTPException(status_code=401, detail="Invalid username or password")
    retuser = deepcopy(users[username])
    print(retuser)
    retuser["password"] = ""
    return {"message": "Login successful", "user": retuser}
