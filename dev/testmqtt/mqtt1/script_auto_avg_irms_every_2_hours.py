#!/usr/bin/python
import MySQLdb
import json
import sys, time, random
import math
import decimal
import datetime

dbcon = MySQLdb.connect(host="localhost", user="smp", passwd="Once&forall", db="smp")

all_plug_id = ["1", "2", "3", "4"]

today = datetime.datetime.now()
hour = int(today.strftime('%H'))
day = int(today.strftime('%d'))
month = int(today.strftime('%m'))
year = int(today.strftime('%Y'))
print "datetime : "+str(today)
print "Hour : "+str(hour)
print "day : "+str(day)
print "month : "+str(month)
print "year : "+str(year)

# hour = 2
# day = 23
# month = 3
# year = 2017

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

# =============== Calculate Date ===============

lastMonth = month-1
if month == 1 :
    lastMonth = 12

lastDayOfMonth = 0
if lastMonth == 1 or lastMonth == 3 or lastMonth == 5 or lastMonth == 7 or lastMonth == 8 or lastMonth == 10 or lastMonth == 12:
    lastDayOfMonth = 31
elif lastMonth == 4 or lastMonth == 6 or lastMonth == 9 or lastMonth == 11:
    lastDayOfMonth = 30
else:
    if year%4 == 0 :
        if year%100 == 0 :
            if year%400 == 0 :
                lastDayOfMonth = 29
            else:
                lastDayOfMonth = 28
        else:
            lastDayOfMonth = 29
    else:
        lastDayOfMonth = 28

hr_start = hour-2
hr_end = hour
day_start = day
day_end = day
month_start = month
month_end = month
year_start = year
year_end = year

if hour == 0:
    hr_start = 22
    day_start = day-1
    if day == 1 :
        day_start = lastDayOfMonth
        month_start = month-1
        if month == 1 :
            month_start = 12
            year_start = year-1

start = str(year_start)+"-"+str(month_start)+"-"+str(day_start)+" "+str(hr_start)+":00:00"
end = str(year_end)+"-"+str(month_end)+"-"+str(day_end)+" "+str(hr_end)+":00:00"

print "start : "+start
print "  end : "+end

# =============== loop Plug ===============
for index in range(len(all_plug_id)): 
    plug_id = all_plug_id[index]
    print "plug id : "+plug_id

    SQL = "SELECT `plug_num_of_outlets` FROM `SMP_Plug` WHERE `plug_id` = '" + plug_id + "';"
    num_of_outlet = dbRead(SQL)[0][0]

    sumAvgOfPlug = 0.0
    # =============== loop Outlet ===============
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
        
    avgOfPlug = round((sumAvgOfPlug), 3)
    print "Avg Of Plug : "+str(avgOfPlug)

    # ============= Insert to SMP_Summary_Month (Plug) ============= 
    SQL = "INSERT INTO `SMP_Summary_Month`(`sum_month_plug_id`, `sum_month_outlet_number`, `sum_month_time`, `sum_month_current`) VALUES ('" + plug_id + "', 'all', '"+end+"', "+str(avgOfPlug)+");"
    dbExec(SQL)
    # if sumAvgOfPlug > 0:
    #     time.sleep(20)
    print "---------------------------------------------"
