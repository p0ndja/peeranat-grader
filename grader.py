import mysql.connector
import time
from os import path
from Garedami.Src import Judge
import requests


dbconnector = mysql.connector.connect(
    host='localhost',
    user='graderga',
    password='8db!#yYvK]8Lw6F|37wz:UwU',
    database='graderga'
)

def getTimeAndMem(idTask):
    response = requests.get(f"http://grader.ga/api/problem?id={idTask}")
    if response.status_code != 200:
        return -69,-420
    data = response.json()[0]
    return data["time"],data["memory"]


if __name__ == '__main__':
    print("Grader.py started")
    while(1):
        mycursor = dbconnector.cursor(buffered=True)
        mycursor.execute("SELECT `id`,`user`,`problem`,`lang`,`script` FROM `submission` WHERE result = 'W'") #Get specific data from submission SQL where result is W (Wait)
        myresult = mycursor.fetchone() #fetchone() -> fetch 1 data matched, fetchall() -> fetch all data matched
        if (myresult != None): #While there's any match
            webLocation = "/" + path.join("var","www","grader.ga")
            #Get data from query
            subID = myresult[0] #id is the 1st.
            userID = myresult[1] #user is the 2nd.
            probID = str(myresult[2]) #problem is the 3rd.
            lang = myresult[3] #lang is the 4th.
            userCodeLocation = myresult[4].replace("..",webLocation) #script location is the 5th.
            #userCodeLocation in format "../file/judge/upload/<User ID>/<Codename>-<EPOCH>.<lang>", real location need change "../" to webLocation
            #Full path: /var/www/grader.ga/file/judge/upload/<User ID>/<Codename>-<EPOCH>.<lang>

            print(f"----------<OwO>----------\nFound Waiting Judge on queue: submission={subID}, problem={probID}, user={userID}")

            probTestcaseLocation = path.join(webLocation,"file","judge","prob",probID)
            #print(probTestcaseLocation)
            #All testcases will be here

            srcCode = ""

            with open(userCodeLocation,"r") as f:
                srcCode = f.read()

            probTime,probMem = getTimeAndMem(probID)

            if probTime < 0:
                judgeResult = ("WebError",0,100,0,0,"Web API Down")
            else:
                judgeResult = Judge.judge(probID,lang,probTestcaseLocation,srcCode)

            #Result from judge
            result = judgeResult[0]
            score = int(judgeResult[1])
            maxScore = int(judgeResult[2])
            runningTime = int(judgeResult[3]) #ms
            memory = int(judgeResult[4]) #MB
            comment = judgeResult[5]

            #Update to SQL
            query = ("UPDATE `submission` SET `result` = %s,`score` = %s,`maxScore` = %s,`runningTime` = %s,`memory` = %s,`comment` = %s WHERE `id` = %s")
            data = (result, score, maxScore, runningTime, memory, comment, subID) #Don't forget to add subID
            mycursor.execute(query, data)
            print(f"Finished Judge submission={subID}, problem={probID}, user={userID} --> {result}")

            #Make sure that query is done.
            dbconnector.commit()
        dbconnector.commit()
        #Time sleep interval for 2 second.
        time.sleep(1)
