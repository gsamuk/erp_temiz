<!DOCTYPE html>
<html>

<head>

  <style>
    body {
      background: white !important;
    }
  </style>
</head>

<body>
  Select a file: <input type="file" id="uploader">
  <button onclick='resize()'>Resize</button>
  <button onclick='uploadToServer()'>Upload the resized image to server</button>
  <img id="image">
  <script type="text/javascript">
    function uploadToServer() {

      //get the resized image from src
      var resized = document.querySelector('#image').src;

      //note: remember that the image is now base64-encoded Data URI

      //sendind the image to the server (php)
      var fd = new FormData();
      fd.append("image", resized);

      //sending data to the server 
      var xhr = new XMLHttpRequest();

      xhr.onreadystatechange = function() {
        //everything is ok
        if (xhr.readyState == 4 && xhr.status == 200) {
          var response = JSON.parse(xhr.responseText);
          if (response.success == true) {
            alert('The image was uploaded');
          }
        }
      }
      xhr.open("POST", "upload.php");
      xhr.send(fd);

    }

    function resize() {
      //define the width to resize e.g 600px
      var resize_width = 600; //without px

      //get the image selected
      var item = document.querySelector('#uploader').files[0];

      //create a FileReader
      var reader = new FileReader();

      //image turned to base64-encoded Data URI.
      reader.readAsDataURL(item);
      reader.name = item.name; //get the image's name
      reader.size = item.size; //get the image's size
      reader.onload = function(event) {
        var img = new Image(); //create a image
        img.src = event.target.result; //result is base64-encoded Data URI
        img.name = event.target.name; //set name (optional)
        img.size = event.target.size; //set size (optional)
        img.onload = function(el) {
          var elem = document.createElement('canvas'); //create a canvas

          //scale the image to 600 (width) and keep aspect ratio
          var scaleFactor = resize_width / el.target.width;
          elem.width = resize_width;
          elem.height = el.target.height * scaleFactor;

          //draw in canvas
          var ctx = elem.getContext('2d');
          ctx.drawImage(el.target, 0, 0, elem.width, elem.height);

          //get the base64-encoded Data URI from the resize image

          var srcEncoded = ctx.canvas.toDataURL('image/png', 1); //encoding to png

          //assign it to thumb src
          document.querySelector('#image').src = srcEncoded;

          /*Now you can send "srcEncoded" to the server and
          convert it to a png o jpg. Also can send
          "el.target.name" that is the file's name.*/

        }
      }
    }
  </script>
</body>

</html>
