var plugID;
/*
 Add page title
 */

document.querySelector("#smart-plug-logo").innerHTML = "<span class='icon-chart3'></span>&nbsp;Summary</h4>"

/*
 Short hand Selector
 */
function select(ele) {
    return document.querySelector(ele);
}

var plug;

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
 Generate plug lists
 */
var htmlRender = "",
    divNodePlug = document.createElement("div"),
    indexItem = 0,
    firstIndex = 0;

var wait = getDetailPlug();
wait.then(function (result) {
    plug = result;
    if (plug.status) {
        htmlRender += "<form>";
        plug.lists.forEach(function (item, index) {
            console.log(index);
            indexItem++;
            htmlRender +=
                "<label class='plug-label' for='plug-radio-" + item.plug_id + "'>" +
                "<div id='plug-" + item.plug_id + "' class='panel plug gradient-bg'>" +
                "<div class='panel-body'>" +
                "<input type='radio' onchange='selectPlug(this)' data-plug-id='" + item.plug_id + "' class='plug-radio' name='plugs' id='plug-radio-" + item.plug_id + "' value='" + item.plug_id + "' ";
            if (index === 0) {
                firstIndex = item.plug_id;
                plugID = item.plug_id;
                htmlRender += "checked";
            }
            htmlRender +=
                "><b>" + indexItem + " : " + item.plug_name + " at " + item.plug_location + "</b>" +
                "</div>" +
                "</div>" +
                "</label>";
        });
        htmlRender += "</form>";


        divNodePlug.innerHTML = htmlRender;
        childLength = divNodePlug.children.length;

        if (htmlRender) {
            for (var child = 0; child < childLength; child++) {
                document.getElementById('plug-render').appendChild(divNodePlug.firstChild);
            }
            document.querySelectorAll(".plug")[0].style.background = "linear-gradient(45deg, #03A9F4 0%, #673AB7 100%)";
            
            $.post("../api/api-outlet.php",
                    {
                        function: "getAllOutletInPlug",
                        plug_id: document.querySelectorAll(".plug")[0].firstChild.firstChild.getAttribute("data-plug-id")
                    }
                    , function (data, status) {
                        if (status === "success") {
                            data = JSON.parse(data);

                            var sOutlet = "<option value='all'>All outlet</option>";
                            if (data.lists.length > 0) {
                                for(var i=1;i<=data.plug_num_of_outlets;i++){
                                    sOutlet += "<option  value="+i+">outlet "+i+"</option>";
                                }
                            }
                            
                                select("#select-outlets").innerHTML = sOutlet;
                        }
                    }
                )

        }
        getData();

    } else {
        alert("Can't query from database.");
    }
});

/*
 Graph
 */
var drawGraph = function (result) {

    function generatechartData(data) {
        var chartData = [];

        for (var i = 0; i < data.lists.length; i++) {
            chartData.push({
                "category" : data.lists[i].sum_month_time.substring(8, 10),
                "column-1" : data.lists[i].sum_month_current
            });
        }
        return chartData;
    }

    var chartData = generatechartData(result);

    var chart = AmCharts.makeChart("chartdiv", {    
        "type": "serial",
        "categoryField": "category",
        "startDuration": 1,
        "color": "#F09090",
        "theme": "black",
        "export": {
            "enabled": true
        },
        "categoryAxis": {
            "gridPosition": "start"
        },
        "chartCursor": {
            "enabled": true,
            "categoryBalloonText": "Day [[category]]"
        },
        "chartScrollbar": {
            "enabled": true
        },
        "trendLines": [],
        "graphs": [
            {
                "balloonText": "[[value]] A",
                "id": "AmGraph-1",
                "lineColor": "#FFFF00",
                "tabIndex": -1,
                "title": "graph 1",
                "type": "smoothedLine",
                "valueField": "column-1"
            }
        ],
        "guides": [],
        "valueAxes": [
            {
                "id": "ValueAxis-1",
                "title": ""
            }
        ],
        "allLabels": [],
        "balloon": {
            "cornerRadius": 2
        },
        "titles": [
            {
                "color": "#FFFF00",
                "id": "Title-1",
                "size": 15,
                "text": "usaged :: 20 units"
            }
        ], "dataProvider": chartData
        });

};


/*Generate summary info*/
var getData = function () {

    var d = new Date();

    var month = d.getMonth() + 1;

    var year = d.getFullYear();

    console.log("ID : "+plugID + " MONTH : "+month + " YEAR : "+year);

    $.post("../api/api-event.php",
        {
            function: "getSummary",
            plug_id: plugID,
            outlet_number: "all",
            month: month,
            year: year
        }
        , function (data, status) {
            if (status === "success") {
                data = JSON.parse(data);
                console.log(data.lists.length);
                drawGraph(data);
            }
        }

    )
};


var getCurrent = function (data) {

    var outlet = document.getElementById("select-outlets");
    var outletValue = outlet.options[outlet.selectedIndex].value;

    var month = document.getElementById("select-month");
    var monthValue = month.options[month.selectedIndex].value;

    var year = document.getElementById("select-year");
    var yearValue = year.options[year.selectedIndex].value;

    console.log("ID : "+plugID + " OUTLET : "+outletValue + " MONTH : "+monthValue + " YEAR : "+yearValue);

    $.post("../api/api-event.php",
        {
            function: "getSummary",
            plug_id: plugID,
            outlet_number: outletValue,
            month: monthValue,
            year: yearValue
        }
        , function (data, status) {
            if (status === "success") {
                data = JSON.parse(data);
                console.log(data.lists.length);
                drawGraph(data);
            }
        }

    )
};

/*User select a plug*/
var selectPlug = function (ele) {
    var plug = document.querySelectorAll(".plug").length;
        plugID = ele.getAttribute("data-plug-id");

    for (var index = 0; index < plug; index++) {
        if (document.querySelectorAll(".plug-radio")[index].getAttribute("data-plug-id") === plugID) {
            ele.parentNode.parentNode.style.background = "linear-gradient(45deg, #03A9F4 0%, #673AB7 100%)";
        } else {
            document.querySelectorAll(".plug")[index].style.background = "";
        }
    }

    
                $.post("../api/api-outlet.php",
                    {
                        function: "getAllOutletInPlug",
                        plug_id: plugID
                    }
                    , function (data, status) {
                        if (status === "success") {
                            data = JSON.parse(data);

                            var sOutlet = "<option value='all'>All outlet</option>";
                            if (data.lists.length > 0) {
                                for(var i=1;i<=data.plug_num_of_outlets;i++){
                                    sOutlet += "<option value="+i+">outlet "+i+"</option>";
                                }
                            }
                            
                                select("#select-outlets").innerHTML = sOutlet;
                        }
                    }
                )
            

};


