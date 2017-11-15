// Modal Image Gallery
function onClick(element) {
  document.getElementById("img01").src = element.src;
  document.getElementById("modal01").style.display = "block";
  var captionText = document.getElementById("caption");
  captionText.innerHTML = element.alt;
}


// Toggle between showing and hiding the sidebar when clicking the menu icon
var mySidebar = document.getElementById("mySidebar");

function w3_open() {
    if (mySidebar.style.display === 'block') {
        mySidebar.style.display = 'none';
    } else {
        mySidebar.style.display = 'block';
    }
}

// Close the sidebar with the close button
function w3_close() {
    mySidebar.style.display = "none";
}


beforeSubmit = function(){
    if (1 == 1) {
    	document.getElementById("myIframe").style.visibility = "visible";

		var html_string= "<center> Uploading... please wait... </center>";
		// var html_string = "<a target=\"_parent\" href=\"http://localhost:8080/index.php#visualization\">Click here to choose visualization</a>";
		document.getElementById('myIframe').src = "data:text/html;charset=utf-8," + escape(html_string);
		setTimeout(function(){ 
			$("#formUpload").submit();            
		}, 500);	

    }        
}
