var animatedElemets = ["anim1", "anim2", "anim3"];

window.addEventListener("load", setLinkFunctions, false);

var linkClickables = [];
var stopScrolling = true;
var scrollTarget = 0;
var windowScroll = 0;
var scrollEase = 10;

function setLinkFunctions(){
  var links = document.getElementsByTagName("a");
  for(var i = 0; i < links.length; i++){
    var link = links[i];
    var href = link.getAttribute("href") || "";
    var hrefr = href.replace("#", "");
    if(hrefr != href){
      linkClickables.push(hrefr);
      link.setAttribute("data-link-id", hrefr);
      link.addEventListener("click", smoothScroll, false);
    }
  }

  document.addEventListener("mousewheel", smoothScrollStop, false);
  document.addEventListener("touchstart", smoothScrollStop, false);
  document.addEventListener("mousedown", smoothScrollStop, false);
  document.addEventListener("keydown", smoothScrollStop, false);
  window.addEventListener("resize", smoothScrollStop, false);

  windowScroll = document.body.scrollTop;

  document.addEventListener("scroll", function(){
    windowScroll = document.body.scrollTop;
  }, false);
}

function smoothScrollStop(){
  if(!stopScrolling) stopScrolling = true;
}

function smoothScrollUpdate(){
  windowScroll += ((scrollTarget - windowScroll)/scrollEase);
  document.body.scrollTop = Math.round(windowScroll);
  if(Math.round(windowScroll - scrollTarget) == 0) stopScrolling = true;
  //console.log(scrollTarget - windowScroll);
  if(!stopScrolling){
    if(window.requestAnimationFrame){
      window.requestAnimationFrame(smoothScrollUpdate);
    } else{
      setTimeout(smoothScrollUpdate, 1000/30);
    }
  }
}

function smoothScroll(e){
  var goto = document.getElementById(this.getAttribute("data-link-id"));
  if(goto){
    scrollTarget = goto.offsetTop;
    //scrollEase = Math.abs(scrollTarget - windowScroll)/150;
    stopScrolling = false;
    smoothScrollUpdate();
  }
  e.preventDefault();
}

document.addEventListener("scroll", checkAnimScroll, false);
window.addEventListener("load", checkAnimScroll, false);

function checkAnimScroll(){
  var alldone = true;

  for(var i = 0; i < animScroll.length; i++){
    var as = animScroll[i];
    if(as.done){
      continue;
    } else{
      alldone = false;
    }
    var elem = document.getElementById(as.id);
    if(elem.offsetTop + elem.offsetHeight/2 <= document.body.scrollTop + window.innerHeight && elem.offsetTop + elem.offsetHeight/2 >= document.body.scrollTop && !as.done){
      as.anim();
      as.done = true;
    }
  }

  if(alldone){
    console.log("All done!");
    document.removeEventListener("scroll", checkAnimScroll);
  }
}
