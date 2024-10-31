function manipulateDom(){
  var s = document.createElement("script");
  s.async = true
  s.type = "text/javascript";
  s.src = "https://widget-libs.s3.amazonaws.com/bundle.js";
  document.body.appendChild(s)
}

window.onload = manipulateDom