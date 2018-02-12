/*
 Add page title
 */

/*
 JSON Plug Data
 */
/*
 var plug = [
 {
 "id": 1,
 "name": "พัดลม",
 "consume": 0.3,
 "status": 1,
 "electronic": "fan",
 "detect": 1
 },
 {
 "id": 2,
 "name": "โคมไฟ",
 "consume": 0.4,
 "status": 0,
 "electronic": "lamp",
 "detect": 1
 },
 {
 "id": 3,
 "name": "ทีวี",
 "consume": 0.5,
 "status": 1,
 "electronic": "tv",
 "detect": 1
 },
 {
 "id": 4,
 "name": "",
 "consume": 0,
 "status": 0,
 "detect": 0
 }
 ];
 */

/*
 Short hand Selector
 */
function select(ele) {
    return document.querySelector(ele);
}

var plug;

var shakeForm = function () {
    var plugDetailForm = select("#plug-detail-form");
    plugDetailForm.className = "smart-plug-card-yellow shake animated";
    setTimeout(function () {
        plugDetailForm.className = "smart-plug-card-yellow";
    }, 1000)
};

/*
 Get all plug from api
 */
var getOutletAll = function () {
    //alert(plug_id);
    var callBack = $.Deferred();
    var http = new XMLHttpRequest();
    var url = "../../api/api-outlet.php";
    var params = "function=getAllOutletInPlug&plug_id=" + plug_id;
    http.open("POST", url, true);

//Send the proper header information along with the request
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    http.onreadystatechange = function () {//Call a function when the state changes.
        if (http.readyState === 4 && http.status === 200) {
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
var divNodeOutlets = document.createElement("div");
var indexItem = 0;

var wait = getOutletAll();
wait.then(function (result) {
    plug = result;
    if (plug.status) {
        plug.lists.forEach(function (item) {
            //item = JSON.parse(item);
            console.log("i");
            indexItem++;
            htmlRender +=
                "<div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>" +
                "<div id='send-command-loading-" + item.outlet_number + "' style='display: none' class='cssload-container'>" +
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
                "</div>";
            if (item.outlet_switch_state === "1") {
                htmlRender += "<div id='switch_state_" + item.outlet_number + "' class='panel power-active animated'>"
            } else {
                htmlRender += "<div id='switch_state_" + item.outlet_number + "' class='panel animated'>"
            }
            htmlRender +=
                "<a href='graph/index.php?plug_id=" + item.outlet_plug_id + "&outlet_number=" + item.outlet_number + "' ><span class='link-outlet-detail'></span></a>" +
                "<div class='panel-body'>" +
                "<div id='electronic-img-" + item.outlet_number + "' class='col-lg-4 col-md-4 col-sm-4 col-xs-4'>" +
                "<span id='img_" + item.outlet_number + "'><img src='imges/electronics/" + item.outlet_current_electronic + ".png' style='width: 70%;'></span>";


            /*
             switch (item.electronic) {
             case "lamp":
             htmlRender += "<img src='imges/electronics/lamp.png'>";
             break;
             case "tv":
             htmlRender += "<img src='imges/electronics/tv.png'>";
             break;
             case "fan":
             htmlRender += "<img src='imges/electronics/fan.png'>";
             break;
             }*/
            htmlRender +=
                "</div>" +
                "<div class='title-content col-lg-8 col-md-8 col-sm-8 col-xs-8'>" +
                "<div><h1><b>" + indexItem + "</b></h1></div>" +
                "<div>";
            if (item.outlet_current_electronic == null) {
                htmlRender += "<p>Name: <b><span id='name_" + item.outlet_number + "'>None</span></b></p>";
            } else {
                htmlRender += "<p>Name: <b><span id='name_" + item.outlet_number + "'>" + item.outlet_current_electronic + "</span></b></p>";
            }
            htmlRender += "<p>Consume: <b><span id='consume_" + item.outlet_number + "' data-usage='" + item.used_current + "'>" + item.used_current + "</span> A(ampere)<span id='up-or-down_" + item.outlet_number + "'></span></b></p>";


            htmlRender +=
                "</div>" +
                "</div>";

            if (item.outlet_switch_state === "1") {
                htmlRender += "<a href='javascript:void(0)' onclick='sendCommand(" + item.outlet_number + ")' data-switch-send='off' id='switch_btn_" + item.outlet_number + "' class='btn power-button-on pull-right btn-lg'><span class='icon-power switch_btn_on' ></span></a>"
            } else if (item.outlet_switch_state === "2") {
                htmlRender += "<a href='javascript:void(0)' data-switch-send='on' id='switch_btn_" + item.outlet_number + "' class='btn power-button-error pull-right btn-lg' disabled><span class='icon-warning switch_btn_error' ></span></a>"
            } else {
                htmlRender += "<a href='javascript:void(0)' onclick='sendCommand(" + item.outlet_number + ")' data-switch-send='on' id='switch_btn_" + item.outlet_number + "' class='btn power-button-off pull-right btn-lg'><span class='icon-power switch_btn_off' ></span></a>"
            }


            htmlRender +=
                "<!-- panel body end -->" +
                "</div>" +
                "</div>" +
                "</div>";
            /*
             if htmlRender has HTML then render to page
             */

            var myVar = setInterval(function () {
                updateRealtime(item.outlet_number)
            }, 10000);

        });
        divNodeOutlets.innerHTML = htmlRender;
        childLength = divNodeOutlets.children.length;
        if (htmlRender) {
            for (var child = 0; child < childLength; child++) {
                select("#outlets-render").appendChild(divNodeOutlets.firstChild);
            }
        }

    } else {
        alert("Can't query from database.");
    }
});


/*
 plug.lists.forEach(function (item) {
 indexItem++;
 htmlRender +=
 "<div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>";
 if (item.status == 1) {
 htmlRender += "<div class='panel power-active animated'>"
 } else {
 htmlRender += "<div class='panel animated'>"
 }
 htmlRender +=
 "<a href='#' ><span class='link-plug-detail'></span></a>" +
 "<div class='panel-body'>" +
 "<div class='title-content col-lg-8 col-md-8 col-sm-8 col-xs-8'>" +
 "<div><h1><b>" + indexItem + "</b></h1></div>" +
 "<div>" +
 "<p>Name: <b>" + item.plug_name + "</b></p>" +
 "<p>Location: <b>" + item.plug_location + "</b></p>" +
 "<p>Outlets: <b>" + item.plug_num_of_outlets + "/4</b></p>" +
 "<p>Consume: <b>" + item.consume + " A(ampere)</b></p>";


 htmlRender +=
 "</div>" +
 "</div>";

 if (item.status == 1) {
 htmlRender += "<a href='javascript:void(0)' class='btn power-button-on pull-right btn-lg'><span class='icon-power' style='font-size: xx-large;'></span></a>"
 } else {
 htmlRender += "<a href='javascript:void(0)' class='btn btn-default pull-right btn-lg'><span class='icon-power' style='font-size: xx-large; color:#313131; '></span></a>"
 }
 htmlRender +=
 "</div>" +
 "</div>" +
 "</div>";
 }
 );
 */


// select('plug-render').addEventListener("click", function (ev) {
//     var oldClass= ev.target.parentNode.parentNode.className;
//     if(!(/bounceIn/g).test(oldClass)){
//         ev.target.parentNode.parentNode.className += " bounceIn";
//         setTimeout(function (){
//             ev.target.parentNode.parentNode.className = oldClass;
//         },750)
//     }
// });

var old_outlet_state = [];
function updateRealtime(outlet_number) {
    //console.log("plug_id:"+plug_id);
    var http = new XMLHttpRequest();
    var url = "../../api/api-outlet.php";
    var params = "function=getOutletRealtime&plug_id=" + plug_id + "&outlet_number=" + outlet_number;
    var oldCurrent = select('#consume_' + outlet_number).getAttribute("data-usage");
    http.open("POST", url, true);

    //Send the proper header information along with the request
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    http.onreadystatechange = function () {//Call a function when the state changes.
        if (http.readyState === 4 && http.status === 200) {
            var current = JSON.parse(http.responseText);
            old_outlet_state[outlet_number] = old_outlet_state[outlet_number] || current.desc.outlet_switch_state;
            if (current.desc.outlet_switch_state !== old_outlet_state[outlet_number]) {
                old_outlet_state[outlet_number] = current.desc.outlet_switch_state;
                if (select("#switch_btn_" + outlet_number).getAttribute("data-switch-send") === "on") {
                    select("#switch_btn_" + outlet_number).setAttribute("data-switch-send", "off");
                } else {
                    select("#switch_btn_" + outlet_number).setAttribute("data-switch-send", "on");
                }
                select("#send-command-loading-" + outlet_number).style.display = 'none';
            }
            if (current.desc.outlet_switch_state === "1") {
                select("#switch_state_" + outlet_number).className = "panel power-active animated";
                select("#switch_btn_" + outlet_number).className = "btn power-button-on pull-right btn-lg";
                select("#switch_btn_" + outlet_number).children[0].className = "icon-power switch_btn_on";
                select("#switch_btn_" + outlet_number).addEventListener("click", function () {
                    sendCommand(outlet_number);
                });
                select("#switch_btn_" + outlet_number).disabled = true;
            } else if (current.desc.outlet_switch_state === "2") {
                select("#switch_state_" + outlet_number).className = "panel";
                select("#switch_btn_" + outlet_number).className = "btn power-button-error pull-right btn-lg";
                select("#switch_btn_" + outlet_number).children[0].className = "icon-warning switch_btn_error";
                select("#switch_btn_" + outlet_number).removeEventListener("click", sendCommand);
                select("#switch_btn_" + outlet_number).disabled = true;
            } else {
                select("#switch_state_" + outlet_number).className = "panel animated";
                select("#switch_btn_" + outlet_number).className = "btn power-button-off pull-right btn-lg";
                select("#switch_btn_" + outlet_number).children[0].className = "icon-power switch_btn_off";
                select("#switch_btn_" + outlet_number).addEventListener("click", function () {
                    sendCommand(outlet_number);
                });
                select("#switch_btn_" + outlet_number).disabled = false;
            }

            if (current.desc.outlet_current_electronic == null) {
                select('#img_' + outlet_number).innerHTML = "<img src='imges/electronics/None.png' style='width: 70%;'>";
                select('#name_' + outlet_number).innerHTML = "None";
            } else {
                select('#img_' + outlet_number).innerHTML = "<img src='imges/electronics/" + current.desc.outlet_current_electronic + ".png' style='width: 70%;'>";
                select('#name_' + outlet_number).innerHTML = current.desc.outlet_current_electronic;
                if (current.desc.used_current < oldCurrent) {
                    select('#up-or-down_' + outlet_number).innerHTML = "<i class='icon-triangle-down' style='color: green;'></i>";
                } else if (current.desc.used_current > oldCurrent) {
                    select('#up-or-down_' + outlet_number).innerHTML = "<i class='icon-triangle-up' style='color: red;'></i>";
                } else {
                    select('#up-or-down_' + outlet_number).innerHTML = "";
                }
            }
            var el = select('#consume_' + outlet_number);
            el.setAttribute("data-usage", current.desc.used_current);
            var od = new Odometer({
                el: el
            });
            od.update(current.desc.used_current);
        }
    };
    http.send(params);
}
/*
 setTimeout(function () {
 alert("Plug1 : "+select('outlet_1').innerHTML+" : "+select('consume_1').innerHTML);
 alert("Plug2 : "+select('outlet_2').innerHTML+" : "+select('consume_2').innerHTML);
 }, 3000)
 */

/*
 Get Plug Detail
 */

var getPlugDetail = function () {
    var plugName = select("#plug-name"),
        plugLocation = select("#plug-location"),
        nameOfPlug = select("#name-of-plug");

    var ajax = new XMLHttpRequest();
    ajax.open("GET", "getplugdetail.php", true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.onreadystatechange = function () {
        if (ajax.readyState ===
            XMLHttpRequest.DONE && ajax.status === 200) {
            var ans = JSON.parse(ajax.responseText);
            if (ans.status) {
                for (var index = 0; index < ans.lists.length; index++) {
                    if (ans.lists[index].plug_id === plug_id) {
                        document.querySelector("#smart-plug-logo").innerHTML = "<span class='icon-cord'></span>&nbsp;" + ans.lists[index].plug_name + "</h4>"
                        plugName.value = ans.lists[index].plug_name;
                        plugLocation.value = ans.lists[index].plug_location;
                        nameOfPlug.innerHTML = ans.lists[index].plug_name + " : " + ans.lists[index].plug_location;
                    }
                }
            }
        }
    };
    ajax.send();
};

getPlugDetail();

/*
 * edit plug detail
 * */

var sendEditToServer = function (event) {
    event.preventDefault();
    var plugName = select("#plug-name"),
        plugLocation = select("#plug-location"),
        errPlugName = select("#err-plug-name"),
        editDetailSuccessful = select("#editDetailSuccessful");
    if (plugName.value.length > 0) {
        var ajax = new XMLHttpRequest();
        ajax.open("POST", "plugdetail.php", true);
        ajax.setRequestHeader("Content-type", "application/json");
        ajax.onreadystatechange = function () {
            if (ajax.readyState ===
                XMLHttpRequest.DONE && ajax.status === 200) {
                var ans = JSON.parse(ajax.responseText);
                if (ans.status) {
                    getPlugDetail();
                    errPlugName.style.display = "none";
                    editDetailSuccessful.style.opacity = "1";
                    editDetailSuccessful.style.zIndex = "1";
                    setTimeout(function () {
                        editDetailSuccessful.style.opacity = "0";
                        editDetailSuccessful.style.zIndex = "auto";
                    }, 1000);
                }
            }
        };
        ajax.send(JSON.stringify({
            plugID: plug_id,
            plugName: select("#plug-name").value,
            plugLocation: select("#plug-location").value
        }))
    } else {
        shakeForm();
        errPlugName.style.display = "inline";
    }
};

/*
 Delete Plug
 */
var deletePlug = function (event) {
    event.preventDefault();
    var ajax = new XMLHttpRequest();
    ajax.open("POST", "deleteplug.php", true);
    ajax.setRequestHeader("Content-type", "application/json");
    ajax.onreadystatechange = function () {
        if (ajax.readyState ===
            XMLHttpRequest.DONE && ajax.status === 200) {
            var ans = JSON.parse(ajax.responseText);
            if (ans.status) {
                //todo delete plug
                location.assign('../');
            }
        }
    };
    ajax.send(JSON.stringify({
        plugID: plug_id
    }))
};

select("#plug-detail-form").addEventListener('submit', sendEditToServer);
select("#del-confirm-btn").addEventListener('click', deletePlug);

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
    console.log("Connected to plug");
}
function onConnectionLost(response) {
    setTimeout(MQTTconnect, reconnectTimeout);
    console.log("connection lost. Reconnecting");
}

var sendCommand = function (outlet_number) {
    select("#send-command-loading-" + outlet_number).style.display = 'block';
    var command = select("#switch_btn_" + outlet_number).getAttribute("data-switch-send");
    var payload = JSON.stringify({
        outlet: outlet_number + "", status: command
    });
    console.log(outlet_number + " " + command);
    message = new Paho.MQTT.Message(payload);
    message.destinationName = "/smartplug/" + plug_id + "/status";
    // console.log(message.destinationName);
    // console.log(payload);
    client.send(message);
};

MQTTconnect();