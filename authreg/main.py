from fastapi import FastAPI, HTTPException
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel
from secrets import compare_digest
from copy import deepcopy
import uuid
import hashlib

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
    # auto generated, used as key
    userid: int

    # auto generated
    role: str = "user"

    # from registration, used for login
    email: str
    password: str

    # from registration, not used for login
    name: str
    surname: str
    phone: str


class RegisterUser(BaseModel):
    email: str
    password: str
    name: str
    surname: str
    phone: str

admin = {
    "userid": 1,
    "role": "admin",
    "email": "admin@energy.org",
    "password": "bfcce2c19c8563fd4aa66f6ec607341ff25e5f6fe7fa520d7d1242d871385f23a3e8e80093120b4877d79535e10b182ae2ec8937d1f72f091e7178c9e4ff0f11",
    "name": "Harley",
    "surname": "Davidson",
    "phone": "123456789",
}

users = []
users.append(User(**admin))

sessions = []


@app.post("/register")
async def register(reg_user: RegisterUser):

    #Check Email
    for user in users:
        if user.email == reg_user.email:
            return "Email already exists"

    #Create and store User
    user = User(**reg_user.dict())
    hash = hashlib.blake2b(user["password"].encode()).hexdigest()
    user.password = hash
    user.userid = len(users) + 1

    users[user.userid] = user

    #Create and store Session
    token: uuid.UUID = uuid.uuid4()
    sessions[token] = user.userid

    #Return a cleaned user with token
    retuser = deepcopy(user)
    del retuser["password"]
    retuser["token"] = token

    return retuser


@app.post("/login")
async def login(email: str, password: str):

    hash = hashlib.blake2b(password.encode()).hexdigest()

    found = False
    for user in users:
        if user.email == email:
            if user.password != hash:
                return "Wrong Password"
            else:
                found = True
                break

    if not found:
        return "Wrong Email"

    #Create and store Session
    token: uuid.UUID = uuid.uuid4()
    sessions[token] = user.userid

    #Return a cleaned user with token
    retuser = deepcopy(user)
    del retuser["password"]
    retuser["token"] = token

    return retuser

@app.post("/get")
async def get(token: str):
    return users[token]

@app.post("/logout")
async def logout(token: str):
    del users[token]
    return []