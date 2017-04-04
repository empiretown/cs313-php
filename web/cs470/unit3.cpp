/***********************************************************************
* Program:
*    Unit 3, ACLs
*    Brother Helfrich, CS470
* Author:
*    Brad Marx
* Summary:
*    This program tracks a collection of student grades
*    Currently, it performs no authentication and furthermore
*    is so trivially hack-able that it is a joke.  Hahaha.  Why
*    is noone laughing?  OK, as you guess, your job is to make
*    this program secure.  Enjoy!
************************************************************************/

#include <iostream>
#include <fstream>
#include <stdlib.h>
#include <vector>
#include <string>
#include <cassert>
using namespace std;

struct Resource
{
   const char *filename;   // where it is located
};

const Resource resources[3] =
{
   { "/home/cs470/unit3/sam.txt" },
   { "/home/cs470/unit3/sue.txt" },
   { "/home/cs470/unit3/sly.txt" }
};

enum SID { PUBLIC, SAM, SUE, SLY, BOB, HANS, NONE, TEACHER, GRADER, STUDENT};

struct UserSID
{
  const char * username;
  const char * password;
  SID sid;
} const USER_SID[] =
{
  { "Bob",  "passwordBob",  BOB  },
  { "Hans", "passwordHans", HANS },
  { "Sam",  "passwordSam",  SAM  },
  { "Sue",  "passwordSue",  SUE  },
  { "Sly",  "passwordSly",  SLY  }
};

struct ACE
{
   // default constructor
   ACE():sid(NONE), read(false), write(false) {}

   // variable provided constructor
   ACE(SID sid, bool read, bool write): sid(sid), read(read), write(write) {}

   SID sid;
   bool read;
   bool write;
};

struct ACL
{
  ACE owner;
  ACE pub;
  ACE student;
  ACE grader;
};


/*****************************************************************
 *****************************************************************
 *                       Student Grade class                     *
 *****************************************************************
 *****************************************************************/
struct Item
{
   float weight;
   float score;
};

struct Node
{
  ACL acl;
  Item item;
};

/***************************************************
 * One instance of a student grade
 ***************************************************/
class StudentGrade
{
public:
   StudentGrade(const Resource & resource, int id);
   ~StudentGrade();
   string getLetterGrade(SID sidRequest); // output letter grade B+
   float  getNumberGrade(SID sidRequest); // integral number grade 88
   void   displayScores(SID sidRequest);  // display scores on screen
   void   editScores(SID sidRequest);     // interactively edit score
   bool   securityCondition(const ACL & aclAsset,
                            const ACE & aceRequest) const;
   void   setScore( int iScore, float score, SID sidRequest);
   float  getScore( int iScore, SID sidRequest);
   void   setWeight(int iScore, float weight, SID sidRequest);
   float  getWeight(int iScore, SID sidRequest);
   string getName() { return name; };
private:
   bool change;
   string name;                    // student's name
   vector < Node > scores;         // list of scores and weightings
   const char * filename;

   void editScore(int, SID);  // edit one score
};

/**********************************************
 * SET SCORE
 **********************************************/
void StudentGrade::setScore( int iScore, float score, SID sidRequest)
{
   assert(iScore >= 0 && iScore < scores.size());
   scores[iScore].item.score = score;
   change = true;
}

/**********************************************
 * GET SCORE
 **********************************************/
float StudentGrade::getScore(int iScore, SID sidRequest)
{
   assert(iScore >= 0 && iScore < scores.size());
   ACE aceRequest(sidRequest, true, false);

   if(securityCondition(scores[iScore].acl, aceRequest))
   {
     return scores[iScore].item.score;
   }
   else{
     return - 1;
   }
}

/****************************************
 * SET WEIGHT
 ****************************************/
void StudentGrade::setWeight(int iScore, float weight, SID sidRequest)
{
   assert(iScore >= 0 && iScore < scores.size());
   if (weight >= 0.0)
   {
      scores[iScore].item.weight = weight;
      change = true;
   }
}

/**********************************************
 * GET WEIGHT
 **********************************************/
float StudentGrade::getWeight(int iScore, SID sidRequest)
{
   assert(iScore >= 0 && iScore < scores.size());
   ACE aceRequest(sidRequest, true, false);

   if(securityCondition(scores[iScore].acl, aceRequest))
   {
     return scores[iScore].item.weight;
   }
   else{
     return - 1;
   }
}

/***********************************************
 * STUDENT GRADE
 * constructor: read the grades from a file
 **********************************************/
StudentGrade::StudentGrade(const Resource & resource, int id) : change(false)
{
   filename = resource.filename;
   assert(filename && *filename);

   // open file
   ifstream fin(filename);
   if (fin.fail())
      return;

   // read name
   getline(fin, name);

   // read scores
   Item item;
   SID sid = (SID)id;

   Node node;
   node.acl.owner   = ACE(BOB, true, true);
   node.acl.pub     = ACE(NONE, false, false);
   node.acl.student = ACE(sid, true, false);
   node.acl.grader  = ACE(HANS, false, true);

   while (fin >> node.item.score >> node.item.weight)
      scores.push_back(node);

   // close up shop
   fin.close();
}

/**************************************************
 * DESTRUCTOR
 * Write the changes to the file if anything changed
 *************************************************/
StudentGrade::~StudentGrade()
{
   assert(filename && *filename);

   if (!change)
      return;

   // open file
   ofstream fout(filename);
   if (fout.fail())
      return;

   // header is the students name
   fout << name << endl;

   // write the data
   for (int iScore = 0; iScore < scores.size(); iScore++)
      fout << scores[iScore].item.score
           << "\t"
           << scores[iScore].item.weight
           << endl;

   // make like a tree
   fout.close();
}

/****************************************
 * Edit only one score.
 ***************************************/
void StudentGrade::editScore(int iScoreEdit, SID sidRequest)
{
   float userInput;  // user inputed weight.

   assert(iScoreEdit >= 0 && iScoreEdit < scores.size());

   //
   // Score
   //

   // get new score
   cout << "Enter grade: ";
   cin  >> userInput;

   // validate
   while (userInput > 100 || userInput < 0)
   {
      cout << "Invalid grade.  Select a number between 0 and 100: ";
      cin  >> userInput;
   }
   setScore(iScoreEdit, userInput, sidRequest);

   //
   // Weight
   //

   // get the weight
   cout << "Enter the weight for the score or (0) for unchanged: ";
   cin >> userInput;

   // validate
   while (userInput > 1.0 || userInput < 0.0)
   {
      cout << "Invalid weight.  Select a number between 0 and 1: ";
      cin  >> userInput;
   }
   if (userInput != 0.0)
      setWeight(iScoreEdit, userInput, sidRequest);

   return;
}


/*********************************************
 * Edit scores until user says he is done
 *******************************************/
void StudentGrade::editScores(SID sidRequest)
{
   // Give the user some feedback
   cout << "Editing the scores of "
        << name
        << endl;

   // display score list
   cout << "Score list\n"
        << "\tScore \tWeight\n";

   for (int iScore = 0; iScore < scores.size(); iScore++)
   {
      cout << "(" << iScore + 1 << ")"
           << "\t";
      float score = getScore(iScore, sidRequest);
      float weight = getWeight(iScore, sidRequest);

      cout << score << "%"
           << "\t"
           << weight;

      cout << endl;
   }
   cout << "(0)\tExit\n";

   // prompt
   bool done = false;
   while (!done)
   {
      // prompt
      int iScoreEdit;
      cout << "Which score would you like to edit (0-"
           << scores.size()
           << "): ";
      cin  >> iScoreEdit;

      // validate score number
      while (iScoreEdit > scores.size() || iScoreEdit < 0)
      {
         cout << "Invalid number.  Select a number between 0 and "
              << scores.size()
              << ": ";
         cin  >> iScoreEdit;
      }

      // from 1 based to 0 based
      iScoreEdit--;

      // edit the score
      if (iScoreEdit != -1)
      {
         // edit score
         editScore(iScoreEdit, sidRequest);

         // continue
         char response;
         cout << "Do you want to edit another score? (Y/N) ";
         cin  >> response;
         done = (response == 'N' || response == 'n');
      }
      else
         done = true;
   }

   return;
}

/************************************************
 * Display scores
 ***********************************************/
void StudentGrade::displayScores(SID sidRequest)
{
   if (scores.size() == 0)
      return;

   // name
   cout << "Student name:\n\t"
        << name
        << endl;

   // grade
   cout << "Grade:\n\t"
        << getNumberGrade(sidRequest) << "%"
        << " : "
        << getLetterGrade(sidRequest)
        << endl;

   // detailed score
   cout << "Detailed score:\n"
        << "\tScore \tWeight\n";
   for (int iScore = 0; iScore < scores.size(); iScore++)
      cout << "\t"
           << getScore(iScore, sidRequest) << "%"
           << "\t"
           << getWeight(iScore, sidRequest)
           << endl;

   // done
   return;
}

/***************************************************
 * Letter Grade include A- and C+
 ***************************************************/
string StudentGrade::getLetterGrade(SID sidRequest)
{
   const char chGrades[] = "FFFFFFDCBAA";
   int nGrade = (int)getNumberGrade(sidRequest);

   // paranioa will destroy ya
   assert(nGrade >= 0.0 && nGrade <= 100.0);

   // Letter grade
   string s;
   s += chGrades[nGrade / 10];

   // and the + and - as necessary
   if (nGrade % 10 >= 7 && nGrade / 10 < 9  && nGrade / 10 > 5)
      s += "+";
   if (nGrade % 10 <= 2 && nGrade / 10 < 10 && nGrade / 10 > 5)
      s += "-";

   return s;
}

/***************************************************
 * Number grade guarenteed to be between 0 - 100
 ***************************************************/
float StudentGrade::getNumberGrade(SID sidRequest)
{
   // add up the scores
   float possible = 0.0;
   float earned   = 0.0;
   for (int iScore = 0; iScore < scores.size(); iScore++)
   {
      earned   += scores[iScore].item.score * scores[iScore].item.weight;
      possible += scores[iScore].item.weight;
   }

   if (possible == 0.0)
      return 0.0;
   else
      return (earned / possible);
}

/****************************************************
 * ADDRESSES :: SECURITY CONDITION
 * Does the entity have access to the asset?
 ****************************************************/
bool StudentGrade :: securityCondition(const ACL & aclAsset,
                                    const ACE & aceRequest) const
{
   // try owner first
   if (aceRequest.sid == aclAsset.owner.sid)
   {
      if (aceRequest.read)
         return aclAsset.owner.read;
      if (aceRequest.write)
         return aclAsset.owner.write;
      assert(false);  // we should never be here!
      return false;
   }

   if (aceRequest.sid == aclAsset.grader.sid)
   {
      if (aceRequest.read)
         return aclAsset.owner.read;
      if (aceRequest.write)
         return aclAsset.owner.write;
      assert(false);  // we should never be here!
      return false;
   }

   if (aceRequest.sid == aclAsset.student.sid)
   {
      if (aceRequest.read)
         return aclAsset.owner.read;
      if (aceRequest.write)
         return aclAsset.owner.write;
      assert(false);  // we should never be here!
      return false;
   }

   // finally try public
   if (aceRequest.read)
      return aclAsset.pub.read;
   if (aceRequest.write)
      return aclAsset.pub.write;
   assert(false);  // we should never be here!
   return false;
}

/*****************************************************************
 *****************************************************************
 *                           INTERFACE                           *
 *****************************************************************
 *****************************************************************/
class Interface
{
public:
   Interface();

   void display(SID sidRequest);
   void interact(SID sidRequest);
private:
   int promptForStudent();
   vector < StudentGrade > students;
};


/*************************************************
 * Prompt the user for which student it to be worked
 * with.  Return -1 for none
 *************************************************/
int Interface::promptForStudent()
{
   int iSelected;

   // prompt
   cout << "Which student's grade would you like to review?\n";
   for (int iStudent = 0; iStudent < students.size(); iStudent++)
      cout << '\t'
           << iStudent + 1
           << ".\t"
           << students[iStudent].getName()
           << endl;
   cout << "\t0.\tNo student, exit\n";
   cout << "> ";

   // get input
   cin >> iSelected;
   while (iSelected < 0 || iSelected > students.size())
   {
      cout << "Invalid selection.  Please select a number between 1 and "
           << students.size()
           << " or select -1 to exit\n";
      cout << ">";
      cin >> iSelected;
   }

   return --iSelected;
}

/***********************************************
 * update the student records interactively
 ***********************************************/
void Interface::interact(SID sidRequest)
{
   int iSelected;

   if(sidRequest == BOB || sidRequest == HANS)
   {
     while (-1 != (iSelected = promptForStudent()))
     {
       // edit grades as necessary
       students[iSelected].editScores(sidRequest);

       // show the results
       students[iSelected].displayScores(sidRequest);

       // visual separater
       cout << "---------------------------------------------------\n";
     }
   }
   else
   {
      students[sidRequest - 1].displayScores(sidRequest);
   }

   return;
}

/*****************************************************
 * CONSTRUCTOR
 * Populate the grades list from a file
 ****************************************************/
Interface::Interface()
{
   for (int i = 0; i < sizeof(resources) / sizeof(Resource); i++)
   {
      StudentGrade student(resources[i], i+1);
      students.push_back(student);
   }
}

/**************************************************
 * DISPLAY
 * Display stuff
 *************************************************/
void Interface::display(SID sidRequest)
{
   for (int i = 0; i < students.size(); i++)
      students[i].displayScores(sidRequest);
}

/**************************************************************
 * USER
 * All the users currently in the system
 *************************************************************/
struct User
{
   const char *name;
   const char *password;
}
const users[] =
{
   { "Bob",  "passwordBob" },
   { "Hans", "passwordHans" },
   { "Sam",  "passwordSam" },
   { "Sue",  "passwordSue" },
   { "Sly",  "passwordSly" }
};

//#define ID_INVALID -1

/**********************************************
 * authenticate the user
 *********************************************/
SID authenticate()
{
   // prompt for username
   string name;
   cout << "Username: ";
   cin  >> name;

   // prompt for password
   string password;
   cout << "Password: ";
   cin  >> password;

   // search for username. If found, verify password
   for (int i = 0; i < sizeof(USER_SID) / sizeof(USER_SID[0]); i++)
      if (name     == string(USER_SID[i].username    ) &&
          password == string(USER_SID[i].password))
         return USER_SID[i].sid;
/*
   // search for username. If found, verify password
   for (int idUser = 0; idUser < sizeof(users) / sizeof(users[0]); idUser++)
      if (name     == string(users[idUser].name    ) &&
          password == string(users[idUser].password))
         return idUser;
*/

   // display error
   cout << "Failed to authenticate " << name << endl;
   return NONE;
}

/*********************************************
 * Main:
 *  open files
 *  edit scores
 *  save files
 ********************************************/
int main()
{
   SID userSID = authenticate();

   Interface interface;

   interface.interact(userSID);

   return 0;
}
