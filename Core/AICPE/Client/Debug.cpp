#include "Debug.h"

#include <cstdlib>
#include <iostream>
#include <fstream>
#include <list>
#include <time.h>

namespace debug
{
	static std::string logFileAddress = "log.txt";
	std::list<std::string> messageList;

	void clearLogFile()
	{
		std::fstream file;
		file.open(logFileAddress.c_str(), std::ios::out);
		if (file.bad())
		{
			return;
		}
		file.close();
	}
	const std::string &getLogFileAddress()
	{
		return logFileAddress;
	}
	void setLogFileAddress(const std::string &address)
	{
		logFileAddress = address;
	}
	void throwMessage(const std::string &message)
	{
		std::cout << message << "\n";
		std::string outputMessage = "	Message : " + message;
		messageList.push_back(outputMessage);
	}
	void throwError(const std::string &message)
	{
		std::cout << "Error : " << message << "\n";
		std::string errorMessage = "	Error : " + message;
		messageList.push_back(errorMessage);
		flushLog();
		exit(1);
	}
	void flushLog()
	{
		std::fstream file;
		file.open(logFileAddress.c_str(), std::ios::out | std::ios::app | std::ios::ate);
		if (file.bad())
		{
			return;
		}
		if (int(file.tellg()) != 0)
		{
			file.write("\n\n", 2);
		}
#ifdef WIN32
		time_t currentTimeMilliseconds = time(0);
		tm currentTime;
		localtime_s(&currentTime, &currentTimeMilliseconds);
		char timeStringBuffer[128];
		asctime_s(timeStringBuffer, &currentTime);
		std::string timeString = "Time : " + std::string(timeStringBuffer);
		file.write(timeString.c_str(), timeString.length() - 1);
#endif
		for (auto listIterator = messageList.begin(); listIterator != messageList.end(); ++listIterator)
		{
			file.write("\n", 1);
			file.write(listIterator->c_str(), listIterator->length());
		}
		file.close();
	}
}