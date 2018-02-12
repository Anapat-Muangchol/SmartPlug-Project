#!/usr/bin/python
import paho.mqtt.client as mqtt
import sys, time, random
import json

# sub_topic1 = "/smartplug/"
# sub_topic2="/smartplug/"
# sub_topic3="/smartplug/"
# sub_topic4="/smartplug/"
sub_topic = "/smartplug/"
pub_topic = "/smartplug/"
outlet1 = "off"
outlet2 = "off"
outlet3 = "off"
outlet4 = "off"
# plug1 = "ON"
# plug2 = "ON"
# plug3 = "ON"
# plug4 = "ON"


def on_connect(client, userdata, rc):
    print("Connected with result code " + str(rc) + "\n")
    # client.subscribe(sub_topic1)
    # print "subscribe topic : "+sub_topic1
    # client.subscribe(sub_topic2)
    # print "subscribe topic : "+sub_topic2
    # client.subscribe(sub_topic3)
    # print "subscribe topic : "+sub_topic3
    # client.subscribe(sub_topic4)
    # print "subscribe topic : "+sub_topic4
    client.subscribe(sub_topic)
    print "subscribe topic : "+sub_topic


def on_message(client, userdata, msg):
    print "Receive from topic: " + msg.topic + "  Message: " + str(msg.payload)
    if msg.topic == "/smartplug/" + sys.argv[1] + "/status":
        try:
            data = json.loads(msg.payload)
        except ValueError, e:
            return False
        
        print "outlet:"+data['outlet']
        print "status:"+data['status']

        global outlet1
        global outlet2
        global outlet3
        global outlet4
        
        if data['outlet'] == "all":
            # global outlet1
            # global outlet2
            # global outlet3
            # global outlet4
            outlet1 = data['status']
            outlet2 = data['status']
            outlet3 = data['status']
            outlet4 = data['status']
        elif data['outlet'] == "1":
            # global outlet1
            outlet1 = data['status']
        elif data['outlet'] == "2":
            # global outlet2
            outlet2 = data['status']
        elif data['outlet'] == "3":
            # global outlet3
            outlet3 = data['status']
        elif data['outlet'] == "4":
            # global outlet4
            outlet4 = data['status']

'''
#The callback for when a PUBLISH message is received from the server.
def on_message(client, userdata, msg):
    print "Topic: " + msg.topic + "  Message: " + str(msg.payload)
    if msg.topic == pub_topic:
        global plug1
        print msg.topic + ' ' + msg.payload
        # data = json.loads(msg.payload)
        # print data["plug1"]["irms"]

    if msg.topic == sub_topic1:
        global plug1
        print msg.topic + ' ' + msg.payload
        plug1 = msg.payload
    if msg.topic == sub_topic2:
        global plug2
        print msg.topic + ' ' + msg.payload
        plug2 = msg.payload
    if msg.topic == sub_topic3:
        global plug3
        print msg.topic + ' ' + msg.payload
        plug3 = msg.payload
    if msg.topic == sub_topic4:
        global plug4
        print msg.topic + ' ' + msg.payload
        plug4 = msg.payload
'''

print sys.argv
if len(sys.argv) != 2:
    print "Usabe : python " + sys.argv[0] + " \"Plug ID\""
    print "Example : python " + sys.argv[0] + sys.argv[1]
    exit(0)
# sub_topic1 += sys.argv[1] + "/plug1/status"
# sub_topic2 += sys.argv[1] + "/plug2/status"
# sub_topic3 += sys.argv[1] + "/plug3/status"
# sub_topic4 += sys.argv[1] + "/plug4/status"
sub_topic += sys.argv[1] + "/status"
pub_topic += sys.argv[1]
print "sys.argv[1] : "+sys.argv[1]
client = mqtt.Client()
client.username_pw_set("isdat", "Qwer1234")
client.on_connect = on_connect
client.on_message = on_message
client.connect("10.16.64.14", 1883, 60)
client.loop_start()

while 1:
    plugID = sys.argv[1]
    irms1 = 0
    irms2 = 0
    irms3 = 0
    irms4 = 0
    app1 = "None"
    app2 = "None"
    app3 = "None"
    app4 = "None"

    if outlet1 == "on":
        app1 = "Lamp"
        irms1 = round(random.uniform(0.2, 0.5), 2)
    if outlet2 == "on":
        app2 = "Lamp"
        irms2 = round(random.uniform(0.2, 0.5), 2)
    if outlet3 == "on":
        app3 = "Fan"
        irms3 = round(random.uniform(0.28, 0.45), 2)
    if outlet4 == "on":
        app4 = "Fan"
        irms4 = round(random.uniform(0.28, 0.45), 2)

    pub_msg = '{"plug_id": ' + str(plugID) + ',"plug_detail":[{"outlet_number": 1,"app":"' + app1 + '","irms": ' + str(
        irms1) + '},{"outlet_number": 2,"app":"' + app2 + '","irms": ' + str(
        irms2) + '},{"outlet_number": 3,"app":"' + app3 + '","irms": ' + str(
        irms3) + '},{"outlet_number": 4,"app":"' + app4 + '","irms": ' + str(irms4) + '}]}'

    client.publish(pub_topic, pub_msg)
    print "send : "+pub_msg
    time.sleep(10)


'''
count = 0
switch_state = "off"
while 1:
    plugID = sys.argv[1]
    irms1 = 0
    irms2 = 0
    irms3 = 0
    irms4 = 0
    app1 = "None"
    app2 = "None"
    app3 = "None"
    app4 = "None"

    count += 1
    if switch_state == "on":
        if count < 12 :
            if plug1 == "ON":
                app1 = "Lamp"
                irms1 = round(random.uniform(0.3, 1.1), 2)
            if plug2 == "ON":
                app2 = "TV"
                irms2 = round(random.uniform(0.5, 1.1), 2)
            if plug3 == "ON":
                app3 = "Ref"
                irms3 = round(random.uniform(0.5, 1.8), 2)
            if plug4 == "ON":
                app4 = "Fan"
                irms4 = round(random.uniform(0.5, 1.1), 2)
        else:
            count = 0
            switch_state = "off"
            continue
    else:
        if count >= 3 :
            count = 0
            switch_state = "on"
            continue

    pub_msg = '{"plug_id": ' + str(plugID) + ',"plug_detail":[{"outlet_number": 1,"app":"' + app1 + '","irms": ' + str(
        irms1) + '},{"outlet_number": 2,"app":"' + app2 + '","irms": ' + str(
        irms2) + '},{"outlet_number": 3,"app":"' + app3 + '","irms": ' + str(
        irms3) + '},{"outlet_number": 4,"app":"' + app4 + '","irms": ' + str(irms4) + '}]}'

    client.publish(pub_topic, pub_msg)
    print switch_state+" - "+str(count)
    print "send : "+pub_msg
    time.sleep(10)
'''

client.loop_stop()
client.disconnect()
