import re
import requests
import json
import random
import time
import copy
import uuid


def add_house(lat, lon, tilt, orientation, altitude, area, number, efficiency):
    flows = requests.get("http://nodered:8880/flows").json()
    y = flows[-1]["y"] + 200
    id = uuid.uuid4()

    new_house = {}
    new_house["id"] = f"{id}"
    new_house["type"] = "function"
    new_house["z"] = "73a28a44.f3c3b4"
    new_house["name"] = f"House {new_house['id']}"
    new_house[
        "func"
    ] = f'msg.payload.powerforecast = Math.abs(msg.payload.powerforecast + Math.random());\nmsg.payload = \'{{"energy_production": \' + msg.payload.powerforecast + \', "energy_consumption": \' + global.get("housePowerConsumption")(new Date()) + \', "house_id":{id} }}\';\nreturn msg;'
    new_house["outputs"] = 1
    new_house["noerr"] = 0
    new_house["initialize"] = ""
    new_house["finalize"] = ""
    new_house["libs"] = []
    new_house["x"] = 340
    new_house["y"] = y
    new_house["wires"] = [["4aa66ec45b6fd43a", "5b16ed9f7c633ca0"]]

    flows["flows"].append(new_house)
    flows["flows"].append(solar_panel)

    flows[2]["wires"].append([solar_panel["id"]])
    requests.post("http://nodered:8880/flows", json=flows)


if __name__ == "__main__":
    main()
