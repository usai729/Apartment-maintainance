function show_pwd(button, id) {
  var element = document.getElementById(id);

  if (element.type == "password") {
    element.type = "text";
  } else {
    element.type = "password";
  }
}

function show_post_area() {
  var ele = document.getElementById("new_area");

  if (ele.style.display == "none") {
    ele.style.display = "flex";
  } else {
    ele.style.display = "none";
  }
}
