import urllib
import wget
import socket
import os

url = "http://thearchmage.moe/logfile.txt"

my_ip = urllib.urlopen('http://ip.42.pl/raw').read()

f = urllib.urlopen(url)

line = f.readline()
iframetxt = ""
while line:
    if "<iframe" in line:
        iframetxt = line
    line = f.readline()

urlList = iframetxt.split('\'')
url3 = urlList[1]

filen = wget.download(url3)

log = open("logfile.txt", 'r')

ips = []
for line in log:
    words = line.split()
    ips.append(words[0])

log.close()
os.remove("logfile.txt")
myFile = open("GS_IP.txt", 'w')

for item in reversed(ips):
    if item != my_ip:
        myFile.write(item)
        break
        
myFile.close()



