document.addEventListener("DOMContentLoaded", function (event) {
    // Hide the login form
    var loginForm = document.getElementById('loginform');
    if (loginForm) {
        loginForm.style.display = 'none';
    }
    var nav = document.getElementById('nav');
    if (nav) {
        nav.style.display = 'none';
    }
    var backtoblog = document.getElementById('backtoblog');
    if (backtoblog) {
        backtoblog.style.display = 'none';
    }

    // Create login wrapper div
    var loginWrapper = document.createElement('div');
    loginWrapper.id = 'login-wrapper';

    // Create OTP login form
    var otpLoginForm = document.createElement('form');
    otpLoginForm.id = 'otp-login-form';

    var emailInput = document.createElement('input');
    emailInput.type = 'email';
    emailInput.name = 'user_email';
    emailInput.classList.add('input');
    emailInput.placeholder = 'Enter your email';
    emailInput.required = true;
    otpLoginForm.appendChild(emailInput);

    var nonceInput = document.createElement('input');
    nonceInput.type = 'hidden';
    nonceInput.name = 'user_verification_otp_nonce';
    nonceInput.value = user_verification_scripts_login.nonce;
    otpLoginForm.appendChild(nonceInput);

    var sendOtpBtn = document.createElement('button');
    sendOtpBtn.type = 'button';
    sendOtpBtn.classList.add('button');
    sendOtpBtn.innerText = 'Send OTP';
    otpLoginForm.appendChild(sendOtpBtn);

    var otpInput = document.createElement('input');
    otpInput.type = 'text';
    otpInput.name = 'otp';
    otpInput.placeholder = 'Enter OTP';
    otpInput.style.display = 'none';
    otpLoginForm.appendChild(otpInput);

    var loginBtn = document.createElement('button');
    loginBtn.type = 'button';
    loginBtn.innerText = 'Login';
    loginBtn.classList.add('button');
    loginBtn.style.display = 'none';
    otpLoginForm.appendChild(loginBtn);

    // Create the message wrapper and append it inside the form
    var messageWrap = document.createElement('div');
    messageWrap.id = 'user_verification-message';
    loginWrapper.appendChild(messageWrap); // Message now appears inside the form

    // Append OTP form inside login wrapper
    loginWrapper.appendChild(otpLoginForm);

    // Create and append the login navigation inside login wrapper
    var loginNav = document.createElement('div');
    loginNav.id = 'login_nav';

    var navP = document.createElement('p');
    navP.id = 'login_nav_items';

    var baseUrl = window.location.origin + "/wp-login.php?action=";

    var registerLink = document.createElement('a');
    registerLink.className = 'wp-login-register';
    registerLink.href = baseUrl + 'register';
    registerLink.innerText = 'Register';
    navP.appendChild(registerLink);

    navP.innerHTML += ' | ';

    var lostPasswordLink = document.createElement('a');
    lostPasswordLink.className = 'wp-login-lost-password';
    lostPasswordLink.href = baseUrl + 'lostpassword';
    lostPasswordLink.innerText = 'Lost your password?';
    navP.appendChild(lostPasswordLink);

    loginNav.appendChild(navP);

    var backToBlogP = document.createElement('p');
    backToBlogP.id = 'login_backtoblog';
    var backToBlogLink = document.createElement('a');
    backToBlogLink.href = window.location.origin;
    backToBlogLink.innerText = '← Go to User Verification';
    backToBlogP.appendChild(backToBlogLink);
    loginNav.appendChild(backToBlogP);

    loginWrapper.appendChild(loginNav);

    // Append login wrapper to body
    document.body.appendChild(loginWrapper);

    // OTP Send button event listener
    sendOtpBtn.addEventListener('click', function () {
        var email = emailInput.value.trim();
        if (!email) {
            messageWrap.innerHTML = 'Email should not be empty';
            return;
        }

        messageWrap.innerHTML = '<i class="fas fa-spin fa-spinner"></i>';

        jQuery.ajax({
            type: 'POST',
            url: user_verification_scripts_login.ajax_url,
            data: {
                "action": "user_verification_send_otp",
                'user_login': email,
                'nonce': nonceInput.value,
            },
            success: function (response) {
                try {
                    var data = JSON.parse(response);
                    if (data.error) {
                        messageWrap.innerHTML = data.error;
                    } else {
                        messageWrap.innerHTML = data.success_message;
                        otpInput.style.display = 'block';
                        loginBtn.style.display = 'block';
                        sendOtpBtn.style.display = 'none';
                    }
                } catch (error) {
                    messageWrap.innerHTML = "Unexpected response from server.";
                }
            }
        });
    });

    // Login button event listener
    loginBtn.addEventListener('click', function () {
        var email = emailInput.value.trim();
        var otp = otpInput.value.trim();

        if (!email || !otp) {
            messageWrap.innerHTML = 'Email and OTP should not be empty';
            return;
        }

        messageWrap.innerHTML = '<i class="fas fa-spin fa-spinner"></i>';

        jQuery.ajax({
            type: 'POST',
            url: user_verification_scripts_login.ajax_url,
            data: {
                "action": "user_verification_auth_otp",
                'user_login': email,
                'otp': otp,
                'nonce': nonceInput.value,
            },
            success: function (response) {
                try {
                    var data = JSON.parse(response);
                    if (data.error) {
                        messageWrap.innerHTML = data.error;
                    } else {
                        messageWrap.innerHTML = data.success_message;
                        window.location.href = '/';
                    }
                } catch (error) {
                    messageWrap.innerHTML = "Unexpected response from server.";
                }
            }
        });
    });

    // Adjust form visibility based on URL
    function adjustFormVisibility() {
        var currentUrl = window.location.href;

        var loginForm = document.getElementById('loginform');
        var nav = document.getElementById('nav');
        var backtoblog = document.getElementById('backtoblog');

        var otpLoginForm = document.getElementById('otp-login-form');
        var loginNav = document.getElementById('login_nav');

        if (currentUrl.includes('action=lostpassword') || currentUrl.includes('action=register')) {
            if (loginForm) loginForm.style.display = 'block';
            if (nav) nav.style.display = 'block';
            if (backtoblog) backtoblog.style.display = 'block';

            if (otpLoginForm) otpLoginForm.style.display = 'none';
            if (loginNav) loginNav.style.display = 'none';
        } else {
            if (otpLoginForm) otpLoginForm.style.display = 'block';
            if (loginNav) loginNav.style.display = 'block';

            if (loginForm) loginForm.style.display = 'none';
            if (nav) nav.style.display = 'none';
            if (backtoblog) backtoblog.style.display = 'none';
        }
    }

    adjustFormVisibility();
    window.addEventListener('popstate', adjustFormVisibility);
    window.addEventListener('hashchange', adjustFormVisibility);
});