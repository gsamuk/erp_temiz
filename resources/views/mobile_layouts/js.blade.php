<!-- ///////////// Js Files ////////////////////  -->
<!-- Jquery -->
<script src="/mobile_assets/js/lib/jquery-3.4.1.min.js"></script>
<!-- Bootstrap-->
<script src="/mobile_assets/js/lib/popper.min.js"></script>
<script src="/mobile_assets/js/lib/bootstrap.min.js"></script>
<!-- Ionicons -->
<script type="module" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons/ionicons.js"></script>

<!-- Owl Carousel -->
<script src="/mobile_assets/js/plugins/owl-carousel/owl.carousel.min.js"></script>
<!-- jQuery Circle Progress -->
<script src="/mobile_assets/js/plugins/jquery-circle-progress/circle-progress.min.js"></script>
<!-- Base Js File -->
<script src="/mobile_assets/js/base.js"></script>

@livewireScripts



<script>
  window.addEventListener('ShowModal', event => {            
        $('#MyModal').modal('show');      
    }); 


    window.addEventListener('CloseTalepListModal', event => {    
             
        $('#TalepListModal').modal('hide');      
    }); 
    
  
    window.addEventListener('CloseModal', event => {  
      setTimeout(function(){  $('.modal').modal('hide');   }, 1000);        
    }); 
</script>