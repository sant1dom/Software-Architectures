from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
import uuid
import hashlib
import sqlite3

app = FastAPI()

origins = ["http://localhost", "http://localhost:8080", "http://localhost:8081"]

app.add_middleware(
    CORSMiddleware,
    allow_origins=origins,
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)


def row_to_user(array):
    return {
        "userid": array[0],
        "role": array[1],
        "email": array[2],
        "password": array[3],
        "name": array[4],
        "surname": array[5],
        "phone": array[6],
    }


db = sqlite3.connect("authreg.db")


def init_db():
    # 1) Users
    query = (
        "CREATE TABLE IF NOT EXISTS users("
        "userid INTEGER PRIMARY KEY, "
        "role TEXT NOT NULL, "
        "email TEXT NOT NULL UNIQUE, "
        "password TEXT NOT NULL, "
        "name TEXT NOT NULL, "
        "surname TEXT NOT NULL, "
        "phone TEXT NOT NULL )"
    )
    print(query)
    db.execute(query)

    # 2) Sessions
    query = "CREATE TABLE IF NOT EXISTS sessions(token TEXT NOT NULL, userid INTEGER NOT NULL)"
    print(query)
    db.execute(query)

    # 3) Admin check
    query = "SELECT userid FROM users WHERE email = ? LIMIT 1"
    print(query)
    response = db.execute(query, ("admin@energy.org",))
    users = response.fetchall()
    if len(users):
        return

    # 4) Admin Store
    password = "passw0rd"
    passhash = hashlib.blake2b(password.encode()).hexdigest()
    query = (
        "INSERT INTO users(role, email, password, name, surname, phone) "
        "VALUES(?,?,?,?,?,?)"
    )
    print(query)
    db.execute(
        query,
        ("admin", "admin@energy.org", passhash, "Harley", "Davidson", "123456789"),
    )


init_db()


@app.get("/register")
async def register(email: str, password: str, name: str, surname: str, phone: str):
    # 1) Email Check
    query = "SELECT userid FROM users where email = ? LIMIT 1"
    response = db.execute(query, (email,))
    users = response.fetchall()
    if len(users):
        return "Email already exists"

    # 2) Store Hashed Password
    passhash = hashlib.blake2b(password.encode()).hexdigest()
    query = "INSERT INTO users(role, email, password, name, surname, phone) VALUES(?, ?, ?, ?, ?, ?)"
    db.execute(query, ("user", email, passhash, name, surname, phone))

    # 3) Read again for userid
    query = "SELECT * FROM users where email = ? and password = ? LIMIT 1"
    response = db.execute(query, (email, passhash))
    users = response.fetchall()
    user = row_to_user(users[0])

    # 4) Generate Token
    token = str(uuid.uuid4())

    # 5) Save Session
    query = "INSERT INTO sessions(token, userid) VALUES(?, ?)"
    db.execute(query, (token, user["userid"]))

    # 6) Return Clean Data
    user["password"] = "HASH"
    user["token"] = token
    return user


@app.get("/login")
async def login(email: str, password: str):
    # 1) Get User
    query = "SELECT * FROM users where email = ? and password=? LIMIT 1"
    print(query)
    response = db.execute(
        query, (email, hashlib.blake2b(password.encode()).hexdigest())
    )
    users = response.fetchall()
    if len(users) == 0:
        return "Wrong Email or Password"
    print(users)
    user = row_to_user(users[0])
    print(user)

    # 2) Generate Token
    token = str(uuid.uuid4())

    # 3) Save Session
    query = "INSERT INTO sessions(token, userid) VALUES(?, ?)"
    print(query)
    db.execute(query, (token, user["userid"]))

    # 4) Ret clean data
    user["password"] = "HASH"
    user["token"] = token
    return user


@app.get("/get")
async def get(token: str):
    # 1) Get Session
    query = "SELECT userid FROM sessions where token = ? LIMIT 1"
    response = db.execute(query, (token,))
    sessions = response.fetchall()
    if len(sessions) == 0:
        return "Invalid token"
    userid = sessions[0][0]

    # 2) Get User
    query = "SELECT * FROM users where userid = ? LIMIT 1"
    response = db.execute(query, (userid,))
    users = response.fetchall()
    if len(users) == 0:
        return "Invalid token"
    user = row_to_user(users[0])

    # 3) Ret clean data
    user["password"] = "HASH"
    user["token"] = token
    return user


@app.get("/logout")
async def logout(token: str):
    # 1) Delete
    query = "DELETE FROM sessions where token = ?"
    print(query)
    db.execute(query, (token,))

    # 2) Ret empty data
    return []
