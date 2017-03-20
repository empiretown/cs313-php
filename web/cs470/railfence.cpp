

//pseudo code:

// ilovebananas = IALBNSOEAAVN
// KEY = 4

int KEY = input;
int lowerBound = 0;
int column = 0;
int lastInsert = 0;
bool ascending = true;

while lastInsert < lengthof(source)
{
   for i < lengthof(source);
   {
      if column == lowerBound;
         array[column][i] = source[lastInsert];
         lastInsert++;
      if(ascending)
         column++;
      else
         column--;

     if column == KEY
        ascending = FALSE;
     else if column == 0
        ascending = TRUE;
   }
   lowerBound++;
}


//////////////////  COPY

//ENCRYPT CAESAR CIPHER

str =  "Encryption:\n";
str += "FOR each letter i in source\n";
str += "   IF character is in alphabet\n";
str += "      IF character is in bottom half of alphabet [A-M|a-m]\n";
str += "         character = character + 3\n";
str += "      ELSE /* character is in top half [N-Z|n-z] */\n";
str += "         character = character – 3\n";
str += "RETURN\n\n";



for (char * p = source; *p; p++)
{
  if(isalpha(*p))
  {
    if((*p >= 'A' && *p <= 'M') || (*p >= 'a' && *p <= 'm'))
    {
        *p += 3;
    }
    else
    {
        *p -= 3;
    }
  }
}
