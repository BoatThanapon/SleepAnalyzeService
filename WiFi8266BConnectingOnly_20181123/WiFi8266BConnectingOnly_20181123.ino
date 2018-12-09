
#include <ESP8266WiFi.h>
#include <DHT.h>
const char* ssid     = "NotWifi";
const char* password = "0970747125";
const char* host = "192.168.43.126";
const char* userID = "1";

#define ledPin D5
#define SoundOutPin D4
#define DHTPIN D7
#define DHTTYPE DHT22 

DHT dht(DHTPIN, DHTTYPE);

//--------------------------------------
void setup()
{ 
  pinMode (ledPin, OUTPUT);
  pinMode (SoundOutPin, OUTPUT);
  Serial.begin(9600);
  digitalWrite (SoundOutPin, HIGH);
  Serial.begin(9600);
  Serial.println("DHTxx test!");

  dht.begin();
  wifiConnect();
}
void loop()
{

  // read the input on analog pin 0:
  int vibrationValue = analogRead(A0);

  // print out the value you read:
  Serial.println("====vibrationValue====");
  Serial.println(vibrationValue);
   if (vibrationValue >= 100){
    digitalWrite (SoundOutPin, LOW);
//    delay(100);
    digitalWrite (SoundOutPin, HIGH);
//    delay(100);
   }

  // Reading temperature or humidity takes about 250 milliseconds!
  // Sensor readings may also be up to 2 seconds 'old' (its a very slow sensor)
  float h = dht.readHumidity();
  // Read temperature as Celsius (the default)
  float t = dht.readTemperature();
  // Read temperature as Fahrenheit (isFahrenheit = true)
  float f = dht.readTemperature(true);

  // Check if any reads failed and exit early (to try again).
  if (isnan(h) || isnan(t) || isnan(f)) {
    Serial.println("Failed to read from DHT sensor!");
    return;
  }

  // Compute heat index in Fahrenheit (the default)
  float hif = dht.computeHeatIndex(f, h);
  // Compute heat index in Celsius (isFahreheit = false)
  float hic = dht.computeHeatIndex(t, h, false);

  Serial.print("Humidity: ");
  Serial.print(h);
  Serial.print(" %\t");
  Serial.print("Temperature: ");
  Serial.print(t);
  Serial.print(" *C ");
  Serial.print(f);
  Serial.print(" *F\t");
  Serial.print("Heat index: ");
  Serial.print(hic);
  Serial.print(" *C ");
  Serial.print(hif);
  Serial.println(" *F");

  // Send Data to Database
  sendURL(h,t,vibrationValue);

  // Wait a few seconds between measurements. The DHT22 should not be read at a higher frequency of
  // about once every 2 seconds. So we add a 3 second delay to cover this.
  delay(3000);
  
}
void wifiConnect()
{
//--------- WiFi----------------------------
    Serial.println();
    Serial.print("Connecting to ");
    Serial.println(ssid);
    WiFi.mode(WIFI_STA);
    WiFi.begin(ssid, password);

    while (WiFi.status() != WL_CONNECTED) {
        digitalWrite (ledPin, HIGH);
        delay(250);
        digitalWrite (ledPin, LOW);
        delay(250);
        Serial.print(".");
        
    }
    
    digitalWrite (SoundOutPin, LOW);
    delay(100);
    digitalWrite (SoundOutPin, HIGH);
    delay(100);
    digitalWrite (SoundOutPin, LOW);
    delay(100);
    digitalWrite (SoundOutPin, HIGH);
    delay(100);
    Serial.println("");
    Serial.println("WiFi connected");
    Serial.println("================================");
    Serial.print("SSID: ");
    Serial.println(ssid);
    Serial.print("IP address: ");
    Serial.println(WiFi.localIP());
    Serial.println("================================");
    digitalWrite (ledPin, HIGH);
    delay(2000);
//------------------------------------------
}

void sendURL(float h, float t, int v)
{
    Serial.print("connecting to ");
    Serial.println(host);
        WiFiClient client;
    const int httpPort = 80;
    if (!client.connect(host, httpPort)) {
        Serial.println("connection failed");
        return;
    }
    String url = "/sa/node_data_update.php?userID=";
    url += userID;
    url += "&humidity=";
    url += h;
    url += "&temperature=";
    url += t;
    url += "&vibration=";
    url += v;
    Serial.print("Requesting URL: ");
    Serial.println(url);
    client.print(String("GET ") + url + " HTTP/1.1\r\n" +
                 "Host: " + host + "\r\n" +
                 "Connection: close\r\n\r\n");
    unsigned long timeout = millis();
    while (client.available() == 0) {
        if (millis() - timeout > 5000) {
            Serial.println(">>> Client Timeout !");
            client.stop();
            return;
        }
    }
}
