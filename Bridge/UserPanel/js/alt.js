function changeContent(id, val) {
  var elem = document.getElementById(id);
  elem.value = val;
  elem.innerHTML = val;
}

function changeFormState(selector, state) {
  if (state == "SUCCESS") {
    jQuery(selector + " > input").tooltip("destroy");
    jQuery(selector).tooltip("destroy");
    jQuery(selector).attr("class", "form-group has-success has-feedback");
    jQuery(selector + " > span").attr("class", "glyphicon glyphicon-ok form-control-feedback");

  } else {
    jQuery(selector).attr("class", "form-group has-error has-feedback");
    jQuery(selector + " > span").attr("class", "glyphicon glyphicon-remove form-control-feedback");
  }
}

function changeAlertState(selector, state, message = "") {
  if (state == "SUCCESS") {
    jQuery(selector).attr("class", "alert alert-success");
    jQuery(selector + " > span").attr("class", "glyphicon glyphicon-ok");
    if (message != "") {
      jQuery(selector + " > strong").text(message);
    }
    return 0;
  } else {
    jQuery(selector).attr("class", "alert alert-danger");
    jQuery(selector + " > span").attr("class", "glyphicon glyphicon-remove");
    if (message != "") {
      jQuery(selector + " > strong").text(message);
    }
  }
}

function changeStyle(id, stl) {
  var elem = document.getElementById(id);
  elem.style = stl;
  return 0;
}

function checkExtension(id) {
  var element1 = document.getElementById(id);
  var element2 = document.getElementById("sub-lang-indicator");
  var ext = element1.files[0].type;
  switch (ext) {
    case "text/x-python":
      changeContent("sub-lang-indicator", "Python");
      element2.style = "color: #dfca00";
      break;
    case "application/x-ruby":
      changeContent("sub-lang-indicator", "Ruby");
      element2.style = "color: red";
      break;
    case "text/x-csrc":
      changeContent("sub-lang-indicator", "C");
      element2.style = "color: green";
      break;
    case "text/x-c++src":
      changeContent("sub-lang-indicator", "C++");
      element2.style = "color: #00c500";
      break;
    case "text/x-java":
      changeContent("sub-lang-indicator", "Java");
      element2.style = "color: #9c6612";
      break;
    case "application/x-perl":
      changeContent("sub-lang-indicator", "Perl");
      element2.style = "color: #6796bf";
      break;
    default:
      changeContent("sub-lang-indicator", "Not supported"); // if 'Undefined' changes, change uploadProcess() extention handler!
      element2.style = "color: black";

  }
  return 0;
}
