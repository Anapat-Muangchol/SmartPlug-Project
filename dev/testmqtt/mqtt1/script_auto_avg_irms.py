#!/usr/bin/python
import MySQLdb
import json
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

dbcon = MySQLdb.connect(host="localhost", user="smp", passwd="Once&forall", db="smp")

plug_id = "1"

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

SQL = "SELECT `plug_num_of_outlets` FROM `SMP_Plug` WHERE `plug_id` = '" + plug_id + "';"
num_of_outlet = dbRead(SQL)[0][0]

hr = 0
day_start = 1
day_end = 31
month = 2
year = 2017

for x in range(day_start, day_end+1):
    while hr < 24:
        start = str(year)+"-"+str(month)+"-"+str(x)+" "+str(hr)+":00:00"
        end = str(year)+"-"+str(month)+"-"+str(x)+" "+str((hr+2))+":00:00"
        for outlet in range(num_of_outlet): 
            SQL = "SELECT `used_current` FROM `SMP_Used` WHERE `used_plug_id` = '" + plug_id + "' AND `used_outlet_number` = '" + str(outlet) + "' AND `used_time` >= '"+start+"' AND `used_time` < '"+end+"';"
            current = dbRead(SQL)
            sum = 0
            for i in range(1, len(current)+1):
                sum += current[i][0]
            print "avg(outlet:"+str(outlet)+", "+end+") : "+str(round((sum/720.0), 3))
        hr += 2
        time.sleep(5)
        print "---------------------------------------------"
    hr = 0

# for x in range(day_start, day_end+1):
#     print "x : "+str(x)