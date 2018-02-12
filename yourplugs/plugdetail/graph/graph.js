/*
 Add page title
 */

document.querySelector("#smart-plug-logo").innerHTML = "<span class='icon-cord'></span>&nbsp;Outlet " + outlet_number + "</h4>";

window.onload = function () {
    /*
     Check owner plug from api
     */
    //alert(plug_id);
    if (plug_id == -1 || outlet_number == -1) window.location = "../../";

    var cheakPlugOwner = function () {
        var http = new XMLHttpRequest();
        var url = "../../../api/api-plug.php";
        var params = "function=checkPlugOwnerAndNumOfOutlet&plug_id=" + plug_id + "&outlet_number=" + outlet_number;
        http.open("POST", url, true);

        //Send the proper header information along with the request
        http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        http.onreadystatechange = function () {//Call a function when the state changes.
            if (http.readyState == 4 && http.status == 200) {
                var JSONRsponse = JSON.parse(http.responseText);
                if (JSONRsponse.status) {
                    getCurrent();
                } else {
                    //alert("error");
                    window.location = "../../";
                }
            }
        };
        http.send(params);
    };


    //alert("show Graph");

    var getCurrent = function () {
        var http = new XMLHttpRequest();
        var url = "../../../api/api-event.php";
        var params = "function=getCurrent&plug_id=" + plug_id + "&outlet_number=" + outlet_number + "&length=300";
        http.open("POST", url, true);

        //Send the proper header information along with the request
        http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        http.onreadystatechange = function () {//Call a function when the state changes.
            if (http.readyState == 4 && http.status == 200) {
                var JSONRsponse = JSON.parse(http.responseText);
                if (JSONRsponse.status) {
                    //alert("success");
                    genChart(JSONRsponse.lists);
                } else {
                    console.log("error");
                    window.location = "../../";
                }
            }
        };
        http.send(params);
    };

    cheakPlugOwner();


    /*
     Generate HTML from plug
     */

    var htmlRender = "";
    var divNodePlug = document.createElement("div");
    var indexItem = 0;
};