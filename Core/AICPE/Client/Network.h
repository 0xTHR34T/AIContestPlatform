#ifndef _NETWORK_H
#define _NETWORK_H

namespace network
{
	int initialize();
	void cleanup();
	int initializeConnection();
	int shutdownConnection();
	int receiveMessage(char *out_buffer, unsigned int length);
	int sendMessage(char *message, unsigned int length);
};

#endif