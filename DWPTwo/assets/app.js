
 // Get the modal
 var modal = document.getElementById("myModal");

 // Get the button that opens the modal
 var btn = document.getElementById("myBtn");

 // Get the <span> element that closes the modal
 var span = document.getElementsByClassName("close")[0];

 // When the user clicks on the button, open the modal
 btn.onclick = function() {
     modal.style.display = "block";
 }

 // When the user clicks on <span> (x), close the modal
 span.onclick = function() {
     modal.style.display = "none";
 }

 // When the user clicks anywhere outside of the modal, close it
 window.onclick = function(event) {
     if (event.target == modal) {
         modal.style.display = "none";
     }
 }






 document.addEventListener("click",function (e){
   if(e.target.classList.contains("gallery-item")){
   	  const src = e.target.getAttribute("src");
   	  document.querySelector(".modal-img").src = src;
   	  const myModal = new bootstrap.Modal(document.getElementById('gallery-modal'));
   	  myModal.show();
   }
 })











/*
  // Get the modal
  var modaldisplay = document.getElementById("displayModal");

  // Get the button that opens the modal
  var btndisplay = document.getElementById("displayimg");
 
  // Get the <span> element that closes the modal
  var spandisplay = document.getElementsByClassName("close")[0];
 
  // When the user clicks on the button, open the modal
  btndisplay.onclick = function() {
      modal.style.display = "modalImg";
  }
 
  // When the user clicks on <span> (x), close the modal
  spandisplay.onclick = function() {
      modal.style.display = "none";
  }
 
  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
      if (event.target == modal) {
          modal.style.display = "none";
      }
  }





      // Open the modal
      function openModal(url) {
        var modal = document.getElementById('customModal');
        var modalImg = document.getElementById("modalImage");
        var closeModalButton = document.getElementsByClassName("close")[0];
        modal.style.display = "block";
        modalImg.src = url;

        // Close the modal when the close button is clicked
        closeModalButton.onclick = function() {
            modal.style.display = "none";
        }

        // Close the modal when clicking outside the modal content
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    }




 */

  

 