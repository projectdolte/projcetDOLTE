#! python3
import socket
import sys
#from urllib2 import urlopen
from random import randint

import numpy as np
import scipy.misc
import cv2

from PIL import Image

import subprocess
import os

#
#"""
#Method getIPAddress() gets and returns the server's local and public IP address
#"""
#def getIPAddress():
#    s = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
#    s.connect(("8.8.8.8", 80))
#    return s.getsockname()[0], urlopen('http://ip.42.pl/raw').read()


"""
Method stopServer() is a command method

Stops and closes the server
"""
def stopServer():
    global connection
    print('Stopping server..')
    connection.sendall('Stopping server..')
    connection.close()


"""
Method suh() is a command method

Prints out and returns a random "Haha, suuuuuh dude" type response
"""
def suh():
    randomNum = randint(1,20)

    #if randomNum is  even, add "Haha, " to the beginning of response
    if(randomNum % 2 == 0):
        t1 = 'Haha, s'
    else:
        t1 = 'S'

    t2 = 'h dude'

    #Add the letter 'u' randomNum times to response
    for x in range(0, randomNum):
        t1 = t1 + 'u'
        
    t1 = t1 + t2
    print(t1)
    
    return t1



#Command list, holds all commands and their corresponding methods to be called
cmdList = {
    'suh' : suh,
    'stop' : stopServer
}


"""
Method interpretCmd() interprets a command received by the client
"""
def interpretCmd(cmd):
    return cmdList[cmd]()
    
    
    
    
    
    
def recvall(sock, count):
    buf = b''
    while count:
        newbuf = sock.recv(count)
        if not newbuf: return None
        buf += newbuf
        count -= len(newbuf)
    return buf    
    
    
    
"""
Add current server.py pid to list of pids
"""    
#sp = subprocess.Popen(['python', 'py.exe'])
pid = os.getpid()
file = open('pid2.txt', 'a')
file.write('\n' + str(pid))
file.close()
print('PID is ' + str(pid))
    
    
    
    
wantedfps = 30;
currFrame = 0;

# Create a TCP/IP socket
sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)


#Get local and public IP addresses
#localAddress, ipAddress = getIPAddress()


# Bind the socket to the local address
#server_name = sys.argv[1]
#server_name = localAddress
server_name = ""
server_address = (server_name, 8082)
print('Starting up on %s:%s' % (server_address[0], server_address[1]))
#print('Connect client to %s if client is on another network' % ipAddress)

sock.bind(server_address)
sock.listen(1)

#Server main running loop
while True:
    
    print('Waiting for a connection')
    connection, client_address = sock.accept()
    
    """
    Open image file    
    """
    image = open("frame.jpg", 'rb')
    
    try:
        print('Client connected @: %s:%s' % (client_address[0], client_address[1]))
        
        
        '''
        Add connected client's IP address to the IP log
        '''
        file = open('logfile.txt', 'a')
        file.write(str(client_address[0]) + "\t<== BBB <br>\n")
        file.close
    
    
        while True:

            #Get input command from client
#            inputCommand = connection.recv(128)          
#            print('Received cmd "%s"' % inputCommand)


    
            
            
            
            """
            Receive image as string, use opencv to decode image (since opencv was used to encode the image)
            """            
            try:
                imgLength = recvall(connection, 16)
                imgStringData = recvall(connection, int(imgLength))
                
                imgData = np.fromstring(imgStringData, dtype='uint8')
                
                
                #Use opencv to decode received jpg image
                decimg=cv2.imdecode(imgData,1)      
                
                
                try:
                    """
                    Save received webcam frame
                    """    
                    filename = 'frame.jpg'
                    scipy.misc.imsave(filename, decimg[:,:,::-1])  
#                    currFrame = currFrame + 1;
#                    if(currFrame >= wantedfps):
#                        currFrame = 0;
						
                except:
                    
                    print("Failed to save image from BBB")
                    
            except:
                print("Failed to get image from BBB")
                connection.close()
                break

#
#            """
#            Save received webcam frame
#            """    
#            try:
#                scipy.misc.imsave('frame.jpg', decimg[:,:,::-1])
#                #imgToSave = Image.fromarray(decimg[:,:,::-1])
#                #imgToSave.save("frame.jpg")
#            except:
#                print("Failed to save image")
            
            

            
            

            #If input isn't empty and a defined command, send response to client
#            if inputCommand:
#                #response = interpretCmd(inputCommand)
#                response = "suh"
#                connection.sendall(response)
#            else:
#                break
            

            
    finally:
        image.close()
        connection.close()
        
        
        
        
        
