function changeContent(id, val) {
  var elem = document.getElementById(id);
  elem.value = val;
  elem.innerHTML = val;
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
    default:
      changeContent("sub-lang-indicator", "Undefined");
      element2.style = "color: black";

  }
  return 0;
}
