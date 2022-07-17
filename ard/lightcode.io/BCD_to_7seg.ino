void setup() {
  // put your setup code here, to run once:
pinMode(0,OUTPUT);
pinMode(1,OUTPUT);
pinMode(2,OUTPUT);
pinMode(3,OUTPUT);
pinMode(4,OUTPUT);
pinMode(5,OUTPUT);
pinMode(6,OUTPUT);
pinMode(8,INPUT);
pinMode(9,INPUT);
pinMode(10,INPUT);
pinMode(11,INPUT);
}

void loop() {
int a,b,c,d,e,f,g;
int w,x,y,z;
w=digitalRead(11);
x=digitalRead(10);
y=digitalRead(9);
z=digitalRead(8);

// based on the powerpoint slide... 
//a = w’x’y’z’ + w’x’yz’ + w’x’yz + w’xy’z + w’xyz’ + w’xyz + wx’y’z’ + wx’y’z
// change ' to ! ex w' is now !w  
// use the & for the AND operation
// use the | for the OR operation


a=!w&!x&!y&!z | !w&!x&y&!z | !w&!x&y&z | !w&x&!y&z | !w&x&y&!z | !w&x&y&z | w&!x&!y&!z | w&!x&!y&z;
b=!w&!x&!y&!z | !w&!x&!y&z | !w&!x&y&!z | !w&!x&y&z | !w&x&!y&!z | !w&x&y&z | w&!x&!y&!z | w&!x&!y&z;

// finish the algebraic equation for c to g below
c=0;
d=0;
e=0;
f=0;
g=0;


digitalWrite(0,a);
digitalWrite(1,b);
digitalWrite(2,c);
digitalWrite(3,d);
digitalWrite(4,e);
digitalWrite(5,f);
digitalWrite(6,g);



  
  

}
