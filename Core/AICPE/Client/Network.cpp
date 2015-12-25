#include "Network.h"

#ifdef WIN32
	#ifndef WIN32_LEAN_AND_MEAN
		#define WIN32_LEAN_AND_MEAN
	#endif

	#include <Windows.h>
	#include <WinSock2.h>
	#include <WS2tcpip.h>
	#include <IPHlpApi.h>
	#pragma comment(lib, "WS2_32.lib")
#else
	#include <sys/types.h>
	#include <netinet/in.h>
	#include <sys/socket.h>
	#include <netdb.h>
	#include <sys/ioctl.h>
	#include <unistd.h> 
	#include <stdlib.h> 
	#include <errno.h> 
	#include <cstring>

	typedef int SOCKET;
	#define INVALID_SOCKET -1
	#define SOCKET_ERROR -1
	#define closesocket close
	#define ioctlsocket ioctl
	#define WSAEWOULDBLOCK EWOULDBLOCK
#endif

#include "Debug.h"

namespace network
{
	const char *DEFAULT_PORT = "1300";
	const int DEFAULT_BUFFER_LENGTH = 1024;
	SOCKET connectSocket;
	addrinfo *resultAddressInfo = 0, *pointer = 0, hints;

	int getLastError();

	int initialize()
	{
#ifdef _WIN32
		WSADATA wsaData;
		int result = WSAStartup(MAKEWORD(2, 2), &wsaData);
		if (result != 0)
		{
			debug::throwError("(Network) WinSock 2.2 startup failed : " + std::to_string(result));
			return 1;
		}
		else
		{
			debug::throwMessage("(Network) WinSock 2.2 startup successful");
		}
#else
		debug::throwMessage("Network system initialized");
#endif
		return 0;
	}
	void cleanup()
	{
#ifdef _WIN32
		WSACleanup();
#endif
	}
	int initializeConnection()
	{
		memset(&hints, 0, sizeof(addrinfo));
		hints.ai_family = AF_UNSPEC;
		hints.ai_socktype = SOCK_STREAM;
		hints.ai_protocol = IPPROTO_TCP;
		int result = getaddrinfo("127.0.0.1", DEFAULT_PORT, &hints, &resultAddressInfo);
		if (result != 0)
		{
			cleanup();
			debug::throwError("(Network) getaddrinfo failed : " + std::to_string(result));
			return 1;
		}
		connectSocket = INVALID_SOCKET;
		for (pointer = resultAddressInfo; pointer != 0; pointer = pointer->ai_next)
		{
			connectSocket = socket(pointer->ai_family, pointer->ai_socktype, pointer->ai_protocol);
			if (connectSocket == INVALID_SOCKET)
			{
				debug::throwError("(Network) Error at socket creation : " + std::to_string(getLastError()));
				return 1;
			}
			result = connect(connectSocket, pointer->ai_addr, (int)pointer->ai_addrlen);
			if (result == SOCKET_ERROR)
			{
				debug::throwMessage("(Network) Error at socket connection : " + std::to_string(getLastError()));
				closesocket(connectSocket);
				connectSocket = INVALID_SOCKET;
				continue;
			}
			else
			{
				debug::throwMessage("(Network) connect call successful");
				break;
			}
		}
		debug::throwMessage("(Network) Connection established");
		freeaddrinfo(resultAddressInfo);
		if (connectSocket == INVALID_SOCKET)
		{
			cleanup();
			debug::throwError("(Network) Unable to connect to the server");
			return 1;
		}
		return 0;
	}
	int shutdownConnection()
	{
#ifndef WIN32
		const int SD_BOTH = SHUT_RDWR;
#endif
		int result = shutdown(connectSocket, SD_BOTH);
		if (result == SOCKET_ERROR)
		{
			debug::throwError("(Network) Socket shutdown failed : " + std::to_string(getLastError()));
			closesocket(connectSocket);
			cleanup();
			return 1;
		}
		return 0;
	}
	int receiveMessage(char *out_buffer, unsigned int length)
	{
		ASSERT(out_buffer != 0);
		int result = recv(connectSocket, out_buffer, length, 0);
		if (result > 0)
		{
			out_buffer[result] = '\0';
		}
		else if (result == 0)
		{
			debug::throwMessage("Connection closing");
		}
		else
		{
			debug::throwError("recv failed : " + std::to_string(getLastError()));
			return 1;
		}
		return 0;
	}
	int sendMessage(char *message, unsigned int length)
	{
		ASSERT(message != 0);
		ASSERT(length != 0);
		int result = send(connectSocket, message, length, 0);
		if (result == SOCKET_ERROR)
		{
			debug::throwError("Failed to send message : " + std::to_string(getLastError()));
			closesocket(connectSocket);
			cleanup();
			return 1;
		}
		return 0;
	}
	int getLastError()
	{
#ifdef WIN32
		return WSAGetLastError();
#else
		return 0;
#endif
	}
}