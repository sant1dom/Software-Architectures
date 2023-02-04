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
        "password": "bfcce2c19c8563fd4aa66f6ec607341ff25e5f6fe7fa520d7d1242d871385f23a3e8e80093120b4877d79535e10b182ae2ec8937d1f72f091e7178c9e4ff0f11",
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
    user["password"] = hashlib.blake2b(user["password"].encode()).hexdigest()
    users[user.username] = user
    retuser = deepcopy(user)
    retuser["password"] = ""
    return {"message": "Registration successful", "user": retuser}


@app.post("/login")
async def login(username: str, password: str):
    if username not in users or not compare_digest(users[username]["password"], hashlib.blake2b(password.encode()).hexdigest()):
        raise HTTPException(status_code=401, detail="Invalid username or password")
    retuser = deepcopy(users[username])
    print(retuser)
    retuser["password"] = ""
    return {"message": "Login successful", "user": retuser}
