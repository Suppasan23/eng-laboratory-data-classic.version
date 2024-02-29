window.addEventListener("load",showData("all"));

let header = document.getElementById("myButton");


let btnsA = header.getElementsByClassName("btnA");
btnsA[0].addEventListener("click", function()
{
    let current = header.getElementsByClassName("active");
    current[0].className = current[0].className.replace(" active", "");

    this.className += " active";

    console.log(this.value);
    showData(this.value);
})


let btns = header.getElementsByClassName("btn");
for (let i = 0; i < btns.length; i++) 
{
  btns[i].addEventListener("click", function()
  {
    let current = header.getElementsByClassName("active");
    current[0].className = current[0].className.replace(" active", "");

    this.className += " active";

    console.log(this.value);
    showData(this.value);
  });
}


function showData(str)
{
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
    {
      if (this.readyState == 4 && this.status == 200)
      {
        document.getElementById("data").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET", "getdata.php?q=" + str, true);
    xmlhttp.send();
}