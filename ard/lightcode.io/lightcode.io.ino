#include <ESP8266WiFi.h>
//#include <ESP8266WiFiMulti.h>
//#include <ESP8266HTTPClient.h>
//#include <WiFiClient.h>


const char* ssid="annateah";   //Put your wifi network name here
const char* password = "11223344";   //Put your wifi password here

IPAddress local_ip(192,168,0,51);
IPAddress subnet(255,255,255,0);
IPAddress gateway(192,168,0,1);
IPAddress primaryDNS(8,8,8,8); //optional
IPAddress secondaryDNS(8,8,8,8); //optional

WiFiServer server(80);


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
  while( WiFi.status() != WL_CONNECTED )  //while loop runs repeatedly unless condition is false  {                                       //it'll keep trying unless wifi is connected      delay(500);      Serial.print(".");          }
    Serial.println();
    Serial.println("Wifi Connected Success!");  
    Serial.print("NodeMCU IP Address : ");   //Shows the IP (Internet Protocol) number of your NodeMcu 
    Serial.println(WiFi.localIP() );         //Gets the IP address of your Board  
    delay(500);
  }

void loop() {
  // put your main code here, to run repeatedly:
//  Serial.println("RELAY OFF");
//  digitalWrite(RELAY1, LOW);
//  delay(4000); 
//
//  Serial.println("RELAY ON");
//  digitalWrite(RELAY1, HIGH);
//  delay(4000);

// Check if a client has connected
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
  Serial.println(request);
  client.flush();
 
  // Match the request
  int value = LOW;
  if (request.indexOf("/ON") != -1)  
  {
    //turn off relay
    digitalWrite(RELAY1,LOW);
    value = LOW;
  }
  if (request.indexOf("/OFF") != -1)  
  {
    //turn on relay
    digitalWrite(RELAY1,HIGH);
    value = HIGH;
  }


  
  // Return the response
  client.println("HTTP/1.1 200 OK");
  client.println("Content-Type: text/html");
  client.println("Access-Control-Allow-Origin: *");
  
  client.println(""); //  this is a must
  client.println("<!DOCTYPE HTML>");
  client.println("<html>");
  client.println("<head><title>ESP8266 RELAY Control</title></head>");
  //  client.print("Relay is now: ");
  
  client.print(value);
  if(value == HIGH) 
  {
    client.print("OFF");
  } 
  else 
  {
    client.print("ON");
  }
//  client.println("<br><br>");
//  client.println("Turn <a href=\"/RELAY=OFF\">OFF</a> RELAY<br>");
//  client.println("Turn <a href=\"/RELAY=ON\">ON</a> RELAY<br>");
  client.println("</html>");
 
  delay(1);
  Serial.println("Client disonnected");
  Serial.println("");
  

}
