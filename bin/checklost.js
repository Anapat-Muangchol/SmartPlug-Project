var hostReachable = function () {

    // Handle IE and more capable browsers
    var xhr = new ( window.ActiveXObject || XMLHttpRequest )("Microsoft.XMLHTTP");
    var status;

    // Open new request as a HEAD to the root hostname with a random param to bust the cache
    xhr.open("HEAD", "//" + window.location.hostname + "/?rand=" + Math.floor((1 + Math.random()) * 0x10000), false);

    // Issue request and handle response
    try {
        xhr.send();
        return ( xhr.status >= 200 && xhr.status < 300 || xhr.status === 304 );
    } catch (error) {
        return false;
    }

};

var stillOnline = true;
var stillOffline = false;
var iconEarth = "<span class='icon-earth' style='color: #00ff8b'></span>";
var iconFlash = "<span class='icon-flash' style='color: #ff0000'></span>";
setInterval(function () {
    var inCon = document.querySelector("#in-con");
    if (hostReachable()) {
        if (!stillOnline) {
            stillOnline = true;
            stillOffline = false;
            inCon.style.borderColor = "#149a48";
            inCon.className = "internet-connection internet-connection-change";
            inCon.innerHTML = "<div>" +
                "<p>" + iconEarth + "&nbsp;ONLINE</p>" +
                "</div>";
            setTimeout(function () {
                inCon.className = "internet-connection";
            }, 1000);
        }
    } else {
        if (!stillOffline) {
            stillOnline = false;
            stillOffline = true;
            lost = true;
            inCon.style.borderColor = "#9a1414";
            inCon.className = "internet-connection internet-connection-change";
            inCon.innerHTML = "<div>" +
                "<p>" + iconFlash + "&nbsp;OFFLINE</p>" +
                "</div>";
        }
    }
}, 3000);