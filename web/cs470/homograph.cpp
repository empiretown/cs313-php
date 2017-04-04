/***********************************************************************
* Program:
*    Week13, Homographs
*    Brother Helfrich, CS470
* Author:
*    Brad Marx
* Summary:
*
*
*
************************************************************************/

#include <iostream>
#include <stdlib.h>
#include <ctype.h>
#include <string>
#include <deque>
using namespace std;

/***********************
* Get User Input
***********************/
void getUsersInput(string &one, string &two)
{
   //Prompt
   cout << "Specify the first filename:  ";
   cin >> one;
   cout << "Specify the second filename: ";
   cin >> two;
}

/****************************
* Render
***************************/
void render(string &givenStr)
{
   deque<string> canonizedStr;
   string temp;
   //Parse through the string
   for(int i = 0; givenStr[i]; i++)
   {
       switch(givenStr[i])
       {
            case '.':
               if(givenStr[i + 1] == '.')
               {
                  if (!canonizedStr.empty())
                  {
                    canonizedStr.pop_back();
                    i++;
                  }
               }
               break;
            case '/':
               break;

               //The  '/~'
            case '~': //cout << givenStr[i] << endl;
               break;

            default:
              string tmp;
              while(givenStr[i] != '/' && givenStr[i])
              {
                tmp += givenStr[i];
                i++;
              }
              canonizedStr.push_back(tmp);
              break;
       }
    }

   while (!canonizedStr.empty())
   {
     temp += canonizedStr.front();
     canonizedStr.pop_front();
   }
   // set the value of the new string
   givenStr = temp;
}

/****************************
* Observer Comparitor
***************************/
void observer(string renderOne, string renderTwo)
{
   //bool isHomograph = false;


   if(one == two)
   {
      cout << "The files are homographs" << endl;
   }
   else
   {
      cout << "The files are NOT homographs" << endl;
   }

  // return isHomograph;
}

/*************************
* Canonicalize
************************/
void canonicalize(string &one, string &two)
{
   render(one);
   render(two);

   observer(one, two);
}

/**********************************************************************
* MAIN
***********************************************************************/
int main()
{
   //Variables
   string filenameOne;
   string filenameTwo;

   //Get the strings!!
   getUsersInput(filenameOne, filenameTwo);

   //Canonicalize
   canonicalize(filenameOne, filenameTwo))

   return 0;
}
