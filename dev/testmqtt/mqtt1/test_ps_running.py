#!/usr/bin/python
import paho.mqtt.client as mqtt
import sys, time, random
import json

sub_topic = "/smartplug/1"

def on_connect(client, userdata, rc):
    print("Connected with result code " + str(rc) + "\n")
    client.subscribe(sub_topic)
    print "subscribe topic : "+sub_topic

def on_message(client, userdata, msg):
    print "Receive from topic: " + msg.topic + "  Message: " + str(msg.payload)

client = mqtt.Client()
client.username_pw_set("isdat", "Qwer1234")
client.on_connect = on_connect
client.on_message = on_message
client.connect("10.16.64.14", 1883, 60)

client.loop_start()
while 1:
    time.sleep(10)
client.loop_stop()