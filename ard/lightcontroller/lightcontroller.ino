#include <ESP8266WiFi.h>
//#include <ESP8266WiFiMulti.h>
//#include <ESP8266HTTPClient.h>
//#include <WiFiClient.h>
#include "LittleFS.h"
#include <Wire.h>

const char* ssid="eshen_2";   //Put your wifi network name here
const char* password = "11223344";   //Put your wifi password here

IPAddress local_ip(192,168,254,130);
IPAddress subnet(255,255,255,0);
IPAddress gateway(192,168,254,254);
IPAddress primaryDNS(8,8,8,8); //optional
IPAddress secondaryDNS(8,8,4,4); //optional

IPAddress canconnect(192,168,254,10);

WiFiServer server(80);


int printMe = 0;

//void readData();
// writeData(String data);
//void deleteData();

#define RELAY1 0
//declare GPI00



void setup() {

  pinMode(RELAY1, OUTPUT); //declare GPI00
  digitalWrite(RELAY1, LOW);
  Serial.begin(9600);      //initial Serial communication for serial monitor  Note:115200 depends on your board  
  Serial.println(); 
  Serial.print("Wifi connecting to "); 
  Serial.println( ssid );
  
  WiFi.begin(ssid,password);  
  Serial.println();  
  server.begin();
  Serial.println("Server started");

  //configure static IP
  if(!WiFi.config(local_ip, gateway, subnet, primaryDNS, secondaryDNS)){
    Serial.println("STA failed to configure");
  }
  
  Serial.print("Connecting");
  
  while( WiFi.status() != WL_CONNECTED ){  
    //while loop runs repeatedly unless condition is false
    //it'll keep trying unless wifi is connected      
    delay(500);      
    Serial.print(".");          
  }
  //Serial.println();
  Serial.println("Wifi Connected Success!");  
  Serial.print("NodeMCU IP Address : ");   //Shows the IP (Internet Protocol) number of your NodeMcu 
  Serial.println(WiFi.localIP());         //Gets the IP address of your Board  
  delay(500);

  if(!LittleFS.begin()){
    Serial.println("An Error has occurred while mounting LittleFS");
    return;
  }
  Serial.println("LittleFS begin...");
}

void loop() {
  
  if(printMe == 0){
    Serial.print("Loop started");
    printMe = 1;
  }

  Serial.println(Serial.readString());
  
  WiFiClient client = server.available();
  if (!client) 
  {
    return;
  }


  // Wait until the client sends some data
  Serial.println("new client");
  while(!client.available())
  {
    delay(1);
  }

  // Read the first line of the request
  String request = client.readStringUntil('\r');
  //Serial.println(request);
  //Serial.println(client.remoteIP());
  client.flush();


  if(client.remoteIP() != canconnect){
    Serial.println("Connection denied.");
    client.print("Connection denied");
    return;
  }

  // Match the request
  int value = LOW;
  
  if (request.indexOf("/fb544adc0adbe717a06e6e1391afcd03") != -1)  
  {
    //turn off relay
    digitalWrite(RELAY1,HIGH);
    value = HIGH;
  }
  
  if (request.indexOf("/d1894f44e4c99eb258b3a3683c52f40e") != -1)  
  {
    //turn on relay
    digitalWrite(RELAY1,LOW);
    value = LOW;
  }

//  if (request.indexOf("/WRITE") != -1)  
//  {
//    //turn on relay
//    Serial.println("WRITE Data");
//    //writeData("fb544adc0adbe717a06e6e1391afcd03");
//    writeData("abc");
//  }
//
//  if (request.indexOf("/DELETE") != -1)  
//  {
//    //turn on relay
//    Serial.println("DELETE Data");
//    deleteData();
//  }
//
//  if (request.indexOf("/READ") != -1)  
//  {
//    
//    //turn on relay
//    Serial.println("Read Data");
//    //readData();
//  }



  // Return the response
  client.println("HTTP/1.1 200 OK");
  client.println("Content-Type: text/html");
  client.println("Access-Control-Allow-Origin: *");
  
  client.println(""); //  this is a must
//  client.println("<!DOCTYPE HTML>");
//  client.println("<html>");
//  client.println("<head><title>ESP8266 RELAY Control</title></head>");
  //  client.print("Relay is now: ");
  
  //client.print(value);
//  if(value == HIGH) 
//  {
//    client.print("ON");
//  } 
//  else 
//  {
//    client.print("OFF");
//  }

  if(digitalRead(RELAY1) == HIGH) 
  {
    client.print("ON");
  } 
  else 
  {
    client.print("OFF");
  }

//  File file = LittleFS.open("/tokenfile.txt", "r");
//  //Check if the file exists
//  if(!file){
//    Serial.println("No Saved Data!"); 
//    return;
//  }
//  
//  while(file.available()){
//    Serial.println(file.read());
//    client.println(file.read());
//  }
//  
//  file.close();

  
//  client.println("<br><br>");
//  client.println("Turn <a href=\"/RELAY=OFF\">OFF</a> RELAY<br>");
//  client.println("Turn <a href=\"/RELAY=ON\">ON</a> RELAY<br>");
//  client.println("</html>");
 
  delay(1);
  Serial.println("Client disonnected");
  Serial.println("");

  
}




void readData(){
  //Open the file
  File file = LittleFS.open("/tokenfile.txt", "r");
  //Check if the file exists
  if(!file){
    Serial.println("No Saved Data!"); 
    return;
  }
  
  while(file.available()){
    Serial.println(file.read());
  }
  
  file.close();
}

void writeData(String data){
  //Open the file 
  File file = LittleFS.open("/tokenfile.txt", "w");
  //Write to the file
  file.print(data);
  file.close();
  delay(1); 
  Serial.println("Write successful");
  file.close();
}

void deleteData(){
   //Remove the file
   LittleFS.remove("/tokenfile.txt"); 
   Serial.println("Data Deleted"); 
}