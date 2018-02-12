#!/usr/bin/python
import MySQLdb
import json
import paho.mqtt.client as mqtt
import sys, time, random

# sub_topic1 = "/smartplug/"
# sub_topic2="/smartplug/"
# sub_topic3="/smartplug/"
# sub_topic4="/smartplug/"
# pub_topic = "/smartplug/"
# plug1 = "ON"
# plug2 = "ON"
# plug3 = "ON"
# plug4 = "ON"

plug_id = "1"
outlet_state = []

def dbExec(SQL):
    cur = dbcon.cursor()
    try:
        cur.execute(SQL)
        dbcon.commit()
        print "OK"
    except:
        dbcon.rollback()
        print "Failed"

def dbRead(SQL):
    cur = dbcon.cursor()
    try:
        cur.execute(SQL)
        results = cur.fetchall()
        print "READ OK"
        return results
    except:
        dbcon.rollback()
        print "READ Failed"

def on_connect(client, userdata, rc):
    SQL = "SELECT `outlet_switch_state` FROM `SMP_Outlet` WHERE `outlet_plug_id` = '" + plug_id + "' ORDER BY outlet_number;"
    results_state = dbRead(SQL)

    print str(len(results_state))+" len"
    for i in range(len(results_state)):
        outlet_state.append(results_state[i][0])
    
    temp = "outlet : "
    for i in range(len(outlet_state)):
        temp += str(outlet_state[i])+" "

    print temp

    client.subscribe("/smartplug/"+plug_id)
    print "subscribe /smartplug/"+plug_id+"\n\n"

    print("\nConnected with result code " + str(rc) + "\n")
    # client.subscribe(pub_topic)
    # client.subscribe(sub_topic1)
    # client.subscribe(sub_topic2)
    # client.subscribe(sub_topic3)
    # client.subscribe(sub_topic4)

# The callback for when a PUBLISH message is received from the server.
def on_message(client, userdata, msg):
    # print "Topic: " + msg.topic + "  Message: " + str(msg.payload)
    # if msg.topic == pub_topic:

    print msg.topic + ' ' + msg.payload
    try:
        data = json.loads(msg.payload)
    except ValueError, e:
        return False
    # print data["plug1"]["irms"]
    global dbcon

    # ================= Insert Current =====================
    SQL = "INSERT INTO `SMP_Used`(`used_plug_id`, `used_outlet_number`, `used_current`) VALUES ('" + str(
        data['plug_id']) + "','1'," + str(data["plug_detail"][0]["irms"]) + "),('" + str(
        data['plug_id']) + "','2'," + str(data["plug_detail"][1]["irms"]) + "),('" + str(
        data['plug_id']) + "','3'," + str(data["plug_detail"][2]["irms"]) + "),('" + str(
        data['plug_id']) + "','4'," + str(data["plug_detail"][3]["irms"]) + ")"
    # print SQL
    dbExec(SQL)


    for i in range(len(data["plug_detail"])):

        SQL = "SELECT `outlet_switch_state` FROM `SMP_Outlet` WHERE `outlet_plug_id` = '" + str(
                data['plug_id']) + "' AND `outlet_number` = '" + str(data["plug_detail"][i]["outlet_number"]) + "';"
        results_state = dbRead(SQL)
        #print "Outlet_state : "+str(results[0][0])
        '''
        # ================= Insert Report =====================
        # ON
        
        if results_state[0][0] == 0 and (data["plug_detail"][i]["app"] != "None" and data["plug_detail"][i]["irms"] > 0):

            SQL = "SELECT `plug_name`, `plug_location`, `plug_mem_id` FROM `SMP_Plug` WHERE `plug_id` = '" + str(
                data['plug_id']) + "';"
            results_plug_detail = dbRead(SQL)

            SQL = "INSERT INTO `SMP_Report`( `report_status`,  `report_plug_id`, `report_outlet`, `report_plug_name`, `report_plug_location`, `report_current_electronic`,`report_member_id`) VALUES (0,'" + str(
                data['plug_id']) + "','" + str(
                data["plug_detail"][i]["outlet_number"]) + "','" + str(
                results_plug_detail[0][0]) + "','" + str(
                results_plug_detail[0][1]) + "','" + str(
                data["plug_detail"][i]["app"]) + "','" + str(
                results_plug_detail[0][2]) + "');"
            dbExec(SQL)

        # OFF
        elif results_state[0][0] == 1 and (data["plug_detail"][i]["app"] == "None" and data["plug_detail"][i]["irms"] == 0):

            SQL = "SELECT `report_id`, `report_time_event`, `report_plug_name`, `report_plug_location`, `report_current_electronic`, `report_member_id` FROM `SMP_Report` WHERE `report_plug_id` = '" + str(
                data['plug_id']) + "' AND `report_outlet` = '" + str(
                data["plug_detail"][i]["outlet_number"]) + "' ORDER BY `report_time_event` DESC LIMIT 1;"
            results_report_detail = dbRead(SQL)

            SQL = "SELECT `used_time` FROM `SMP_Used` WHERE `used_plug_id` = '" + str(
                data['plug_id']) + "' AND `used_outlet_number` = '" + str(
                data["plug_detail"][i]["outlet_number"]) + "' ORDER BY `used_time` DESC LIMIT 1;"
            results_tiem_off = dbRead(SQL)
            results_tiem_off = results_tiem_off[0][0]

            SQL = "SELECT TIMESTAMPDIFF(SECOND,'"+str(results_report_detail[0][1])+"','"+str(results_tiem_off)+"');"
            results_sec = dbRead(SQL)
            sec = long(str(results_sec[0][0]))
            min = sec/60
            sec = (min  - math.floor(min)) * 60
            min = math.floor(min)
            hr = min / 60
            min = (hr  - math.floor(hr)) * 60
            hr = math.floor(hr)

            SQL = "SELECT `used_current` FROM `SMP_Used` WHERE `used_plug_id` = '" + str(
                data['plug_id']) + "' AND `used_outlet_number` = '" + str(
                data["plug_detail"][i]["outlet_number"]) + "' AND (`used_time` BETWEEN '"+str(results_report_detail[0][1])+"' AND '"+str(results_tiem_off)+"') ORDER BY `used_time`;"
            results_current = dbRead(SQL)

            #for i in range(len(results_current)):
        '''
        
        #================= Update State =====================
        if data["plug_detail"][i]["app"] == "None" and data["plug_detail"][i]["irms"] == 0:
            SQL = "UPDATE `SMP_Outlet` SET `outlet_switch_state` = '0', `outlet_status` = '0', `outlet_current_electronic` = NULL WHERE `SMP_Outlet`.`outlet_plug_id` = '" + str(data['plug_id']) + "' AND `SMP_Outlet`.`outlet_number` = '" + str(data["plug_detail"][i]["outlet_number"]) + "'"
            dbExec(SQL)
        else:
            if data["plug_detail"][i]["irms"] > 0 and data["plug_detail"][i]["app"] != "None":
                SQL = "UPDATE `SMP_Outlet` SET `outlet_switch_state` = '1', `outlet_status` = '1', `outlet_current_electronic` = '" + str(
                    data["plug_detail"][i]["app"]) + "' WHERE `SMP_Outlet`.`outlet_plug_id` = '" + str(
                    data['plug_id']) + "' AND `SMP_Outlet`.`outlet_number` = '" + str(data["plug_detail"][i]["outlet_number"]) + "'"
                dbExec(SQL)
            else:
                SQL = "UPDATE `SMP_Outlet` SET `outlet_switch_state` = '0', `outlet_status` = '1', `outlet_current_electronic` = '" + str(
                    data["plug_detail"][i]["app"]) + "' WHERE `SMP_Outlet`.`outlet_plug_id` = '" + str(
                    data['plug_id']) + "' AND `SMP_Outlet`.`outlet_number` = '" + str(data["plug_detail"][i]["outlet_number"]) + "'"
                dbExec(SQL)
        # dbcon.close()
        # if msg.topic == sub_topic1:
        #     global plug1
        #     print msg.topic + ' ' + msg.payload
        #     plug1 = msg.payload
        # if msg.topic == sub_topic2:
        #     global plug2
        #     print msg.topic + ' ' + msg.payload
        #     plug2 = msg.payload
        # if msg.topic == sub_topic3:
        #     global plug3
        #     print msg.topic + ' ' + msg.payload
        #     plug3 = msg.payload
        # if msg.topic == sub_topic4:
        #     global plug4
        #     print msg.topic + ' ' + msg.payload
        #     plug4 = msg.payload


print sys.argv
# if len(sys.argv) != 2:
#     print "Usabe : python " + sys.argv[0] + " \"MAC Address\""
#     print "Example : python " + sys.argv[0] + " 18:FE:34:CE:0C:86"
#     exit(0)
# sub_topic1 += sys.argv[1] + "/plug1/status"
# sub_topic2 += sys.argv[1] + "/plug2/status"
# sub_topic3 += sys.argv[1] + "/plug3/status"
# sub_topic4 += sys.argv[1] + "/plug4/status"
# pub_topic += sys.argv[1]
client = mqtt.Client()
client.username_pw_set("isdat", "Qwer1234")
client.on_connect = on_connect
client.on_message = on_message
client.connect("10.16.64.14", 1883, 60)
dbcon = MySQLdb.connect(host="localhost", user="smp", passwd="Once&forall", db="smp")
client.loop_start()
while 1:
    #     plugID = random.uniform(1, 4)
    #     irms1 = 0
    #     irms2 = 0
    #     irms3 = 0
    #     irms4 = 0
    #     app1 = "None"
    #     app2 = "None"
    #     app3 = "None"
    #     app4 = "None"
    #
    #     if plug1 == "ON":
    #         app1 = "Lamp"
    #         irms1 = round(random.uniform(0.3, 1.1), 2)
    #     if plug2 == "ON":
    #         app2 = "TV"
    #         irms2 = round(random.uniform(0.5, 1.1), 2)
    #     if plug3 == "ON":
    #         app3 = "Ref"
    #         irms3 = round(random.uniform(0.5, 1.8), 2)
    #     if plug4 == "ON":
    #         app4 = "Fan"
    #         irms4 = round(random.uniform(0.5, 1.1), 2)
    #
    #     pub_msg = '{"plug1": {"app":"' + app1 + '","irms": ' + str(
    #         irms1) + '},"plug2": {"app":"' + app2 + '","irms": ' + str(
    #         irms2) + '},"plug3": {"app":"' + app3 + '","irms": ' + str(
    #         irms3) + '},"plug4": {"app":"' + app4 + '","irms": ' + str(irms4) + '}}'
    #
    #     client.publish(pub_topic, pub_msg)
    time.sleep(10)
#
client.loop_stop()
# client.disconnect()
