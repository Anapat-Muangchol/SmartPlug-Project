'use strict';

/*
 Add page title
 */

document.querySelector("#smart-plug-logo").innerHTML = "<span class='icon-plus'></span>&nbsp;Add plug</h4>";

/*
 Short hand Selector
 */
function select(ele) {
    return document.querySelector(ele);
}

/*
 Variables
 */


/*
 Functions
 */
var shakeForm = function () {
    var plugForm = select("#plugForm");
    plugForm.className = "smart-plug-card-yellow shake animated";
    setTimeout(function () {
        plugForm.className = "smart-plug-card-yellow";
    }, 1000)
};
/*
 check plug ID format or duplicate
 */
function checkPlugID(plugCode) {
    var checkPlugID_deferred = $.Deferred();

    var plugIDRegEx = /^([0-9A-F]{2}:){5}[0-9A-F]{2}$/i;
    if (plugCode.length === 0) {
        checkPlugID_deferred.resolve({status: false, text: "ERROR_REQUIRE_CODE"});
    }
    else if (!plugIDRegEx.test(plugCode)) {
        //Your plug ID is invalid.
        checkPlugID_deferred.resolve({status: false, text: "ERROR_INVALID_CODE"});
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
                    checkPlugID_deferred.resolve({status: false, text: "ERROR_NOT_FOUND_OR_USED"});
                } else {
                    checkPlugID_deferred.resolve({status: true, text: "VERIFY_OK"});
                }
            }
        };
        ajax.send(JSON.stringify({plugCode: plugCode}));
    }
    return checkPlugID_deferred.promise();
}

var validate = function (event) {
    event.preventDefault();
    var plugCode = select("#plugCode"),
        err = select("#err");
    var checkPlugCode_promise = checkPlugID(plugCode.value);
    checkPlugCode_promise.then(function (result) {
        if (result.status && result.text === "VERIFY_OK") {
            err.style.display = "none";
            plugCode.className = "form-control";
            sendPlugToServer();
        } else {
            shakeForm(this);
            plugCode.className += " red-border";
            if (result.text === "ERROR_REQUIRE_CODE") {
                err.innerHTML = "*Require plug code"
            } else if (result.text === "ERROR_INVALID_CODE") {
                err.innerHTML = "Your plug ID is invalid.";
            } else if (result.text === "ERROR_NOT_FOUND_OR_USED") {
                err.innerHTML = "This plug code is already in use or not found.";
            }
            err.style.display = "block";
        }
    });
};

select("#add-more-btn").onclick = function () {
    select("#plugAddSuccessful").style.display = "none";
    select("#plugForm").style.display = "block";
};

/*
 Ajax
 */

function sendPlugToServer() {
    var ajax = new XMLHttpRequest();
    ajax.open("POST", "addPlug.php", true);
    ajax.setRequestHeader("Content-type", "application/json");
    ajax.onreadystatechange = function () {
        if (ajax.readyState ===
            XMLHttpRequest.DONE && ajax.status === 200) {
            var ans = JSON.parse(ajax.responseText);
            if (ans.status) {
                select("#plugAddSuccessful").style.display = "block";
                select("#plugForm").style.display = "none";
                select("#plugName").value = "";
                select("#plugCode").value = "";
                select("#plugLocation").value = "";
            }
        }
    };
    ajax.send(JSON.stringify({
        plugName: select("#plugName").value,
        plugCode: select("#plugCode").value,
        plugLocation: select("#plugLocation").value
    }))
}

/*
 Event
 */
select("#plugForm").addEventListener("submit", validate);

