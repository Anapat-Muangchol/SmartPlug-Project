/*
 Short hand Selector
 */
function select(ele) {
    return document.querySelector(ele);
}

/*
 Add page title
 */
select("#smart-plug-logo").innerHTML = "<span class='icon-plus'></span>&nbsp;Profile</h4>";

/*
 Function
 */
function validForm() {
    var fname = select("#fname"),
        lname = select("#lname"),
        tel = select("#tel"),
        valid = true;
    if (fname.value.length <= 0) {
        console.log("what is your first name?");
        select("#fname-label").innerHTML = "what is your first name?";
        valid = valid && false;
    }
    if (lname.value.length <= 0) {
        console.log("what is your last name?");
        select("#lname-label").innerHTML = "what is your last name?";
        valid = valid && false;
    }
    select("#submit-btn").disabled = !valid;
    return valid;
}

/*
 Events
 */

select("#edit-btn").addEventListener("click", function () {
    console.log("click");
    select("#editable-user-form").style.display = "block";
    select("#view-user").style.display = "none";
});
select("#fname").addEventListener("input", validForm);
select("#lname").addEventListener("input", validForm);
select("#form-panel").addEventListener("submit", function () {
    event.preventDefault();
    if (validForm()) {
        sendEditToServer();
    }
});

/*
 Ajax
 */
function sendEditToServer() {
    var ajax = new XMLHttpRequest();
    ajax.open("POST", "profile.php", true);
    ajax.setRequestHeader("Content-type", "application/json");
    ajax.onreadystatechange = function () {
        if (ajax.readyState === XMLHttpRequest.DONE && ajax.status === 200) {
            location.reload();
        }
    };
    ajax.send(JSON.stringify({
        fname: select("#fname").value,
        lname: select("#lname").value,
        tel: select("#tel").value
    }))
}