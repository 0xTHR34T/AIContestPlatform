#include <cstring>
#include <time.h>

#include "Network.h"
#include "Debug.h"

#include <thread>

int clientIndex = -1;

enum FieldCell : char
{
	FIELD_CELL_EMPTY = -1,
	FIELD_CELL_WALL = -2,
	FIELD_CELL_SEED = -3
};
enum SnakeDirection : unsigned int
{
	SNAKE_DIRECTION_LEFT = 0,
	SNAKE_DIRECTION_RIGHT = 1,
	SNAKE_DIRECTION_UP = 2,
	SNAKE_DIRECTION_DOWN = 3
};
struct Point
{
	int x, y;
};
const unsigned int FIELD_WIDTH = 40;
char field[FIELD_WIDTH][FIELD_WIDTH];
Point headPosition;
unsigned int command = SNAKE_DIRECTION_UP;
int gameCounter = 0;
void createField(char *gameStateString);
void determineCommand();
bool isCellObstacle(unsigned int x, unsigned int y);
unsigned int findEmptyCell();
int findSeed();

int main(int argc, char *argv[])
{
	srand((unsigned int)(time(0)));
	debug::setLogFileAddress("Player0 Log.txt");
	network::initializeConnection();
	network::sendMessage("0", 1);
	char clientIndexString[8];
	network::receiveMessage(clientIndexString, 8);
	clientIndex = atoi(clientIndexString);
	debug::throwMessage("Client index is " + std::to_string(clientIndex));
	bool gameEnded = 0;
	while (!gameEnded)
	{
		debug::throwMessage("Turn " + std::to_string(gameCounter));
		char gameStateString[2048];
		debug::throwMessage("to receive...");
		int result = network::receiveMessage(gameStateString, 2048);
		if (strcmp(gameStateString, "End") == 0)
		{
			gameEnded = 1;
			break;
		}
		createField(gameStateString);
		determineCommand();
		std::string commandString = std::to_string(command);
		network::sendMessage((char *)(commandString.c_str()), commandString.length());
		gameCounter++;
		if (rand() % 10 == 0)
		{
			//std::this_thread::sleep_for(std::chrono::milliseconds(400));
		}
	}
	debug::flushLog();
	return 0;
}
void createField(char *gameStateString)
{
	ASSERT(gameStateString != 0);
	ASSERT(strlen(gameStateString) != 0);
	for (unsigned int i = 0; i < FIELD_WIDTH; ++i)
	{
		for (unsigned int j = 0; j < FIELD_WIDTH; ++j)
		{
			field[i][j] = gameStateString[i * FIELD_WIDTH + j];
			if (field[i][j] == 64 + clientIndex)
			{
				headPosition.x = j;
				headPosition.y = i;
			}
		}
	}
}
void determineCommand()
{
	if (rand() % 100 == 0)
	{
		command = rand() % 4;
	}
	Point movementVector;
	switch (command)
	{
	case SNAKE_DIRECTION_LEFT:
		movementVector.x = -1;
		movementVector.y = 0;
		break;
	case SNAKE_DIRECTION_RIGHT:
		movementVector.x = 1;
		movementVector.y = 0;
		break;
	case SNAKE_DIRECTION_UP:
		movementVector.x = 0;
		movementVector.y = -1;
		break;
	case SNAKE_DIRECTION_DOWN:
		movementVector.x = 0;
		movementVector.y = 1;
		break;
	}
	if (findSeed() != -1)
	{
		command = findSeed();
	}
	else if (isCellObstacle(headPosition.x + movementVector.x, headPosition.y + movementVector.y))
	{
		command = findEmptyCell();
	}
}
bool isCellObstacle(unsigned int x, unsigned int y)
{
	return (field[y][x] != FIELD_CELL_EMPTY && field[y][x] != FIELD_CELL_SEED);
}
unsigned int findEmptyCell()
{
	unsigned int choiceCount = 0;
	unsigned int choiceList[4];
	if (!isCellObstacle(headPosition.x, headPosition.y - 1))
	{
		choiceList[choiceCount] = SNAKE_DIRECTION_UP;
		choiceCount++;
	}
	if (!isCellObstacle(headPosition.x, headPosition.y + 1))
	{
		choiceList[choiceCount] = SNAKE_DIRECTION_DOWN;
		choiceCount++;
	}
	if (!isCellObstacle(headPosition.x - 1, headPosition.y))
	{
		choiceList[choiceCount] = SNAKE_DIRECTION_LEFT;
		choiceCount++;
	}
	if (!isCellObstacle(headPosition.x + 1, headPosition.y))
	{
		choiceList[choiceCount] = SNAKE_DIRECTION_RIGHT;
		choiceCount++;
	}

	if (choiceCount == 0)
	{
		return SNAKE_DIRECTION_RIGHT;
	}
	else
	{
		unsigned int choiceIndex = rand() % choiceCount;
		return choiceList[choiceIndex];
	}
}
int findSeed()
{
	if (field[headPosition.y - 1][headPosition.x] == FIELD_CELL_SEED)
	{
		return SNAKE_DIRECTION_UP;
	}
	else if (field[headPosition.y + 1][headPosition.x] == FIELD_CELL_SEED)
	{
		return SNAKE_DIRECTION_DOWN;
	}
	else if (field[headPosition.y][headPosition.x - 1] == FIELD_CELL_SEED)
	{
		return SNAKE_DIRECTION_LEFT;
	}
	else if (field[headPosition.y][headPosition.x + 1] == FIELD_CELL_SEED)
	{
		return SNAKE_DIRECTION_RIGHT;
	}
	else
	{
		return -1;
	}
}