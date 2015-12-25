#ifndef _DEBUG_H
#define _DEBUG_H

#include <string>

namespace debug
{
	void clearLogFile();
	const std::string &getLogFileAddress();
	void setLogFileAddress(const std::string &address);
	void throwMessage(const std::string &message);
	void throwError(const std::string &message);
	void flushLog();
}

#if ((defined _DEBUG) && (!defined _NDEBUG))
	#define ASSERT(expression) (void)((expression) || \
	(debug::throwError("Assertion failed : \"" + std::string(#expression) + "\", file \"" + std::string(__FILE__) + "\", line " + std::to_string((unsigned int)(__LINE__))), 0))
#else
	#define ASSERT(expression) 0
#endif

#endif