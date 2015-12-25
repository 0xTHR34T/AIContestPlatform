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

  if (langIndicator.innerHTML.trim() == "Not supported") {
    changeAlertState("#uploadAlert", "FAILURE", "Forbidden file extension");
    return 0;
  }

  changeContent("uploadGoBtn", "Uploading...");
  jQuery("#uploadGoBtn").attr("class", "btn btn-success btn-lg btn-block disabled");
  formData.append("file", fl, fl.name);

  xhr.onload = function() {
    if (xhr.status == 200) {
      if (xhr.responseText.trim() == "Uploaded successfully!") {
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

function contestProcessInit(element, lv = null) {
  var nm = element.name;
  var modal = document.getElementById("joinModal");
  modal.name = nm.trim();
  if (lv == "create") {
    modal.role = "CREATE_CONTEST";
  }
}

function initialTestProcess(obj)
{
  var url = "../UserPanel/monitor.php?query=test&agent="+ obj.name;
  var xhr = new XMLHttpRequest();
  var pObj = obj.parentElement;

  pObj.innerHTML = "<img src = 'images/mini-pre.GIF'>";

  xhr.onload = function() {
    if (xhr.status == 200) {
      pObj.innerHTML = "<h4 style='color:black'><b>"+ xhr.responseText.trim() +"</b></h4>";
      if (xhr.responseText.trim() == "Initial test: DONE") {
        pObj.innerHTML = "<h4 style='color:green'><b>Done!</b></h4>";
      } else {
        pObj.innerHTML = "<h4 style='color:red'><b>Failed!</b></h4>";
      }
    } else {
      pObj.innerHTML = "<h4 style='color:red'><b>Error</b></h4>";
    }
  }

  xhr.open('GET', url, true);
  xhr.send();
}

var rootApp = angular.module('rootApp', ['contest-app', 'monitor-app', 'ranking-app']);

var contestApp = angular.module('contest-app', []);

contestApp.controller('contest-ctrl', function($scope, $http){
  $http.get("../UserPanel/contests.php?query=show").success(function(response){
    jQuery("#table-contest tbody").html(response);               //Note: Probable XSS attack
  });

  /*$scope.createContestProcess = function() {
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
  };*/
});

var monitorApp = angular.module('monitor-app', []);

monitorApp.controller('monitor-ctrl', function($scope, $http){
    $http.get("../UserPanel/monitor.php?query=show").success(function(response){
      jQuery("#table-monitor tbody").html(response);               //Note: Probable XSS attack
    });
  });

var rankingApp = angular.module('ranking-app', []);

rankingApp.controller('ranking-ctrl', function($scope, $http){
    $http.get("../UserPanel/ranking.php?query=show").success(function(response){
      jQuery("#table-ranking tbody").html(response);               //Note: Probable XSS attack
    });
  });
