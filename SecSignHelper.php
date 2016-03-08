<?php

include ('secsign-jsapi/phpApi/SecSignIDApi.php');

class SecSignHelper {

    public function buildLoginForm($title, $path, $layout)
    {
        $output = $this->includeCSS();
        $output .= $this->includeParams($title, $path, $layout);
        $output .= $this->includeJS();
        $output .= $this->printForm();

        return $output;
    }

    public function validateLogin($post)
    {
        // Create a new session instance, which is needed to check its status.
        $status = false;
        $authsessionStatus = false;
        $authsession = new AuthSession();
        $authsession->createAuthSessionFromArray(array(
            'requestid' => $_POST['secsignidrequestid'],
            'secsignid' => $_POST['secsigniduserid'],
            'authsessionid' => $_POST['secsignidauthsessionid'],
            'servicename' => $_POST['secsignidservicename'],
            'serviceaddress' => $_POST['secsignidserviceaddress']
        ));
        $secSignIDApi = new SecSignIDApi();

        try {
            $authsessionStatus = $secSignIDApi->getAuthSessionState($authsession); // just ask the server for the status. this returns immediately
        } catch (Exception $e) {
            $status = 'SecSign ID login error: ' . $e->getMessage();
        }

        switch ($authsessionStatus) {
            case AuthSession::AUTHENTICATED:
                $status = true;
                break;
            case AuthSession::NOSTATE:
                echo "SecSign ID login error (NOSTATE)";
                break;
            case AuthSession::PENDING:
                echo "SecSign ID login still pending";
                break;
            case AuthSession::FETCHED:
                echo "SecSign ID login error (FETCHED)";
                break;
            case AuthSession::DENIED:
                echo "SecSign ID login denied";
                break;
        }

        $secSignIDApi->releaseAuthSession($authsession);
        return $status;
    }

    private function includeCSS(){
        return '<link rel="stylesheet" type="text/css" href="vendor/secsign-php-full/css/secsignid_layout.css">';
    }

    private function includeJS(){
        return '<script src="vendor/secsign-php-full/js/secsignfunctions.js"></script>';
    }

    private function printForm(){
    $output = '
        <div id="secsignidplugincontainer">
                <noscript>
                    <div class="secsignidlogo"></div>
                    <p>Please enable JavaScript</p>
        <a style="color: #fff; text-decoration: none;" id="noscriptbtn"
           href="https://www.secsign.com/support/" target="_blank">SecSign Support</a>
        </noscript>
        <div style="display:none;" id="secsignidplugin">
            <!-- Page Login -->
            <div id="secsignid-page-login">
                <div class="secsignidlogo"></div>
                <div id="secsignid-error"></div>
                <form id="secsignid-loginform">
                    <div class="form-group">
                        <input type="text" class="form-control login-field" value="" placeholder="SecSign ID"
                               id="login-secsignid" name="secsigniduserid" autocapitalize="off" autocorrect="off">
                        <label class="login-field-icon fui-user" for="login-secsignid"></label>
                    </div>

                    <div id="secsignid-checkbox">
                        <span>
                            <input id="rememberme" name="rememberme" type="checkbox" value="rememberme" checked>
                            <label for="rememberme">Remember Me</label>
                        </span>
                    </div>
                    <button id="secloginbtn" type="submit">Log in</button>
                </form>
                <div class="secsignid-login-footer">
                    <a href="#" class="infobutton" id="secsignid-infobutton">Info</a>
                    <div class="clear"></div>
                </div>
            </div>

            <!-- Page Info SecSign Login -->
            <div id="secsignid-page-info">
                <div class="secsignidlogo secsignidlogo-left"></div>
                <h3 id="headinginfo">Eliminate Passwords and Password Theft.</h3>

                <div class="clear"></div>
                <p>Protect your organization and your sensitive data with two-factor authentication.</p>
                <a id="secsignid-learnmore" href="https://www.secsign.com/products/secsign-id/" target="_blank">Learn more</a>

                <img style="margin: 0 auto;width: 100%;display: block;max-width: 200px;"
                     src="vendor/secsign-php-full/images/secsignhelp.png">

                <a class="linktext" id="secsignid-info-secsignid" href="#">Go back to the login screen</a>

                <a style="color: #fff; text-decoration: none;"
                   href="https://www.secsign.com/try-it/#login" target="_blank"
                   id="secsignidapp1">See how it works</a>

                <div class="clear"></div>
            </div>

            <!-- Page Accesspass -->
            <div id="secsignid-page-accesspass">
                <div class="secsignidlogo"></div>

                <div id="secsignid-accesspass-container">
                    <img id="secsignid-accesspass-img"
                         src="vendor/secsign-php-full/images/preload.gif">
                </div>

                <div id="secsignid-accesspass-info">
                    <a href="#" class="infobutton" id="secsignid-questionbutton">Info</a>

                    <p class="accesspass-id">Access pass for <b id="accesspass-secsignid"></b></p>

                    <div class="clear"></div>
                </div>

                <form action="" method="post" id="secsignid-accesspass-form">
                    <button id="secsignid-cancelbutton" type="submit">Cancel</button>

                    <!-- OK -->
                    <input type="hidden" name="check_authsession" id="check_authsession" value="1"/>
                    <input type="hidden" name="option" value="com_secsignid"/>
                    <input type="hidden" name="task" value="getAuthSessionState"/>

                    <!-- Cancel
                    <input type="hidden" name="cancel_authsession" id="cancel_authsession" value="0"/>
                    -->

                    <!-- Values -->
                    <input type="hidden" name="return" value="<?php echo $return; ?>"/>
                    <input type="hidden" name="secsigniduserid" value=""/>
                    <input type="hidden" name="secsignidauthsessionid" value=""/>
                    <input type="hidden" name="secsignidrequestid" value=""/>
                    <input type="hidden" name="secsignidservicename" value=""/>
                    <input type="hidden" name="secsignidserviceaddress" value=""/>
                    <input type="hidden" name="secsignidauthsessionicondata" value=""/>
                </form>
            </div>

            <!-- Page Question SecSign Accesspass -->
            <div id="secsignid-page-question">
                <div class="secsignidlogo secsignidlogo-left"></div>
                <h3 id="headingquestion">How to sign in with SecSign ID.</h3>

                <div class="clear"></div>
                <p>In order to log in using your SecSign ID, you need to follow the following steps:</p>
                <ol>
                    <li>Open the SecSign ID app on your mobile device</li>
                    <li>Tap your ID</li>
                    <li>Enter your PIN or passcode or scan your fingerprint</li>
                    <li>Select the correct access symbol</li>
                </ol>

                <a class="linktext" id="secsignid-question-secsignid" href="#">Go back to the Access Pass verification</a>

                <a style="color: #fff; text-decoration: none;" class="button-secsign blue"
                   href="https://www.secsign.com/try-it/#account" target="_blank" id="secsignidapp2">Get the SecSign ID App</a>

                <div class="clear"></div>
            </div>
        </div>
        </div>
        ';
        return $output;
    }

    private function includeParams($title, $path, $layout){
        $output = '<script>
                var url = document.URL;
                var title = "'.$title.'";
                var secsignPluginPath = "'.$path.'";
                var frameoption = '.$layout.';
                var backend = true;

                if (title == "") {
                    title = document.title;
                }

                if (!window.jQuery) {
                    console.log("jQuery is not available");
                }</script>';
        return $output;
    }
}







