#!/usr/bin/python
import MySQLdb
import json
import sys, time, random
import math
import decimal

dbcon = MySQLdb.connect(host="localhost", user="smp", passwd="Once&forall", db="smp")

#----- 1. change plug_id -----
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

#----- 2. change year, month and day_end -----
hr = 0
day_start = 1
day_end = 31
month = 3
year = 2017

for day in range(day_start, day_end+1):
    while hr <= 22:
        start = ""
        end = ""
        if hr == 22 :
            start = str(year)+"-"+str(month)+"-"+str(day)+" "+str(hr)+":00:00"
            end = str(year)+"-"+str(month)+"-"+str(day+1)+" 00:00:00"
            # if day == day_end :
            #     end = str(year)+"-"+str(month+1)+"-01 00:00:00"
        else :
            start = str(year)+"-"+str(month)+"-"+str(day)+" "+str(hr)+":00:00"
            end = str(year)+"-"+str(month)+"-"+str(day)+" "+str((hr+2))+":00:00"
        
        sumAvgOfPlug = 0.0
        for outlet in range(1, num_of_outlet+1): 
            SQL = "SELECT `used_current` FROM `SMP_Used` WHERE `used_plug_id` = '" + plug_id + "' AND `used_outlet_number` = '" + str(outlet) + "' AND `used_time` >= '"+start+"' AND `used_time` < '"+end+"';"
            current = dbRead(SQL)
            sum = 0
            strTemp = ""
            print "length : "+str(len(current))
            for i in range(len(current)):
                sum += current[i][0]
                strTemp += str(current[i][0])+", "
            print "current : "+strTemp
            print "sum : "+str(sum)
            avg = round((float(sum)/720.0), 3)
            print "avg(outlet:"+str(outlet)+", "+end+") : "+str(avg)
            sumAvgOfPlug += avg
            
            # ============= Insert to SMP_Summary_Month (Outlet) ============= 
            SQL = "INSERT INTO `SMP_Summary_Month`(`sum_month_plug_id`, `sum_month_outlet_number`, `sum_month_time`, `sum_month_current`) VALUES ('" + plug_id + "', '" + str(outlet) + "', '"+end+"', "+str(avg)+");"
            dbExec(SQL)
        
        avgOfPlug = round((sumAvgOfPlug/num_of_outlet), 3)
        print "Avg Of Plug : "+str(avgOfPlug)

        # ============= Insert to SMP_Summary_Month (Plug) ============= 
        SQL = "INSERT INTO `SMP_Summary_Month`(`sum_month_plug_id`, `sum_month_outlet_number`, `sum_month_time`, `sum_month_current`) VALUES ('" + plug_id + "', 'all', '"+end+"', "+str(avgOfPlug)+");"
        dbExec(SQL)
        # if sumAvgOfPlug > 0:
        #     time.sleep(20)
        hr += 2
        print "---------------------------------------------"
    hr = 0

# for x in range(day_start, day_end+1):
#     print "x : "+str(x)