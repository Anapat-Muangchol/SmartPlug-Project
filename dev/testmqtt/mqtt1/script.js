var mqtt;
var reconnectTimeout = 2000;
var topic0 = "plug0/sensor0";
var topic1 = "plug0/sensor1";
var topic2 = "plug0/sensor2";
var topic3 = "plug0/sensor3";

function MQTTconnect() {
    mqtt = new Paho.MQTT.Client(host, port, "web_" + parseInt(Math.random() * 100, 10));

    var options = {
        timeout: 3,
        useSSL: useTLS,
        userName: username,
        password: password,
        cleanSession: cleansession,
        onSuccess: onConnect,
        onFailure: function (message) {
            $('#status').val("Connection failed: " + message.errorMessage + "Retrying");
            setTimeout(MQTTconnect, reconnectTimeout);
        }
    };

    /*sensor0_ON = new Paho.MQTT.Message("0_ON");
     sensor0_OFF = new Paho.MQTT.Message("0_OFF");

     sensor0_ON.destinationName = "control/plug";
     sensor0_ON.qos = 2;
     sensor0_OFF.destinationName = "control/plug";
     sensor0_OFF.qos = 2;
     sensor1_ON.destinationName = "control/plug";
     sensor1_ON.qos = 2;
     sensor1_OFF.destinationName = "control/plug";
     sensor1_OFF.qos = 2;
     sensor2_ON.destinationName = "control/plug";
     sensor2_ON.qos = 2;
     sensor2_OFF.destinationName = "control/plug";
     sensor2_OFF.qos = 2;
     sensor3_ON.destinationName = "control/plug";
     sensor3_ON.qos = 2;
     sensor3_OFF.destinationName = "control/plug";
     sensor3_OFF.qos = 2;*/

    mqtt.onConnectionLost = onConnectionLost;
    mqtt.onMessageArrived = onMessageArrived;

    if (username != null) {
        console.log("Host=" + host + ", port=" + port + " TLS = " + useTLS + " username=" + username + " password=" + password);
        //options.userName = username;
        //options.password = password;
        console.log(options);
    }
    mqtt.connect(options);
}

function onConnect() {
    $('#status').val('Connected to ' + host + ':' + port);
    // Connection succeeded; subscribe to our topic
    mqtt.subscribe(topic, {qos: 2});

    $('#topic').val(topic0);
}

function onConnectionLost(response) {
    setTimeout(MQTTconnect, reconnectTimeout);
    $('#status').val("connection lost: " + responseObject.errorMessage + ". Reconnecting");

};

function onMessageArrived(message) {

    var topic = message.destinationName;
    var payload = message.payloadString;

    $('#ws').prepend('<li>' + topic + ' = ' + payload + '</li>');
    if (topic == "plug0/sensor0") {
        var image0 = document.getElementById('app0');
        setImage(payload, image0);
    } else if (topic == "plug0/sensor1") {
        var image1 = document.getElementById('app1');
        setImage(payload, image1);
    } else if (topic == "plug0/sensor2") {
        var image2 = document.getElementById('app2');
        setImage(payload, image2);
    } else if (topic == "plug0/sensor3") {
        var image3 = document.getElementById('app3');
        setImage(payload, image3);
    } else {
        //alert("Undefine topic");
    }

    // Collect data for weka
    if (topic == "sensor0/forweka") {
        $('#sensorval0').prepend('<span>' + payload + '</span><br />');
    }
    if (topic == "sensor1/forweka") {
        $('#sensorval1').prepend('<p>' + payload + '</p>');
    }
    if (topic == "sensor2/forweka") {
        $('#sensorval2').prepend('<p>' + payload + '</p>');
    }
    if (topic == "sensor3/forweka") {
        $('#sensorval3').prepend('<p>' + payload + '</p>');
    }
};

/*function sendCommand(cmd) {
 switch (cmd) {
 case '0_ON':
 mqtt.send(sensor0_ON);
 break;
 case '0_OFF':
 mqtt.send(sensor0_OFF);
 break;
 case '1_ON':
 mqtt.send(sensor1_ON);
 break;
 case '1_OFF':
 mqtt.send(sensor1_OFF);
 break;
 case '2_ON':
 mqtt.send(sensor2_ON);
 break;
 case '2_OFF':
 mqtt.send(sensor2_OFF);
 break;
 case '3_ON':
 mqtt.send(sensor3_ON);
 break;
 case '3_OFF':
 mqtt.send(sensor3_OFF);
 break;
 default:
 alert("Undefined CMD");
 break;
 }
 }*/

$(document).ready(function () {
    MQTTconnect();
});