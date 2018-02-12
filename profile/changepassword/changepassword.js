/*
 Short hand Selector
 */
function select(ele) {
    return document.querySelector(ele);
}
/*
 Add page title
 */
select("#smart-plug-logo").innerHTML = "<span class='icon-key'></span>&nbsp;Change password</h4>";

var shakeForm = function () {
    var changePasswordForm = select("#change-password-form");
    changePasswordForm.className = "smart-plug-card-yellow shake animated";
    setTimeout(function () {
        changePasswordForm.className = "smart-plug-card-yellow";
    }, 1000)
};

var changePassword = function () {
    var oldPassword = select("#old-password"),
        oldPasswordLabel = select("#old-password-label"),
        newPassword = select("#new-password"),
        changePasswordForm = select("#change-password-form"),
        pwChangeSuccessful = select("#password-change-successful");

    var ajax = new XMLHttpRequest(),
        userInput = select("#user-input");
    ajax.open("POST", "changepassword.php", true);
    ajax.setRequestHeader("Content-type", "application/json");
    ajax.onreadystatechange = function () {
        if (ajax.readyState === XMLHttpRequest.DONE && ajax.status === 200) {
            if (ajax.responseText === "true") {
                changePasswordForm.style.display = "none";
                pwChangeSuccessful.style.display = " block";
            } else {
                shakeForm();
                oldPasswordLabel.innerHTML = "Your current password is incorrect.";
                oldPasswordLabel.style.color = "#E91E63";
                oldPassword.style.borderColor = "#E91E63";
            }
        }
    };
    ajax.send(JSON.stringify({old_password: oldPassword.value, new_password: newPassword.value}));
};

var check = function (event) {
    event.preventDefault();
    var oldPassword = select("#old-password"),
        oldPasswordLabel = select("#old-password-label"),
        newPassword = select("#new-password"),
        newPasswordLabel = select("#new-password-label"),
        newPasswordConfirm = select("#new-password-confirm"),
        newPasswordConfirmLabel = select("#new-password-confirm-label"),
        submitBTN = select("#submit-btn"),
        changePasswordForm = select("#change-password-form"),
        errPWText = select("#err-pw-text");

    /*
     Check password security
     */
    function checkSecurity(password) {
        var minRegEx = /.{8,}/g,
            numRegEx = /\d/g, //contain numbers
            notNumRegEx = /[^\d]/g,
            /*
             Password Strength must have
             -number
             -at least 8 character
             -character that not numbers
             */
            passwordReg = /^(?=.*[^\d])(?=.*[\d]).{8,}$/g;

        return passwordReg.test(password);
    }

    var oldPasswordNormal = function () {
        oldPasswordLabel.innerHTML = "Old password";
        oldPasswordLabel.style.color = "";
        oldPassword.style.borderColor = "";
    };
    var oldPasswordError = function () {
        oldPasswordLabel.innerHTML = "Please type your current password.";
        oldPasswordLabel.style.color = "#E91E63";
        oldPassword.style.borderColor = "#E91E63";
    };
    var newPasswordNormal = function () {
        newPasswordLabel.innerHTML = "New password";
        newPasswordLabel.style.color = "";
        newPassword.style.borderColor = "";
    };
    var newPasswordError = function () {
        newPasswordLabel.innerHTML = "What is the new password?";
        newPasswordLabel.style.color = "#E91E63";
        newPassword.style.borderColor = "#E91E63";
    };
    var newPasswordConfirmNormal = function () {
        newPasswordConfirmLabel.innerHTML = "Confirm new password.";
        newPasswordConfirmLabel.style.color = "";
        newPasswordConfirm.style.borderColor = "";
    };
    var newPasswordConfirmError = function () {
        newPasswordConfirmLabel.innerHTML = "Please type your new password again.";
        newPasswordConfirmLabel.style.color = "#E91E63";
        newPasswordConfirm.style.borderColor = "#E91E63";
    };

    if (oldPassword.value.length > 0 && newPassword.value.length > 0 && newPasswordConfirm.value.length > 0) {
        if (newPassword.value === newPasswordConfirm.value) {
            if (checkSecurity(newPasswordConfirm.value)) {
                newPasswordNormal();
                newPasswordConfirmNormal();
                errPWText.style.display = "none";
                changePassword();
            } else {
                shakeForm();
                errPWText.innerHTML = "Your password is too weak.";
                errPWText.style.display = "block";
                newPasswordError();
                newPasswordConfirmError();
            }
        } else {
            shakeForm();
            errPWText.innerHTML = "Your new password doesn't match.";
            errPWText.style.display = "block";
            newPasswordError();
            newPasswordConfirmError();
        }
    } else {
        shakeForm();
        if (oldPassword.value.length < 1) {
            oldPasswordError();
        } else {
            oldPasswordNormal()
        }
        if (newPassword.value.length < 1) {
            newPasswordError();
        } else if (newPassword.value === newPasswordConfirm.value) {
            newPasswordNormal();
        }
        if (newPasswordConfirm.value.length < 1) {
            newPasswordConfirmError();
        } else if (newPassword.value === newPasswordConfirm.value) {
            newPasswordConfirmNormal();
        }
    }
};

/*
 Event
 */
select("#form-panel").addEventListener("submit", check);