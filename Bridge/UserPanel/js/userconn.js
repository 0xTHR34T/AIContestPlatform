/*
 *
 *
*/

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

function joinProcessInit(element) {
  var nm = element.name;
  var modal = document.getElementById("joinModal");
  modal.name = nm.trim();
}

var contestApp = angular.module('contest-app', []);

contestApp.controller('contest-ctrl', function($scope, $http){
  $http.get("../UserPanel/contests.php?query=show").success(function(response){
    jQuery("#table-contest tbody").html(response);               //Note: Probable XSS attack
  });

  $scope.createContestProcess = function() {
    var plNumber = document.getElementById("contestCreateButton").innerHTML;
    var url;

    plNumber = plNumber.trim();
    url = "../UserPanel/contests.php?query=create&number=" + plNumber[0];

    jQuery(".contest-create").html("<img src = 'images/mini-pre.GIF'>"); //Note: Probable XSS attack
    $http.get(url).success(function(response){
      if (response.trim() == "Created!") {
        jQuery(".contest-create").html("<b style = 'color:green'>Done!</b>");
      } else {
        jQuery(".contest-create").html("<b style = 'color:red'>Failed!</b>");
      }
    });
  };
});
