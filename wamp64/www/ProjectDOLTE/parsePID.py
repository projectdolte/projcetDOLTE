# -*- coding: utf-8 -*-
"""
Created on Sat Apr  1 15:44:48 2017

@author: Josh
"""

import numpy as np

#Open pid.txt
lines = np.loadtxt("pid.txt", dtype=np.string_, delimiter=",", unpack=False)

linesList = []
for line in lines:
    linesList.append(line.decode('utf-8'))

pidString = linesList[1]
pidString = pidString[1:len(pidString)-1]   #Delete beginning " and ending "

#Save pid
file = open('pid2.txt', 'w')
file.write(pidString)
file.close()

