
#include <iostream>
#include <cctype>
#include <string>
#include <math>

//perform logn formula here = bits = log2(n^m)
// where n = alphabetSize
// and m = length of password
// basically just do log2(combinations)
unsigned int calcBits(unsigned int combinations)
{
  unsigned int bits = log2(combinations);

  return bits;
}

unsigned int calcCombinations(string password)
{
  unsigned int alphabetSize = 0;
  unsigned int length = 0;
  bool FLAGlower = false;
  bool FLAGupper = false;
  bool FLAGnum = false;
  bool FLAGsymbol = false;


  for(length; length < password.size(); length++)
  {
    if(ischar(password[length]))
    {
      if(islower(password[length]))
        FLAGlower = true;
      else if(isupper(password[length]))
        FLAGupper = true;
    }
    else if (isdigit(password[length]))
      FLAGnum = true;
    else if (ispunct(password[length]))
      FLAGsymbol = true;
  }

  if(FLAGnum)
    alphabetSize += 10;

  if(FLAGupper)
    alphabetSize += 26;

  if(FLAGlower)
    alphabetSize += 26;

  if(FLAGsymbol)
    alphabetSize += 32;

  return pow(alphabetSize, length+1);
}


int main()
{
  unsigned int combinations;
  unsigned int bits;
  string password;

  cout << "Please enter the password: ";
  cin >> password;

  combinations = calcCombinations(password);
  bits = calcBits(combinations);

  cout << "There are " << combinations << " combinations" << endl;
  cout << "That is equivalent to a key of " << bits << " bits" << endl;

  return 0;
}
