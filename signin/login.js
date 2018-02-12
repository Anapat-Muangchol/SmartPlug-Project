/*
 Short hand Selector
 */
function select(ele) {
    return document.querySelector(ele);
}


/*
 Functions
 */

var togglePassword = function () {
    if (select("#password-signin").type === "password") {
        select("#password-signin").type = "text";
    } else {
        select("#password-signin").type = "password";
    }
};

var signin = function (event) {
    event.preventDefault();
    var emailSignin = select("#email-signin"),
        passwordSignin = select("#password-signin"),
        errEmail = select("#err-email"),
        errPassword = select("#err-password"),
        errSignin = select("#err-signin"),
        remember;

    if (select("#remember-radio").checked) {
        remember = "yes";
    } else {
        remember = "no";
    }

    if (emailSignin.value.length > 0 && passwordSignin.value.length > 0) {
        errEmail.style.display = "none";
        errPassword.style.display = "none";
        var ajax = new XMLHttpRequest();
        ajax.open("POST", "login.php", true);
        ajax.setRequestHeader("Content-type", "application/json");
        ajax.onreadystatechange = function () {
            if (ajax.readyState === XMLHttpRequest.DONE && ajax.status === 200) {
                var ans = JSON.parse(ajax.responseText);
                if (ans.boolean) {
                    // Login successfully
                    errSignin.style.display = "none";
                    location.reload();
                } else {
                    if (ans.detail === "please verify your email.") {
                        errSignin.innerHTML = "Sign in failed. please verify your email.";
                        errSignin.style.display = "block";
                    } else if (ans.detail === "wrong username or password") {
                        errSignin.innerHTML = "Sign in failed. We not found your email or password.";
                        errSignin.style.display = "block";
                    }
                }
            }
        };
        ajax.send(JSON.stringify({
            email: emailSignin.value,
            password: passwordSignin.value,
            remember: remember
        }))
    } else {
        if (emailSignin.value.length < 1) {
            errEmail.style.display = "block";
        }
        if (passwordSignin.value.length < 1) {
            errPassword.style.display = "block";
        }
    }
};

/*
 Events
 */
select("#form-signin").addEventListener("submit", signin);
//Touch Devices
select("#show-password-btn").addEventListener("touchstart", togglePassword);
select("#show-password-btn").addEventListener("touchend", togglePassword);
//Other
select("#show-password-btn").addEventListener("mousedown", togglePassword);
select("#show-password-btn").addEventListener("mouseup", togglePassword);