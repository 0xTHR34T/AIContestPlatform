#!/usr/bin/python

import sys
import thread
import threading
import os
import time
#from multiprocessing import Process

class ClientHandler(object):
	def __init__(self):
		if len(sys.argv) < 2:
			sys.exit("Args??\n")
		if (sys.argv[1] == None) or (int(sys.argv[1])*2+2 != len(sys.argv)):
			sys.exit("Assertion failure.\n")
			
	def shellExec(self, agent):
		os.system("./%s" % (agent))
		
		
CH = ClientHandler()
engineArgs = ""
i = 1

while i <= int(sys.argv[1]):
	engineArgs += sys.argv[i+1] + " "
	i += 1

thread.start_new_thread ( CH.shellExec, ("engine.o %s %s" % (sys.argv[1], engineArgs),) )
print "INFO: Starting engine...\n"
time.sleep(1)

i += 1

while i < len(sys.argv):
	thread.start_new_thread ( CH.shellExec, (sys.argv[i],) )
	print "INFO: Starting " + sys.argv[i] + "\n"
	time.sleep(1)
	i += 1
	
while 1:
	if (threading.activeCount() < 2):
		break
		
sys.exit("INFO: Done.\n")
