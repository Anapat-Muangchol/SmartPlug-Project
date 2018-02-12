/*
 Add page title
 */

document.querySelector("#smart-plug-logo").innerHTML = "<span class='icon-cord'></span>&nbsp;Your plugs</h4>";

/*
 Short hand Selector
 */
function select(ele) {
    return document.querySelector(ele);
}

var client,
    reconnectTimeout = 200,
    plug;

/*
 Get all plug from api
 */
var getDetailPlug = function () {
    var callBack = $.Deferred();
    var http = new XMLHttpRequest();
    var url = "../api/api-plug.php";
    var params = "function=getDetailAllPlug";
    http.open("POST", url, true);

//Send the proper header information along with the request
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    http.onreadystatechange = function () {//Call a function when the state changes.
        if (http.readyState == 4 && http.status == 200) {
            callBack.resolve(JSON.parse(http.responseText));
        }
    };
    http.send(params);
    return callBack.promise();
};


/*
 Generate HTML from plug
 */
var htmlRender = "";
var divNodePlug = document.createElement("div");
var indexItem = 0;
var wait = getDetailPlug();
wait.then(function (result) {
    plug = result;
    if (plug.status) {
        plug.lists.forEach(function (item) {
            indexItem++;
            htmlRender +=
                "<div class='plug-panel col-lg-6 col-md-6 col-sm-6 col-xs-12'>";
            //alert("switch_state : "+item.switch_state);
            if (item.switch_state == "1") {
                htmlRender += "<div id='switch_state_" + item.plug_id + "' class='panel power-active'>"
            } else {
                htmlRender += "<div id='switch_state_" + item.plug_id + "' class='panel'>"
            }
            htmlRender +=
                "<div id='send-command-loading-" + item.plug_id + "' style='display: none' class='cssload-container'>" +
                "<div class='cssload-shaft1'></div>" +
                "<div class='cssload-shaft2'></div>" +
                "<div class='cssload-shaft3'></div>" +
                "<div class='cssload-shaft4'></div>" +
                "<div class='cssload-shaft5'></div>" +
                "<div class='cssload-shaft6'></div>" +
                "<div class='cssload-shaft7'></div>" +
                "<div class='cssload-shaft8'></div>" +
                "<div class='cssload-shaft9'></div>" +
                "<div class='cssload-shaft10'></div>" +
                "</div>" +
                "<a href='plugdetail/?plug_id=" + item.plug_id + "' ><span class='link-plug-detail'></span></a>" +
                "<div class='panel-body'>" +
                "<div class='title-content col-lg-8 col-md-8 col-sm-8 col-xs-8'>" +
                "<div><h1><b>" + indexItem + "</b></h1></div>" +
                "<div>" +
                "<p>Name: <b>" + item.plug_name + "</b></p>" +
                "<p>Location: <b>" + item.plug_location + "</b></p>" +
                "<p>Outlets: <b><span id='outlet_" + item.plug_id + "'>" + item.num_of_outlet_active + "</span>/" + item.plug_num_of_outlets + "</b></p>" +
                "<p>Consume: <b><span id='consume_" + item.plug_id + "' data-usage='" + item.sum_current + "' class='odometer'>" + item.sum_current + "</span> A(ampere)&nbsp<span id='up-or-down_" + item.plug_id + "'></span></b></p>";


            htmlRender +=
                "</div>" +
                "</div>";

            if (item.switch_state === "1") {
                htmlRender += "<a href='javascript:void(0)' onclick='sendCommand(" + item.plug_id + ")' data-switch-send='off' id='switch_btn_" + item.plug_id + "' class='btn power-button-on pull-right btn-lg'><span class='icon-power switch_btn_on' ></span></a>"
            } else if (item.switch_state === "2") {
                htmlRender += "<a href='javascript:void(0)' data-switch-send='on' id='switch_btn_" + item.plug_id + "' class='btn power-button-error pull-right btn-lg' disabled><span class='icon-warning switch_btn_error' ></span></a>"
            } else {
                htmlRender += "<a href='javascript:void(0)' onclick='sendCommand(" + item.plug_id + ")' data-switch-send='on' id='switch_btn_" + item.plug_id + "' class='btn power-button-off pull-right btn-lg'><span class='icon-power switch_btn_off' ></span></a>"
            }
            htmlRender +=
                "</div>" +
                "</div>" +
                "</div>";
            /*
             if htmlRender has HTML then render to page
             */

            var myVar = setInterval(function () {
                updateRealtime(item.plug_id)
            }, 10000);
        });


        divNodePlug.innerHTML = htmlRender;
        childLength = divNodePlug.children.length;

        if (htmlRender) {
            for (var child = 0; child < childLength; child++) {
                document.getElementById('plug-render').appendChild(divNodePlug.firstChild);
            }
        }


    } else {
        alert("Can't query from database.");
    }
});

// document.getElementById('plug-render').addEventListener("click", function (ev) {
//     var oldClass = ev.target.parentNode.parentNode.className;
//     if (!(/bounceIn/g).test(oldClass)) {
//         ev.target.parentNode.parentNode.className += " bounceIn";
//         setTimeout(function () {
//             ev.target.parentNode.parentNode.className = oldClass;
//         }, 750)
//     }
// });

var old_switch_state = [];
function updateRealtime(plug_id) {

    var http = new XMLHttpRequest();
    var url = "../api/api-plug.php";
    var params = "function=getPlugRealtime&plug_id=" + plug_id;
    var oldCurrent = document.getElementById('consume_' + plug_id).getAttribute("data-usage");

    http.open("POST", url, true);

    //Send the proper header information along with the request
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    http.onreadystatechange = function () {//Call a function when the state changes.
        if (http.readyState === 4 && http.status === 200) {
            var current = JSON.parse(http.responseText),
                switchBTN = select("#switch_btn_" + plug_id),
                switchState = select("#switch_state_" + plug_id),
                upOrDown = select("#up-or-down_" + plug_id);
            old_switch_state[plug_id] = old_switch_state[plug_id] || current.switch_state;

            if (current.switch_state !== old_switch_state[plug_id]) {
                old_switch_state[plug_id] = current.switch_state;
                if (switchBTN.getAttribute("data-switch-send") === "on") {
                    switchBTN.setAttribute("data-switch-send", "off");
                } else {
                    switchBTN.setAttribute("data-switch-send", "on");
                }
                select("#send-command-loading-" + plug_id).style.display = 'none';
            }

            if (current.switch_state === "1") {
                switchState.className = "panel power-active animated";
                switchBTN.className = "btn power-button-on pull-right btn-lg";
                switchBTN.children[0].className = "icon-power switch_btn_on";
                switchBTN.addEventListener("click", function () {
                    sendCommand(plug_id);
                });
                switchBTN.disabled = false;
            } else if (current.switch_state === "2") {
                switchState.className = "panel";
                switchBTN.className = "btn power-button-error pull-right btn-lg";
                switchBTN.children[0].className = "icon-warning switch_btn_error";
                switchBTN.removeEventListener("click", sendCommand);
                switchBTN.disabled = true;
            } else {
                switchState.className = "panel animated";
                switchBTN.className = "btn power-button-off pull-right btn-lg";
                switchBTN.children[0].className = "icon-power switch_btn_off";
                switchBTN.addEventListener("click", function () {
                    sendCommand(plug_id);
                });
                switchBTN.disabled = false;
            }
            document.getElementById('outlet_' + plug_id).innerHTML = current.num_of_outlet_active;

            if (current.sum_current < oldCurrent) {
                upOrDown.innerHTML = "<i class='icon-triangle-down' style='color: green;'></i>";
            } else if (current.sum_current > oldCurrent) {
                upOrDown.innerHTML = "<i class='icon-triangle-up' style='color: red;'></i>";
            } else {
                upOrDown.innerHTML = "";
            }
            var el = select("#consume_" + plug_id);
            el.setAttribute("data-usage", current.sum_current);
            var od = new Odometer({
                el: el
            });
            od.update(current.sum_current);
        }
    };
    http.send(params);
}

/*
 MQTT
 */

var MQTTconnect = function () {
    var host = '10.16.64.14',
        port = 5508,
        clientID = "web_" + parseInt(Math.random() * 100, 10);
    var useTLS = false,
        username = 'isdat',
        password = 'Qwer1234',
        cleansession = true;

    client = new Paho.MQTT.Client(host, port, clientID);

    var options = {
        timeout: 3,
        useSSL: useTLS,
        cleanSession: cleansession,
        onSuccess: onConnect,
        onFailure: function (message) {
            $('#status').val("Connection failed: " + message.errorMessage + "Retrying");
            setTimeout(MQTTconnect, reconnectTimeout);
        }
    };

    client.onConnectionLost = onConnectionLost;

    if (username != null) {
        options.userName = username;
        options.password = password;
    }
    //console.log("Host=" + host + ", port=" + port + " TLS = " + useTLS + " username=" + username + " password=" + password);
    client.connect(options);
};

function onConnect() {
    //console.log("Connected to plugs");
}
function onConnectionLost(response) {
    setTimeout(MQTTconnect, reconnectTimeout);
    console.log("connection lost. Reconnecting");
}

var sendCommand = function (plug_id) {
    select("#send-command-loading-" + plug_id).style.display = 'block';
    var command = select("#switch_btn_" + plug_id).getAttribute("data-switch-send");
    var payload = JSON.stringify({
        outlet: "all", status: command
    });
    //console.log(plug_id + " " + command);
    message = new Paho.MQTT.Message(payload);
    message.destinationName = "/smartplug/" + plug_id + "/status";
    //console.log(message.destinationName);
    console.log(payload);
    client.send(message);
};

MQTTconnect();
