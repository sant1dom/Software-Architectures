from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
import uuid
import hashlib
import sqlite3

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

db = sqlite3.connect("authreg.db")

query = "CREATE TABLE users(" \
        "userid INTEGER PRIMARY KEY, " \
        "role, " \
        "email UNIQUE, " \
        "password, " \
        "name, " \
        "surname, " \
        "phone )"
db.execute(query)

query = f"INSERT INTO users('role', 'email', 'password', 'name', 'surname', 'phone') VALUES(" \
        f"'admin'," \
        f"'admin@energy.org',," \
        f"'bfcce2c19c8563fd4aa66f6ec607341ff25e5f6fe7fa520d7d1242d871385f23a3e8e80093120b4877d79535e10b182ae2ec8937d1f72f091e7178c9e4ff0f11'," \
        f"'Harley'," \
        f"'Davidson'," \
        f"'123456789' )"
db.execute(query)

query = "CREATE TABLE sessions(token, userid)"
db.execute(query)

@app.get("/register")
async def register(email: str, password: str, name: str, surname: str, phone: str):
    #1) Email Check
    query = f"SELECT userid FROM users where email = '{email}' LIMIT 1"
    print(query)
    response = db.execute(query)
    users = response.fetchall()
    if len(users):
        return "Email already exists"

    #2) Store
    hash = hashlib.blake2b(password.encode()).hexdigest()
    query = f"INSERT INTO users('role', 'email', 'password', 'name', 'surname', 'phone') VALUES(" \
            f"'user'," \
            f"'{email}'," \
            f"'{hash}'," \
            f"'{name}'," \
            f"'{surname}'," \
            f"'{phone}',"
    db.execute(query)

    #3) Read again for userid
    query = f"SELECT * FROM users where email = '{email}' and password='{hash}' LIMIT 1"
    print(query)
    response = db.execute(query)
    users = response.fetchall()
    user = users[0]

    #4) Generate Token
    token = uuid.uuid4()

    #5) Save Session
    query = f"INSERT INTO sessions('token','userid') VALUES(" \
            f"'{token}'," \
            f"'{user.userid}')"
    print(query)
    db.execute(query)

    #6) Ret clean data
    user.password = "HASH"
    user.token = token
    return user


@app.get("/login")
async def login(email: str, password: str):
    #1) Get User
    hash = hashlib.blake2b(password.encode()).hexdigest()
    query = f"SELECT * FROM users where email = '{email}' and password='{hash}'  LIMIT 1"
    print(query)
    response = db.execute(query)
    users = response.fetchall()
    if len(users) == 0:
        return "Wrong Email or Password"
    user = users[0]

    #2) Generate Token
    token = uuid.uuid4()

    #3) Save Sesion
    query = f"INSERT INTO sessions('token','userid') VALUES(" \
            f"'{token}'," \
            f"'{user.userid}')"
    print(query)
    db.execute(query)

    #4) Ret clean data
    user.password = "HASH"
    user.token = token
    return user

@app.get("/get")
async def get(token: str):
    #1) Get Session
    query = f"SELECT userid FROM sessions where token = '{token}' LIMIT 1"
    print(query)
    response = db.execute(query)
    sessions = response.fetchall()
    if len(sessions) == 0:
        return "Invalid token"
    session = sessions[0]

    # 2) Get User
    query = f"SELECT * FROM users where token = '{session.userid}' LIMIT 1"
    print(query)
    response = db.execute(query)
    users = response.fetchall()
    if len(users) == 0:
        return "Invalid token"
    user = users[0]

    #3) Ret clean data
    user.password = "HASH"
    user.token = token
    return user

@app.get("/logout")
async def logout(token: str):
    #1) Delete
    query = f"DELETE FROM sessions where token = '{token}'"
    print(query)
    db.execute(query)

    #2) Ret empty data
    return []
