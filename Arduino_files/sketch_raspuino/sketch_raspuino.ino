#include <Ethernet2.h>
#include <EthernetClient.h>
#include <EthernetServer.h>
#include <SPI.h>
#include <EEPROMex.h>
#include <EEPROMVar.h>

//used to save the output state: 1 bit for output pin
EEPROMClassEx mem;


#define numInPin 
#define numOutPin 

byte output_pins[] = {}; //insert array output pin es.{2,3,4,5,6,7}
byte input_pins[] = {}; // insert array input pin es.{14,15,16,17,18,19}

byte mac[]={}; //insert MAC
String my_mac=""; //insert MAC as String es. "90-A2-DA-10-21-A9"


IPAddress ip();  //insert ip for this shield
EthernetServer server(); //insert port number for this shield
EthernetClient client;

String request;

long lastTime;

void setup() {
  for(int i=0;i<numInPin;i++){
    pinMode(input_pins[i],INPUT);
    
  }
  for(int i=0;i<numOutPin;i++){
    pinMode(output_pins[i],OUTPUT);
    //load the last output state
    int address = i/8;  
    byte pos = i%8;
    bool value = mem.readBit(address, pos);
    if(value==1){
      digitalWrite(output_pins[i], HIGH);  
    }
    else{
      digitalWrite(output_pins[i], LOW);  
    }
  }
  
  pinMode(4, OUTPUT);  //pin SDcard on EthernetShield  
  digitalWrite(4, HIGH);
  pinMode(10, OUTPUT); //pin ETHCS
  digitalWrite(10,HIGH); //impostiamo il pin ETHCS al valore alto per evitare problemi al caricamento della pagina
  
  lastTime=0;

  Ethernet.begin(mac, ip);
  server.begin();
  // give the Ethernet shield a second to initialize:
  delay(1000);
}

void loop(){
  client = server.available();
  if (client) {
    // an http request ends with a blank line
    boolean currentLineIsBlank = true;
    while (client.connected()) {
      if (client.available()) {
        char c = client.read();
        request.concat(c);
        // if you've gotten to the end of the line (received a newline
        // character) and the line is blank, the http request has ended,
          // so you can send a reply
        if (c == '\n' && currentLineIsBlank) {
            if(request.indexOf("GET /mac")>-1){
              client.println("HTTP/1.1 200 OK");
              client.println();
              client.println(my_mac);
            }
            else if(request.indexOf("GET /input_pin")>-1){
              client.println("HTTP/1.1 200 OK");
              client.println();
              client.println(getInputPinJSON());
            }
            else if(request.indexOf("GET /output_pin")>-1){
              client.println("HTTP/1.1 200 OK");
              client.println();
              client.println(getOutputPinJSON());
            }
            else if(request.indexOf("GET /input_status")>-1){
              client.println("HTTP/1.1 200 OK");
              client.println();
              client.println(getInputStatusJSON());
            }
            else if(request.indexOf("GET /output_status")>-1){
              client.println("HTTP/1.1 200 OK");
              client.println();
              client.println(getOutputStatusJSON());
            }
            else if(request.indexOf("GET /setout")>-1){
              modificaStatoPin();
              client.println("HTTP/1.1 200 OK");
              client.println();
            }
            else if(request.indexOf("GET /toggle")>-1){
              togglePin();
              client.println("HTTP/1.1 200 OK");
              client.println();
            }
            else{
              client.println("HTTP/1.1 404 NOT FOUND");
              client.println();
            }
            client.stop();
            request="";
          }
          if (c == '\n') {
            // you're starting a new line
            currentLineIsBlank = true;
          }
          else if (c != '\r') {
            // you've gotten a character on the current line
            currentLineIsBlank = false;
          }
        }
      }
    }
    // save the current output state on EEPROM every 10 seconds
    if(millis()-lastTime>10000){
      for(int i=0;i<numOutPin;i++){
        int address = i/8;
        byte pos = i%8;
        if(digitalRead(output_pins[i])==HIGH){
          mem.updateBit(address, pos, 1);
        }
        else{
          mem.updateBit(address, pos, 0); 
        }
      }
      lastTime=millis();
    }
    delay(10);
}


/* restituisce una stringa contenente un vettore di boolean rappresentanti lo stato dei pin in Javascript
 * 1,1,0,... 
 */
String getVettoreStato(){
  String arrayStato = "";
  for(int i=0;i<numInPin;i++)
   {
    if(digitalRead(input_pins[i])==HIGH) 
      arrayStato+="1";
    else 
      arrayStato+="0";
    if(i!=(numInPin-1))
      arrayStato+=",";
   }
   return arrayStato;
}

/* restituisce una stringa contenente un vettore di interi rappresentanti i pin di output da gestire da remoto in Javascript
 * 2,3,4,... 
 */
String getInputPinJSON(){
  String arrayNum="[";
  for(int i=0;i<numInPin;i++)
   { 
    arrayNum+=(String(input_pins[i]));
    if(i!=(numInPin-1))
      arrayNum+=",";
   }
   arrayNum+="]";
   return arrayNum;
}

String getOutputPinJSON(){
  String arrayNum="[";
  for(int i=0;i<numOutPin;i++)
   { 
    arrayNum+=(String(output_pins[i]));
    if(i!=(numOutPin-1))
      arrayNum+=",";
   }
   arrayNum+="]";
   return arrayNum;
}

String getInputStatusJSON(){
  String array="[";
  for(int i=0;i<numInPin;i++)
   { 
    if(digitalRead(input_pins[i])==HIGH)
      array+="1";
    else
      array+="0"; 
    if(i!=(numInPin-1))
      array+=",";
   }
   array+="]";
   return array;
}

String getOutputStatusJSON(){
    String array="[";
  for(int i=0;i<numOutPin;i++)
   { 
    if(digitalRead(output_pins[i])==HIGH)
      array+="1";
    else
      array+="0"; 
    if(i!=(numOutPin-1))
      array+=",";
   }
   array+="]";
   return array;
}

/* funzione per la modifica dello stato di un pin a partire dalla richiesta inviata al server ("ON" accensione, "OFF" spegnimento) 
 * la richiesta è del tipo /setout?PIN#=1  
*/
void modificaStatoPin(){
  int start_index = request.indexOf("PIN");
  if(start_index>-1){
    int equal_index = request.indexOf("=", start_index);  //trovo l'indice del simbolo '='
    int pin = request.substring(start_index+3,equal_index).toInt();  //estraggo il numero del pin compreso tra la stringa 'PIN' e il simbolo '='
    int new_state = request.substring(equal_index+1, equal_index+2).toInt();  //estraggo il nuovo stato che deve assumere il pin, può essere 0 o 1
    String str = "modifico ";
    str.concat(pin);
    if(new_state==1)
      digitalWrite(pin,HIGH);
    else
      digitalWrite(pin,LOW);
  }
  delay(10);
}

/* funzione per la modifica dello stato di un pin in modo toggle
 * la richiesta è del tipo /toggle/PIN#  
*/
void togglePin(){
  int start_index = request.indexOf("PIN");
  if(start_index>-1){
    int fine_index = request.indexOf("\n", start_index);  //trovo l'indice del simbolo '='
    int pin = request.substring(start_index+3,fine_index).toInt();  //estraggo il numero del pin compreso tra la stringa 'PIN' e il simbolo '='
    digitalWrite(pin, HIGH);
    delay(2000);
    digitalWrite(pin,LOW);
  }
  delay(10);
}


