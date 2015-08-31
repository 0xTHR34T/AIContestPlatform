/*
 *
 *
*/

function sha1(input) {
  var shaObj = new jsSHA("SHA-1", "TEXT");
  shaObj.update(input);
  var output = shaObj.getHash("HEX");
  return output;
}

function uploadProcess() {
  var xhr = new XMLHttpRequest();
  var formData = new FormData();
  var inputElement = document.getElementById("uploadBtn");
  var langIndicator = document.getElementById("sub-lang-indicator");
  var fl = inputElement.files[0];

  if (langIndicator.innerHTML.trim() == "Undefined") {
    changeAlertState("#uploadAlert", "FAILURE", "Undefined file extension");
    return 0;
  }

  changeContent("uploadGoBtn", "Uploading...");
  jQuery("#uploadGoBtn").attr("class", "btn btn-success btn-lg btn-block disabled");
  formData.append("file", fl, fl.name);

  xhr.onload = function() {
    if (xhr.status == 200) {
      if (xhr.responseText.trim() == "Successfully uploaded!") {
        changeAlertState("#uploadAlert", "SUCCESS", xhr.responseText);
        jQuery("#uploadGoBtn").attr("class", "btn btn-success btn-lg btn-block").text("GO!");
      } else {
        changeAlertState("#uploadAlert", "FAILURE", xhr.responseText);
        jQuery("#uploadGoBtn").attr("class", "btn btn-success btn-lg btn-block").text("GO!");
      }
    } else {
      changeAlertState("#uploadAlert", "FAILURE", "Couldn't connect to the server");
      jQuery("#uploadGoBtn").attr("class", "btn btn-success btn-lg btn-block").text("GO!");
    }
  }

  xhr.open('POST', '../UserPanel/upload.php', true);
  xhr.send(formData);

  return 0;
}

var obj = document.getElementById("status");
var app = angular.module('app-gateway', []);
app.controller('gateway-login', function($scope, $http){
  $scope.Login = function(){
    var usr = $scope.userName;
    var pss = sha1($scope.Pass);
    var chb = $scope.checkBox;
    var url = 'login.php?userName='+ usr +'&Password='+ pss +'&rem='+ chb;
    $http.get(url).success(function(response){
      if (response.trim() == "Incorrect username or password") {
        changeContent("status", response);
        changeStyle("status", "color:red");
        jQuery("#status").fadeIn("fast").delay(3000).fadeOut();
      } else {
        window.location = "UserPanel/";
      }
    });
  };
});

app.controller('gateway-register', function($scope, $http){
  var user_vld = false;
  var pass_vld = false;
  var email_vld = false;

  var usr = $scope.userName;
  var pss = $scope.Pass;           // note: sha1() doesn't work in this case: ERROR -> e is undefined
  var pss2 = $scope.Pass2;
  var email = $scope.Email;
  var url;

  $scope.userCheck = function(){
    usr = $scope.userName;
    url = 'register.php?Username='+ usr;

    if (usr.length < 6) {
      jQuery("#username-fg > input").tooltip({title: "Minimum length: 6 characters" , trigger: "hover" , placement : "right"});
      changeFormState("#username-fg", "DANGER");
      user_vld = false;
      return 0;
    }

    $http.get(url).success(function(response) {
      if (response.trim() == "Username is invalid or already taken") {
        jQuery("#username-fg > input").tooltip({title: response , trigger: "hover" , placement : "right"});
        changeFormState("#username-fg", "DANGER");
        user_vld = false;
        return 0;
      }
      user_vld = true;
      changeFormState("#username-fg", "SUCCESS");
    });
  };

  $scope.emailCheck = function(){
    email = $scope.Email;
    url = 'register.php?Email='+ email;

    $http.get(url).success(function(response) {
      if (response.trim() == "Email is invalid or already taken") {
        jQuery("#email-fg > input").tooltip({title : response , trigger : "hover" , placement : "right"});
        changeFormState("#email-fg", "DANGER");
        email_vld = false;
        return 0;
      }
      changeFormState("#email-fg", "SUCCESS");
      email_vld = true;
    });
  };

  $scope.passCheck = function(){
    pss = $scope.Pass;
    pss2 = $scope.Pass2;

    if (pss.length < 6) {
      jQuery("#password-fg > input").tooltip({title: "Minimum length: 6 characters" , trigger: "hover" , placement : "right"});
      changeFormState("#password-fg", "DANGER");
      pass_vld = false;
      return 0;
    }

    jQuery("#password-fg > input").tooltip("destroy");

    if(pss == pss2) {
      changeFormState("#password-fg", "SUCCESS");
      changeFormState("#re-password-fg", "SUCCESS");
      pass_vld = true;
    } else {
      jQuery("#re-password-fg > input, #password-fg > input").tooltip({title : "Password does not match!" , trigger : "hover" , placement : "right"});
      changeFormState("#password-fg", "DANGER");
      changeFormState("#re-password-fg", "DANGER");
      pass_vld = false;
    }
  };

  $scope.Register = function(){
    url = 'register.php?Username='+ usr +'&Password='+ sha1(pss) +'&Email='+ email;
    if (!user_vld || !email_vld || !pass_vld) {
      changeContent("status", "Please check the fields and try again");
      changeStyle("status", "color:red");
      jQuery("#status").fadeIn("fast").delay(3000).fadeOut();
      return 0;
    }

    $http.get(url).success(function(response){
      if (response.trim() === "Your account registered!") {
        jQuery("#status").attr("class", "alert alert-success");
        changeContent("status", response);
        changeStyle("status", "color:green");
        jQuery("#status").fadeIn("fast").delay(3000).fadeOut();
        jQuery("#status").delay(4000).attr("class", "alert alert-danger");
      } else {
        changeContent("status", response);
        changeStyle("status", "color:red");
        jQuery("#status").fadeIn("fast").delay(3000).fadeOut();
      }
    });
  };
});
