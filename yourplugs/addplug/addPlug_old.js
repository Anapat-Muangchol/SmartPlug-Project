'use strict';

/*
 Add page title
 */

document.querySelector("#smart-plug-logo").innerHTML = "<span class='icon-plus'></span>&nbsp;Add plug</h4>";

/*
 Variables
 */
var count = 1;

/*
 Functions
 */
function renderAddPlugForm(count) {
    var addPlugFormHTML = document.createElement('form');
    addPlugFormHTML.className = "animated bounceInUp";
    addPlugFormHTML.innerHTML = "<div class='plug-title gradient-ffc107-ff9800-diagonal'>" +
        "<p><span class='icon-cord'></span>&nbsp;<b>&nbsp;Plug&nbsp;" + count + "</b></p>" +
        "</div>" +
        "<div class='line-red'></div>" +
        "<div class='panel'> " +
        "<div class='panel-body'>" +
        "<div class='styled-input-wrapper'>" +
        "<div class='input-icon'>" +
        "<i class='icon-cord'></i>" +
        "</div>" +
        "<div class='styled-input'>" +
        "<div class='form-group'>" +
        "<label for='plugName'>Plug name</label>" +
        "<input type='text' class='form-control' id='plugName' placeholder='plug name here'>" +
        "</div>" +
        "</div>" +
        "</div>" +
        "</div>" +
        "<div class='panel-body'>" +
        "<div class='styled-input-wrapper'>" +
        "<div class='input-icon'>" +
        "<i class='icon-key'></i>" +
        "</div>" +
        "<div class='styled-input'>" +
        "<div class='form-group'>" +
        "<label for='plugBarcode'>Plug barcode</label>" +
        "<input type='text' class='form-control' id='plugBarcode' placeholder='plug code here' required>" +
        "<span id='err-" + count + "' class='help-block'>*please fill your plug code</span>" +
        "</div>" +
        "</div>" +
        "</div>" +
        "</div>" +
        "<div class='panel-body'>" +
        "<div class='styled-input-wrapper'>" +
        "<div class='input-icon'>" +
        "<i class='icon-location'></i>" +
        "</div>" +
        "<div class='styled-input'>" +
        "<div class='form-group'>" +
        "<label for='plugLocation'>Plug location</label>" +
        "<input type='text' class='form-control' id='plugLocation'placeholder='plug location here'>" +
        "</div>" +
        "</div>" +
        "</div>" +
        "</div>" +
        "</div>" +
        "<button type='submit' style='display: none'></button>";
    return addPlugFormHTML
}

function addForm() {
    count += 1;
    document.getElementById('plugForm').appendChild(renderAddPlugForm(count));
    controls();
}

function addPlug(event) {
    event.preventDefault();
    if (controls()) {
        var plugForm = document.forms,
            formData = [];
        for (var i = 0; i < plugForm.length; i++) {

            // if(plugForm[i].elements[0].value.length <= 0){
            //     plugForm[i].elements[0].value = "";
            // }
            // if(plugForm[i].elements[2].value.length <= 0){
            //     plugForm[i].elements[2].value = "";
            // }
            formData.push({
                plugName: plugForm[i].elements[0].value,
                plugBarcode: plugForm[i].elements[1].value,
                plugLocation: plugForm[i].elements[2].value
            })
        }
        sendPlugToServer(JSON.stringify(formData))
    }
    return false;
}

/*
 check plug ID format or duplicate
 */
function checkPlugID(plugID, i) {
    var checkPlugID_deferred = $.Deferred();
    var plugIDRegEx = /^([0-9A-F]{2}:){5}[0-9A-F]{2}$/i;
    if (!plugIDRegEx.test(plugID)) {
        //Your plug ID is invalid.
        checkPlugID_deferred.resolve({status: false, text: "ERROR_INVALID_CODE", i: i});
    } else {
        /*
         check plug ID on Server
         */
        var ajax = new XMLHttpRequest();
        ajax.open("POST", "isfoundplugid.php", true);
        ajax.setRequestHeader("Content-type", "application/json");
        ajax.onreadystatechange = function () {
            if (ajax.readyState === XMLHttpRequest.DONE && ajax.status === 200) {
                if (ajax.responseText === "false") {
                    //This plug ID is already in use or not found.
                    checkPlugID_deferred.resolve({status: false, text: "ERROR_NOT_FOUND_OR_USED", i: i});
                } else {
                    checkPlugID_deferred.resolve({status: true, text: "VERIFY_OK", i: i});
                }
            }
        };
        ajax.send(JSON.stringify({plugID: plugID}));
    }
    return checkPlugID_deferred.promise();
}

function controls() {
    var plugForm = document.forms,
        isPlugBarcodeFill = [],
        isPlugNameFill = [],
        isPlugLocationFill = [];

    function controlsSubmit() {
        var result = true;
        for (var i = 0; i < isPlugBarcodeFill.length; i++) {
            if (isPlugBarcodeFill[i]) {
                result = result && false;
            } else if ((isPlugNameFill[i] || isPlugLocationFill[i])) {
                return true
            }
        }
        console.log(result);
        return result
    }

    function controlsAddMore() {
        for (var i = 0; i < isPlugBarcodeFill.length; i++) {
            if (!isPlugBarcodeFill[i]) {
                return true
            }
        }
        return false
    }

    for (var i = 0; i < plugForm.length; i++) {
        var err = document.querySelector('#err-' + (i + 1));
        if (plugForm[i].elements[0].value.length > 0) {
            isPlugNameFill.push(true);
        } else {
            isPlugNameFill.push(false);
        }
        if (plugForm[i].elements[1].value.length > 0) {
            //todo check plug id here
            var verifyPlugCode = checkPlugID(plugForm[i].elements[1].value, i);
            verifyPlugCode.then(function (result) {
                if (result.status && result.text === "VERIFY_OK") {
                    isPlugBarcodeFill.push(true);
                    err.style.display = "none";
                    plugForm[result.i].elements[1].className = "form-control"
                } else {
                    isPlugBarcodeFill.push(false);
                    plugForm[result.i].elements[1].className += " red-border";
                    if (result.text === "ERROR_INVALID_CODE") {
                        err.innerHTML = "Your plug ID is invalid.";
                    } else if (result.text === "ERROR_NOT_FOUND_OR_USED") {
                        err.innerHTML = "This plug code is already in use or not found.";
                    }
                    err.style.display = "block";
                }
            });
        } else {
            isPlugBarcodeFill.push(false);
            err.innerHTML = "*please fill your plug code.";
            err.style.display = "block";
            plugForm[i].elements[1].className += " red-border"
        }
        if (plugForm[i].elements[2].value.length > 0) {
            isPlugLocationFill.push(true);
        } else {
            isPlugLocationFill.push(false);
        }
        // isPlugNameFill.push(plugForm[i].elements[0].value.length > 0);
        // isPlugBarcodeFill.push(plugForm[i].elements[1].value.length > 0);
        // isPlugLocationFill.push(plugForm[i].elements[2].value.length > 0)
    }

    document.querySelector('#submit-btn').disabled = controlsSubmit();
    document.querySelector("#more-btn").disabled = controlsAddMore();
    return !controlsSubmit();
}

/*
 Event Listeners
 */

//add event to new form that create dynamically
document.querySelector('#plugForm').addEventListener('submit', addPlug);
document.querySelector('#plugForm').addEventListener('input', controls);
document.querySelector('#submit-btn').addEventListener('click', addPlug);
document.querySelector('#more-btn').addEventListener('click', addForm);

/*
 Ajax
 */

function sendPlugToServer(formData) {
    var ajax = new XMLHttpRequest();
    ajax.open("POST", "addPlug.php", true);
    ajax.setRequestHeader("Content-type", "application/json");
    ajax.send(formData)
}

