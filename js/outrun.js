// Stolen from: https://codepen.io/nawwab/pen/Yzydjxj
const terminal = document.getElementById("terminal");
const terminalBody = document.getElementById("containerTerminal");
let newLine = document.createElement("p");
const skipBtn = document.querySelector(".control span");
terminal.appendChild(newLine);

let str = `Hey my name is Wilyarti Howard.
I am a hobbyist web developer, programmer and gardener.
I enjoy making things that help people in their daily lives.`;


function sayItSlowly(str){
  let arr = str;
  let counter = 0;
  let isPaused = false;

  let interval = setInterval(function(){
    if (!isPaused) {
      printChar(arr[counter]);
      counter++;
    }

    if (counter === arr.length) {
      clearInterval(interval);
      //skipBtn.textContent = "End.";
      skipBtn.classList.remove("hidden");
      skipBtn.addEventListener("click", () => {
        newLine.textContent = ""
        sayItSlowly(user, place, str)
      })
    }

    if (terminal.clientHeight > (terminalBody.clientHeight/2)) {
      if(arr[counter] === " "){
        // toggle alway toggling and wont stop, we need to toggle skipBTN outside interval
        isPaused = true;
        skipBtn.classList.remove("hidden");

        skipBtn.addEventListener("click", function(){
          newLine.textContent = `${username}`;
          skipBtn.classList.add("hidden");
          isPaused = false;
        })
      }
    }
  }, 50)
}


function pause(){
  clearInterval(interval);
}

function printChar(char){
  newLine.textContent += char;
}
function outrun() {
  sayItSlowly( str);

}
