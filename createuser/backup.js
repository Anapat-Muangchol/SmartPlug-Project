'use strict';

// Loading
$(function () {
    $(".loading-wrapper").fadeOut(2000);
});

/*
 Short hand Selector
 */
function createuser(ele) {
    return document.querySelector(ele);
}

/*
 Variables
 */
var q_id = 0,
    text_count = 0,
    isAsk = false,
    old_input,
    email_old,
    email_confirm_count = 0,
    password_confirm_count = 0;

/*
 Can not be modify
 */
var FREEZE = (function () {
    var onlyMe = {
        'NO_USER_DATA': 's4+K'
    };

    return {
        get: function (name) {
            return onlyMe[name];
        }
    }
})();

var userAnswer =
    {
        fname: undefined,
        lname: undefined,
        e_mail: undefined,
        pw: undefined,
        plugID: undefined,
        tel_phone: undefined
    };

/*
 chat message
 */
var message = {

    intro: {
        m_id: 0,
        text: [
            "First of all thank you for joining smartplug",
            "I will ask you some questions.",
            "Type the answers in the boxes below.",
            "Let's begin."
        ]
    }
    ,
    askFirstname: {
        m_id: 1,
        text: [
            "First, what's your first name?"
        ]
    },
    askLastname: {
        m_id: 2,
        text: [
            "and... your last name?"
        ]
    }
    ,
    askEmail: {
        m_id: 3,
        text: [
            "OK, what's your email address?",
            "Make sure you type it in correctly. Please type the email again.",
            "If you want to change the email.",
            "just type the new one below.",
            "If the email is now correct. please press enter.",
            "Now you will have to confirm the new email.",
            "Type it again.",
            "Great!, You can use this email for signing now."
        ]
    }
    ,
    askPassword: {
        m_id: 4,
        text: [
            "And a password for signing in.",
            "Type it again, please."
        ]
    }
    , askPlugID: {
        m_id: 5,
        text: [
            "Do have a plug ID?",
            "Type it below or press enter to skip."
        ]
    }
    ,
    askTelephoneNumber: {
        m_id: 6,
        text: [
            "It's done now, but if you want to add a phone number",
            "you can fill it in below.",
            "With the phone number, we could reach you when you need support.",
            "Just press enter if you don't have a phone number or you want to do it later,",
            "or you just don't want to."
        ]
    }
    ,
    tellUserEditLater: {
        m_id: 7,
        text: [
            "You can edit almost of the information later in select page."
        ]
    }
    ,
    createAccount: {
        m_id: 8,
        text: [
            "I'm creating your account...",
            "Your account is ready.",
            "Thanks again! for joining smartplug :)",
            "You will redirect in a few seconds if not click the button below."
        ]
    }
};

/*
 Review user's information messages
 */
var userInfoMessage = [
    "This is the information you gave me.",
    "First Name: ",
    "Last Name: ",
    "Email: ",
    "Password: " + "<span style='color: #FFEB3B;'>" + " I don't show password " + "</span>",
    "Plug ID: ",
    "Your phone number is "
];

/*
 Functions
 */

function scrollButtom() {
    var chatDiv = createuser("#chat-div");
    chatDiv.scrollTop = chatDiv.scrollHeight;
}

function showPassword() {
    var iconEye = createuser("#i-icon-eye"),
        userInput = createuser("#user-input");
    iconEye.className = "fa fa-eye eye-toggle-password";
    userInput.type = "text";
}

function hidePassword() {
    var iconEye = createuser("#i-icon-eye"),
        userInput = createuser("#user-input");
    iconEye.className = "fa fa-eye-slash eye-toggle-password";
    userInput.type = "password";
}

/*
 Add messages to the screen
 */
function addMessage(text) {
    var chatBox = createuser("#chats-box");
    chatBox.appendChild(text);
}

/*
 render messages
 */

function messageOut(text) {
    var message = document.createElement("li");
    message.className += "out";
    message.style.clear = "both";
    message.innerHTML = "<div class='message'>" +
        "<p class='inffo'>" +
        text +
        "</p>" +
        "</div>";
    return message;
}

function messageIn(text) {
    var message = document.createElement("li");
    message.className += "in";
    message.style.clear = "both";
    message.innerHTML = "<div class='message'>" +
        "<p class='inffo'>" +
        text +
        "</p>" +
        "</div>";
    return message;
}

/*
 Check password security
 */
function checkSecurity(password) {
    var minReg = /.{8,}/g,
        numReg = /\d/g, //contain numbers
        notNumReg = /[^\d]/g,
        /*
         Password Strength must have
         -number
         -at least 8 character
         -character that not numbers
         */
        passwordReg = /^(?=.*[^\d])(?=.*[\d]).{8,}$/g;

    if (!passwordReg.test(password)) {
        addMessage(messageIn("Your password is too weak."));
        if (!minReg.test(password)) {
            addMessage(messageIn("It must contain at least 8 characters."));
        }
        if (!numReg.test(password)) {
            addMessage(messageIn("It must contain numbers."));
        }
        if (!notNumReg.test(password)) {
            addMessage(messageIn("It must contain characters."));
        }
        return false;
    }
    return true;
}

/*
 Check email format
 */
function checkEmail(email) {
    var deferred = $.Deferred();
    var emailReg = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if (!emailReg.test(email)) {
        addMessage(messageIn("Your email is invalid."));
        if (/^@/.test(email)) {
            addMessage(messageIn("You must have something before \"@\"."));
        } else if (/@$/.test(email)) {
            addMessage(messageIn("You must have something after \"@\"."));
        } else if (!/@/.test(email)) {
            addMessage(messageIn("You must have \"@\"."));
        }
        return false;
    } else {
        /*
         check duplicate email
         */
        var ajax = new XMLHttpRequest(),
            userInput = createuser("#user-input");
        ajax.open("POST", "isfoundemail.php", true);
        ajax.setRequestHeader("Content-type", "application/json");
        ajax.onreadystatechange = function () {
            if (ajax.readyState === XMLHttpRequest.DONE && ajax.status === 200) {
                if (ajax.responseText === "true") {
                    addMessage(messageIn("This email is already in use."));
                    scrollButtom();
                    return false
                }
                return true;
            }
        };
        ajax.send(JSON.stringify({e_mail: email}));
        scrollButtom();
    }
    return deferred.promise();
}

/*
 Check thailand telephone format
 */
function checkTelTH(tel) {
    var minReg = /^[0-9]{10}$/g, // 10 digits
        numReg = /^[0-9]+$/g, //only number
        begin = /^[0]/g, //begin with 0
        telReg = /^[0]+[0-9]{9}$/g;
    if (!telReg.test(tel)) {
        addMessage(messageIn("Your phone number is invalid."));
        if (!numReg.test(tel)) {
            addMessage(messageIn("It must be numbers without \"-\" or \" \"."));
        }
        if (!begin.test(tel)) {
            addMessage(messageIn("It must begin with \"0\"."));
        }
        if (!minReg.test(tel)) {
            addMessage(messageIn("It must have 10 digits."));
        }
        return false;
    }
    return true;
}

/*
 Welcome message for user
 */
(function intro() {
    var k = 0,
        chatBox = createuser("#chats-box"),
        welcomeMessage = setInterval(function () {
            if (k === message.intro.text.length) {
                clearInterval(welcomeMessage);
                //console.log("clear!");
                askFirstname();
            } else {
                addMessage(messageIn(message.intro.text[k]));
            }
            //console.log(k);
            k++;
            scrollButtom();
        }, 1000);
})();

/*
 Questions
 */

/*
 ask First name
 */
var askFirstname = function () {
    var userInput = createuser("#user-input");
    if (isAsk) {
        isAsk = false;
        userAnswer.fname = userInput.value;
        //MOVE TO LAST NAME
        askLastname();
    } else {
        addMessage(messageIn(message.askFirstname.text[0]));
        userInput.value = "";
        userInput.disabled = false;
        userInput.placeholder = "Type your first name...";
        userInput.focus();
        scrollButtom();
        isAsk = true;
    }
};

/*
 ask Last name
 */
var askLastname = function () {
    var userInput = createuser("#user-input");
    if (isAsk) {
        isAsk = false;
        userAnswer.lname = userInput.value;
        //MOVE TO EMAIL
        askEmail();
    } else {
        setTimeout(function () {
            addMessage(messageIn(message.askLastname.text[0]));
            userInput.value = "";
            userInput.disabled = false;
            userInput.placeholder = "Type your last name...";
            userInput.focus();
            scrollButtom();
        }, 1000);
        isAsk = true;
    }
};

/*
 ask Email
 */
var askEmail = function () {
    var userInput = createuser("#user-input");
    if (isAsk) {
        var promise = checkEmail(userInput.value);
        promise.then(function (result) {

        });
        if (checkEmail(userInput.value)) {
            old_input = old_input || userInput.value;
            if (old_input === userInput.value) {
                email_confirm_count++;
                if (email_confirm_count > 1) {
                    email_confirm_count = 0;
                    old_input = undefined;
                    email_old = userInput.value;
                    setTimeout(function () {
                        addMessage(messageIn(message.askEmail.text[2]));
                        scrollButtom();
                    }, 1000);
                    setTimeout(function () {
                        addMessage(messageIn(message.askEmail.text[3]));
                        scrollButtom();
                    }, 2000);
                    setTimeout(function () {
                        addMessage(messageIn(message.askEmail.text[4]));
                        userInput.value = "";
                        userInput.disabled = false;
                        userInput.placeholder = "type new email or press enter";
                        userInput.focus();
                        scrollButtom();
                    }, 3000);
                } else {
                    askEmailAgain();
                }
            } else {
                setTimeout(function () {
                    addMessage(messageIn("Your emails don't match. Please try again."));
                    userInput.disabled = false;
                    userInput.focus();
                    scrollButtom();
                }, 1000);
            }
        } else {
            userInput.disabled = false;
            userInput.focus();
            scrollButtom();
        }
    } else {
        setTimeout(function () {
            addMessage(messageIn(message.askEmail.text[0]));
            userInput.value = "";
            userInput.disabled = false;
            userInput.placeholder = "example \"john.satina@kop.com\"";
            userInput.focus();
            scrollButtom();
        }, 1000);
        isAsk = true;
    }
};

/*
 ask Email again
 */
var askEmailAgain = function () {
    var userInput = createuser("#user-input");

    if (email_old) {
        email_old = undefined;
        setTimeout(function () {
            addMessage(messageIn(message.askEmail.text[5]));
            scrollButtom();
        }, 1000);
        setTimeout(function () {
            addMessage(messageIn(message.askEmail.text[6]));
            scrollButtom();
        }, 2000);
    } else {
        addMessage(messageIn(message.askEmail.text[1]));
    }
    userInput.value = "";
    userInput.disabled = false;
    userInput.placeholder = "Type the email again...";
    userInput.focus();
    scrollButtom();

};

/*
 ask password
 */
var askPassword = function () {
    var userInput = createuser("#user-input");
    var iconEye = createuser("#i-icon-eye");
    if (isAsk) {
        if (checkSecurity(userInput.value)) {
            old_input = old_input || userInput.value;

            if (old_input === userInput.value) {
                password_confirm_count++;
                if (password_confirm_count > 1) {
                    userAnswer.pw = userInput.value;
                    password_confirm_count = 0;
                    /*
                     Remove event that has been attached with the addEventListener() method
                     because it will never be used anymore
                     */
                    iconEye.parentNode.removeEventListener("mousedown", showPassword);
                    iconEye.parentNode.removeEventListener("mouseup", hidePassword);
                    userInput.value = "";
                    userInput.type = "text";

                    userInput.parentNode.className = "";
                    createuser("#span-icon-eye").parentNode.removeChild(createuser("#span-icon-eye"));
                    isAsk = false;
                    //MOVE TO PLUG ID
                    askPlugID();
                } else {
                    //MOVE TO repeat PASSWORD
                    askPasswordAgain();
                }
            } else {
                setTimeout(function () {
                    addMessage(messageIn("your password doesn't match. try again"));
                    userInput.value = "";
                    userInput.disabled = false;
                    userInput.focus();
                    scrollButtom();
                }, 1000);
            }
        } else {
            userInput.disabled = false;
            userInput.focus();
            scrollButtom();
        }
    } else {
        setTimeout(function () {
            addMessage(messageIn(message.askPassword.text[0]));
            userInput.type = "password";
            userInput.parentNode.className = "input-group";


            iconEye.className = "fa fa-eye-slash eye-toggle-password";
            iconEye.style.fontSize = "1.5em";
            iconEye.setAttribute('aria-hidden', 'true');

            createuser("#span-icon-eye").style.display = "table-cell";
            userInput.value = "";
            userInput.disabled = false;
            userInput.placeholder = "Type your password...";
            userInput.focus();
            scrollButtom();
        }, 2000);
        isAsk = true;
    }

};

/*
 ask password again
 */
var askPasswordAgain = function () {
    var userInput = createuser("#user-input");
    addMessage(messageIn(message.askPassword.text[1]));
    userInput.value = "";
    userInput.disabled = false;
    userInput.placeholder = "Type the password again...";
    userInput.focus();
    scrollButtom();
};

/*
 ask Plug ID
 */
var askPlugID = function () {
    var userInput = createuser("#user-input");
    if (isAsk) {
        isAsk = false;
        userAnswer.plugID = userInput.value;
        userInput.value = "";
        //MOVE TO TEL PHONE
        askTelephoneNumber();
    } else {
        setTimeout(function () {
            addMessage(messageIn(message.askPlugID.text[0]));
            scrollButtom();
        }, 1000);
        setTimeout(function () {
            addMessage(messageIn(message.askPlugID.text[1]));
            userInput.disabled = false;
            userInput.placeholder = "Type plug ID or press enter.";
            userInput.focus();
            scrollButtom();
        }, 2000);
        isAsk = true;
    }
};

/*
 ask Telephone number
 */
var askTelephoneNumber = function () {
    var userInput = createuser("#user-input");
    if (isAsk) {
        if (checkTelTH(userInput.value)) {
            isAsk = false;
            userAnswer.tel_phone = userInput.value;
            //REVIEW
            reviewUserInfo(sendDataToServer);
        } else {
            userInput.disabled = false;
            userInput.focus();
            scrollButtom();
        }
    } else {
        var k = 0;
        var telMessage = message.askTelephoneNumber.text;
        var runner = setInterval(function () {
            if (k === telMessage.length) {
                clearInterval(runner);
                userInput.disabled = false;
                userInput.placeholder = "Type phone number(081 xxx xxxx) or press enter.";
                userInput.focus();
            } else {
                addMessage(messageIn(telMessage[k]));
                scrollButtom();
            }
            k++;
        }, 1000);
        isAsk = true;
    }
};

/*
 Review user's information
 */
var reviewUserInfo = function (callback) {
    if (typeof callback === 'undefined' || callback === null) {
        callback = function () {
        };
    }
    var text_count = 0;
    var review = setInterval(function () {
        if (text_count === 0) {
            addMessage(messageIn(userInfoMessage[0]));
        } else if (text_count === 1) {
            addMessage(messageIn(
                //Show First name
                userInfoMessage[1] + "<span style='color: #FFEB3B;'>" + userAnswer.fname + "</span>" + "<br>" +
                //Show Last Name
                userInfoMessage[2] + "<span style='color: #FFEB3B;'>" + userAnswer.lname + "</span>" + "<br>" +
                //Show Email
                userInfoMessage[3] + "<span style='color: #FFEB3B;'>" + userAnswer.e_mail + "</span>" + "<br>" +
                //Show Password(Not really)
                userInfoMessage[4] + "<br>"
            ));
        } else if (text_count === 2) {
            if (userAnswer.plugID === FREEZE.get("NO_USER_DATA")) {
                addMessage(messageIn("You have no plug ID yet."));
            } else {
                //Show Plug ID
                addMessage(messageIn("Your plug ID is " + "<span style='color: #FFEB3B;'>" + userAnswer.plugID + "</span>"));
            }
        } else if (text_count === 3) {
            //Show telephone number
            if (userAnswer.tel_phone === FREEZE.get("NO_USER_DATA")) {
                addMessage(messageIn("You haven't given a phone number"));
            } else {
                addMessage(messageIn(userInfoMessage[6] + "<span style='color: #FFEB3B;'>" + userAnswer.tel_phone + "</span>"));
            }
        } else if (text_count === 4) {
            addMessage(messageIn(message.tellUserEditLater.text[0]))
        }
        if (text_count === 5) {
            clearInterval(review);
            callback();
        } else {
            createuser("#user-input").disabled = true;
        }

        scrollButtom();
        text_count++;
    }, 1000)
};

// Register
var sendDataToServer = function () {

    addMessage(messageIn(message.createAccount.text[0]));
    /*
     Ajax
     */
    var ajax = new XMLHttpRequest(),
        userInput = createuser("#user-input");
    ajax.open("POST", "createuser.php", true);
    ajax.setRequestHeader("Content-type", "application/json");
    ajax.onreadystatechange = function () {
        if (ajax.readyState === XMLHttpRequest.DONE && ajax.status === 200) {
            addMessage(messageIn(message.createAccount.text[1]));
            scrollButtom();
            setTimeout(function () {
                addMessage(messageIn(message.createAccount.text[2]));
                scrollButtom();
            }, 1000);
            setTimeout(function () {
                addMessage(messageIn(message.createAccount.text[3]));
                //location.assign("../yourplugs");

                //create a tag
                var a_tag = document.createElement("a");
                a_tag.href = "../yourplugs";
                a_tag.className = "btn btn-red";
                a_tag.style.display = "block";
                a_tag.innerHTML = "Go to your plugs";

                createuser("#message-input").removeEventListener("submit", messageProcessor);
                userInput.parentNode.appendChild(a_tag);
                userInput.parentNode.removeChild(userInput);
                scrollButtom();
            }, 2000);

        }
    };
    ajax.send(JSON.stringify(userAnswer));
    scrollButtom();
};

/*
 User enters messages
 */

var messageProcessor = function (event) {
    var userInput = createuser("#user-input");
    event.preventDefault();

    if (userInput.value) {
        userInput.disabled = true;

        if (userInput.type === "password") {
            /* Generate dummy password ▙▛▞▟▚▛▞▙ */
            var p_txt = "",
                p_gen = undefined,
                passwordLength = userInput.value.length;
            var passwordCensor = [
                "▙",
                "▚",
                "▛",
                "▜",
                "▞",
                "▟"
            ];
            for (var i = 0; i < passwordLength; i++) {
                p_txt += passwordCensor[Math.floor((Math.random() * 6))];
                if (i === passwordLength - 1) {
                    p_gen = true;
                }
                //console.log(p_txt);
            }
            if (p_gen) {
                addMessage(messageOut(p_txt));
                scrollButtom();
                p_gen = null;
            }
        } else {
            addMessage(messageOut(userInput.value));
        }
        scrollButtom();

        if (!userAnswer.fname) {
            askFirstname();
        } else if (!userAnswer.lname) {
            askLastname();
        } else if (!userAnswer.e_mail) {
            askEmail();
        } else if (!userAnswer.pw) {
            askPassword();
        } else if (!userAnswer.plugID) {
            askPlugID();
        } else if (!userAnswer.tel_phone) {
            askTelephoneNumber();
        }
    } else if (email_old) {
        setTimeout(function () {
            addMessage(messageIn(message.askEmail.text[message.askEmail.text.length - 1]));
            scrollButtom();
        }, 1000);
        isAsk = false;
        userAnswer.e_mail = email_old;
        email_old = undefined;
        userInput.disabled = true;
        askPassword();
    } else if (userAnswer.fname && userAnswer.lname && userAnswer.e_mail && userAnswer.pw) {
        if (!userAnswer.plugID) {
            isAsk = false;
            userAnswer.plugID = FREEZE.get('NO_USER_DATA');
            userInput.disabled = true;
            askTelephoneNumber();
        } else if (!userAnswer.tel_phone) {
            isAsk = false;
            userAnswer.tel_phone = FREEZE.get('NO_USER_DATA');
            userInput.disabled = true;
            reviewUserInfo(sendDataToServer);
        }
    }

};

/*
 Events
 */

createuser("#message-input").addEventListener("submit", messageProcessor);
createuser("#i-icon-eye").parentNode.addEventListener("mousedown", showPassword);
createuser("#i-icon-eye").parentNode.addEventListener("mouseup", hidePassword);