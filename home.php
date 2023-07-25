<?php
  session_start();

  //check if session is sset for user or not, if not set so he redirect to login.php 
  if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true){
    header('location: login.php');
    //for existing php script
    exit;
  }

?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1"
      crossorigin="anonymous"
    />
    <title>Speech To Text</title>
    <style>
      .dynamicDiv {
        display: flex;
        flex-direction: column;
      }
      
      .dynamicDiv > span {
        flex: 1;
      }
    </style>
  </head>
  <body class="container pt-5 bg-dark">
    <!-- <h1 class="mt-4 text-light text-right"> Welcome "<?php echo $_SESSION['username']; ?>"!! Let's Transcribe Your Sweet Voice🎶 in Text📝</h1> -->
    <h1 class="mt-4 text-light text-right"><span class="auto-type"></span></h1>
    <h2 class="mt-4 text-light text-center">Speech Recognition</h2> 

    
    <h2 class="mt-4 text-light">Transcript</h2>
    
    <div class="p-3" style="border: 1px solid gray; border-radius: 8px;">
      <span id="final" class="text-light"></span>
      <span id="interim" class="text-secondary"></span>
    </div>
    <div class="mt-4">
      <select id="languageSelect">
        <option value="en">English</option>
        <option value="hi">Hindi</option>
        <option value="gu">Gujarati</option>
      </select>
      <button class="btn btn-success" id="start">Start</button>
      <button class="btn btn-danger" id="stop">Stop</button>
      <button class="btn btn-secondary" id="clear">Clear</button>
      <textarea id="extraText" class="form-control mt-3" rows="3" placeholder="Add extra text"></textarea>
      <button class="btn btn-primary mt-3" id="addText">Add Text</button>
      
      <button class="btn btn-warning mt-3" id="logout"><a href="logout.php">Logout</a></button>
      
      <p id="status" class="lead mt-3 text-light" style="display: none">Listening ...</p>
      
    </div>
    
  </body>
  
  <!-- script to add typewriting effect in text -->
  <script src="https://unpkg.com/typed.js@2.0.16/dist/typed.umd.js"></script>
  <script>
   var typed = new Typed('.auto-type', {
      strings: ["Welcome <?php echo $_SESSION['username']; ?>!! Let's Transcribe Your Sweet Voice🎶 in Text📝"],
      typeSpeed: 30,
      loop: false,
    });
  </script>

<!-- script for speech to text recoginatition -->
    <script>
    const languageSelect = document.getElementById("languageSelect");
    const startButton = document.getElementById("start");
    const stopButton = document.getElementById("stop");
    const clearButton = document.getElementById("clear");
    const addTextButton = document.getElementById("addText");
    const extraTextArea = document.getElementById("extraText");

    const recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.interimResults = true;
    let alltext = "";

    recognition.onstart = function() {
      document.getElementById("status").style.display = "block";
      document.getElementById("status").innerHTML = "Listening...";
    };

    recognition.onerror = function(event) {
      console.error("Speech recognition error:", event.error);
    };

    recognition.onend = function() {
      document.getElementById("status").innerHTML = "Stopped";
    };

    recognition.onresult = function(event) {
      let finalTranscript = "";
      let interimTranscript = "";

      for (let i = event.resultIndex; i < event.results.length; i++) {
        const transcript = event.results[i][0].transcript;
        if (event.results[i].isFinal) {
          finalTranscript += transcript;
        } else {
          interimTranscript += transcript;
        }
      }
      
      document.getElementById("final").innerHTML = finalTranscript;
      document.getElementById("interim").innerHTML = interimTranscript;
      alltext = alltext + finalTranscript ;
      extraTextArea.innerHTML = alltext + "\n";
      
    };

    startButton.onclick = function() {
      recognition.lang = languageSelect.value;
      recognition.start();
    };

    stopButton.onclick = function() {
      recognition.stop();
      document.getElementById("status").style.display = "none";
    };

    clearButton.onclick = function() {
      document.getElementById("final").innerHTML = "";
      document.getElementById("interim").innerHTML = "";
       extraTextArea.value = finalTranscript + " " + interimTranscript;
    };

    addTextButton.onclick = function() {
      const text = extraTextArea.value;
      if (text !== "") {
        document.getElementById("final").innerHTML += " " + text;
        extraTextArea.value = "";
      }
    };
  </script>
</html>
