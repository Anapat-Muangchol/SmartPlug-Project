#!/usr/bin/python
import MySQLdb
import paho.mqtt.client as mqtt

topic0 = "smartplug"

def on_connect(client, userdata, rc):
        print("Connected with result code "+str(rc))
        client.subscribe(topic0)

# The callback for when a PUBLISH message is received from the server.
def on_message(client, userdata, msg):
	dbcon = MySQLdb.connect(host="localhost", user="smp", passwd="smp@2017", db="smartplug")
	
	SQL = "INSERT INTO smp (smp_id,IRMS1,IRMS2,IRMS3,IRMS4) VALUES (" + msg.payload + ")"
	print SQL;
	cur = dbcon.cursor()
	#cur.execute(SQL)
	#cur.commit()
	try:
		cur.execute(SQL)
		dbcon.commit()
	except:
		dbcon.rollback()
		cur.close()
	dbcon.close()
	print(msg.topic)
	
client = mqtt.Client()
client.username_pw_set("isdat","Qwer1234")
client.on_connect = on_connect
client.on_message = on_message

client.connect("10.16.64.14", 1883, 60)

client.loop_forever()
