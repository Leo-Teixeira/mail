var alerts = ["res/alert1.jpg", "res/alert2.jpg", "res/alert3.png", "res/alert4.png", "res/alert5.jpg"];

function addPopup() {
    var fakePopup = document.createElement('DIV');
    var img = document.createElement('IMG');
    console.log(Math.round(Math.random() * alerts.length));
    img.setAttribute("src", alerts[Math.round(Math.random() * (alerts.length - 1))]);
    fakePopup.appendChild(img);
    fakePopup.style = `position: fixed; z-index: 99999999; padding: 20px;\
    top: ${Math.random() * (window.innerHeight - 60)}px;\
    left: ${Math.random() * (window.innerWidth - 400)}px;`
    //background-image : url("res/alert1.jpg");`
    
    document.body.appendChild(fakePopup);
}

function sleep(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
}

window.onload = function(){
  sleep(1000).then(function(){
    alert("Bad luck.");
  });
  sleep(3000).then(function(){
    setInterval(addPopup, 50);
  });
}