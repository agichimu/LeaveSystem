var glbStaffCurrentDisplayID;
var glbAdminCurrentDisplayID;
window.onload = function() {
    //Gettig the path on our browser
    var currentDocument = window.location.pathname.split('/').pop();
     

    /*we get our path to know if we are currently on which page then go ahead and
    hide all other displays from the user.
    
    since we disable all the displays when the user reloads we need to make sure 
    not to take the user back to the dashboard display instead keep him on the already 
    existing dStaffisplay */

    try {
        glbAdminCurrentDisplayID = localStorage.getItem("glbAdminCurrentDisplayID");
        glbStaffCurrentDisplayID = localStorage.getItem("glbStaffCurrentDisplayID");
      } catch (e) {
        // Handle any errors with local storage access
        console.error("Error accessing local storage:", e);
    }

    var activeDisplay = document.getElementsByClassName("content");
     
    // Disabling all the displays
    if (currentDocument == "ClientDashboard.php") {
        // Disable relevant displays on the clientDashboard
        console.log("Disabling displays for ClientDashboard");
        for (var i = 0; i < activeDisplay.length; i++) {
            activeDisplay[i].style.display = "none";
        }
        // Enable current display if it was hidden on page load
        // Get the ID of the active display
        var activeDisplayId = glbStaffCurrentDisplayID;
        if(activeDisplayId == null){
            document.getElementById("dashboard").style.display = "flex";
            activeDisplayId = "dashboard";
            console.log("Was null now set at: " + activeDisplayId);
            glbStaffCurrentDisplayID = activeDisplayId;
            console.log("globlStaffCurrentDisplayId Staffis set as: " + glbStaffCurrentDisplayID);
            localStorage.setItem(glbStaffCurrentDisplayID, activeDisplayId);
        }else{
            localStorage.setItem(glbStaffCurrentDisplayID, activeDisplayId);
            activeDisplay = glbStaffCurrentDisplayID;
            document.getElementById(activeDisplay).style.display = "flex";
            console.log("Reloading and seting id as: " + activeDisplay);
        }

    } else if (currentDocument == "adminDashboard.php") {
        // Disable relevant displays on the admin dashboard 
        console.log("Disabling displays for adminDashboard");
        for (var i = 0; i < activeDisplay.length; i++) {
            activeDisplay[i].style.display = "none";
        }
        // Enable current display if it was hidden on page load
        // Get the ID of the active display
        var activeDisplayId = glbAdminCurrentDisplayID;
        console.log("log: " + activeDisplayId);
        if(activeDisplayId == null){
            document.getElementById("dashboard").style.display = "flex";
            activeDisplayId = "dashboard";
            console.log("Was null now set at: " + activeDisplayId);
            glbAdminCurrentDisplayID = activeDisplayId;
            console.log("globlAdminCurrentDisplayId Staff is set as: " + glbAdminCurrentDisplayID);
            localStorage.setItem(glbAdminCurrentDisplayID, activeDisplayId);
        }else{
            localStorage.setItem(glbAdminCurrentDisplayID, activeDisplayId);
            activeDisplay = glbAdminCurrentDisplayID;
            document.getElementById(activeDisplay).style.display = "flex";
            console.log("Reloading and seting id as: " + activeDisplay);
        }
    }
    

};
  

function changeContent(contentID) {
    // Hide all content elements
    var contentElements = document.getElementsByClassName("content");
    for (var i = 0; i < contentElements.length; i++) {
      contentElements[i].style.display = "none";
    }
  
    // Show the selected content element
    var selectedContent = document.getElementById(contentID);
    selectedContent.style.display = "flex";

    var currentDocument = window.location.pathname.split('/').pop();

    if(currentDocument == "ClientDashboard.php"){
        localStorage.setItem("glbStaffCurrentDisplayID", contentID);
        console.log("globlStaffCurrentDisplayId Staffis set as: " + glbStaffCurrentDisplayID);
    }
    else if(currentDocument == "adminDashboard.php"){
        localStorage.setItem("glbAdminCurrentDisplayID", contentID);
        console.log("globlAdminCurrentDisplayId Admin is set as: " + glbAdminCurrentDisplayID);
    }
    
    
    
  }

  //linking pages
  function goToPage(url){
    console.log("working..");
    window.location.href = "../EmployeeLeaveSystem/" + url;
    console.log(url);
}

//reporting back
function reportBack(leave_id) {
      
      // Send AJAX request to update the leave record as reported
      $.ajax({
        url: 'includes/report_leave.inc.php',
        method: 'POST',
        data: { id: leave_id },
        success: function(response) {
          // Display success message
          alert('Leave record reported successfully!');
        },
        error: function(xhr, status, error) {
          // Display error message
          alert('Error: ' + error);
        }
      });
    }
    function showPassword() {
      var passwordField = document.getElementById("password");
      var eyeIcon = document.getElementById("eye");
      if (passwordField.type === "password") {
          passwordField.type = "text";
          eyeIcon.setAttribute("name", "eye");
          eyeIcon.setAttribute("name", "eye-off");
      } else {
          passwordField.type = "password";
          eyeIcon.setAttribute("name", "eye-off");
          eyeIcon.setAttribute("name", "eye");
      }
    }
  