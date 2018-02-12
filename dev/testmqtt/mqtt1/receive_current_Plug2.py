#!/usr/bin/python
import MySQLdb
import json
import paho.mqtt.client as mqtt
import sys, time, random
import math
import decimal

# sub_topic1 = "/smartplug/"
# sub_topic2="/smartplug/"
# sub_topic3="/smartplug/"
# sub_topic4="/smartplug/"
# pub_topic = "/smartplug/"
# plug1 = "ON"
# plug2 = "ON"
# plug3 = "ON"
# plug4 = "ON"

plug_id = "2"
outlet_state = []

plug_is_dead = True

def dbExec(SQL):
    cur = dbcon.cursor()
    try:
        cur.execute("SET NAMES UTF8")
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

    print "\n"+str(len(results_state))+" Outlets"
    for i in range(len(results_state)):
        outlet_state.append(results_state[i][0])
    
    temp = "Outlet_state : "
    for i in range(len(outlet_state)):
        temp += str(outlet_state[i])+" "
    print temp

    client.subscribe("/smartplug/"+plug_id)
    print "subscribe /smartplug/"+plug_id+"\n"

    print("Connected with result code " + str(rc) + "\n")
    # client.subscribe(pub_topic)
    # client.subscribe(sub_topic1)
    # client.subscribe(sub_topic2)
    # client.subscribe(sub_topic3)
    # client.subscribe(sub_topic4)

# The callback for when a PUBLISH message is received from the server.
def on_message(client, userdata, msg):
    # print "Topic: " + msg.topic + "  Message: " + str(msg.payload)
    # if msg.topic == pub_topic:

    try:
        global plug_is_dead

        plug_is_dead = False
        print "plug_is_dead : " + str(plug_is_dead)

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

            # ================= Update State =====================
            # On_switch_outlet
            if data["plug_detail"][i]["irms"] >= 0 and data["plug_detail"][i]["app"] != "None":

                # ---------- cherk real switch state after plug dead ----------
                if outlet_state[i] == 2:
                    SQL = "SELECT `report_status` FROM `SMP_Report` WHERE `report_plug_id` = '" + str(
                        data['plug_id']) + "' AND `report_outlet` = '" + str(
                        data["plug_detail"][i]["outlet_number"]) + "' ORDER BY `report_time_event` DESC LIMIT 1;"
                    results_real_state = dbRead(SQL)
                    if len(results_real_state) == 0:
                        outlet_state[i] = 1
                        SQL = "UPDATE `SMP_Outlet` SET `outlet_switch_state` = '1', `outlet_status` = '1', `outlet_current_electronic` = '" + str(
                            data["plug_detail"][i]["app"]) + "' WHERE `SMP_Outlet`.`outlet_plug_id` = '" + str(
                            data['plug_id']) + "' AND `SMP_Outlet`.`outlet_number` = '" + str(
                            data["plug_detail"][i]["outlet_number"]) + "'"
                        dbExec(SQL)
                    else :
                        if results_real_state[0][0] == 0:
                            outlet_state[i] = 1
                            SQL = "UPDATE `SMP_Outlet` SET `outlet_switch_state` = '1', `outlet_status` = '1', `outlet_current_electronic` = '" + str(
                                data["plug_detail"][i]["app"]) + "' WHERE `SMP_Outlet`.`outlet_plug_id` = '" + str(
                                data['plug_id']) + "' AND `SMP_Outlet`.`outlet_number` = '" + str(
                                data["plug_detail"][i]["outlet_number"]) + "'"
                            dbExec(SQL)
                        else:
                            outlet_state[i] = 0

                # ---------- Update switch state ----------
                if outlet_state[i] == 0:
                    outlet_state[i] = 1
                    SQL = "UPDATE `SMP_Outlet` SET `outlet_switch_state` = '1', `outlet_status` = '1', `outlet_current_electronic` = '" + str(
                        data["plug_detail"][i]["app"]) + "' WHERE `SMP_Outlet`.`outlet_plug_id` = '" + str(
                        data['plug_id']) + "' AND `SMP_Outlet`.`outlet_number` = '" + str(
                        data["plug_detail"][i]["outlet_number"]) + "'"
                    dbExec(SQL)

                    # ---------- Insert report current on ----------
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

            # Off_switch_outlet
            else:

                # ---------- cherk real switch state after plug dead ----------
                if outlet_state[i] == 2:
                    SQL = "SELECT `report_status` FROM `SMP_Report` WHERE `report_plug_id` = '" + str(
                        data['plug_id']) + "' AND `report_outlet` = '" + str(
                        data["plug_detail"][i]["outlet_number"]) + "' ORDER BY `report_time_event` DESC LIMIT 1;"
                    results_real_state = dbRead(SQL)
                    if len(results_real_state) == 0:
                        outlet_state[i] = 0
                        SQL = "UPDATE `SMP_Outlet` SET `outlet_switch_state` = '0', `outlet_status` = '0', `outlet_current_electronic` = '" + str(
                            data["plug_detail"][i]["app"]) + "' WHERE `SMP_Outlet`.`outlet_plug_id` = '" + str(
                            data['plug_id']) + "' AND `SMP_Outlet`.`outlet_number` = '" + str(
                            data["plug_detail"][i]["outlet_number"]) + "'"
                        dbExec(SQL)
                    else :
                        if results_real_state[0][0] == 0:
                            outlet_state[i] = 1
                        else:
                            outlet_state[i] = 0
                            SQL = "UPDATE `SMP_Outlet` SET `outlet_switch_state` = '0', `outlet_status` = '0', `outlet_current_electronic` = '" + str(
                                data["plug_detail"][i]["app"]) + "' WHERE `SMP_Outlet`.`outlet_plug_id` = '" + str(
                                data['plug_id']) + "' AND `SMP_Outlet`.`outlet_number` = '" + str(
                                data["plug_detail"][i]["outlet_number"]) + "'"
                            dbExec(SQL)

                # ---------- Update switch state ----------
                if outlet_state[i] == 1:
                    outlet_state[i] = 0
                    SQL = "UPDATE `SMP_Outlet` SET `outlet_switch_state` = '0', `outlet_status` = '0', `outlet_current_electronic` = NULL WHERE `SMP_Outlet`.`outlet_plug_id` = '" + str(
                        data['plug_id']) + "' AND `SMP_Outlet`.`outlet_number` = '" + str(
                        data["plug_detail"][i]["outlet_number"]) + "'"
                    dbExec(SQL)

                    # ---------- Insert report current off ----------
                    SQL = "SELECT `report_id`, `report_time_event`, `report_plug_name`, `report_plug_location`, `report_current_electronic`, `report_member_id` FROM `SMP_Report` WHERE `report_plug_id` = '" + str(
                        data['plug_id']) + "' AND `report_outlet` = '" + str(
                        data["plug_detail"][i]["outlet_number"]) + "' ORDER BY `report_time_event` DESC LIMIT 1;"
                    # print SQL
                    results_report_detail = dbRead(SQL)

                    SQL = "SELECT `used_time` FROM `SMP_Used` WHERE `used_plug_id` = '" + str(
                        data['plug_id']) + "' AND `used_outlet_number` = '" + str(
                        data["plug_detail"][i]["outlet_number"]) + "' ORDER BY `used_time` DESC LIMIT 1;"
                    results_tiem_off = dbRead(SQL)
                    results_tiem_off = results_tiem_off[0][0]

                    # print "results_tiem_off : "+str(results_tiem_off)
                    # print "results_report_detail[0][0] : "+str(results_report_detail[0][0])
                    # print "results_report_detail[0][1] : "+str(results_report_detail[0][1])
                    # print "results_report_detail[0][2] : "+str(results_report_detail[0][2])
                    # print "results_report_detail[0][3] : "+str(results_report_detail[0][3])
                    # print "results_report_detail[0][4] : "+str(results_report_detail[0][4])
                    # print "results_report_detail[0][5] : "+str(results_report_detail[0][5])

                    SQL = "SELECT TIMESTAMPDIFF(SECOND,'" + str(results_report_detail[0][1]) + "','" + str(
                        results_tiem_off) + "');"
                    results_sec = dbRead(SQL)
                    real_sec = long(str(results_sec[0][0]))
                    # print "real_sec : "+str(real_sec)
                    min = real_sec / 60.0
                    # print "min : "+str(min)
                    sec = int((min - math.floor(min)) * 60.0)
                    # print "sec : "+str(sec)
                    min = math.floor(min)
                    # print "min : "+str(min)
                    hr = min / 60.0
                    # print "hr : "+str(hr)
                    min = int((hr - math.floor(hr)) * 60.0)
                    # print "min : "+str(min)
                    hr = int(math.floor(hr))
                    # print "hr : "+str(hr)

                    SQL = "SELECT `used_current` FROM `SMP_Used` WHERE `used_plug_id` = '" + str(
                        data['plug_id']) + "' AND `used_outlet_number` = '" + str(
                        data["plug_detail"][i]["outlet_number"]) + "' AND (`used_time` BETWEEN '" + str(
                        results_report_detail[0][1]) + "' AND '" + str(results_tiem_off) + "') ORDER BY `used_time`;"
                    results_current = dbRead(SQL)

                    mov_avg = 0.0
                    for j in range(len(results_current)):
                        if j == (len(results_current) - 1):
                            break;
                        mov_avg = round((0.75 * mov_avg) + (float(results_current[j][0]) * 0.25), 10)
                        # print "mov_avg = "+str(mov_avg)+" + "+str(float(results_current[j][0])* 0.25)
                    unit = (220.0 * mov_avg) * (real_sec / 3600.0)
                    # print "mov_avg : "+str(mov_avg)
                    # unit = 220*mov_avg
                    # print "mov_avg*220 : "+str(unit)
                    # unit = unit*real_sec
                    # print "mov_avg*220*time : "+str(unit)
                    # unit = unit/3600
                    # print "mov_avg*220*time/3600 : "+str(unit)
                    unit = unit / 1000.0
                    unit = round(unit, 3)
                    print "real_sec : " + str(real_sec)
                    print "Unit : " + str(unit)

                    SQL = "INSERT INTO `SMP_Report`(`report_id`, `report_status`,  `report_plug_id`, `report_outlet`, `report_plug_name`, `report_plug_location`, `report_current_electronic`, `report_time_duration`, `report_power_use`, `report_member_id`) VALUES ('" + str(
                        results_report_detail[0][0]) + "',1,'" + str(
                        data['plug_id']) + "','" + str(
                        data["plug_detail"][i]["outlet_number"]) + "','" + str(
                        results_report_detail[0][2]) + "','" + str(
                        results_report_detail[0][3]) + "','" + str(
                        results_report_detail[0][4]) + "','" + str(hr) + ":" + str(min) + ":" + str(sec) + "','" + str(
                        unit) + "','" + str(
                        results_report_detail[0][5]) + "');"
                    dbExec(SQL)
                    print "=============================================================="

                # ---------- Update switch state ----------
                if outlet_state[i] == 2:
                    outlet_state[i] = 0
                    SQL = "UPDATE `SMP_Outlet` SET `outlet_switch_state` = '0', `outlet_status` = '0', `outlet_current_electronic` = NULL WHERE `SMP_Outlet`.`outlet_plug_id` = '" + str(
                        data['plug_id']) + "' AND `SMP_Outlet`.`outlet_number` = '" + str(
                        data["plug_detail"][i]["outlet_number"]) + "'"
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
    except ValueError, e:
        print "Program is crash"
        sys.exit(1)




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

# Check plug dead
client.loop_start()
while 1:
    try:
        time.sleep(30)
        print "================= Check Plug ================="
        print "plug_is_dead : " + str(plug_is_dead)
        if plug_is_dead:
            for i in range(len(outlet_state)):
                outlet_state[i] = 2
            SQL = "UPDATE `SMP_Outlet` SET `outlet_switch_state` = '2', `outlet_status` = '2', `outlet_current_electronic` = 'Plug Not Running' WHERE `SMP_Outlet`.`outlet_plug_id` = '" + plug_id + "';"
            dbExec(SQL)
            print "Plug " + plug_id + " is DEAD!!"
        else:
            print "Plug " + plug_id + " is Running..."
        print "=============================================="
        plug_is_dead = True
    except ValueError, e:
        print "Program is crash"
        sys.exit(1)

#
client.loop_stop()
# client.disconnect()
