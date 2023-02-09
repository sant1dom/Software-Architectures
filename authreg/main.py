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


class User():
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

class Session():
    token: uuid.UUID
    userid: int

users = []
sessions = []

admin = User()
admin.userid = 0,
admin.role = "admin"
admin.email = "admin@energy.org"
admin.password = "bfcce2c19c8563fd4aa66f6ec607341ff25e5f6fe7fa520d7d1242d871385f23a3e8e80093120b4877d79535e10b182ae2ec8937d1f72f091e7178c9e4ff0f11"
admin.name = "Harley"
admin.surname = "Davidson"
admin.phone = "123456789"
users.append(admin)

@app.get("/register")
async def register(email: str, password: str, name: str, surname: str, phone: str):

    #Check Email
    for user in users:
        if user.email == email:
            return "Email already exists"


    #Create and store User
    user = User()
    user.userid = len(users)
    user.email = email
    user.name = name
    user.surname = surname
    user.phone = phone

    #Hash Password
    hash = hashlib.blake2b(password.encode()).hexdigest()
    user.password = hash

    users.append(user)

    #Generate Token
    token = uuid.uuid4()

    # Create and store Session
    session = Session()
    session.token = token
    session.userid = user.userid
    sessions.append(session)

    #Return a cleaned user with token
    retuser = deepcopy(user)
    retuser.password = "HASH"
    retuser.token = token

    return retuser


@app.get("/login")
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

    #Generate Token
    token = uuid.uuid4()

    # Create and store Session
    session = Session()
    session.token = token
    session.userid = user.userid
    sessions.append(session)

    #Return a cleaned user with token
    retuser = deepcopy(user)
    retuser.password = "HASH"
    retuser.token = token

    return retuser

@app.get("/get")
async def get(token: str):
    for session in sessions:
        if str(session.token) == str(token):
            user = users[session.userid]

            # Return a cleaned user with token
            retuser = deepcopy(user)
            retuser.password = "HASH"
            retuser.token = token

            return retuser

    return "Invalid token"

@app.get("/logout")
async def logout(token: str):
    for k, session in enumerate(sessions):
        if session.token == token:
            del sessions[k]

    return []
