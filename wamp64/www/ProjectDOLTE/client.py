#! python3
import socket
import sys

import cv2
from PIL import Image

import time

import numpy as np

"""
Webcam variables
"""
cameraPort = 0
fps = 30.0
msWaitPerPic = (int) ((1.0 / fps)*1000)
secWaitPerPic = 1.0 / fps

for i in range(0, 3):
    try:
        camera = cv2.VideoCapture(i)
        #camera = cv.CaptureFromCAM(i)
        print("Successfully capturing webcam video on port " + str(i))
        cameraPort = i
        
        camera
        break
    except:
        i = i + 1

def getImage():
    global camera
    returnValue, img = camera.read()
    #img = cv.QueryFrame(camera)
    if(not returnValue):
        print("returnValue = " + str(returnValue))
        sys.exit(1)
        
    return img




#Get current Python version running (2.X or 3.X)
pyVersion = sys.version_info

#Set bool to know if we should use Python 2.X commands or Python 3.X commands
usePyThree = False
if (pyVersion[0] == 3):
    usePyThree = True
    print('Using Python 3')
else:
    print('Using Python 2')


# Create a TCP/IP socket
sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)

# Connect the socket to the port on the server given by the caller
#server_address = (sys.argv[1], 8082)   #connect to an IP given by argument
server_address = ('75.186.40.144', 8082) #connect to a predefined IP
print('Connecting to %s:%s' % (server_address[0], server_address[1]))
sock.connect(server_address)


try:

    print('Connected to %s:%s' % (server_address[0], server_address[1]))    
    
    #Client main running loop
    while True:

        #See if we should use Py2 or Py3 command to get input from user
#        if(usePyThree):
#            input2Send = input('Send command: ')
#        else:
#            input2Send = raw_input('Send command: ')
#            
#        print('Sending "%s"' % input2Send)





        """
        Get image frame from webcam
        """
        frame = getImage()
        
        #Use opencv to encode the frame
        encode_param=[int(cv2.IMWRITE_JPEG_QUALITY),90]
        result, frameimg = cv2.imencode('.jpg', frame, encode_param)

        #Turn frame into numpy array, turn numpy array into string
        npImg = np.array(frameimg)
        framestring = npImg.tostring()


        #Send image as string to the server
        sock.send(str(len(framestring)).ljust(16))
        sock.send(framestring)

    
        """
        Wait until getting another frame
        """
        time.sleep(secWaitPerPic)



#        
#
#        #Method to receive full message if its size is larger than 128 bytes*, *unsure but probably
#        amount_received = 0
#        amount_expected = len(frame)
#    
#        while amount_received < amount_expected:
#            data = sock.recv(128)
#            amount_received += len(data)
#            print('Received "%s"' % data.decode())    
#

        #Check to see if command was 'stop', if yes stop client
#        if(str(input2Send) == 'stop'):
#            print('Stopping server and client..')
#            sock.close()
#            break
    

finally:
    sock.close()
